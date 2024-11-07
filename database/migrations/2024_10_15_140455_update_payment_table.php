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
        Schema::table('payment', function (Blueprint $table) {
            // Xóa trường shopping_cart_id
            $table->dropForeign(['shopping_cart_id']);
            $table->dropColumn('shopping_cart_id');

            // Thêm trường order_id để liên kết với bảng shop_order
            $table->unsignedInteger('order_id')->after('user_id')->nullable();
            $table->foreign('order_id')->references('id')->on('shop_order')->onDelete('cascade');


            // Xóa cột date_payment nếu nó tồn tại
            $table->dropColumn('date_payment'); // Thêm dòng này để xóa cột date_payment
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment', function (Blueprint $table) {
            // Thêm lại trường shopping_cart_id nếu cần
            $table->unsignedInteger('shopping_cart_id');
            $table->foreign('shopping_cart_id')->references('id')->on('shopping_cart')->onDelete('cascade');

            // Xóa trường order_id
            $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');

            // Thêm lại cột date_payment nếu cần
            $table->timestamp('date_payment')->nullable(); // Thêm dòng này để khôi phục cột date_payment
        });
    }
};
