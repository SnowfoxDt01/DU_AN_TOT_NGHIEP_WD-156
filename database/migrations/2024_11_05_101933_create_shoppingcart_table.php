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
        Schema::create('shopping_cart', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Transaction_id_user')->unique()->comment('Mã giao dịch của người dùng');
            $table->integer('Transaction_id_merchant')->unique()->comment('Mã giao dịch của người bán');
            $table->unsignedBigInteger('customer_id')->comment('Khách hàng sở hữu giỏ hàng'); // Thêm customer_id
            $table->unsignedInteger('user_id')->comment('Người dùng tạo giỏ hàng'); // Thêm user_id
            $table->softDeletes();
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_cart');
    }
};