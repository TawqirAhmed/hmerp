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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('p_name');
            $table->string('p_sku');
            $table->string('p_description');
            $table->string('p_buy');
            $table->string('p_profit');
            $table->string('p_sell');
            $table->string('p_previous');
            $table->string('p_new');
            $table->string('p_total');
            $table->string('p_disburse');
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
        Schema::dropIfExists('products');
    }
}
