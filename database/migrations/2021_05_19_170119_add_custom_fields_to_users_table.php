<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname', 100)->after('name');
            $table->string('lastname', 100)->after('firstname');
            $table->string('username', 200)->after('lastname');
            $table->string('company_name', 200)->after('email');
            $table->string('company_website', 255)->after('company_name');
            $table->string('com_code', 200)->after('company_website');
            $table->string('administrator', 100)->after('com_code');
            $table->enum('company_admin', ['Y', 'N'])->default('N')->after('administrator');
            $table->text('accstatus')->after('company_admin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
