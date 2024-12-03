<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\ProcessProduct;
use Exception;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

abstract class Controller
{
    protected $apiKey = 'sTG1ytYTxF2864F';

    public function makeProductFiles(): void
    {
        set_time_limit(7200);
        $filename = 'products.csv';
        Storage::put($filename, '');
        $headers = ['ean_code', 'url'];
        Storage::append($filename, implode(';', $headers));

        $productsListResponse = $this->GetProductsList();
        $productsBaseResponse = $this->GetProductBase();

        $products_list = $productsListResponse['products_list'];
        $products_base = $productsBaseResponse['products_base'];

        $batch = Bus::batch([])->dispatch();

        foreach ($products_list as $index => $product) {
            $batch->add(new ProcessProduct($product, $products_base, $filename));

            if ($index % 99 == 0 && $index > 0) {
                Log::info('Reached maximum requests per minute. Waiting for 1 minute...');
                sleep(61); // Pause for 1 minute
            }
        }

        Log::info('Batch processing started for products.');
    }

    public function init(int $length = 1): array
    {
        return array_fill(0, $length, '');
    }

    public function GetProductBase(): array
    {
        $data = [
            'method' => 'GetProductBase',
            'parameters' => [],
        ];

        return $this->apiRequest($data);
    }

    public function GetProductsList(): array
    {
        $data = [
            'method' => 'GetProductsList',
            'parameters' => [['ShowGroups' => '1', 'ShowIndex' => '1']],
        ];

        return $this->apiRequest($data);
    }

    public function GetProductsDocuments(string $prodID): array
    {
        $data = [
            'method' => 'GetProductDocuments',
            'parameters' => [['ProductId' => $prodID]],
        ];

        return $this->apiRequest($data);
    }

    public function GetProductInfo(string $productId): array
    {
        $data = [
            'method' => 'GetProductInfo',
            'parameters' => [['ProductId' => $productId]],
        ];

        return $this->apiRequest($data);
    }

    public function GetProductPrice(string $productId): array
    {
        $data = [
            'method' => 'GetProductPrice',
            'parameters' => [['ProductId' => $productId]],
        ];

        return $this->apiRequest($data);
    }

    protected function apiRequest(array $data): array
    {
        $url = 'https://api.wycena.keno-energy.com';
        $data['apikey'] = $this->apiKey;

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
