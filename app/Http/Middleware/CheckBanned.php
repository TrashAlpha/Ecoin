<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         $user = Auth::user();

        if ($user && $user->status === 'banned') {
            Auth::logout(); // Langsung logout user
            return response()->json([
                'message' => 'Akun Anda telah dibanned. Silakan hubungi admin.'
            ], 403);
        }

        return $next($request);
    }
}
