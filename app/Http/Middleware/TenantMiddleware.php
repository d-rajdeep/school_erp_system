<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login.form');
        }

        $user = Auth::user();

        if (!$user) {
            abort(403, 'User not authenticated');
        }

        if (!$user->tenant_id) {
            abort(403, 'Tenant not assigned');
        }

        return $next($request);
    }
}
