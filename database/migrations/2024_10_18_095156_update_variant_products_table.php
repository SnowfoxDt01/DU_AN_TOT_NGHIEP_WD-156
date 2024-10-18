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
            // Thêm cột size_id và xóa cột size
            $table->unsignedBigInteger('size_id')->after('category_id'); // Thêm cột mới
            $table->dropColumn('size'); // Xóa cột cũ
            
            // Thêm cột color_id và xóa cột color
            $table->unsignedBigInteger('color_id')->after('size_id'); // Thêm cột mới
            $table->dropColumn('color'); // Xóa cột cũ

            $table->dropColumn('sku');
            
            // Đổi kiểu dữ liệu sku
            $table->integer('sku')->change(); // Đổi kiểu dữ liệu
        });

         // Thêm khóa ngoại cho size_id và color_id
         Schema::table('variant_products', function (Blueprint $table) {
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('variant_products', function (Blueprint $table) {
            // Quay lại các thay đổi
            $table->dropForeign(['size_id']);
            $table->dropForeign(['color_id']);
            
            $table->dropColumn('size_id');
            $table->string('size'); // Khôi phục cột size
            
            $table->dropColumn('color_id');
            $table->string('color'); // Khôi phục cột color
            
            $table->string('sku')->change(); // Đổi lại kiểu dữ liệu sku
        });
    }
};
