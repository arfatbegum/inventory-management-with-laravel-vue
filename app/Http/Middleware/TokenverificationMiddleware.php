<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next): Response
{
    $token = $request->cookie('token');
    $result = JWTToken::VerifyToken($token);

    if (!is_object($result) || !property_exists($result, 'userEmail')) {
        return response()->json(['message' => 'unauthorized'], 401);
    }

    // Inject into request data instead of headers
    $request->merge([
        'email' => $result->userEmail,
        'id' => $result->userID
    ]);

    return $next($request);
}

}
