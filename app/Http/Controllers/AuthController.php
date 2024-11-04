<?php

namespace App\Http\Controllers;

use App\Actions\AuthenticateUser;
use App\Exceptions\MissingShopDomainException;
use App\Lib\AuthRedirection;
use App\Models\ShopifySession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Shopify\Exception\CookieSetException;
use Shopify\Exception\PrivateAppException;
use Shopify\Exception\SessionStorageException;
use Shopify\Exception\UninitializedContextException;
use Shopify\Utils;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request, AuthenticateUser $auth)
    {
        if ($request->missing('shop')) {
            throw new MissingShopDomainException;
        }

        $auth($request);
        $host = $request->query('host');

        $redirectUrl = Utils::getEmbeddedAppUrl($host);

        return redirect($redirectUrl);
    }

    /**
     * Redirect to the Shopify OAuth page.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws CookieSetException
     * @throws PrivateAppException
     * @throws SessionStorageException
     * @throws UninitializedContextException
     */
    public function auth(Request $request)
    {
        $shop = Utils::sanitizeShopDomain($request->query('shop'));

        // Delete any previously created OAuth sessions that were not completed (don't have an access token)
        ShopifySession::where('shop', $shop)->where('access_token', null)->delete();

        return AuthRedirection::redirect($request);
    }
}
