<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RotasController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\UserController;

//registo
Route::post('/signup', [RegisterController::class, 'storeApi']);

//login
Route::post('/login', [LoginController::class, 'loginApi']);


//para mostrar as rotas~
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logoutApi']);

    Route::post('/deleteacc', [UserController::class, 'destroyApi']);
    
    Route::put('/updatefirstname', [UserController::class, 'updateFirstName']);
    Route::put('/updatelastname', [UserController::class, 'updateLastName']);
    Route::put('/updateemail', [UserController::class, 'updateEmail']);
    Route::put('/updatepassword', [UserController::class, 'updatePassword']);

    Route::get('/rotas', [RotasController::class, 'getRotas']);
    Route::get('/rotas/search', [RotasController::class, 'indexApi']);
    Route::get('/rotas/{id}', [RotasController::class, 'getRotaApi']);
    Route::get('/rotas/zona/{zona}', [RotasController::class, 'getRotasByZona']);
    
    Route::get('/faqs', [FaqController::class, 'indexApi']);
    Route::get('/faqs/{id}', [FaqController::class, 'showApi']);
});


