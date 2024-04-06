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
            $table->text("description")->nullable();
            $table->double('price');
            $table->foreignId('category_id')->index()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            // $table->bigInteger('costValue');
            // $table->bigInteger('saleValue');
            $table->integer('qts_stock');
            $table->json('extraInformation')->nullable();
            $table->boolean('active')->default(false);
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
