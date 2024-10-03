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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id'); //mặc định sẽ tăng dần, thuộc tính int, primary
            $table->string('name', 250);
            $table->text('desription')->nullable()->comment('Mô tả sản phẩm');
            $table->bigInteger('price');
            $table->string('image')->nullable()->comment('Đường dẫn hình ảnh của sản phẩm');
            $table->integer('quantity')->unsigned()->default(0)->comment('số lượng sản phẩm có trong kho');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
