<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductBasesTable extends Migration
{
    public function up(): void
    {
        Schema::create('product_bases', function (Blueprint $table) {
            $table->id();
            $table->string('index')->unique();
            $table->json('logistic_parameters');
            $table->decimal('weight', 8, 2)->nullable(); // New field
            $table->json('dimensions')->nullable(); // New field
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_bases');
    }
}
