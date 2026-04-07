<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

final class AuthController extends ApiController
{
    /**
     * Login
     * @unauthenticated
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);

        if (auth()->guard('web')->attempt($request->only('email', 'password'), false)) {

            $token = auth()->user()->createToken('auth_token');

            return $this->success(null, [
                'token' => $token->plainTextToken,
                'username' => auth()->user()->name,
                'email' => auth()->user()->email
            ]);
        }

        return $this->unauthorized();
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        try {
            auth()->guard('web')->logout();
            $request->user()->currentAccessToken()->delete();
        } catch (\Exception $e) {
            return $this->error('Erro ao realizar logout: '.$e->getMessage());
        }

        return $this->success('Logout realizado com sucesso');
    }

}
