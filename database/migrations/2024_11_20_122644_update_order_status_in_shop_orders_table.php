<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Sử dụng câu lệnh ALTER TABLE để thêm giá trị vào ENUM
        DB::statement("ALTER TABLE `shop_order` MODIFY `order_status` ENUM('confirming','confirmed','preparing','shipping','delivered','completed','canceled', 'pending')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Nếu cần rollback, loại bỏ giá trị 'pending' khỏi ENUM
        DB::statement("ALTER TABLE `shop_order` MODIFY `order_status` ENUM('confirming','confirmed','preparing','shipping','delivered','completed','canceled')");
    }
};
