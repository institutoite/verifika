<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('multiplicacions', function (Blueprint $table) {
            $table->id();
            $table->string('tipo')->default('multiplicacion');
            $table->string('enunciado');
            $table->string('respuesta');
            $table->string('grado')->nullable();
            $table->unsignedBigInteger('practico_id')->nullable();
            $table->timestamps();
            $table->foreign('practico_id')->references('id')->on('practicos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multiplicacions');
    }
};
