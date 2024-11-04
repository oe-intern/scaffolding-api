<?php

namespace App\Contracts\Commands;

use App\Contracts\Objects\Values\AccessToken;
use App\Objects\Values\UserDomain;
use App\Objects\Values\UserId;

interface User
{
    /**
     * Create a shop.
     *
     * @param UserDomain $domain
     * @param AccessToken $token
     * @return UserId
     */
    public function make(UserDomain $domain, AccessToken $token): UserId;

    /**
     * Set the access token for a shop.
     *
     * @param UserId $id
     * @param AccessToken $token
     * @return UserId
     */
    public function setAccessToken(UserId $id, AccessToken $token): UserId;

    /**
     * Delete a shop.
     *
     * @param UserId $id
     * @return bool
     */
    public function softDelete(UserId $id): bool;
}
