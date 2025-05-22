<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * O caminho para a sua home route.
     *
     * Normalmente usado após o login.
     */
    public const HOME = '/home';

    /**
     * Define os grupos de rotas para a aplicação.
     */
    public function boot(): void
    {
        $this->routes(function () {
            // Rotas da API
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Rotas Web
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
