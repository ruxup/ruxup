<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rating', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rater_id');
            $table->foreign('rater_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('ratee_id');
            $table->foreign('ratee_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('star', 1)->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rating');
    }
}
