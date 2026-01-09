<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ejercicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('practico_id')->nullable();
            $table->string('tipo'); // suma, resta, multiplicacion, division
            $table->text('enunciado'); // Ejercicio generado
            $table->string('respuesta'); // Respuesta correcta
            $table->integer('cociente')->nullable(); // Cociente para división
            $table->integer('resto')->nullable(); // Resto para división
            $table->string('grado')->nullable(); // Grado de dificultad
            $table->timestamps();

            $table->foreign('practico_id')->references('id')->on('practicos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejercicios');
    }
};
