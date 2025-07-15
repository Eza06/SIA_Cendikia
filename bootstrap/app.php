<?php

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsGuru;
use App\Http\Middleware\IsSiswa;
use App\Http\Middleware\RedirectIfUnauthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Alias middleware kustom
        $middleware->alias([
            'IsAdmin' => IsAdmin::class,
            'IsGuru'  => IsGuru::class,
            'IsSiswa' => IsSiswa::class,
            'auth'    => RedirectIfUnauthenticated::class, // Override bawaan Laravel
        ]);

        // Tambahkan ke grup web
        $middleware->appendToGroup('web', [
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \App\Http\Middleware\CheckSessionValidity::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Tidak perlu override Handler lagi kalau pakai middleware ini
    })
    ->create();
