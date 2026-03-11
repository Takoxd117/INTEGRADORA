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
        // Verifica si el usuario está autenticado Y es administrador
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Si no es admin, redirige al dashboard con un error
        return redirect('/dashboard')->with('error', 'Acceso denegado. Solo administradores.');
    }
}
