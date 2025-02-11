<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('上映日');
            $table->foreignId('user_id')->comment('ユーザーID')->references('id')->on('users');
            $table->foreignId('schedule_id')->comment('スケジュールID')->references('id')->on('schedules');
            $table->unsignedBigInteger('sheet_id')->comment('シートID');
            $table->foreign('sheet_id')->references('id')->on('sheets');
            $table->unique(['schedule_id', 'sheet_id']);
            $table->string('email',255)->comment('予約者メールアドレス');
            $table->string('name',255)->comment('予約者名');
            $table->tinyInteger('is_canceled')->default(0)->comment('予約キャンセル済み');
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
        Schema::dropIfExists('reservations');
    }
}
