<?php

use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\RotasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PontoController;


Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/rotas');
    }

    return redirect('/login');
});


Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');


Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/admins', [UserController::class, 'admins'])->name('admins.index');
    Route::middleware(['auth'])->group(function () {
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
    Route::put('/users/{id}', [UserController::class, 'updateType'])->name('users.updateType');

    Route::get('/users/{id}', function ($id) {
        $user = User::find($id);
        return view('user', ['user' => $user]);
    });

    Route::get('/rotas', [RotasController::class, 'index'])->name('rotas.index');
    Route::get('/rotas/create', [RotasController::class, 'create'])->name('rotas.create');
    Route::post('/rotas', [RotasController::class, 'store'])->name('rotas.store');
    Route::get('/rotas/{id}', [RotasController::class, 'show'])->name('rotas.show');
    Route::get('/rotas/{id}/edit', [RotasController::class, 'edit'])->name('rotas.edit');
    Route::put('/rotas/{id}', [RotasController::class, 'update'])->name('rotas.update');
    Route::delete('/rotas/{id}', [RotasController::class, 'destroy'])->name('rotas.destroy');

    Route::put('/pontos/{ponto}', [PontoController::class, 'update'])->name('pontos.update');
    Route::get('/rotas/{rota}/pontos/{ponto}/edit', [PontoController::class, 'edit'])->name('pontos.edit');
    Route::delete('/pontos/{ponto}', [PontoController::class, 'destroy'])->name('pontos.destroy');


    Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
    Route::get('/faqs/create', [FaqController::class, 'create'])->name('faqs.create');
    Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
    Route::get('/faqs/{id}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
    Route::put('/faqs/{id}', [FaqController::class, 'update'])->name('faqs.update');
    Route::delete('/faqs/{id}', [FaqController::class, 'destroy'])->name('faqs.destroy');


    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');


    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
