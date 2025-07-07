<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Password::min(6), 'confirmed'] //confirmação
        ], [
            'email.unique' => 'Este email já está em uso.',
            'password.confirmed' => 'A confirmação da password não coincide.',
        ]);

        $attributes['tipo'] = 'admin';

        User::create($attributes);

        return redirect('/')->with('success', 'Your account has been created.');
    }

    //PARA A APLICAÇÃO ANDROID
    public function storeApi(Request $request)
    {
        $attributes = $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', Password::min(6), 'confirmed'] //confirmação
        ]);

        $attributes['tipo'] = 'user'; // Defina o tipo padrão como 'user'
        $attributes['password'] = Hash::make($attributes['password']);

        User::create($attributes);

        return response()->json(['message' => 'User created successfully'], 201);
    }
}
