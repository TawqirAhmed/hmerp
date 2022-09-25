<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductspurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productspurchase', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ppurchase_name');
            $table->string('ppurchase_sku');
            $table->string('ppurchase_quantity');
            $table->string('ppurchase_purchase');
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
        Schema::dropIfExists('productspurchase');
    }
}
