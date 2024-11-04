<?php

namespace App\Http\Middleware;

use App\Lib\Utils;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthEventBridgeWebhook
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $incoming_api_key = $request->header('X-Api-Key');
        $expected_api_key = Utils::getShopifyConfig('webhook_event_bridge_secret');

        if ($incoming_api_key !== $expected_api_key) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
