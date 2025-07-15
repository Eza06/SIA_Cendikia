<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSessionValidity
{
    public function handle(Request $request, Closure $next)
    {
        // CheckSessionValidity.php
        if (Auth::check()) {
            $user             = Auth::user();
            $currentSessionId = $request->session()->getId();

            \Log::info("✅ Middleware aktif untuk {$user->email}");
            \Log::info("Last session: {$user->last_session_id} | Current: {$currentSessionId}");

            // ✅ Skip logout jika session belum pernah disimpan (login pertama kali)
            if (! is_null($user->last_session_id) && $user->last_session_id !== $currentSessionId) {
                session(['last_role' => $user->role]);

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('welcome');
            }
        }

        return $next($request);
    }
}
