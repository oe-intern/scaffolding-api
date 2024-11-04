<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AppOverview;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\ActionSize;
use Filament\Actions;

class Analytic extends Page
{
    use HasPageShield;

    /**
     * @var string
     */
    const MetricUrl = "";

    /**
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    /**
     * @var string
     */
    protected static string $view = 'filament.pages.analytic';

    /**
     * Get header widgets
     *
     * @return array|\Filament\Widgets\WidgetConfiguration[]|string[]
     */
    protected function getHeaderWidgets(): array
    {
        return [
            AppOverview::class,
        ];
    }

    /**
     * Get header actions
     *
     * @return array|\Filament\Actions\Action[]|\Filament\Actions\ActionGroup[]
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Metric')
                ->size(ActionSize::ExtraSmall)
                ->color(Color::Cyan)
                ->openUrlInNewTab()
                ->action(fn () => redirect(self::MetricUrl)),
        ];
    }
}
