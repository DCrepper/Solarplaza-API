<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->unique();
            $table->string('group');
            $table->string('name');
            $table->string('index');
            $table->string('ean_code')->nullable();
            $table->json('urls')->nullable();
            $table->text('description')->nullable(); // New field
            $table->decimal('price', 8, 2)->nullable(); // New field
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
