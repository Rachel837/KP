<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();
        if ($user->role && $user->role->nama === $role) {
            return $next($request);
        }

        // Jika middleware 'role:admin' bisa juga diakses 'super_admin', bisa ditambahkan di sini
        if ($role === 'super_admin' && $user->role && $user->role->nama === 'admin') {
            return $next($request); 
        }

        abort(403, 'Unauthorized access - Invalid Role.');
    }
}
