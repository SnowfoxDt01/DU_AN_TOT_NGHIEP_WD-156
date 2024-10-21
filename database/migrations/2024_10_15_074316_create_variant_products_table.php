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
        Schema::create('variant_products', function (Blueprint $table) {
            $table->increments('id'); // Khóa chính
            $table->string('name'); // Tên sản phẩm
            $table->text('description'); // Mô tả
            $table->decimal('price', 10, 2); // Giá sản phẩm
            $table->integer('quantity'); // Số lượng
            
            // Thay đổi category_id thành kiểu dữ liệu unsignedInteger
            $table->unsignedInteger('category_id'); 
            
            // Khóa ngoại tham chiếu đến bảng product_categories
            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
            
            $table->string('size'); // Kích cỡ
            $table->string('color'); // Màu sắc
            $table->string('image_url'); // Đường dẫn hình ảnh
            $table->string('sku')->unique()->comment('mã sản phẩm biến thể'); // Mã sản phẩm
            
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('active: hoạt động, inactive: không hoạt động'); // Trạng thái

            $table->timestamps(); // Ngày tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_products');
    }
};
