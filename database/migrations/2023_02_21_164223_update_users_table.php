<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('hrcode')->after('email')->unique();
            $table->string('gender')->after('hrcode')->nullable();
            $table->string('addres')->after('gender')->nullable();
            $table->string('phone')->after('addres')->unique();
            $table->dateTime('birthday')->after('phone')->nullable();
            $table->string('birthplace')->after('birthday')->nullable();
            $table->string('religion')->after('birthplace')->nullable();
            $table->string('marital_status')->after('religion')->nullable();
            $table->string('nationality')->after('marital_status')->nullable();
            $table->string('education')->after('nationality')->nullable();
            $table->string('name_of_school')->after('education')->nullable();
            $table->integer('number_of_identity')->after('name_of_school')->nullable();
            $table->string('place_of_identity')->after('number_of_identity')->nullable();
            $table->string('branch')->after('place_of_identity')->nullable();
            $table->integer('role_id')->after('branch')->nullable();
            $table->string('team_id')->after('role_id')->nullable();
            $table->string('job_level')->after('team_id')->nullable();
            $table->string('employee_type')->after('job_level')->nullable();
            $table->string('profile_picture')->after('employee_type')->nullable();
            $table->boolean('is_active')->after('profile_picture')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
