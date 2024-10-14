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
        Schema::table('shop_order', function (Blueprint $table) {
            $table->string('status')->default('pending'); // trạng thái đơn hàng
            $table->string('payment_status')->default('unpaid'); // trạng thái thanh toán
            $table->string('shipping_address')->nullable(); // địa chỉ giao hàng
            $table->string('payment_method')->nullable(); // phương thức thanh toán
            $table->dateTime('shipped_at')->nullable(); // ngày giao hàng
            $table->dateTime('delivered_at')->nullable(); // ngày giao hàng thành công
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_order', function (Blueprint $table) {
            $table->dropColumn(['status', 'payment_status', 'shipping_address', 'payment_method', 'shipped_at', 'delivered_at']);
        });
    }
};
