<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommendationTdasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendation_tdas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recommendation_id');
            $table->foreign('recommendation_id')->references('id')->on('recommendations')->onDelete('cascade');
            $table->unsignedInteger('tda_id');
            $table->foreign('tda_id')->references('id')->on('tdas')->onDelete('cascade');
            $table->unsignedInteger('teeth_id');
            $table->foreign('teeth_id')->references('id')->on('teeths')->onDelete('cascade');
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
        Schema::dropIfExists('recommendation_tdas');
    }
}
