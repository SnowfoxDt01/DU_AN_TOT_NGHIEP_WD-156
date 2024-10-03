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
        Schema::create('payment', function (Blueprint $table) {
            $table->increments('id'); //mặc định sẽ tăng dần, thuộc tính int, primary
            $table->datetime('date_payment')->default(now())->comment('ngày giờ trả tiền đơn hàng');
            $table->enum('method_payment', ['tiền mặt', 'chuyển khoản', 'thẻ tín dụng'])->comment('Phương thức thanh toán');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
