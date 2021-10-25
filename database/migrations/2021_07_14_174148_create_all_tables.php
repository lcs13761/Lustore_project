<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->autoIncrement()->unique();
            $table->string('photo')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('level')->default("1");
            $table->string('cpf')->nullable();
            $table->string('phone')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create("address", function(Blueprint $table){
            $table->id()->autoIncrement()->unique();
            $table->string('cep')->nullable();
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('street')->nullable();
            $table->integer('number')->nullable();
            $table->string('complement')->nullable();
            $table->foreignIdFor(User::class)->constrained("users")->onUpdate("cascade")->onDelete("cascade");
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
        
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create("categories", function (Blueprint $table) {
            $table->id()->autoIncrement()->unique();
            $table->string('category');            
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create("products", function (Blueprint $table) {
            $table->id()->autoIncrement()->unique();
            $table->string('code')->unique();
            $table->string('product');
            $table->foreignIdFor(Category::class)->constrained("categories")->onUpdate("cascade")->onDelete("cascade");
            $table->double('costValue');
            $table->double('saleValue');
            $table->text("description")->nullable();
            $table->string("size");
            $table->integer('qts');
            $table->integer('allQts');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });


        Schema::create("images", function (Blueprint $table) {
            $table->id()->autoIncrement()->unique();
            $table->string('image');
            $table->foreignIdFor(Product::class)->constrained('products')->onUpdate("cascade")->onDelete("cascade");
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
        Schema::create("monthCost", function (Blueprint $table) {
            $table->id()->autoIncrement()->unique();
            $table->double('value');          
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
   
        Schema::create("sales", function (Blueprint $table) {
            $table->id()->autoIncrement()->unique();
            $table->string("client");
            $table->string('code');
            $table->string('product');
            $table->double('saleValue');
            $table->double("discount")->default(0.0);
            $table->text("size");
            $table->integer('qts');
            $table->foreignIdFor(Category::class)->constrained('categories')->onUpdate("cascade")->onDelete("cascade");
            $table->foreignIdFor(Product::class)->constrained('products')->onUpdate("cascade")->onDelete("cascade");
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create("historicSales", function (Blueprint $table) {
            $table->id()->autoIncrement()->unique();
            $table->string("client");
            $table->string('code');
            $table->string('product');
            $table->double('saleValue');
            $table->double("discount")->default(0.0);
            $table->text("size");
            $table->integer('qts');
            $table->foreignIdFor(Category::class)->constrained('categories')->onUpdate("cascade")->restrictOnDelete();           
            $table->string('codeSales');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorys');
        Schema::dropIfExists('address');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('products');
        Schema::dropIfExists('images');
        Schema::dropIfExists('historicSales');
        Schema::dropIfExists('monthCost');
        Schema::dropIfExists('sales');
        
    }
}
