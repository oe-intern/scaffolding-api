<?php

namespace App\Console\Commands\Users;

use App\Models\User;
use Illuminate\Console\Command;
use Osiset\ShopifyApp\Actions\DispatchWebhooks;

class ResetUserWebhooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:users:reset-webhooks {--id=} {--from=} {--to=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset user webhooks';

    /**
     * Execute the console command.
     */
    public function handle(DispatchWebhooks $dispatchWebhooksAction): void
    {
        $id = $this->option('id');
        $from = $this->option('from');
        $to = $this->option('to');

        if ($id) {
            $user = User::find($id);

            if (!$user) {
                $this->error("User with id $id not found");

                return;
            }

            try {
                call_user_func($dispatchWebhooksAction, $user->getId(), true);
                $this->info('User ' . $user->id . ' domain ' . $user->name . ' done');
            } catch (\Exception $e) {
                $this->error(
                    'Reset user '
                        . $user->id
                        . ' with domain '
                        . $user->name
                        . ' webhook failed due to error '
                        . $e->getMessage()
                );
            }

            return;
        }

        $query = User::query();

        if ($from) {
            $query->where('id', '>=', $from);
        }

        if ($to) {
            $query->where('id', '<=', $to);
        }

        $count = $query->count();

        if (!$this->confirm("Are you sure want to reset $count users' webhooks?", false)) {
            $this->info('BYE');

            return;
        }

        $query->chunk(50, function ($users) use ($dispatchWebhooksAction) {
            foreach ($users as $user) {
                try {
                    call_user_func($dispatchWebhooksAction, $user->getId(), true);
                    $this->info("User {$user->id} - {$user->name} updated");
                } catch (\Exception $e) {
                    $this->error(
                        "Reset user {$user->id} - {$user->name} failed. Error: {$e->getMessage()}",
                    );
                }
            }
        });
        $this->info('FINISHED');
    }
}
