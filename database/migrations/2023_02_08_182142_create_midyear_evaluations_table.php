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
        Schema::create('midyear_evaluations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('goal_id')->unsigned();
            $table->string('midyear_realization');
            $table->string('midyear_manager_comment');
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
        Schema::dropIfExists('midyear_evaluations');
    }
};
