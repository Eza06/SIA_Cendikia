<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class RedirectIfUnauthenticated extends Middleware
{
    protected function redirectTo($request): ?string
    {
        // Selalu arahkan ke halaman welcome
        return route('welcome');
    }
}
