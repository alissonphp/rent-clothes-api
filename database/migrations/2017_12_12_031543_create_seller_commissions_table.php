<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellerCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_commissions', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('users_id')->unsigned();
            $table->integer('cashiers_id')->unsigned();
            $table->decimal('commission');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('cashiers_id')->references('id')->on('cashier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_commissions');
    }
}
