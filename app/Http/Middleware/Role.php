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
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();
        if ($user->role && in_array($user->role->nama, $roles)) {
            return $next($request);
        }

        // Jika middleware 'role:admin' bisa juga diakses 'super_admin', bisa ditambahkan di sini
        if (in_array('super_admin', $roles) && $user->role && $user->role->nama === 'admin') {
            return $next($request); 
        }

        abort(403, 'Unauthorized access - Invalid Role.');
    }
}
