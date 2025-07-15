<?php

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsGuru;
use App\Http\Middleware\IsSiswa;
use App\Http\Middleware\CheckSessionValidity;
use App\Http\Middleware\RedirectIfUnauthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\AuthenticateSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ✅ Alias middleware
        $middleware->alias([
            'IsAdmin' => IsAdmin::class,
            'IsGuru'  => IsGuru::class,
            'IsSiswa' => IsSiswa::class,
            'auth'    => RedirectIfUnauthenticated::class, // ⬅️ override bawaan Laravel
        ]);

        // ✅ Tambahkan ke grup middleware `web`
        $middleware->appendToGroup('web', [
            AuthenticateSession::class,
            CheckSessionValidity::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Tidak perlu override handler lagi kalau sudah pakai middleware custom "auth"
    })
    ->create();
