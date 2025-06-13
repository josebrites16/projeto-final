<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (!Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Credenciais inválidas.'
            ]);
        }

        // Verifica se o tipo do utilizador autenticado é "admin"
        if (Auth::user()->tipo !== 'admin') {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Apenas administradores podem aceder.'
            ]);
        }

        request()->session()->regenerate();

        return redirect('/rotas')->with('success', 'Sessão iniciada com sucesso.');
    }

    public function destroy()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'You have been logged out.');
    }

    //PARA A APLICAÇÃO ANDROID

    public function loginApi(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function logoutApi(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json(['message' => 'Logout successful']);
    }
}
