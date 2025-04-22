<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Rota;
use App\Http\Controllers\RotasController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('home');
});

Route::get('/users', function () {
    return view('users', [
        'users' => User::all()
    ]);
});

Route::get('/users/{id}', function ($id) {
    $user = User::find($id);
    return view('user', ['user' => $user]);
});

Route::middleware(['auth'])->group(function () {
Route::get('/rotas', [RotasController::class, 'index'])->name('rotas.index');
Route::get('/rotas/create', [RotasController::class, 'create'])->name('rotas.create');
Route::post('/rotas', [RotasController::class, 'store'])->name('rotas.store');
Route::get('/rotas/{id}', [RotasController::class, 'show'])->name('rotas.show');
Route::get('/rotas/{id}/edit', [RotasController::class, 'edit'])->name('rotas.edit');
Route::put('/rotas/{id}', [RotasController::class, 'update'])->name('rotas.update'  );
Route::delete('/rotas/{id}', [RotasController::class, 'destroy'])->name('rotas.destroy');


Route::get('/register', [RegisterController::class, 'create']);
Route::post('/register', [RegisterController::class, 'store']);


Route::post('/logout', [LoginController::class, 'destroy']);
});

Route::post('/login', [LoginController::class, 'store']);
Route::get('/login', [LoginController::class, 'create']);
