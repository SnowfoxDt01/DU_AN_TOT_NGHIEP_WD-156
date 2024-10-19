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
        Schema::table('variant_products', function (Blueprint $table) {
            // Thêm cột product_id và xóa cột category_id
            $table->unsignedInteger('product_id')->after('id'); // Thêm cột product_id
            
            // Xóa cột category_id và khóa ngoại của nó
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            
            // Thêm khóa ngoại cho product_id
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('variant_products', function (Blueprint $table) {
            // Quay lại các thay đổi
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
            
            $table->unsignedInteger('category_id')->after('quantity'); // Khôi phục cột category_id
            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
        });
    }
};
