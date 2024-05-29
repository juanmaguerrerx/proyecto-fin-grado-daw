<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Verificar si el usuario es administrador
            if (Auth::user()->admin) {
                // Si el usuario es administrador, continúa con la solicitud
                return $next($request);
            } else {
                // Si el usuario no es administrador, redirige a una página de acceso denegado o muestra un error
                return redirect()->route('login');
            }
        } else {
            // Si el usuario no está autenticado, redirige al inicio de sesión
            return redirect()->route('login');
        }
    }
}
