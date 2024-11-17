<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdatePaymentMethodEnumInPaymentsTable extends Migration
{
    public function up()
    {
        // Thay đổi giá trị enum
        Schema::table('shop_order', function (Blueprint $table) {
            DB::statement("ALTER TABLE shop_order MODIFY COLUMN payment_method ENUM('cash', 'card', 'paypal', 'vnpay') NOT NULL");
        });
    }

    public function down()
    {
        // Rollback về giá trị enum cũ
        Schema::table('shop_order', function (Blueprint $table) {
            DB::statement("ALTER TABLE shop_order MODIFY COLUMN payment_method ENUM('cash', 'card', 'paypal') NOT NULL");
        });
    }
}

