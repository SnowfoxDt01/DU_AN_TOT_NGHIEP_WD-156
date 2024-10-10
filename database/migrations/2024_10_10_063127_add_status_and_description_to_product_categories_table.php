<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->comment('0: Inactive, 1: Active')->before('deleted_at');
            $table->text('description')->nullable()->comment('Description of the product category')->before('deleted_at');
        });

        DB::statement('ALTER TABLE product_categories MODIFY COLUMN status TINYINT(1) DEFAULT 1 COMMENT "0: Inactive, 1: Active" AFTER deleted_at');
        DB::statement('ALTER TABLE product_categories MODIFY COLUMN description TEXT NULL COMMENT "Description of the product category" AFTER status');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            //
        });
    }
};
