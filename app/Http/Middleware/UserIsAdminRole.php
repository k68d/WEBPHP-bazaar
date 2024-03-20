<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserIsAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->hasRole(['Admin'])) {
            // Omleiden naar een andere pagina als de gebruiker niet de rol 'Business' heeft
            return redirect('/')->with('error', 'Je moet een zakelijk account hebben om die pagina te bekijken.');
        }

        return $next($request);
    }
}
