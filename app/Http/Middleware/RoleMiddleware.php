<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        
        if (Auth::user()->role != $role) {
            // Redirect to appropriate dashboard based on role
            return match(Auth::user()->role) {
                'admin' => redirect('/admin'),
                'seller' => redirect('/dashboard'),
                default => redirect('/')
            };
        }
        
        return $next($request);
    }
}