<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOthersviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('othersview', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('othersview_particulars');
            $table->string('othersview_id');
            $table->string('othersview_folio');
            $table->string('othersview_credit');
            $table->string('othersview_debit');
            $table->string('othersview_balance');
            $table->string('othersview_note');
            $table->string('othersview_disburse');
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
        Schema::dropIfExists('othersview');
    }
}
