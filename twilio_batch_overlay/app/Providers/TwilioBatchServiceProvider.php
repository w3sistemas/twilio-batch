<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TwilioBatchServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Carrega rotas adicionais sem precisar editar routes/web.php
        $routesPath = base_path('routes/batches.php');
        if (file_exists($routesPath)) {
            require $routesPath;
        }
    }
}
