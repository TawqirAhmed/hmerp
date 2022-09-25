<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalestoapproveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salestoapprove', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('products');
            $table->string('bill_code');
            $table->bigInteger('id_customer');
            $table->bigInteger('id_seller');
            $table->string('net_price');
            $table->string('total_price');
            $table->string('payment_method');
            $table->string('amount_paid');
            $table->string('amount_due');
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
        Schema::dropIfExists('salestoapprove');
    }
}
