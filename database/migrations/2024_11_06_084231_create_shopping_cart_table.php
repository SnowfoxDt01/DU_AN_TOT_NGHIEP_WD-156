<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingCartTable extends Migration
{
    public function up()
    {
        Schema::create('shopping_cart', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('total_price', 10, 2)->default(0.00);
            $table->softDeletes(); // Thêm xóa mềm
            $table->timestamps();
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('shopping_cart');
    }
}
