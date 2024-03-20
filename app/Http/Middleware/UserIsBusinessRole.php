<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserIsBusinessRole
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
        if (!Auth::check()) {
            // Omleiden naar inlogpagina als de gebruiker niet ingelogd is
            // Redirect user back to the intended page after login
            return redirect()->route('login')->with('error', 'Je moet ingelogd zijn om die pagina te bekijken.')->with('url.intended', $request->url());
        }

        if (!Auth::user()->hasRole(['Business', 'Admin'])) {
            // Omleiden naar een andere pagina als de gebruiker niet de rol 'Business' heeft
            return redirect('home')->with('error', 'Je moet een zakelijk account hebben om die pagina te bekijken.');
        }

        return $next($request);
    }
}
