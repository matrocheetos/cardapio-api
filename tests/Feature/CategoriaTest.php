<?php

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lista todas as categorias sem precisar de autenticação', function () {
    Categoria::factory()->count(2)->create();

    $this->getJson('/api/cardapio/categorias')
        ->assertSuccessful();
});

it('permite atualizacao de categoria por usuario autenticado', function () {
    $user = User::factory()->create();
    $categoria = Categoria::factory()->create(['descricao' => 'Bebidas']);

    // Verifica que PUT em /edita/{id} requer middleware Sanctum e funciona se autenticado
    $this->actingAs($user)->putJson("/api/cardapio/categorias/edita/{$categoria->id_categoria}", [
        'descricao' => 'Sucos',
    ])->assertSuccessful();

    $this->assertDatabaseHas('categoria', [
        'id_categoria' => $categoria->id_categoria,
        'descricao' => 'Sucos',
    ]);
});

it('permite manter a mesma descricao ao atualizar categoria', function () {
    $user = User::factory()->create();
    $categoria = Categoria::factory()->create(['descricao' => 'Bebidas']);

    $this->actingAs($user)->putJson("/api/cardapio/categorias/edita/{$categoria->id_categoria}", [
        'descricao' => 'Bebidas',
    ])->assertSuccessful();

    $this->assertDatabaseHas('categoria', [
        'id_categoria' => $categoria->id_categoria,
        'descricao' => 'Bebidas',
    ]);
});

it('impede atualizacao para descricao ja existente em outra categoria', function () {
    $user = User::factory()->create();
    Categoria::factory()->create(['descricao' => 'Bebidas']);
    $categoria2 = Categoria::factory()->create(['descricao' => 'Sobremesas']);

    $this->actingAs($user)->putJson("/api/cardapio/categorias/edita/{$categoria2->id_categoria}", [
        'descricao' => 'Bebidas',
    ])->assertStatus(401)
        ->assertJsonPath('result.descricao.0', 'A categoria já existe.');
});
