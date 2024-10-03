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
        Schema::create('shipping', function (Blueprint $table) {
            $table->increments('id'); //mặc định sẽ tăng dần, thuộc tính int, primary
            $table->string('name')->comment('tên người giao hàng');
            $table->enum('status', ['đang giao', 'rảnh rỗi'])->default('rảnh rỗi')->comment('Trạng thái giao hàng: đang giao, rảnh rỗi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping');
    }
};
