<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productout', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pout_name');
            $table->string('pout_sku');
            $table->string('pout_billno');
            $table->string('pout_quantity');
            $table->string('pout_saledate');
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
        Schema::dropIfExists('productout');
    }
}
