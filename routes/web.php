<?php

use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Rota;
use App\Http\Controllers\RotasController;
use App\Models\Faq;

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

// Rotas para rotas (usando o controller)
Route::get('/rotas', [RotasController::class, 'index'])->name('rotas.index');
Route::get('/rotas/create', [RotasController::class, 'create'])->name('rotas.create');
Route::post('/rotas', [RotasController::class, 'store'])->name('rotas.store');
Route::get('/rotas/{id}', [RotasController::class, 'show'])->name('rotas.show');
Route::get('/rotas/{id}/edit', [RotasController::class, 'edit'])->name('rotas.edit');
Route::put('/rotas/{id}', [RotasController::class, 'update'])->name('rotas.update'  );
Route::delete('/rotas/{id}', [RotasController::class, 'destroy'])->name('rotas.destroy');




//rotas para FAQ
Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
Route::get('/faqs/create', [FaqController::class, 'create'])->name('faqs.create');
Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
Route::get('/faqs/{id}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
Route::put('/faqs/{id}', [FaqController::class, 'update'])->name('faqs.update');
Route::delete('/faqs/{id}', [FaqController::class, 'destroy'])->name('faqs.destroy');

