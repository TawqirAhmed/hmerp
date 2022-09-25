<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliesviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliesview', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('suppliesview_name');
            $table->string('suppliesview_particulars');
            $table->string('suppliesview_id');
            $table->string('suppliesview_folio');
            $table->string('suppliesview_credit');
            $table->string('suppliesview_debit');
            $table->string('suppliesview_balance');
            $table->string('suppliesview_note');
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
        Schema::dropIfExists('suppliesview');
    }
}
