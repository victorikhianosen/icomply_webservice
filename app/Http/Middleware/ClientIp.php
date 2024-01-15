<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ClientIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {


        // $clientIps[] = $request->ip();     

        // $allowedIPs = [
        //     '102.219.155.14', // Ezekiel
        //     '192.168.43.212', //hanson
        //     '192.168.100.92', //uche
        //     '192.168.100.53', // charles
        //     '192.168.100.79', // hanson
        //     '192.168.100.211', // charles
        //     '127.0.0.1',
        //     '192.168.0.200'
        // ];

        // foreach ($clientIps as $clientIp) {
        //     if (in_array($clientIp, $allowedIPs)) {
        //         return $next($request);
        //     }
        // }

        // return response('Unauthorized!', 401);
        return $next($request);

    
        
    }
}
