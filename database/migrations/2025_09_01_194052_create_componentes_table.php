<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('componentes', function (Blueprint $table) {
            $table->id('id_comp');
            $table->string('procesador', 50);
            $table->string('tarjeta_madre', 50);
            $table->string('ram', 50);
            $table->string('disco_duro', 50);
            $table->string('tarjeta_video', 50);
            $table->string('tarjeta_red', 50);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('componentes');
    }
};
