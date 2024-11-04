<?php

namespace App\Lib;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;
use Shopify\Auth\OAuth;
use Shopify\Context;
use Shopify\Exception\CookieSetException;
use Shopify\Exception\PrivateAppException;
use Shopify\Exception\SessionStorageException;
use Shopify\Exception\UninitializedContextException;
use Shopify\Utils;

class AuthRedirection
{
    /**
     * Redirects to the Shopify OAuth page.
     *
     * @param Request $request
     * @param bool $is_online
     * @return ResponseFactory|Application|RedirectResponse|Response|Redirector
     * @throws CookieSetException
     * @throws PrivateAppException
     * @throws SessionStorageException
     * @throws UninitializedContextException
     */
    public static function redirect(Request $request, bool $is_online = false)
    {
        $shop = Utils::sanitizeShopDomain($request->query("shop"));

        if (Context::$IS_EMBEDDED_APP && $request->query("embedded", false) === "1") {
            return self::clientSideRedirectUrl($shop);
        } else {
            $redirect_url = self::serverSideRedirectUrl($shop, $is_online);
        }

        return redirect($redirect_url);
    }

    /**
     * Server-side redirect URL.
     *
     * @param string $shop
     * @param bool $is_online
     * @return string
     * @throws CookieSetException
     * @throws PrivateAppException
     * @throws SessionStorageException
     * @throws UninitializedContextException
     */
    private static function serverSideRedirectUrl(string $shop, bool $is_online): string
    {
        return OAuth::begin(
            $shop,
            '/authenticate',
            $is_online,
            ['App\Lib\CookieHandler', 'saveShopifyCookie'],
        );
    }

    /**
     * Client-side redirect URL.
     *
     * @param $shop
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    private static function clientSideRedirectUrl($shop)
    {
        $redirect_uri = "auth?shop=$shop";
        $redirect_to = Redirect::to($redirect_uri);

        return response(view('exit_iframe', [
            'redirect_url' => $redirect_to->getTargetUrl(),
        ]));
    }
}
