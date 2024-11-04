<?php

namespace App\Jobs;

use Filament\Actions\Exports\Jobs\ExportCsv as BaseExportCsv;
use Illuminate\Support\Facades\Config;

class ExportCsv extends BaseExportCsv
{
    /**
     * @inheritdoc
     */
    public function handle(): void
    {
        Config::set('auth.defaults.guard', 'admin');
        parent::handle();
    }
}
