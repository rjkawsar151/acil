<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        if (!$user->hasRole($roles)) {
            abort(403, 'Unauthorized access to this module.');
        }

        return $next($request);
    }
}
