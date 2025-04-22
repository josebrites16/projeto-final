<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Rota;
use App\Http\Controllers\RotasController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('home');
});
/*
Route::get('/users', function () {
    return view('users', [
        'users' => User::all()
    ]);
});
*/
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/admins', [UserController::class, 'admins'])->name('admins.index');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::put('/users/{id}', [UserController::class, 'updateType'])->name('users.updateType');

Route::get('/users/{id}', function ($id) {
    $user = User::find($id);
    return view('user', ['user' => $user]);
});



// Rotas para rotas (usando o controller)
Route::get('/rotas', [RotasController::class, 'index'])->name('rotas.index');
Route::get('/rotas/create', [RotasController::class, 'create'])->name('rotas.create');
Route::post('/rotas', [RotasController::class, 'store'])->name('rotas.store');
Route::get('/rotas/{id}', [RotasController::class, 'show'])->name('rotas.show');
Route::get('/rotas/{id}/edit', [RotasController::class, 'edit'])->name('rotas.edit');
Route::put('/rotas/{id}', [RotasController::class, 'update'])->name('rotas.update'  );
Route::delete('/rotas/{id}', [RotasController::class, 'destroy'])->name('rotas.destroy');
