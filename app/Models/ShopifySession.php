<?php

namespace App\Models;

use App\Contracts\Objects\Values\AccessToken as IAccessToken;
use App\Objects\Values\AccessToken;
use App\Objects\Values\UserDomain;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Shopify\Context;

class ShopifySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'shop',
        'is_online',
        'state',
        'scope',
        'access_token',
        'expires_at',
        'user_id',
        'user_first_name',
        'user_last_name',
        'user_email',
        'user_email_verified',
        'account_owner',
        'locale',
        'collaborator',
    ];

    /**
     * Get the access token.
     */
    public function getAccessToken(): IAccessToken
    {
        return AccessToken::fromNative($this->acess_token);
    }

    /**
     * Get the myshopify domain.
     *
     * @return UserDomain
     */
    public function getMyShopifyDomain(): UserDomain
    {
        return UserDomain::fromNative($this->shop);
    }

    /**
     * Determine if the session is valid.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return (Context::$SCOPES->equals($this->scope) &&
            $this->access_token &&
            (!$this->expires_at || ($this->expires_at > new DateTime()))
        );
    }
}
