<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOccsviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occsview', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('occview_particulars');
            $table->string('occview_id');
            $table->string('occview_folio');
            $table->string('occview_credit');
            $table->string('occview_debit');
            $table->string('occview_balance');
            $table->string('occview_note');
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
        Schema::dropIfExists('occsview');
    }
}
