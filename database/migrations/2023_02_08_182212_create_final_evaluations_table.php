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
        Schema::create('final_evaluations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('goal_id')->unsigned();
            $table->bigInteger('midyear_id')->unsigned();
            $table->string('final_realization');
            $table->string('final_goal_status');
            $table->string('final_employee_score');
            $table->string('final_manager_score');
            $table->string('final_employee_behavior');
            $table->string('final_manager_behavior');
            $table->string('final_manager_comment');
            $table->string('final_employee_comment');
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
        Schema::dropIfExists('final_evaluations');
    }
};
