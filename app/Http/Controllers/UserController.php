<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::when($search, function ($query) use ($search) {
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
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->paginate(6);

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

        if (Auth::check() && Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Não pode eliminar a si próprio.');
        }

        $tipo = $user->tipo; // guardar antes de eliminar
        $user->delete();

        if ($tipo === 'admin') {
            return redirect()->route('admins.index')->with('success', 'Administrador eliminado com sucesso.');
        } else {
            return redirect()->route('users.index')->with('success', 'Utilizador eliminado com sucesso.');
        }
    }


    //para a aplicação android

    public function destroyApi(Request $request)
    {
        $user = $request->user(); // Isto vem do token (sanctum/passport/etc)

        if (!$user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully.'], 200);
    }

    public function updateFirstName(Request $request)
    {
        $user = $request->user(); // Isto vem do token (sanctum/passport/etc)

        if (!$user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
        ]);

        $user->first_name = $request->input('first_name');
        $user->save();

        return response()->json(['message' => 'Primeiro nome atualizado com sucesso.'], 200);
    }

    public function updateLastName(Request $request)
    {
        $user = $request->user(); // Isto vem do token (sanctum/passport/etc)

        if (!$user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $request->validate([
            'last_name' => 'required|string|max:255',
        ]);

        $user->last_name = $request->input('last_name');
        $user->save();

        return response()->json(['message' => 'Último nome atualizado com sucesso.'], 200);
    }

    public function updateEmail(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Não autorizado.'], 401);
        }

        $newEmail = $request->input('email');

        if (!$newEmail || !filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['message' => 'O email fornecido não é válido.'], 422);
        }

        if (strlen($newEmail) > 255) {
            return response()->json(['message' => 'O email excede 255 caracteres.'], 422);
        }

        if (User::where('email', $newEmail)->where('id', '!=', $user->id)->exists()) {
            return response()->json(['message' => 'Este email já está em uso por outro user.'], 422);
        }

        if ($user->email === $newEmail) {
            return response()->json(['message' => 'O email é o mesmo que o atual.'], 200);
        }

        $user->email = $newEmail;
        $user->save();

        return response()->json(['message' => 'Email atualizado com sucesso.'], 200);
    }


    public function updatePassword(Request $request)
    {
        $user = $request->user(); // Isto vem do token (sanctum/passport/etc)

        if (!$user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        // Verifica se a senha atual está correta
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json(['message' => 'A palavra-passe atual está incorreta.'], 422);
        }

        // Atualiza a senha do usuário
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return response()->json(['message' => 'Palavra-passe atualizada com sucesso.'], 200);
    }
}
