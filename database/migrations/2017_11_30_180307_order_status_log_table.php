<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderStatusLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_status_log', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('users_id')->unsigned();
            $table->integer('orders_id')->unsigned();
            $table->string('status');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('orders_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_status_log');
    }
}
