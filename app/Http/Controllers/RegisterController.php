<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
 
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'first_name' => ['required','max:255'],
            'last_name' => ['required','max:255'],
            'email' => ['required','email','max:255'],
            'password' => ['required', Password::min(6), 'confirmed'] //confirmação
        ]);

        $attributes['tipo'] = 'admin'; 

        User::create($attributes);

        return redirect('/')->with('success', 'Your account has been created.');
    }
}
