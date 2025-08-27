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
        Schema::create('restaurante', function (Blueprint $table) {
            $table->id('id_restaurante');
            $table->string('nome', 32)
                ->unique();
            $table->string('telefone', 15)
                ->nullable();
            $table->string('email', 255)
                ->nullable();
            $table->string('endereco', 255)
                ->nullable();
            $table->string('database_name', 64)
                ->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurante');
    }
};
