<?php

namespace App\Http\Middleware;

use App\Exceptions\MissingShopDomainException;
use App\Lib\AuthRedirection;
use App\Models\ShopifySession;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Shopify\Exception\CookieSetException;
use Shopify\Exception\PrivateAppException;
use Shopify\Exception\SessionStorageException;
use Shopify\Exception\UninitializedContextException;
use Shopify\Utils;
use Symfony\Component\HttpFoundation\Response;

class EnsureShopifyInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     * @throws CookieSetException
     * @throws PrivateAppException
     * @throws SessionStorageException
     * @throws UninitializedContextException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $myshopify_domain = $request->query('shop');

        if (!$myshopify_domain) {
            throw new MissingShopDomainException;
        }

        $myshopify_domain = $myshopify_domain ? Utils::sanitizeShopDomain($myshopify_domain) : null;
        $shopify_session = ShopifySession::where('shop', $myshopify_domain)->whereNotNull('access_token')->first();
        $user_existed = User::where('myshopify_domain', $myshopify_domain)->exists();

        if (!$shopify_session || !$user_existed || !$shopify_session->isValid()) {
            return AuthRedirection::redirect($request);
        }

        return $next($request);
    }
}
