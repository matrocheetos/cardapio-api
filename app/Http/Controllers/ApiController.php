<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class ApiController
{
    public function success(string $message = null, array|object $data = null): JsonResponse
    {
        return response()->json([
            'error'  => false,
            'msg'    => $message,
            'result' => $data
        ], 200);
    }

    public function error(string $message = null, array|object $data = null): JsonResponse
    {
        return response()->json([
            'error'  => true,
            'msg'    => $message,
            'result' => $data
        ], 400);
    }

    public function notFound(string $message = null): JsonResponse
    {
        return response()->json([
            'error'  => true,
            'msg'    => $message ?? 'Recurso não encontrado',
            'result' => null
        ], 404);
    }
}