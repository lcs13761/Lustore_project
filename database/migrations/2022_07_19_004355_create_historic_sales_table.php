<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historic_sales', function (Blueprint $table) {
            $table->id();
            $table->string('codeSales');
            $table->string('barcode')->unique();
            $table->foreignId("user_id")->nullable();
            $table->foreignId("seller_id")->constrained();
            $table->string('cpf_client')->nullable();
            $table->integer('code_product');
            $table->string('product');
            $table->double('saleValue');
            $table->string("discount");
            $table->text("size");
            $table->integer('qts');
            $table->foreignId('category_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historic_sales');
    }
}
