<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Http\Requests\ProdutoCriaRequest;
use App\Http\Requests\ProdutoEditaRequest;
use App\Http\Resources\ProdutoResource;
use App\Services\R2StorageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

final class ProdutoController extends ApiController
{
    public function __construct(private readonly R2StorageService $storageService) {}

    /**
     * Retorna todos os produtos
     */
    public function lista(): JsonResponse
    {
        try {
            $produto = ProdutoResource::collection(Produto::all());
        } catch (\Exception $e) {
            return $this->error('Erro ao buscar categoria: '.$e->getMessage());
        }

        return $this->success(null, $produto);
    }

    /**
     * Retorna um produto pelo ID
     */
    public function listaId(int $id): JsonResponse
    {
        try {
            $produto = new ProdutoResource(Produto::findOrFail($id));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return $this->notFound('Produto não encontrado');
        } catch (\Exception $e) {
            return $this->error('Erro ao buscar produto: '.$e->getMessage());
        }

        return $this->success(null, $produto);
    }

    /**
     * Cria um novo produto
     */
    public function cria(ProdutoCriaRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('imagem')) {
            $restaurante = 'dev';
            $data['imagem'] = $this->storageService->upload(
                $request->file('imagem'), Str::uuid(), $restaurante.'/produtos', 'public'
            );
        }

        try {
            $produto = Produto::create($data);
        } catch (\Exception $e) {
            return $this->error('Erro ao criar produto: '.$e->getMessage());
        }

        return $this->success(null, $produto);
    }

    /**
     * Edita um produto
     */
    public function edita(ProdutoEditaRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        try {
            $produto = Produto::findOrFail($id);
        } catch (\Exception $e) {
            return $this->notFound('Produto não encontrado');
        }

        if ($request->hasFile('imagem')) {
            $path     = $produto->getOriginal('imagem');
            $basePath = dirname($path);

            $this->storageService->delete($path);

            $data['imagem'] = $this->storageService->upload(
                $request->file('imagem'), Str::uuid(), $basePath, 'public'
            );
        }

        $produto->fill($data);

        if ($produto->isDirty()) {
            $produto->save();
        }

        return $this->success(null, $produto);
    }

    /**
     * Deleta um produto
     */
    public function deleta(int $id): JsonResponse
    {
        try {
            $produto = Produto::findOrFail($id);
        } catch (\Exception $e) {
            return $this->notFound('Produto não encontrado');
        }

        $path = $produto->getOriginal('imagem');

        $this->storageService->delete($path);
        $produto->delete();

        return $this->success('Produto deletado com sucesso', null);
    }
}