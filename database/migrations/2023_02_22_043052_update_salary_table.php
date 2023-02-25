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
        Schema::table('salary', function (Blueprint $table) {

            // edit table 
            $table->string('sallary_type')->after('signed_date')->nullable()->change();
            $table->string('sallary_form')->after('sallary_type')->nullable()->change();
            $table->integer('amout_allowance')->after('amout_sallary')->nullable()->change();
            $table->string('allowance_type')->after('amout_allowance')->nullable()->change();
            $table->string('note')->after('allowance_type')->nullable()->change();
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
