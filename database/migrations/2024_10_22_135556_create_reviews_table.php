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
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id'); // Khóa ngoại đến bảng products
            $table->unsignedInteger('user_id'); // Khóa ngoại đến bảng users
            $table->text('comment')->nullable(); // Bình luận của người dùng
            $table->integer('rating'); // Điểm đánh giá
            $table->boolean('is_visible')->default(true); // Cờ kiểm soát hiển thị/ẩn
            $table->timestamps();
        
            // Thiết lập khóa ngoại
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
