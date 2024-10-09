<?php

namespace App\Console\Commands\Users;

use App\Models\User;
use Illuminate\Console\Command;

class ListUserWebhooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:users:list-webhooks {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List single user webhook';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $id = $this->argument('id');
        $user = User::find($id);

        if (!$user) {
            $this->error('User not found');

            return;
        }

        dd($user->api()->rest('GET', 'admin/webhooks.json')['body']);
    }
}
