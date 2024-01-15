<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RateLimitMiddleware extends ThrottleRequests
{
    protected function resolveRequestSignature($request)
    {
        $ip = $request->ip();
        $parameter = $request->query();
        $parameter = array_keys($parameter);
        $parameter=$parameter[0];
        
        if ($ip && $parameter=='dsql'
        ) {
            // Combine IP address and request parameter to generate a unique key
            Log::info($parameter);
            $key = $ip . '|' . $parameter;
            return sha1($key);
        }

        // If either the IP address or the query parameter is missing, return null
        return null;
    }

    public function handle($request, Closure $next, $limit = -1, $time = 1, $headers = [])
    {
        // $this->setHeaders($headers);

        $key = $this->resolveRequestSignature($request);

        // If key is null, bypass rate limiting
        if ($key === null) {
            return $next($request);
        }

        return parent::handle($request, $next, $limit, $time);
    }

    protected function getRateLimiter()
    {
        return app(\Illuminate\Cache\RateLimiter::class);
    }
    
    protected function buildResponse($key, $maxAttempts)
    {
        $response = response()->json([
            'message' => 'Too Many equests Proceed After 1 Minute',
        ], 429);

        $response->headers->add([
            'Retry-After' => $this->getRateLimiter()->availableIn($key),
            'X-RateLimit-Limit' => $maxAttempts,
            'X-RateLimit-Remaining' => 0,
            'X-RateLimit-Reset' => $this->getRateLimiter()->availableIn($key),
        ]);

        return $response;
    }
}
