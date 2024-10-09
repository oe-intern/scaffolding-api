<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\Shopify\REST\ShopService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class UpdateShopProfile implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var \App\Models\User
     */
    protected User $user;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $shopService = App::make(ShopService::class, ['shop' => $this->user]);
        $shopProfile = $shopService->getShopProfile();
        $this->user->fill($shopProfile);
        $this->user->save();
    }
}
