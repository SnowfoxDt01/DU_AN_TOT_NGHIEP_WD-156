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
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title'); // Tiêu đề của banner
            $table->string('image_url'); // Đường dẫn tới hình ảnh của banner
            $table->text('description')->nullable(); // Mô tả chi tiết của banner (có thể để trống)
            $table->enum('status', ['active', 'inactive'])->default('inactive'); // Trạng thái của banner
            $table->integer('position')->default(0); // Vị trí hiển thị của banner
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
