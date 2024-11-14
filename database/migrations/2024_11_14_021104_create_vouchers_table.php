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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->string('code')->unique();
            $table->decimal('discount', 8, 2);
            $table->enum('discount_type', ['fixed', 'percentage'])->default('fixed');
            $table->date('expiry_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('usage_limit')->nullable()->default(null);
            $table->integer('usage_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
