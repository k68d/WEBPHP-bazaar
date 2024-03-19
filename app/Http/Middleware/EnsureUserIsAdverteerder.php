<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdverteerder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
    if (!in_array(auth()->user()->user_type, ['particulier', 'zakelijk'])) {
        // Redirect of geef een foutmelding als de gebruiker geen adverteerder is
        return redirect('home');
    }

    return $next($request);
    }
}
