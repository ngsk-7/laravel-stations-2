<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practices', function (Blueprint $table) {
            $table->id();
            $table->text('title')->comment('タイトル');
            $table->timestamps();
        });
        //alter tableなどもここで指定可能
        //migrateは積み重ねていくのが基本のため、DB構造に変更があった場合は、変更分のmigrateファイルを増やしていく
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('practices');
    }
}
