<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('description'); 
            $table->dateTime('event_date_time'); 
            $table->decimal('price', 10, 2); 
            $table->string('modality'); 
            $table->unsignedInteger('num_participantes'); 
            $table->uuid('field_id');
            $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};