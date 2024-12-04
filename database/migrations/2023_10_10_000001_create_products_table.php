<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**'product_id',
        'subcategory_id',
        'index',
        'name',
        'producer',
        'warranty_extension_for_product_index',
        'description',
        'image',
        'price',
        'mechanical_parameters_width',
        'mechanical_parameters_height',
        'mechanical_parameters_thickness',
        'mechanical_parameters_weight',
        'ean_code',
        'stock', */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->nullable();
            $table->foreignId('subcategory_id')->nullable();
            $table->string('index')->nullable();
            $table->string('name')->nullable();
            $table->string('producer')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('price')->nullable();
            $table->string('mechanical_parameters_width')->nullable();
            $table->string('mechanical_parameters_height')->nullable();
            $table->string('mechanical_parameters_thickness')->nullable();
            $table->string('mechanical_parameters_weight')->nullable();
            $table->string('ean_code')->nullable();
            $table->integer('stock')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
