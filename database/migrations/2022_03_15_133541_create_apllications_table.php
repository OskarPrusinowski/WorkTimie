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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string("type")->nullable();
            $table->date("date")->nullable();
            $table->date("first_date")->nullable();
            $table->date("second_date")->nullable();
            $table->longText("comment")->nullable();
            $table->integer("minutes")->nullable();
            $table->date("acceptation_date")->nullable();
            $table->string("status")->nullable();
            $table->boolean("accepted")->nullable();
            $table->bigInteger("user_id")->nullable()->unsigned();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
};
