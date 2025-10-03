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
        Schema::create('ips', function (Blueprint $table) {
            $table->id('id_ip');
            $table->string('ip',50);
            $table->string('codigo', 50);
            $table->string('gateway',50)->nullable();
            $table->string('subred',50)->nullable();
            $table->string('mac',60)->nullable();
            $table->string('puerto',20)->nullable();
            $table->string('switch',50)->nullable();
            $table->unsignedBigInteger('id_ubicacion');
            // Relación con equipos 
            $table->foreign('id_ubicacion')->references('id_ubicacion')->on('ubicaciones')->onDelete('cascade');
            $table->foreign('codigo')->references('codigo')->on('equipos')->onDelete('cascade');
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('ips');
    }
};
