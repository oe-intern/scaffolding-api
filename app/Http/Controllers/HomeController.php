<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Shopify\Context;
use Shopify\Exception\InvalidArgumentException;
use Shopify\Utils;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @throws InvalidArgumentException
     */
    public function index(Request $request)
    {
        if (Context::$IS_EMBEDDED_APP &&  $request->query("embedded", false) === "1") {
            $key = config('shopify-app.api_key');
            $ttl = config('cache.redis_ttl.embedded_version');
            $version = Cache::remember('embedded_version', $ttl, function () {
                return time();
            });

            return response()->view('welcome', [
                'key' => $key,
                'version' => $version,
                'shop' => $request->get('shop'),
            ]);
        }

        return redirect(Utils::getEmbeddedAppUrl($request->query("host", null)) . "/" . $request->path());
    }
}
