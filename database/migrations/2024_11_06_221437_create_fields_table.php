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
            $table->uuid('id')->primary();           
            $table->uuid('user_id'); // Ensure this is the correct data type (uuid)
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('contact')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->string('modality')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['disponível', 'ocupado', 'manutenção'])->default('disponível');

            //google maps
            $table->decimal('latitude', 10, 8)->nullable(); 
            $table->decimal('longitude', 11, 8)->nullable();

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
