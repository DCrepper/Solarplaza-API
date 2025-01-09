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
    public $timeout = 10000;
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

        /** @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $localProducts */
        $localProducts = Product::all();

        // Azok a term�kek, amelyek nincsenek a WooCommerce adatb�zisban
        $missingProducts = $localProducts->filter(function ($product) use ($wooProductSkus) {
            return in_array($product->ean_code, $wooProductSkus);
        });

        foreach ($missingProducts as $product) {
            $documents = ApiController::GetProductDocuments($product->product_id);
            $document_file = '';
            foreach ($documents as $document) {

                if (strpos($document['description'], 'DE') !== false) {
                    //documentumot egy sz�vegbe | karakterrel elv�lasztva
                    $document_file .=  $document['url'] . '|' ;
                }
                
            }
            $product->update(['document' => $document_file]);
            

            // K�sleltet�s a lek�rdez�si limit elker�l�se �rdek�ben
            usleep(600000); // 600000 mikrosekundum = 0.6 m�sodperc
        }
        $this->appendToChain(new ExportProductToCsv);
        
    }
}
