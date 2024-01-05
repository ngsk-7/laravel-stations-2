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
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',100)->comment('映画タイトル')->unique();
            $table->text('image_url')->comment('画像URL');
            $table->integer('published_year')->comment('公開年');
            $table->tinyInteger('is_showing')->comment('上映中かどうか');
            $table->text('description')->comment('概要');
            $table->integer('genre_id')->comment('ジャンル');
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
        Schema::dropIfExists('movies');
    }
}
