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
        Schema::create('workdays', function (Blueprint $table) {
            $table->id();
            $table->string('holiday')->nullable();
            $table->string("day")->nullable();
            $table->date("date")->nullable();
            $table->dateTime("start")->nullable();
            $table->dateTime("stop")->nullable();
            $table->integer("breaktime")->nullable();
            $table->integer("worktime")->nullable();
            $table->integer("overtime")->nullable();
            $table->bigInteger("user_id")->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workdays');
    }
};
