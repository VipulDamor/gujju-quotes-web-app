<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifySessionIntegrity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $session = $request->session();
            $currentUserAgent = $request->header('User-Agent');
            $currentIp = $request->ip();

            // Store UA and IP on first login if not present
            if (!$session->has('user_agent')) {
                $session->put('user_agent', $currentUserAgent);
            }

            // Critical Check: If User Agent changes, it's a high signal of session hijacking
            if ($session->get('user_agent') !== $currentUserAgent) {
                Auth::logout();
                $session->flush();
                return redirect()->route('admin.login')->with('error', 'Session integrity violation detected. Please login again.');
            }
        }

        return $next($request);
    }
}
