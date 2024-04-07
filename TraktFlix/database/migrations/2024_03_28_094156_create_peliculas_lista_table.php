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
        Schema::create('peliculas_lista', function (Blueprint $table) {
            $table->string('pelicula_lista_id')->primary();
            $table->string('lista_id');
            $table->string("trakt_id");
            $table->boolean("activo")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peliculas_lista');
    }
};
