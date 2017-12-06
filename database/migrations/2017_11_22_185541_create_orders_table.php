<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table)
        {

            $table->increments('id');
            $table->integer('clients_id')->unsigned();
            $table->string('code');
            $table->enum('status',[
                'Aberta',
                'Paga (total)',
                'Paga (parcial)',
                'Cancelada',
                'Finalizada'
            ]);
            $table->enum('items_situation',[1,2,3]);
            $table->date('output');
            $table->date('expected_return');
            $table->date('returned')->nullable();
            $table->decimal('subtotal');
            $table->decimal('discount')->nullable();
            $table->decimal('interest')->nullable();
            $table->decimal('fines')->nullable();
            $table->decimal('total');
            $table->timestamps();

            $table->foreign('clients_id')->references('id')->on('clients');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
