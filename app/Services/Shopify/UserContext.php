<?php

namespace App\Services\Shopify;

use App\Contracts\Objects\Values\AccessToken as IAccessToken;
use App\Models\User;
use App\Contracts\Queries\User as UserQuery;
use App\Objects\Values\AccessToken;
use App\Objects\Values\UserDomain;
use Shopify\Auth\Session;

class UserContext
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Session
     */
    private $shopify_session;

    /**
     * @var UserQuery
     */
    protected UserQuery $user_query;

    /**
     * UserContext constructor.
     *
     * @param UserQuery $user_query
     */
    public function __construct(UserQuery $user_query)
    {
        $this->user_query = $user_query;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * Get the user
     *
     * @return ?User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set the Shopify session
     *
     * @param Session $shopify_session
     */
    public function setShopifySession(Session $shopify_session): void
    {
        $this->shopify_session = $shopify_session;
    }

    /**
     * @return ?Session
     */
    public function getShopifySession(): ?Session
    {
        return $this->shopify_session;
    }

    /**
     * Get the access token
     *
     * @return IAccessToken
     */
    public function getAccessToken(): IAccessToken
    {
        if ($shopify_session = $this->getShopifySession()) {
            return AccessToken::fromNative($shopify_session->getAccessToken());
        }

        if ($user = $this->getUser()) {
            return $user->getAccessToken();
        }

        throw new \RuntimeException('No access token found.');
    }

    /**
     * Get the domain
     *
     * @return UserDomain
     */
    public function getDomain(): UserDomain
    {
        $domain = null;

        if ($user = $this->getUser()) {
            $domain = $user->name;
        }

        if ($this->getShopifySession()) {
            $domain = $this->shopify_session->getShop();
            $domain = UserDomain::fromNative($domain);
            $user = $this->user_query->getByDomain($domain);

            $domain = $user->name;
        }

        if ($domain) {
            return UserDomain::fromNative($domain);
        }

        throw new \RuntimeException('No domain found.');
    }
}
