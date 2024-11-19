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
        Schema::table('voucher_user', function (Blueprint $table) {
            $table->unsignedInteger('order_id')->nullable()->after('user_id');
            $table->foreign('order_id')->references('id')->on('shop_order')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voucher_user', function (Blueprint $table) {
            //
        });
    }
};
