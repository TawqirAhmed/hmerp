<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCivilsviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('civilsview', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('civilview_particulars');
            $table->string('civilview_id');
            $table->string('civilview_folio');
            $table->string('civilview_credit');
            $table->string('civilview_debit');
            $table->string('civilview_balance');
            $table->text('civilview_note');
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
        Schema::dropIfExists('civilsview');
    }
}
