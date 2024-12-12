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
            $table->unsignedBigInteger('field_id');
            $table->text('description');
            $table->dateTime('event_date_time');
            $table->decimal('price', 10, 2);
            $table->string('modality');
            $table->string('status')->default('pending');
            $table->unsignedInteger('num_participants');
            $table->unsignedInteger('num_subscribers')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->json('participants_user_id')->nullable(); // Adicionando o campo JSON para armazenar participantes
            $table->timestamps();

            $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
