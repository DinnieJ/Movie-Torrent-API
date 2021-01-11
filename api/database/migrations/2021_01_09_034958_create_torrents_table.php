<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTorrentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('torrent', function (Blueprint $table) {
            $table->bigIncrements('torrent_id');
            $table->foreignId('movie_id');
            $table->string('url');
            $table->string('hash');
            $table->string('quality');
            $table->string('type');
            $table->bigInteger('size');
            $table->integer('date_uploaded');
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
        Schema::dropIfExists('torrent');
    }
}
