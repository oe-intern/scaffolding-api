<?php

declare(strict_types=1);

namespace App\Lib\Handlers;

use App\Models\ShopifySession;
use App\Objects\Values\UserDomain;
use Shopify\Webhooks\Handler;
use App\Contracts\Queries\User as UserQuery;
use App\Contracts\Commands\User as UserCommand;

class AppUninstalled implements Handler
{
    /**
     * @var UserQuery
     */
    protected UserQuery $user_query;

    /**
     * @var UserCommand
     */
    protected UserCommand $user_command;

    /**
     * Create a new handler instance.
     */
    public function __construct(UserQuery $user_query, UserCommand $user_command)
    {
        $this->user_query = $user_query;
        $this->user_command = $user_command;
    }

    /**
     * Handle the incoming webhook.
     *
     * @param string $topic
     * @param string $shop
     * @param array $body
     * @return void
     */
    public function handle(string $topic, string $shop, array $body): void
    {
        ShopifySession::where('shop', $shop)->delete();

        $user = $this->user_query->getByDomain(UserDomain::fromNative($shop));

        if(!$user) {
            return;
        }

        $this->user_command->softDelete($user->getId());
    }
}
