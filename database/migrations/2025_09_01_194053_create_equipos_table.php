<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id('id_equipo');
            $table->string('codigo', 50)->unique();
            $table->text('descripcion');
            $table->string('estado', 100)->nullable();
            
            // Relación con componentes
            $table->unsignedBigInteger('id_comp')->nullable();
            $table->foreign('id_comp')->references('id_comp')->on('componentes')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('equipos');
    }
};
