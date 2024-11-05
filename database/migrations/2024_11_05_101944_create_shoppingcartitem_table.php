<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shopping_cart_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity')->unsigned()->default(0)->comment('số lượng sản phẩm trong giỏ hàng');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('shopping_cart_id');
            $table->unsignedInteger('variant_product_id'); // Thêm variant_product_id
            $table->decimal('price', 10, 2)->comment('Giá của sản phẩm'); // Thêm cột price
            $table->softDeletes();
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('shopping_cart_id')->references('id')->on('shopping_cart')->onDelete('cascade');
            $table->foreign('variant_product_id')->references('id')->on('variant_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_cart_item');
    }
};