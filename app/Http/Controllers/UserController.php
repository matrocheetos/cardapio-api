<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCriaRequest;
use App\Models\FeatureFlag;
use App\Models\User;
use Illuminate\Http\Request;

final class UserController extends ApiController
{
    /**
     * Registrar um novo usuário
     * @unauthenticated
     */
    public function cria(UserCriaRequest $request)
    {
        $registroEnabled = FeatureFlag::where('name', '=', 'user_registration')->value('enabled');

        if ($registroEnabled === null) {
            return $this->error('Configuração de registro de usuários não encontrada');
        }

        if (!$registroEnabled) {
            return $this->error('Registro de usuários desabilitado');
        }

        $data = $request->validated();

        try {
            $user = User::create($data);

            return $this->success('Usuário criado com sucesso', $user);
        } catch (\Exception $e) {
            return $this->error('Erro ao criar usuário: '.$e->getMessage());
        }
    }

    /**
     * Editar dados do usuário
     */
    public function edita(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8',
        ]);

        if ($request->has('name')) {
            $user->name = $request->input('name');
        }
        if ($request->has('email')) {
            $user->email = $request->input('email');
        }
        if ($request->has('password')) {
            $user->password = $request->input('password');
        }

        if ($user->save()) {
            return $this->success('Usuário atualizado com sucesso', $user);
        } else {
            return $this->error('Erro ao atualizar usuário');
        }
    }
}