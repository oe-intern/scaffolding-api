<?php

namespace App\Storage\Queries;

use App\Contracts\Queries\User as UserQuery;
use App\Objects\Values\UserDomain;
use App\Objects\Values\UserId;
use Illuminate\Support\Collection;
use App\Models\User as UserModel;

class User implements UserQuery
{
    /**
     * The user model (configurable).
     *
     */
    protected UserModel $model;

    /**
     * Setup.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = app(UserModel::class);
    }
    /**
     * @inheritdoc
     */
    public function getById(UserId $user_id, array $with = [], bool $with_trashed = false)
    {
        $result = $this->model::with($with);

        if ($with_trashed) {
            $result = $result->withTrashed();
        }

        return $result
            ->where('id', $user_id->toNative())
            ->first();
    }

    /**
     * @inheritdoc
     */
    public function getByDomain(UserDomain $domain, array $with = [], bool $with_trashed = false)
    {
        $result = $this->model::with($with);

        if ($with_trashed) {
            $result = $result->withTrashed();
        }

        return $result
            ->where('name', $domain->toNative())
            ->first();
    }

    /**
     * @inheritdoc
     */
    public function getAll(array $with = []): Collection
    {
        return $this->model::with($with)->get();
    }
}
