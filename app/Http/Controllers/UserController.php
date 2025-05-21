<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::when($search, function($query) use ($search) {
            return $query->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })->get();

        return view('users', compact('users'));
    }

    public function admins(Request $request)
    {
        $search = $request->input('search');
        $users = User::where('tipo', 'admin')
            ->when($search, function($query) use ($search) {
                return $query->where('first_name', 'like', "%{$search}%")
                             ->orWhere('last_name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->get();
    
        return view('admins', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user', compact('user'));
    }

    public function updateType(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|string',
        ]);

        $user = User::findOrFail($id);
        $user->tipo = $request->input('tipo');
        $user->save();

        return redirect()->route('users.index')->with('success', 'User type updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
