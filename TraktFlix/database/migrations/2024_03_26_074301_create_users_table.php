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
        Schema::create('users', function (Blueprint $table) {
                    $table->string('user_id')->primary();
                    $table->string('nombre');
                    $table->string('email');
                    $table->string('password');
                    $table->timestamp('fecha_registro')->nullable();
                    $table->date('fecha_nacimiento')->nullable();
                    $table->string('usuario');
                    $table->boolean('activo')->default(true);
                    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
