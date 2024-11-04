<?php

namespace App\Filament\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Support\Utils;
use Z3d0X\FilamentLogger\Resources\ActivityResource as BaseResource;

class ActivityResource extends BaseResource implements HasShieldPermissions
{
    /**
     * @var string|null
     */
    protected static ?string $navigationGroup = null;

    /**
     * @return string[]
     */
    public static function getPermissionPrefixes(): array
    {
        return [
            'view_list',
            'view_detail',
        ];
    }

    /**
     * Get permission descriptions
     *
     * @return array
     */
    public static function getPermissionDescriptions()
    {
        return [
            //
        ];
    }

    /**
     * @return string|null
     */
    public static function getNavigationGroup(): ?string
    {
        return Utils::isResourceNavigationGroupEnabled()
            ? __('filament-shield::filament-shield.nav.group')
            : '';
    }
}
