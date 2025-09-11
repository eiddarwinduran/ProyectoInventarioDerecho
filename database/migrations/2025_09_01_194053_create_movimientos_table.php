<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id('id_movimiento');
            $table->string('codigo', 50);
            $table->string('ci', 20);

            // Relación con ubicaciones
            $table->unsignedBigInteger('id_ubicacion');
            $table->foreign('id_ubicacion')->references('id_ubicacion')->on('ubicaciones')->onDelete('cascade');

            $table->dateTime('fecha_movimiento')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('estado', 100)->nullable();
            $table->text('detalle')->nullable();

            // Relación con equipos y responsables
            $table->foreign('codigo')->references('codigo')->on('equipos')->onDelete('cascade');
            $table->foreign('ci')->references('ci')->on('responsables')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
