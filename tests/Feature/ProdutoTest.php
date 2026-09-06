<?php

use App\Models\Categoria;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('lista todos os produtos publicamente', function () {
    Produto::factory()->count(3)->create();

    $this->getJson('/api/cardapio/produtos')
        ->assertSuccessful()
        ->assertJsonStructure([
            'result' => [
                '*' => ['id_produto', 'nome', 'descricao', 'preco'],
            ],
        ]);
});

it('impede criacao de produto para visitantes (nao logados)', function () {
    $this->postJson('/api/cardapio/produtos/cria', [
        'nome' => 'Novo Produto',
        'preco' => 10.50,
    ])->assertUnauthorized();
});

it('permite criacao de produto para usuarios autenticados pelo sanctum', function () {
    Storage::fake('r2');
    $user = User::factory()->create();
    $categoria = Categoria::factory()->create();

    $this->actingAs($user)->postJson('/api/cardapio/produtos/cria', [
        'id_categoria' => $categoria->id_categoria,
        'nome' => 'Hamburguer Especial',
        'descricao' => 'Pão, carne e queijo.',
        'imagem' => UploadedFile::fake()->image('produto.jpg'),
        'preco' => 25.90,
        'eh_vegano' => false,
        'eh_sem_gluten' => false,
        'em_estoque' => true,
        'porcoes' => 1,
    ])->assertSuccessful();

    $this->assertDatabaseHas('produto', [
        'nome' => 'Hamburguer Especial',
    ]);
});

it('permite delecao de produto para usuarios logados', function () {
    Storage::fake('r2');
    $user = User::factory()->create();
    $produto = Produto::factory()->create();

    $this->actingAs($user)->deleteJson("/api/cardapio/produtos/deleta/{$produto->id_produto}")
        ->assertSuccessful();

    $this->assertDatabaseMissing('produto', [
        'id_produto' => $produto->id_produto,
    ]);
});
