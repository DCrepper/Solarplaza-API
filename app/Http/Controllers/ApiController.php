<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    protected static $apiKey = 'sTG1ytYTxF2864F';

    public static function GetProductBase(): array
    {
        $data = [
            'method' => 'GetProductBase',
            'parameters' => [],
        ];

        return self::apiRequest($data)['products_base'];
    }

    public static function GetProductDocuments(string $prodID): array
    {
        $data = [
            'method' => 'GetProductDocuments',
            'parameters' => [['ProductId' => $prodID]],
        ];
        $documents = self::apiRequest($data);
        if (!isset($documents['product_documents'])) {
            return [];
        }
        return $documents['product_documents'];
    }

    public static function GetProductCategories(): array
    {
        $data = [
            'method' => 'GetProductCategories',
            'parameters' => [],
        ];

        return self::apiRequest($data)['categories'];
    }

    protected static function apiRequest(array $data): array
    {
        $url = 'https://api.wycena.keno-energy.com';
        $data['apikey'] = self::$apiKey;

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
