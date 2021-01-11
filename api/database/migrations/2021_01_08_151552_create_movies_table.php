<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie', function (Blueprint $table) {
            $table->bigIncrements('movie_id');
            $table->string('title');
            $table->string('title_eng');
            $table->integer('year');
            $table->double('rating', 8, 2);
            $table->longText('description');
            $table->string('background_img');
            $table->string('cover_img');
            $table->string('url');
            $table->string('source_movie_id');
            $table->string('source');
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
        Schema::dropIfExists('movie');
    }
}
