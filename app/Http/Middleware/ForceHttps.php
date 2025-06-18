<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ForceHttps
{
    public function handle(Request $request, Closure $next)
    {
        URL::forceScheme('https');

        if ($request->secure() || env('APP_ENV') === 'production') {
            return $next($request);
        }

        return redirect()->secure($request->getRequestUri());
    }
}
