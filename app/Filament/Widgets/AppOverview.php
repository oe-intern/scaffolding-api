<?php

namespace App\Filament\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AppOverview extends BaseWidget
{
    use HasWidgetShield;

    /**
     * @var string|null
     */
    protected static ?string $pollingInterval = null;

    /**
     * Get Stats
     *
     * @return array|Stat[]
     */
    protected function getStats(): array
    {
        return [
            Stat::make('Total Installs', 0),
            Stat::make('Active Users', 0),
            Stat::make('Free Users', 0),
            Stat::make('Paid Users', 0),
        ];
    }
}
