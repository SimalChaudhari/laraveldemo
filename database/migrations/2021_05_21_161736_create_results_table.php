<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('sess_id', 80);
            $table->bigInteger('test_id');
            $table->enum('completed', ['Y', 'N'])->default('N');
            $table->datetime('datetime');
            $table->string('company_name', 255);
            $table->string('firstname', 255);
            $table->string('rand', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
