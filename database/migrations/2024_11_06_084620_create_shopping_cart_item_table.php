<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingCartItemTable extends Migration
{
    public function up()
    {
        Schema::create('shopping_cart_item', function (Blueprint $table) {
            $table->id(); // Khóa chính, kiểu unsignedBigInteger
            $table->unsignedBigInteger('cart_id'); // Khóa ngoại liên kết với bảng shopping_cart
            $table->unsignedInteger('product_id'); // Khóa ngoại liên kết với bảng products (dùng unsignedInteger)
            $table->unsignedInteger('variant_id')->nullable(); // Khóa ngoại liên kết với bảng variant_products (dùng unsignedInteger)
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
            $table->softDeletes(); // Xóa mềm

            // Khóa ngoại
            $table->foreign('cart_id')->references('id')->on('shopping_cart')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on('variant_products')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('shopping_cart_item');
    }
}
