<?php

namespace App\Actions;

use App\Contracts\Queries\User as UserQuery;
use App\Contracts\Shopify\Graphql\Shop;
use App\Objects\Values\UserId;
use App\Services\Shopify\UserContext;

class AfterAuthorize
{
    /**
     * Querier for shops.
     *
     * @var UserQuery
     */
    protected UserQuery $user_query;

    /**
     * Setup.
     *
     * @param UserQuery $user_query
     */
    public function __construct(UserQuery $user_query)
    {
        $this->user_query = $user_query;
    }

    /**
     * Handle the action.
     *
     * @param UserId $id
     * @return void
     */
    public function __invoke(UserId $id): void
    {
        $user = $this->user_query->getById($id);
        $jobs = config('shopify-app.after_authenticate_jobs', []);

        foreach ($jobs as $job) {
            $job::dispatch($user)
                ->onQueue(config('shopify-app.job_queues.after_authenticate'));
        }
    }
}
