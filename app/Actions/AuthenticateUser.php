<?php

namespace App\Actions;

use App\Objects\Values\UserDomain;
use Illuminate\Http\Request;
use Shopify\Auth\OAuth;

class AuthenticateUser
{
    /**
     * @var InstallShop
     */
    protected InstallShop $install_shop;

    /**
     * @var AfterAuthorize
     */
    protected AfterAuthorize $after_authorize;

    /**
     * Create a new action instance.
     */
    public function __construct(
        InstallShop $install_shop,
        AfterAuthorize $after_authorize,

    ) {
        $this->install_shop = $install_shop;
        $this->after_authorize = $after_authorize;
    }

    /**
     * Execute the action.
     *
     * @param Request $request
     * @return void
     */
    public function __invoke(Request $request): void
    {
        $session = OAuth::callback(
            $request->cookie(),
            $request->query(),
            ['App\Lib\CookieHandler', 'saveShopifyCookie'],
        );

        // Install the shop
        $user_id = call_user_func(
            $this->install_shop,
            UserDomain::fromNative($request->query('shop')),
            $session
        );

        call_user_func($this->after_authorize, $user_id);
    }
}
