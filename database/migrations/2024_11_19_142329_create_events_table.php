<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // ID único
            $table->text('description'); // Descrição (renomeado de 'field_name')
            $table->dateTime('event_date_time'); // Data e hora do evento
            $table->decimal('price', 10, 2); // Preço total
            $table->string('modality'); // Modalidade
            $table->unsignedInteger('num_participantes'); // Número de participantes (renomeado de 'participants')
            $table->unsignedBigInteger('user_id'); // ID do usuário (se necessário)
            $table->timestamps(); // Campos created_at e updated_at

            // Relacionamento com a tabela users (se necessário)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
