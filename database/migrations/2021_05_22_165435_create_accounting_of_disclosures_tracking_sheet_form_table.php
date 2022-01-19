<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountingOfDisclosuresTrackingSheetFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_of_disclosures_tracking_sheet_form', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name', 255);
            $table->date('dob');
            $table->text('ss');
            $table->date('first_entry');
            $table->text('data_info');
            $table->text('to_whome');
            $table->text('descri_info');
            $table->text('add_info');
            $table->text('reported_by');
            $table->text('sign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounting_of_disclosures_tracking_sheet_form');
    }
}
