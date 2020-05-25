<?php

namespace App\Http\Middleware;

use Closure;

class ACLMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Pre-Middleware Action

        if(!$request->user->is_admin) return response()->json([ "errors" => ["permission denied"] ], 403);
        
        $response = $next($request);
        // Post-Middleware Action
        return $response;
    }
}
