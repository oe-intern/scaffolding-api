<?php

namespace App\Filament\Resources\Shield\RoleResource\Pages;

use App\Filament\Resources\Shield\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoles extends ListRecords
{
    /**
     * @var string
     */
    protected static string $resource = RoleResource::class;

    /**
     * Get the resource's available actions.
     *
     * @return array|Actions\Action[]|Actions\ActionGroup[]
     */
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
