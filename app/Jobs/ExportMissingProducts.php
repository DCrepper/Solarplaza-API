<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Batchable;
use Automattic\WooCommerce\Client;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\ApiController;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ExportMissingProducts implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // WooCommerce API kliens inicializ�l�sa
        $woocommerce = new Client(
            'https://solarplaza.at',
            env('WORDPRESS_KEY'),
            env('WORDPRESS_SECRET'),
            [
                'version' => 'wc/v3',
                'timeout' => 300,
            ]
        );

        // WooCommerce term�kek lek�r�se
        $wooProducts = $woocommerce->get('products', ['per_page' => 4000]);
        $wooProductSkus = collect($wooProducts)->pluck('sku')->toArray();

        // Helyi adatb�zis term�kek lek�r�se
        $localProducts = Product::get();

        // Azok a term�kek, amelyek nincsenek a WooCommerce adatb�zisban
        $missingProducts = $localProducts->filter(function ($product) use ($wooProductSkus) {
            return !in_array($product->ean_code, $wooProductSkus);
        });

        // Export�l�s CSV f�jlba
        $csvData = [];
        foreach ($missingProducts as $product) {
            $documents = ApiController::GetProductDocuments($product->product_id);
            $document_file = '';
            foreach ($documents as $document) {

                if (strpos($document['description'], 'DE') !== false) {
                    //documentumot egy sz�vegbe | karakterrel elv�lasztva
                    $document_file .=  $document['url'] . '|' ;
                }
                $product->update(['document' => $document_file]);
            }

            $csvData[] = [
                'SKU' => $product->ean_code,
                'Name' => $product->name,
                'Price' => $product->price,
                'Stock' => $product->stock,
                'description' => $product->description,
                'image' => $product->image,
                'mechanical_parameters_width' => $product->mechanical_parameters_width,
                'mechanical_parameters_height' => $product->mechanical_parameters_height,
                'mechanical_parameters_thickness' => $product->mechanical_parameters_thickness,
                'mechanical_parameters_weight' => $product->mechanical_parameters_weight,
                'ean_code' => $product->ean_code,
                'document' => $product->document,
            ];

            // K�sleltet�s a lek�rdez�si limit elker�l�se �rdek�ben
            usleep(600000); // 600000 mikrosekundum = 0.6 m�sodperc
        }

        $csvFileName = 'missing_products.csv';
        $csvFilePath = storage_path('app/' . $csvFileName);

        $file = fopen($csvFilePath, 'w');
        fputcsv($file, [
            'SKU',
            'Name',
            'Price',
            'Stock',
            'description',
            'image',
            'mechanical_parameters_width',
            'mechanical_parameters_height',
            'mechanical_parameters_thickness',
            'mechanical_parameters_weight',
            'ean_code',
            'document'
        ], ";");
        foreach ($csvData as $row) {
            fputcsv($file, $row, ";");
        }
        fclose($file);

        // F�jl let�lt�se
        // Itt nem sz�ks�ges let�lt�st kezelni, mivel a job a h�tt�rben fut
    }
}
