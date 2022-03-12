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
        Schema::dropIfExists('work_periods');
        Schema::create('work_periods', function (Blueprint $table) {
            $table->id();
            $table->string("type")->nullable();
            $table->dateTime("start")->nullable();
            $table->dateTime("stop")->nullable();
            $table->integer("minutes")->nullable();
            $table->bigInteger("workday_id")->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('workday_id')->references('id')->on('workdays')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_periods');
    }
};
