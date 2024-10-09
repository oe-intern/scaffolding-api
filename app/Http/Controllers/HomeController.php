<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Osiset\ShopifyApp\Traits\HomeController as HomeControllerTrait;

class HomeController extends Controller
{
    use HomeControllerTrait;

    /**
     * Index route which displays the home page of the app.
     *
     * @param Request $request The request object.
     *
     * @return \Illuminate\Contracts\View\View @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return View::make(
            'shopify-app::home.index',
            [
                'v' => $this->getVersion(),
                'user' => auth()->user(),
                'portal_url' => config('app.portal_url'),
            ],
        );
    }

    /**
     * Get index version for cloudflare cache
     *
     * @return number
     */
    protected function getVersion()
    {
        return Cache::rememberForever(
            config('app.custom.app_portal_version_cache_key'),
            function () {
                return time();
            },
        );
    }
}
