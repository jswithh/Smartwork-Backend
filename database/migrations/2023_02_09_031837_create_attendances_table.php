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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id')->unsigned();
            $table->bigInteger('company_id')->unsigned();
            $table->dateTime('clock_in');
            $table->dateTime('clock_out');
            $table->string('working_from');
            $table->float('late');
            $table->string('clock_out_address');
            $table->float('working_hours');
            $table->time('break_in');
            $table->time('break_out');
            $table->float('break_hours');
            $table->float('totally');
            $table->float('overtime');
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
        Schema::dropIfExists('attendances_tabel');
    }
};
