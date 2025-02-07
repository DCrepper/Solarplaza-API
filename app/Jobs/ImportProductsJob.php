<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Models\SwitchedProduct;
use Automattic\WooCommerce\Client;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\ApiController;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Batchable;
    public $timeout = 500;

    public function handle()
    {
        // Import products from API
        foreach (ApiController::GetProductBase() as $product) {
            $stock = (int) $product['stock']['Nyiregyhaza'] + (int) $product['stock']['Szekesfehervar'] + (int) $product['stock']['Poland'];
            $switchedProduct = SwitchedProduct::where('sku', $product['logistic_parameters']['ean_code'])->first();

            if ($switchedProduct) {
                $tmp = $product['description']['de'];
                $product['description']['de'] = $product['name'];
                $product['name'] = $tmp;
            }
            $product = Product::firstOrCreate([
                'product_id' => $product['product_id'],
            ], ['product_id' => $product['product_id']]);
            $product->update([
                'sub_category_id' => $product['subcategory_id'],
                'index' => $product['index'],
                'name' => $product['name'],
                'producer' => $product['producer'],
                'description' => $product['description']['de'],
                'image' => $product['image'],
                'price' =>  $product['price']['price'],
                'mechanical_parameters_width' => $product['mechanical_parameters']['Width'],
                'mechanical_parameters_height' => $product['mechanical_parameters']['height'],
                'mechanical_parameters_thickness' => $product['mechanical_parameters']['thickness'],
                'mechanical_parameters_weight' => $product['mechanical_parameters']['weight'],
                'ean_code' => $product['logistic_parameters']['ean_code'],
                'stock' => $stock,
            ]);

        }
        /*
        foreach (ApiController::GetProductCategories() as $category) {
            Category::whereCategoryId($category['id'])->firstOrCreate([
                'category_id' => $category['id'],
                'name' => $category['name'],
            ]);
            foreach ($category['subcategories'] as $subcategory) {
                SubCategory::whereSubCategoryId($subcategory['id'])->firstOrCreate([
                    'category_id' => $category['id'],
                    'sub_category_id' => $subcategory['id'],
                    'name' => $subcategory['name'],
                ]);
            }
        }
        */
        $woocommerce = new Client(
            'https://solarplaza.at',
            env('WORDPRESS_KEY'),
            env('WORDPRESS_SECRET'),
            [
                'version' => 'wc/v3',
                'timeout' => 300,
            ]
        );

        $products = [];
        for ($page = 1; $page <= 40; $page++) {
            $response = $woocommerce->get('products', ['per_page' => 100, 'page' => $page]);
            if (empty($response)) {
                break;
            }
            $products = array_merge($products, $response);
        }
        $updateData = [];
        foreach ($products as $woo_product) {
            $product = Product::whereEanCode($woo_product->sku)->first();
            if ($product) {
                $updateData[] = [
                    'id' => $woo_product->id,
                    'status' => 'publish',
                    'price' => $product->price * 1.15,
                    'regular_price' => $product->price * 1.15,
                    'stock_quantity' => $product->stock,
                ];
            }
        }

        if (!empty($updateData)) {
            $chunks = array_chunk($updateData, 100);
            foreach ($chunks as $chunk) {
                UploadProductsToWooCommerce::dispatch($chunk);
            }
        }
    }
}
