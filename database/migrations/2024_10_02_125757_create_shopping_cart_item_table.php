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
            $table->increments('id'); //mặc định sẽ tăng dần, thuộc tính int, primary
            $table->integer('quantity')->unsigned()->default(0)->comment('số lượng sản phẩm trong giỏ hàng');
            $table->timestamps();
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
