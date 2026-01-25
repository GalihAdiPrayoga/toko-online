<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->guest(route('login'));
        }

        $user = auth()->user();

        if ($request->is('penjual*') && $user->role !== 'penjual') {
            return redirect('/');
        }

        if ($request->is('pembeli*') && $user->role !== 'pembeli') {
            return redirect('/');
        }

        return $next($request);
    }
}
