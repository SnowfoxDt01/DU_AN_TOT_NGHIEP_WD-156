<?php

use App\Enums\PaymentMethod;
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
            // Thay đổi kiểu dữ liệu của cột payment_method thành ENUM
            $table->enum('payment_method', PaymentMethod::getValues())
                  ->default(PaymentMethod::CASH)
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
