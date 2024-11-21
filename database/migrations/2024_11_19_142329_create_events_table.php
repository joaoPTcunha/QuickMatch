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
            $table->unsignedInteger('num_participantes'); 
            $table->unsignedBigInteger('user_id'); 
            $table->timestamps(); 

           
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
