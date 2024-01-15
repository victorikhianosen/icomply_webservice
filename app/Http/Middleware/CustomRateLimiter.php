<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Log;

class CustomRateLimiter extends ThrottleRequests
{
    public function handle($request, Closure $next, $maxAttempts = 3, $decayMinutes = 1, $prefix = '')
    {
        // Apply rate limiting based on the IP address and query parameter value
        if ($this->shouldApplyRateLimit($request)) {
            return parent::handle($request, $next, $maxAttempts, $decayMinutes, $prefix);
        }

        return $next($request);
    }

    private function shouldApplyRateLimit(Request $request)
    {
        // Check the IP address of the sender
        $ip = $request->ip();

        // Define the query parameter that triggers rate limiting
        $rateLimitedQueryParam = 'dsql';

        // Define the allowed number of requests and time window
        $maxRequests = 3;
        $decayMinutes = 1;

        // Get the value of the rate-limited query parameter
        $operation = $request->query($rateLimitedQueryParam);

        // Generate a unique identifier for the rate limit
        $identifier = $rateLimitedQueryParam . '|' . $operation . '|' . $ip;

        // Check if the rate limit has been exceeded
        
        // logger()->info(
        //     "Rate Limit Check\n" .
        //                     "Ip: " . $ip . "\n" .
        //                     "Operation: " . $operation . "\n" .
        //                     "Identifier: " . $identifier . "\n" .
        //                     "RateLimitApplied: " . json_encode($this->limiter->tooManyAttempts($identifier, $maxRequests, $decayMinutes)) . "\n" 

        //             );
        return $this->limiter->tooManyAttempts(
            $identifier,
            $maxRequests,
            $decayMinutes
        );
    }
}