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
        Schema::table('shop_order_items', function (Blueprint $table) {
            Schema::table('shop_order_items', function (Blueprint $table) {
                $table->unsignedInteger('variant_id')->nullable(); // Thêm cột variant_id và cho phép null để tránh lỗi ràng buộc
                $table->foreign('variant_id')->references('id')->on('variant_products')->onDelete('set null'); // Đặt null nếu xóa sản phẩm biến thể
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_order_items', function (Blueprint $table) {
            Schema::table('shop_order_items', function (Blueprint $table) {
                $table->dropForeign(['variant_id']); // Xóa khóa ngoại trước
                $table->dropColumn('variant_id'); // Xóa cột variant_id
            });
        });
    }
};
