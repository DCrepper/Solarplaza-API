<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Category;
use Filament\Widgets\Widget;
use App\Http\Controllers\ApiController;
use App\Models\Subcategory;

class ImportProductsWidget extends Widget
{
    protected static string $view = 'filament.widgets.import-products-widget';

    public function importProducts()
    {
        foreach (ApiController::GetProductBase() as $product) {
            Product::whereProductId($product['product_id'])->firstOrCreate([
                'product_id' => $product['product_id'],
                'subcategory_id' => $product['subcategory_id'],
                'index' => $product['index'],
                'name' => $product['name'],
                'producer' => $product['producer'],
                'description' => $product['description']['de'],
                'image' => $product['image'],
                'price' => (int) $product['price']['price'],
                'mechanical_parameters_width' => $product['mechanical_parameters']['Width'],
                'mechanical_parameters_height' => $product['mechanical_parameters']['height'],
                'mechanical_parameters_thickness' => $product['mechanical_parameters']['thickness'],
                'mechanical_parameters_weight' => $product['mechanical_parameters']['weight'],
                'ean_code' => $product['logistic_parameters']['ean_code'],
                'stock' => (int) $product['stock']['Nyiregyhaza'],

            ]);
        }
        foreach (ApiController::GetProductCategories() as $category) {
            Category::whereCategoryId($category['id'])->firstOrCreate([
                'category_id' => $category['id'],
                'name' => $category['name'],
            ]);
            foreach ($category['subcategories'] as $subcategory) {
                Subcategory::whereSubCategoryId($subcategory['id'])->firstOrCreate([
                    'category_id' => $category['id'],
                    'sub_category_id' => $subcategory['id'],
                    'name' => $subcategory['name'],
                ]);
            }
        }

    }
}
