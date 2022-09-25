<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovedquotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvedquotation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('products');
            $table->string('bill_code');
            $table->string('id_customer');
            $table->string('id_seller');
            $table->string('net_price');
            $table->string('vat_percent');
            $table->string('total_vat');
            $table->string('total_price');
            $table->string('payment_method');
            $table->string('payment_description');
            $table->string('amount_paid');
            $table->string('amount_due');
            $table->string('profit_percentage');
            $table->string('amount_profit');
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
        Schema::dropIfExists('approvedquotation');
    }
}
