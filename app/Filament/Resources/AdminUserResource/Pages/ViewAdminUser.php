<?php

namespace App\Filament\Resources\AdminUserResource\Pages;

use App\Filament\Resources\AdminUserResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewAdminUser extends ViewRecord
{
    /**
     * @var string
     */
    protected static string $resource = AdminUserResource::class;

    /**
     * @var string|null
     */
    protected static ?string $title = 'Admin User';

    /**
     * Get header actions.
     *
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
