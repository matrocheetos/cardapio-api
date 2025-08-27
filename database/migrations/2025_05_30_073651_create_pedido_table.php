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
        Schema::create('pedido', function (Blueprint $table) {
            $table->id('id_pedido');
            $table->foreignId('comanda');
            $table->foreignId('id_produto')
                ->nullable();
            $table->string('observacao', 255)
                ->nullable();
            $table->enum('status_pedido',['PREPARANDO', 'PRONTO', 'ENTREGUE', 'CANCELADO'])
                ->default('PREPARANDO');
            $table->timestamp('data_pedido', 0);
            $table->timestamp('data_atualizacao', 0);

            // Foreign key constraints
            $table->foreign('comanda')
                ->references('comanda')
                ->on('mesa')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('id_produto')
                ->references('id_produto')
                ->on('produto')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido');
    }
};
