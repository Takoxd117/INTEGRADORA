<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next): Response
{
    // 1. Verificamos si el usuario es realmente admin
    if (auth()->check() && auth()->user()->role === 'admin') {
        return $next($request);
    }

    // 2. Si NO es admin, comprobamos si ya está intentando ir al dashboard.
    // Si ya está en el dashboard, evitamos redirigirlo de nuevo ahí para romper el bucle.
    if ($request->is('dashboard')) {
        return $next($request); 
    }

    // 3. Si no es admin y no está en el dashboard, lo mandamos al dashboard
    return redirect('/dashboard')->with('error', 'Acceso denegado.');
}
}
