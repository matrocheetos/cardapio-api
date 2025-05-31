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
        Schema::create('mesa', function (Blueprint $table) {
            $table->id('comanda');
            $table->unsignedSmallInteger('nro_mesa');
            $table->enum('status_pagamento', ['PAGO', 'PENDENTE', 'CANCELADO'])
                ->default('PENDENTE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesa');
    }
};
