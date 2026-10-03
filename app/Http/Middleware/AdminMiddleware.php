<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please log in to access the administration dashboard.');
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Your administrator account has been deactivated. Please contact support.');
        }

        return $next($request);
    }
}
