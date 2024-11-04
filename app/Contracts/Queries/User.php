<?php

namespace App\Contracts\Queries;

use App\Objects\Values\UserDomain;
use App\Objects\Values\UserId;
use Illuminate\Support\Collection;

interface User
{
    /**
     * Get by ID.
     */
    public function getById(UserId $user_id, array $with = [], bool $with_trashed = false);

    /**
     * Get by domain.
     */
    public function getByDomain(UserDomain $domain, array $with = [], bool $with_trashed = false);

    /**
     * Get all records.
     */
    public function getAll(array $with = []): Collection;
}
