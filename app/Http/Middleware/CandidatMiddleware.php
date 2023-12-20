<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CandidatMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next) : Response
    {
        $user = Auth::user();

        if ($user && $user->role === 'User') {
            return $next($request);
        }

        return response()->json(['error' => "Vous n'êtes pas autorisé à accéder à cette page en tant que candidat"], 403);
    }
}
