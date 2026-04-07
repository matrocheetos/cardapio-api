<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class ApiController
{
    public function success(?string $message = null, array|object|null $data = null): JsonResponse
    {
        return response()->json([
            /** @default false */
            'error' => false,

            'msg' => $message,

            'result' => $data
        ], 200);
    }

    public function error(?string $message = null, array|object|null $data = null): JsonResponse
    {
        return response()->json([
            /** @default true */
            'error' => true,

            'msg' => $message,

            'result' => $data
        ], 400);
    }

    public function notFound(?string $message = null): JsonResponse
    {
        return response()->json([
            /** @default true */
            'error' => true,
            /** @default Recurso não encontrado */
            'msg' => $message ?? 'Recurso não encontrado',

            'result' => null
        ], 404);
    }

    public function unauthorized(?string $message = null): JsonResponse
    {
        return response()->json([
            /** @default true */
            'error' => true,
            /** @default Acesso não autorizado */
            'msg' => $message ?? 'Acesso não autorizado',

            'result' => null
        ], 401);
    }
}