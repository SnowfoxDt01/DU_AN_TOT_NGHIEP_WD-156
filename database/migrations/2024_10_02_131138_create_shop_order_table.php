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
        Schema::create('shop_order', function (Blueprint $table) {
            $table->increments('id'); //mặc định sẽ tăng dần, thuộc tính int, primary
            $table->datetime('date_order')->default(now())->comment('ngày giờ tạo đơn hàng');
            $table->bigInteger('total_price');
            $table->enum('status_order', ['đã nhận', 'đang giao', 'đang chờ shipper'])->default('đang chờ shipper')->comment('Trạng thái đơn hàng: đã nhận, đang giao, đang chờ shipper');
            $table->text('address_shipping')->comment('địa chỉ giao hàng');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_order');
    }
};
