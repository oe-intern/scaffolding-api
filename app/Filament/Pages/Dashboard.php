<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;

class Dashboard extends BaseDashboard
{
    /**
     * @return array|\Filament\Widgets\WidgetConfiguration[]|string[]
     */
    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
        ];
    }
}
