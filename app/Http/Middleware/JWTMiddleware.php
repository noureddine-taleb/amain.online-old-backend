<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JWTMiddleware
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
        $token = $request->bearerToken();
        
        // Unauthorized response if token not there
        if(!$token) {
            return response()->json([
                'errors' => ['Token not provided.']
            ], 401);
        }
        //check token 's validation
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'errors' => ['Provided token is expired.']
            ], 401);
        } catch(Exception $e) {
            return response()->json([
                'errors' => ['An error while decoding token.']
            ], 401);
        }

        //get the authorized user
        $user = User::findOrFail($credentials->sub);

        // Now let's put the user in the request class so that you can grab it from there
        $request->user = $user;

        return $next($request);
    }
}
