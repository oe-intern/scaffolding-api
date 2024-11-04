<?php

declare(strict_types=1);

namespace App\Lib;

use Illuminate\Http\Request;

class TopLevelRedirection
{
    /**
     * Header to indicate that the request should be redirected to the top level.
     */
    public const REDIRECT_HEADER = 'X-Shopify-API-Request-Failure-Reauthorize';

    /**
     * Header to indicate the URL to redirect to.
     */
    public const REDIRECT_URL_HEADER = 'X-Shopify-API-Request-Failure-Reauthorize-Url';

    /**
     * Redirects the request to the top level.
     *
     * @param Request $request
     * @param string $redirectUrl
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public static function redirect(Request $request, $redirectUrl)
    {
        $bearerPresent = preg_match("/Bearer (.*)/", $request->header('Authorization', ''));
        if ($bearerPresent !== false) {
            return response('', 401, [
                self::REDIRECT_HEADER => '1',
                self::REDIRECT_URL_HEADER => $redirectUrl,
            ]);
        } else {
            return redirect($redirectUrl);
        }
    }
}
