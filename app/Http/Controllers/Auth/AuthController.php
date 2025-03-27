<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json(['message' => 'Inicio de Sesión Existoso'], 200);
        }

        return response()->json(['message' => 'Email o Contraseña incorrectos'], 401);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Sesión cerrada'], 200);
    }

    public function register(Request $request)
    {
        $response = create($request);

        return response()->json(['message' => 'Registro exitoso', 'register' => $response], 201);

    }
}
