<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price');
            $table->unsignedBigInteger('brand_id')->index()->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->integer('stock_quantity');
            $table->string('sku')->unique();
            $table->string('barcode')->unique()->nullable();
            $table->string('material')->nullable();
            $table->string('gender')->nullable();
            $table->decimal('weight')->nullable();
            $table->string('dimensions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
