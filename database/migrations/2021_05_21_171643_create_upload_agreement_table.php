<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadAgreementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_agreements', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name', 255);
            $table->string('file', 255);
            $table->string('type', 255);
            $table->integer('size');
            $table->string('company_name', 255);
            $table->string('firstname', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload_agreements');
    }
}
