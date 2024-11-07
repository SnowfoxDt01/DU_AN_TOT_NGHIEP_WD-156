<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table){
            $table->unsignedInteger('product_category_id')->after('id');
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');
        });
        

        Schema::table('shopping_cart_item', function (Blueprint $table){
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedInteger('shopping_cart_id');
            $table->foreign('shopping_cart_id')->references('id')->on('shopping_cart')->onDelete('cascade');
        });

        Schema::table('shopping_cart', function (Blueprint $table){
            $table->unsignedInteger('shop_order_id');
            $table->foreign('shop_order_id')->references('id')->on('shop_order')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('payment', function (Blueprint $table){
            $table->unsignedInteger('shopping_cart_id');
            $table->foreign('shopping_cart_id')->references('id')->on('shopping_cart')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('shop_order', function (Blueprint $table){
            $table->unsignedInteger('shipping_id');
            $table->foreign('shipping_id')->references('id')->on('shipping')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['product_category_id']);
            $table->dropColumn('product_category_id');
        });

        Schema::table('shopping_cart_item', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['shopping_cart_id']);
            $table->dropColumn(['product_id', 'shopping_cart_id']);
        });

        Schema::table('shopping_cart', function (Blueprint $table) {
            $table->dropForeign(['shop_order_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['shop_order_id', 'user_id']);
        });

        Schema::table('payment', function (Blueprint $table) {
            $table->dropForeign(['shopping_cart_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['shopping_cart_id', 'user_id']);
        });

        Schema::table('shop_order', function (Blueprint $table) {
            $table->dropForeign(['shipping_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['shipping_id', 'user_id']);
        });
    }
};
