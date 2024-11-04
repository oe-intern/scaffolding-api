<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    /**
     * @var string
     */
    protected static string $resource = UserResource::class;

    /**
     * @return array|Actions\Action[]|Actions\ActionGroup[]
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    /**
     * Get the infolists for the resource.
     *
     * @return array
     */
    public static function info()
    {
        return [
            Section::make('Shop Ids')
                ->aside()
                ->inlineLabel()
                ->description('Shop id, shopify id, user id')
                ->visible(auth()->user()->can('view_ids_user'))
                ->columns(1)
                ->schema([
                    TextEntry::make('id')
                        ->label('Shop ID'),
                    TextEntry::make('shop_id')
                        ->label('Shopify ID')
                        ->copyable(),
                ]),
            Section::make('Shopify Domain')
                ->aside()
                ->inlineLabel()
                ->visible(auth()->user()->can('view_myshopify_domain_user'))
                ->description('Shopify domain detail')
                ->columns(1)
                ->schema([
                    TextEntry::make('myshopify_domain')
                        ->label('MyShopify Domain')
                        ->copyable(),
                    TextEntry::make('domain')
                        ->label('Domain'),
                    TextEntry::make('shop_name')
                        ->label('Shop Name'),
                    TextEntry::make('shop_owner')
                        ->label('Owner'),
                ]),
            Section::make('Plan')
                ->aside()
                ->inlineLabel()
                ->visible(auth()->user()->can('view_shopify_plan_user'))
                ->columns(1)
                ->description('Plan detail')
                ->schema([
                    TextEntry::make('plan_name')
                        ->label('Plan Name')
                        ->badge(),
                    TextEntry::make('plan_display_name')
                        ->label('Plan Display Name'),
                ]),
            Section::make('Email')
                ->aside()
                ->inlineLabel()
                ->visible(auth()->user()->can('view_email_user'))
                ->columns(1)
                ->description('Email detail')
                ->schema([
                    TextEntry::make('shop_email')
                        ->label('Email')
                        ->icon('heroicon-m-envelope')
                        ->iconColor('primary')
                        ->copyable(),
                    TextEntry::make('customer_email')
                        ->icon('heroicon-m-envelope')
                        ->iconColor('primary')
                        ->label('Customer Email'),
                ]),
            Section::make('Address')
                ->aside()
                ->inlineLabel()
                ->visible(auth()->user()->can('view_address_user'))
                ->description('Address detail')
                ->columns(1)
                ->schema([
                    TextEntry::make('country')
                        ->label('Country'),
                    TextEntry::make('country_code')
                        ->label('Country Code'),
                    TextEntry::make('country_name')
                        ->label('Country Name'),
                    TextEntry::make('province')
                        ->label('Province'),
                    TextEntry::make('province_code')
                        ->label('Province Code'),
                    TextEntry::make('address1')
                        ->label('Address 1'),
                    TextEntry::make('address2')
                        ->label('Address 2'),
                    TextEntry::make('city')
                        ->label('City'),
                    TextEntry::make('zip')
                        ->label('Zip'),
                ]),
            Section::make('Internationalization')
                ->aside()
                ->visible(auth()->user()->can('view_internationalization_user'))
                ->description('Internationalization detail')
                ->inlineLabel()
                ->columns(1)
                ->schema([
                    TextEntry::make('primary_locale')
                        ->label('Primary Locale'),
                    TextEntry::make('currency')
                        ->label('Currency'),
                    TextEntry::make('timezone')
                        ->label('Timezone'),
                    TextEntry::make('iana_timezone')
                        ->label('IANA Timezone'),
                ]),
            Section::make('Geoeconomic identifier')
                ->aside()
                ->inlineLabel()
                ->visible(auth()->user()->can('view_geoeconomic_identifier_user'))
                ->description('Geoeconomic identifier detail')
                ->columns(1)
                ->schema([
                    TextEntry::make('weight_unit')
                        ->label('Weight Unit'),
                    TextEntry::make('patitude'),
                    TextEntry::make('longitude'),
                    TextEntry::make('weight_unit')
                        ->label('Weight Unit'),
                    TextEntry::make('taxes_included')
                        ->label('Taxes Included'),
                    TextEntry::make('tax_shipping')
                        ->label('Tax Shipping'),
                ]),
            Section::make('System administration')
                ->aside()
                ->visible(auth()->user()->can('view_system_administration_user'))
                ->description('System administration detail')
                ->inlineLabel()
                ->columns(1)
                ->schema([
                    TextEntry::make('setup_required')
                        ->label('Setup Required'),
                ]),
            Section::make('Timestamps')
                ->aside()
                ->inlineLabel()
                ->visible(auth()->user()->can('view_timestamps_user'))
                ->description('Timestamps detail')
                ->columns(1)
                ->schema([
                    TextEntry::make('created_at')
                        ->label('Created At'),
                    TextEntry::make('updated_at')
                        ->label('Updated At'),
                ]),
        ];
    }
}
