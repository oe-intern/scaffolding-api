<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Shopify\Context;
use Symfony\Component\HttpFoundation\Response;

class AccessControlHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Context::$IS_EMBEDDED_APP) {

            /** @var \Illuminate\Http\Response $response */
            $response = $next($request);

            $response->headers->set("Access-Control-Allow-Origin", "*");
            $response->headers->set("Access-Control-Allow-Header", "Authorization");
            $response->headers->set("Access-Control-Expose-Headers", 'X-Shopify-API-Request-Failure-Reauthorize-Url');

            return $response;
        }
    }
}
