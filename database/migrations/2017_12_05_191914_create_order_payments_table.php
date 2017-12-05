<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_payments', function (Blueprint $table)
        {
           $table->increments('id');
           $table->integer('orders_id')->unsigned();
           $table->integer('users_id')->unsigned();
           $table->decimal('value');
           $table->timestamps();
           $table->foreign('orders_id')->references('id')->on('orders');
           $table->foreign('users_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_payments');
    }
}
