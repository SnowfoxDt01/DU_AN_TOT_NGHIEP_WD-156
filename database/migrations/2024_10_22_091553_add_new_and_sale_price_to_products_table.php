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
        Schema::table('products', function (Blueprint $table) {
            // Thêm cột 'new' với giá trị mặc định là 0
            $table->boolean('new')->default(0)->after('quantity');
            
            // Thêm cột 'sale_price' có thể là null nếu không có giá trị
            $table->bigInteger('sale_price')->nullable()->after('base_price'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
