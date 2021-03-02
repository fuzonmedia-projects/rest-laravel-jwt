<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::drop('products');
        Schema::create('products', function (Blueprint $table) {
            Schema::dropIfExists('products');
            $table->id();
            $table->string('order_number',120);
            $table->string('order_ammt',120);
            //$table->BigInteger('user_id');
           
            $table->timestamps();
            //$table->foreignId('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
