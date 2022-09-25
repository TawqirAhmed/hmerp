<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIctsviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ictsview', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ictview_particulars');
            $table->string('ictview_id');
            $table->string('ictview_folio');
            $table->string('ictview_credit');
            $table->string('ictview_debit');
            $table->string('ictview_balance');
            $table->string('ictview_disburse');
            $table->string('ictview_note');
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
        Schema::dropIfExists('ictsview');
    }
}
