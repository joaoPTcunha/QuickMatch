<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // Nome do campo
            $table->text('description')->nullable();      // Descrição do campo
            $table->string('image')->nullable();          // URL da imagem do campo
            $table->decimal('cost', 10, 2)->nullable();   // Custo do campo
            $table->string('location')->nullable();       // Localização (pode ser um endereço ou coordenadas)
            $table->boolean('availability')->default(true); // Disponibilidade (sim/não)
            $table->string('contact')->nullable();        // Contato do campo
            $table->decimal('price', 10, 2)->nullable();  // Preço de aluguel ou uso
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
