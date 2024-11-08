<?php

namespace App\Lib;

use Illuminate\Support\Facades\Cookie;
use Shopify\Auth\OAuthCookie;
use Shopify\Context;

class CookieHandler
{
    /**
     * Save the Shopify cookie.
     *
     * @param OAuthCookie $cookie
     * @return true
     */
    public static function saveShopifyCookie(OAuthCookie $cookie)
    {
        Cookie::queue(
            $cookie->getName(),
            $cookie->getValue(),
            $cookie->getExpire() ? ceil(($cookie->getExpire() - time()) / 60) : null,
            '/',
            parse_url(Context::$HOST_SCHEME . "://" . Context::$HOST_NAME, PHP_URL_HOST),
            $cookie->isSecure(),
            $cookie->isHttpOnly(),
            false,
            'Lax'
        );

        return true;
    }
}
