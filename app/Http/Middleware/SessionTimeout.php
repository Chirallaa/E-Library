<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    protected $timeout = 1200; // Waktu timeout dalam detik (misalnya 20 menit)

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = session('lastActivityTime');
            if ($lastActivity && (time() - $lastActivity > $this->timeout)) {
                Auth::logout();
                session()->flush();
                return redirect()->route('login')->withErrors(['message' => 'You have been logged out due to inactivity.']);
            }
            session(['lastActivityTime' => time()]);
        }

        return $next($request);
    }
}