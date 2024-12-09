<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Automattic\WooCommerce\Client;

class UploadProductsToWooCommerce implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $products;

    /**
     * Create a new job instance.
     *
     * @param  array  $products
     * @return void
     */
    public function __construct(array $products)
    {
        $this->products = $products;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
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


        $woocommerce->post('products/batch', [
            'update' => $this->products,
        ]);

    }
}
