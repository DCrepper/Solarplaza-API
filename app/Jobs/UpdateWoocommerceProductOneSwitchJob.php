<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Batchable;
use Automattic\WooCommerce\Client;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateWoocommerceProductOneSwitchJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $product)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $woocommerce = new Client(
            'https://solarplaza.at',
            env('WORDPRESS_KEY'),
            env('WORDPRESS_SECRET'),
            [
                'version' => 'wc/v3',
                'timeout' => 300, // Timeout is set to 300 seconds (5 minutes)
            ]
        );
        //dump($this->product->sku);
        $product = Product::whereEanCode($this->product->sku)->first();
        //dump($product);
        $woocommerce->put('products/' . $this->product->id, [
            'name' => $product->description,
            'description' => $product->name,
        ]);
    }
}
