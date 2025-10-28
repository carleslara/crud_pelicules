<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyAccessKey
{
    /**
     * Handle an incoming request.
     *
     * Ahora el middleware no realiza cap comprovació i sempre permet la petició.
     */
    public function handle(Request $request, Closure $next)
    {
        // Accés públic: no fem cap comprovació i deixem passar la petició
        return $next($request);
    }
}
