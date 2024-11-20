<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
{
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->text('description');
        $table->dateTime('event_date_time');
        $table->decimal('price', 10, 2);
        $table->string('modality');
        $table->integer('num_participantes');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('field_id'); // Adicione esta linha
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade'); // Adicione esta linha
    });
}

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
