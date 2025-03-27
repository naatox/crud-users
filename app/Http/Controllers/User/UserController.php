<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
// use hash


class UserController extends Controller
{
    public function all()
    {
        return response()->json(User::all());
    }

    public function create(Request $request)
    {
        try {
            $messages = makeMessages();
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string'
            ], $messages);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'remember_token' => Str::random(10),
                'email_verified_at' => now()
            ]);

            return response()->json(['message' => 'Usuario creado correctamente', 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function delete($mail)
    {
        try {
            $user = User::where('email', $mail)->first();
            if ($user) {
                $user->delete();
                return response()->json(['message' => 'Usuario eliminado']);
            }
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function get($mail)
    {
        try {
            $user = User::where('email', $mail)->first();
            if ($user) {
                return response()->json($user);
            }
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $mail) // ✅ "Request" corregido
    {
        try {
            $user = User::where('email', $mail)->first();
            if (!$user) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }

            $messages = makeMessages(); // ✅ Definir correctamente $messages
            $validatedData = $request->validate([
                'name' => 'sometimes|string',
                'email' => 'sometimes|email|unique:users,email,' . $user->id,
                'password' => 'sometimes|string'
            ], $messages);

            $user->update([
                'name' => $validatedData['name'] ?? $user->name,
                'email' => $validatedData['email'] ?? $user->email,
                'password' => isset($validatedData['password']) ? bcrypt($validatedData['password']) : $user->password,
                'remember_token' => Str::random(10),
                'email_verified_at' => now()
            ]);

            return response()->json(['message' => 'Usuario actualizado']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
