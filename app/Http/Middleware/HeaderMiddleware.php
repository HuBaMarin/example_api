<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HeaderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('accept') != 'application/vnd.api+json') {
            return response()->json([
                'error' => 'Error procesando la respuesta',
                'status' => 406,
                "details" => 'Error procesando la respuesta'
            ], 406);
        }
        return $next($request);
    }
}
