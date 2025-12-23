<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        api: __DIR__.'/../routes/api.php'
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 🔹 Aliases déjà présents
        $middleware->alias([
            'auth.apikey' => \App\Http\Middleware\ApiKeyMiddleware::class,
            'auth'        => \App\Http\Middleware\LoginMiddleware::class,
            'admin'       => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // 🔹 Middleware global appliqué à toutes les routes web et api
        $middleware->web(append: [
            \App\Http\Middleware\ApplyMailConfig::class,
        ]);

        $middleware->api(append: [
            \App\Http\Middleware\ApplyMailConfig::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
