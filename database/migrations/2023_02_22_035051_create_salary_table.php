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
        Schema::create('salary', function (Blueprint $table) {
            $table->id();
            $table->integer('bank_account_number')->unique();
            $table->string('bank_name');
            $table->string('bank_of_issue');
            $table->integer('npwp_number')->unique();
            $table->dateTime('signed_date');
            $table->string('sallary_type');
            $table->string('sallary_form');
            $table->integer('amout_sallary');
            $table->integer('amout_allowance');
            $table->string('allowance_type');
            $table->string('note');
            $table->softDeletes();
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
        Schema::dropIfExists('salary');
    }
};
