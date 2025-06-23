<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RotasController;
use App\Http\Controllers\FaqController;


//registo
Route::post('/signup', [RegisterController::class, 'storeApi']);

//login
Route::post('/login', [LoginController::class, 'loginApi']);


//para mostrar as rotas~
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logoutApi']);
    Route::get('/rotas', [RotasController::class, 'getRotas']);
    Route::get('/rotas/search', [RotasController::class, 'indexApi']);
    Route::get('/rotas/{id}', [RotasController::class, 'getRotaApi']);
    Route::get('/rotas/zona/{zona}', [RotasController::class, 'getRotasByZona']);
    
    Route::get('/faqs', [FaqController::class, 'indexApi']);
    Route::get('/faqs/{id}', [FaqController::class, 'showApi']);
});


