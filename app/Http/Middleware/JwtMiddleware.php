<?php
namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

use App\Services\JwtService;
use App\Repositories\ApplicationRepository;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();
        
        if (!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }

        try {
            $jwtService = new JwtService();
            $payload = $jwtService->getPayload($token);
            
            if ($payload->reset_password) {
                $credentials = JWT::decode($token, env('TOKEN_RESET_PASSWORD'), ['HS256']);
            } else {
                $credentials = JWT::decode($token, env('TOKEN_AUTH'), ['HS256']);
            }

        } catch (ExpiredException $e) {
            return response()->json([
                'message' => 'Provided token is expired.'
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error while decoding token.'
            ], 400);
        }

        // return id user
        return $next($request->merge(['idUser' => $credentials->sub]));
    }
}