<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->float('bill', 6, 2)->unsigned();
            $table->date('order_date');
            $table->string('buyer_fullname', 150);
            $table->string('buyer_email', 60);
            $table->string('buyer_address');
            $table->string('buyer_phone', 40)->nullable();
            $table->text('note');
            $table->string('transaction_id');
            $table->boolean('transaction_status');
            $table->timestamps();
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
