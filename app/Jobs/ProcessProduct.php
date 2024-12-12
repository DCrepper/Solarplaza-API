<?php

declare(strict_types=1);

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessProduct implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $product;

    protected $products_base;

    protected $filename;

    protected $apiKey = 'sTG1ytYTxF2864F';

    public function __construct(array $product, array $products_base, string $filename)
    {
        $this->product = $product;
        $this->products_base = $products_base;
        $this->filename = $filename;
    }

    public function handle(): void
    {
        try {
            $productId = $this->product['product_id'];
            $productIndex = $this->product['index'];
            $eanCode = '';

            foreach ($this->products_base as $base) {
                if ($base['index'] == $productIndex) {
                    $eanCode = $base['logistic_parameters']['ean_code'];
                    break;
                }
            }

            $response = $this->GetProductsDocuments($productId);
            $prd_ = $response['product_documents'];
            $productData = [
                $eanCode,
                implode('|', array_column($prd_, 'url')),
                $this->product['subcategory_id'],
                $this->product['producer'],
                $this->product['image'],
                json_encode($this->product['mechanical_parameters']),
                json_encode($this->product['logistic_parameters']),
                json_encode($this->product['stock']),
                json_encode($this->product['quantity_unit']),
                $this->product['description'], // New field
                $this->product['price'],       // New field
            ];
            Storage::append($this->filename, implode(',', $productData));

            Log::info("Processed product ID: {$productId}");
        } catch (Exception $e) {
            Log::error("Failed to process product ID: {$this->product['product_id']}. Error: " . $e->getMessage());
        }
    }

    public function GetProductsDocuments(string $prodID): array
    {
        $url = 'https://api.wycena.keno-energy.com';
        $data = [
            'apikey' => $this->apiKey,
            'method' => 'GetProductDocuments',
            'parameters' => [['ProductId' => $prodID]],
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, $data);

        if ($response->failed()) {
            Log::error('API request failed: ' . $response->body());
            throw new Exception('Error: ' . $response->body());
        }

        return $response->json();
    }
}
