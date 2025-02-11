<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and has the admin email
        if (!auth()->check() || auth()->user()->email !== 'admin@gmail.com') {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
} 