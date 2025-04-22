<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        if(! Auth::attempt($attributes)){
            throw ValidationException::withMessages([
                'email' => 'Invalid credentials.'
            ]);
        }
        

        request()->session()->regenerate();

        return redirect('/rotas')->with('success', 'You are now logged in.');
    }
    
    public function destroy()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'You have been logged out.');
    }
}