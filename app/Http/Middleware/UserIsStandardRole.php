<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use illuminate\Support\Facades\Auth;


class UserIsStandardRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->hasRole('Admin') || !(Auth::user()->hasRole('Business') || Auth::user()->hasRole('Private'))) {
            return redirect('/')->with('error', 'Je hebt geen toegang tot deze pagina.');
        }

        return $next($request);
    }
}
