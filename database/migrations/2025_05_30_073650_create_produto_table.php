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
        Schema::create('produto', function (Blueprint $table) {
            $table->id('id_produto');
            $table->foreignId('id_categoria')
                ->nullable();
            $table->string('nome', 255);
            $table->string('descricao', 255);
            $table->string('imagem', 255);
            $table->decimal('preco', 8, 2);
            $table->decimal('preco_desconto', 8, 2)
                ->nullable()
                ->default(null);
            $table->boolean('eh_vegano')
                ->default(false);
            $table->boolean('eh_sem_gluten')
                ->default(false);
            $table->boolean('em_estoque')
                ->default(true);
            $table->unsignedTinyInteger('porcoes')
                ->nullable();

            // Foreign key constraints
            $table->foreign('id_categoria')
                ->references('id_categoria')
                ->on('categoria')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produto');
    }
};
