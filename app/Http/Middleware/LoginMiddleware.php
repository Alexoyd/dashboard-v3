<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next)
    {
	   Log::info('LoginMiddleware exécuté');
        Log::info('Request Data:', ['headers' => $request->headers->all(), 'body' => $request->all()]);

        $response = $next($request);

        Log::info('Response Data:', ['body' => $response->getContent()]);

        return $response;
    }
}
