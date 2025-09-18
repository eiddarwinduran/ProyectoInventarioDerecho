<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bajas', function (Blueprint $table) {
            $table->id('id_baja');
            $table->string('codigo', 50);
            $table->string('ci', 20);
            $table->dateTime('fecha_baja')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('estado', 100)->nullable();
            $table->text('descripcion')->nullable();

            // Relación con equipos 
            $table->foreign('codigo')->references('codigo')->on('equipos')->onDelete('cascade');
            $table->foreign('ci')->references('ci')->on('responsables')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bajas');
    }
};
