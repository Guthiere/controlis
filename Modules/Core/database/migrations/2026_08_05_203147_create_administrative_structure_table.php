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
        Schema::create('administrative_structure', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo'); // Ej: Sede, Departamento, Unidad, Oficina
            $table->foreignId('parent_id')->nullable()->constrained('administrative_structure')->onDelete('cascade');

            $table->timestamps();
        });

        // Divisiones Geográficas (Recursiva)
        Schema::create('geographical_divisions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ej: Región, Provincia, Municipio, Distrito
            $table->string('tipo');
           $table->foreignId('parent_id')->nullable()->constrained('geographical_divisions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrative_structure');
        Schema::dropIfExists('geographical_divisions');
    }
};


