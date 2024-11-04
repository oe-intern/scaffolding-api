<?php

namespace App\Filament\Exports;

use App\Models\User;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class UserExporter extends Exporter
{
    /**
     * @var string|null
     */
    protected static ?string $model = User::class;

    /**
     * @inheritdoc
     */
    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('shop_id')
                ->label('Shopify ID'),
            ExportColumn::make('shop_name')
                ->label('Name'),
            ExportColumn::make('domain')
                ->label('Domain'),
            ExportColumn::make('myshopify_domain')
                ->label('MyShopify Domain'),
            ExportColumn::make('shop_email')
                ->label('Email'),
            ExportColumn::make('plan_display_name')
                ->label('Plan Display Name'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your instance export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
