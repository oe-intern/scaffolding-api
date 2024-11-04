<?php

namespace App\Filament\Resources;

use App\Filament\Exports\UserExporter;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource implements HasShieldPermissions
{
    /**
     * The default number of resources to show per page.
     */
    const DEFAULT_LIMIT = 10;

    /**
     * @var string|null
     */
    protected static ?string $model = User::class;

    /**
     * @var string
     */
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    /**
     * @var string|null
     */
    protected static ?string $label = 'Shops';

    /**
     * @var string
     */
    protected static ?string $recordTitleAttribute = 'id';

    /**
     * Get permission prefixes.
     *
     * @return string[]
     */
    public static function getPermissionPrefixes(): array
    {
        return [
            'view_list',
            'view_detail',
            'update',
            'view_ids',
            'view_myshopify_domain',
            'view_email',
            'view_shopify_plan',
            'update_shopify_plan',
            'view_address',
            'update_address',
            'view_internationalization',
            'update_internationalization',
            'view_geoeconomic_identifier',
            'update_geoeconomic_identifier',
            'view_system_administration',
            'update_system_administration',
            'view_timestamps',
            'show_list_limit',
            'use_paginated_has_overview',
            'export',
            'advanced_filter',
        ];
    }

    /**
     * Get the permission descriptions.
     *
     * @return array
     */
    public static function getPermissionDescriptions(): array
    {
        return [
            'update' => 'Access to Edit page',
            'view_ids' => 'View shop_id, user_id, shopify_id',
            'view_myshopify_domain' => 'View myshopify_domain, domain, shop owner, shop name',
            'view_email' => 'View shop email, customer email',
            'view_timestamps' => 'View created_at, updated_at',
            'view_shopify_plan' => 'View shopify_plan, shopify_plan_display_name',
            'update_shopify_plan' => 'Update shopify_plan, shopify_plan_display_name',
            'view_address' => 'View address, city, state, country, postal_code',
            'update_address' => 'Update address, city, state, country, postal_code',
            'view_internationalization' => 'View currency, timezone',
            'update_internationalization' => 'Update currency, timezone',
            'view_geoeconomic_identifier' => 'View weight_unit, money_format, money_with_currency_format',
            'update_geoeconomic_identifier' => 'Update weight_unit, money_format, money_with_currency_format',
            'view_system_administration' => 'View google_app_domain, password_enabled, google_apps_login_enabled, google_apps_domain, google_apps_login_email',
            'update_system_administration' => 'Update google_app_domain, password_enabled, google_apps_login_enabled, google_apps_domain, google_apps_login_email',
            'use_paginated_has_overview' => 'Enables an alternative pagination method, different from the current cursor pagination.',
            'export' => 'Export shop data',
            'advanced_filter' => 'Use advanced filters',
            'enable_extreme_pagination' => 'Enable extreme pagination',
        ];
    }

    /**
     * Form for creating and updating records.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Shop Ids')
                    ->collapsible()
                    ->aside()
                    ->visible(auth()->user()->can('view_ids_user'))
                    ->schema([
                        Forms\Components\TextInput::make('id')
                            ->disabled(),
                        Forms\Components\TextInput::make('shop_id')
                            ->label('Shopify ID')
                            ->disabled(),
                    ]),

                Forms\Components\Section::make('Shopify Domain')
                    ->collapsible()
                    ->aside()
                    ->visible(auth()->user()->can('view_myshopify_domain_user'))
                    ->schema([
                        Forms\Components\TextInput::make('myshopify_domain')
                            ->label('MyShopify Domain')
                            ->disabled(),
                        Forms\Components\TextInput::make('domain')
                            ->label('Domain')
                            ->disabled(),
                        Forms\Components\TextInput::make('shop_name')
                            ->label('Shop Name')
                            ->disabled(),
                        Forms\Components\TextInput::make('shop_owner')
                            ->label('Owner')
                            ->disabled(),
                    ]),

                Forms\Components\Section::make('Email')
                    ->aside()
                    ->collapsible()
                    ->visible(auth()->user()->can('view_email_user'))
                    ->schema([
                        Forms\Components\TextInput::make('shop_email')
                            ->label('Email')
                            ->disabled(),
                        Forms\Components\TextInput::make('customer_email')
                            ->label('Customer Email')
                            ->disabled(),
                    ]),

                Forms\Components\Section::make('Plan')
                    ->aside()
                    ->collapsible()
                    ->visible(auth()->user()->can('update_shopify_plan_user'))
                    ->schema([
                        Forms\Components\TextInput::make('plan_name')
                            ->label('Plan Name'),
                        Forms\Components\TextInput::make('plan_display_name')
                            ->label('Plan Display Name'),
                    ]),

                Forms\Components\Section::make('Address')
                    ->aside()
                    ->collapsible()
                    ->visible(auth()->user()->can('update_address_user'))
                    ->schema([
                        Forms\Components\TextInput::make('country')
                            ->label('Country'),
                        Forms\Components\TextInput::make('country_code')
                            ->label('Country Code'),
                        Forms\Components\TextInput::make('country_name')
                            ->label('Country Name'),
                        Forms\Components\TextInput::make('city')
                            ->label('City'),
                        Forms\Components\TextInput::make('province')
                            ->label('Province'),
                        Forms\Components\TextInput::make('province_code')
                            ->label('Province Code'),
                        Forms\Components\TextInput::make('zip')
                            ->label('Zip'),
                        Forms\Components\TextInput::make('address1')
                            ->label('Address 1'),
                        Forms\Components\TextInput::make('address2')
                            ->label('Address 2'),
                    ]),

                Forms\Components\Section::make('Internationalization')
                    ->aside()
                    ->collapsible()
                    ->visible(auth()->user()->can('update_internationalization_user'))
                    ->schema([
                        Forms\Components\TextInput::make('primary_locale')
                            ->label('Primary Locale'),
                        Forms\Components\TextInput::make('currency')
                            ->label('Currency'),
                        Forms\Components\TextInput::make('timezone')
                            ->label('Timezone'),
                        Forms\Components\TextInput::make('iana_timezone')
                            ->label('IANA Timezone'),
                    ]),

                Forms\Components\Section::make('Geoeconomic Identifier')
                    ->aside()
                    ->collapsible()
                    ->visible(auth()->user()->can('update_geoeconomic_identifier_user'))
                    ->schema([
                        Forms\Components\TextInput::make('weight_unit'),
                        Forms\Components\TextInput::make('latitude'),
                        Forms\Components\TextInput::make('longitude'),
                        Forms\Components\Toggle::make('taxes_included')
                            ->inline(false),
                        Forms\Components\Toggle::make('tax_shipping')
                            ->inline(false),
                    ]),

                Forms\Components\Section::make('System Administration')
                    ->aside()
                    ->collapsible()
                    ->visible(auth()->user()->can('update_system_administration_user'))
                    ->schema([
                        Forms\Components\Toggle::make('setup_required')
                            ->inline(false),
                    ]),
            ]);
    }

    /**
     * Table for listing records.
     *
     * @param Table $table
     * @return Table
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        $visible_ids = auth()->user()->can('view_ids_user');
        $visible_myshopify_domain = auth()->user()->can('view_myshopify_domain_user');
        $visible_email = auth()->user()->can('view_email_user');
        $visible_shopify_plan = auth()->user()->can('view_shopify_plan_user');
        $visible_address = auth()->user()->can('view_address_user');
        $visible_internationalization = auth()->user()->can('view_internationalization_user');
        $visible_timestamps = auth()->user()->can('view_timestamps_user');

        $table = $table
            ->columns([
                ColumnGroup::make('')
                    ->columns([
                        TextColumn::make('id')
                            ->label('Id')
                            ->visible($visible_ids)
                            ->toggleable()
                            ->searchable(),
                        TextColumn::make('shop_id')
                            ->label('Shopify Id')
                            ->visible($visible_ids)
                            ->toggleable()
                            ->searchable(),
                    ]),

                ColumnGroup::make('')
                    ->columns([
                        TextColumn::make('myshopify_domain')
                            ->label('MyShopify Domain')
                            ->visible($visible_myshopify_domain)
                            ->toggleable()
                            ->searchable(),
                        TextColumn::make('domain')
                            ->label('Domain')
                            ->visible($visible_myshopify_domain)
                            ->toggleable(),
                        TextColumn::make('shop_name')
                            ->label('Shop Name')
                            ->visible($visible_myshopify_domain)
                            ->toggleable(),
                        TextColumn::make('shop_owner')
                            ->toggleable(),
                    ]),

                ColumnGroup::make('')
                    ->columns([
                        TextColumn::make('plan_name')
                            ->label('Plan Name')
                            ->visible($visible_shopify_plan)
                            ->toggleable(),
                        TextColumn::make('plan_display_name')
                            ->label('Plan Display Name')
                            ->visible($visible_shopify_plan)
                            ->toggleable(),
                    ]),

                ColumnGroup::make('')
                    ->columns([
                        TextColumn::make('shop_email')
                            ->visible($visible_email)
                            ->toggleable(),
                        TextColumn::make('customer_email')
                            ->visible($visible_email)
                            ->toggleable(),
                    ]),

                ColumnGroup::make('')
                    ->columns([
                        TextColumn::make('country')
                            ->visible($visible_address)
                            ->toggleable(),
                        TextColumn::make('country_code')
                            ->visible($visible_address)
                            ->toggleable(),
                        TextColumn::make('country_name')
                            ->visible($visible_address)
                            ->toggleable(),
                        TextColumn::make('city')
                            ->visible($visible_address)
                            ->toggleable(),
                        TextColumn::make('province')
                            ->visible($visible_address)
                            ->toggleable(),
                        TextColumn::make('province_code')
                            ->visible($visible_address)
                            ->toggleable(),
                        TextColumn::make('zip')
                            ->visible($visible_address)
                            ->toggleable(),
                        TextColumn::make('address1')
                            ->visible($visible_address)
                            ->toggleable(),
                        TextColumn::make('address2')
                            ->visible($visible_address)
                            ->toggleable(),
                    ]),

                ColumnGroup::make('')
                    ->columns([
                        TextColumn::make('primary_locale')
                            ->visible($visible_internationalization)
                            ->toggleable(),
                        TextColumn::make('currency')
                            ->visible($visible_internationalization)
                            ->toggleable(),
                        TextColumn::make('timezone')
                            ->visible($visible_internationalization)
                            ->toggleable(),
                        TextColumn::make('iana_timezone')
                            ->visible($visible_internationalization)
                            ->toggleable(),
                    ]),

                ColumnGroup::make('')
                    ->columns([
                        TextColumn::make('created_at')
                            ->visible($visible_timestamps)
                            ->label('Created At')
                            ->toggleable(),
                        TextColumn::make('updated_at')
                            ->visible($visible_timestamps)
                            ->label('Updated At')
                            ->toggleable(),
                    ]),

            ])
            ->searchOnBlur()
            ->filters(Pages\ListUsers::groupFilters(), FiltersLayout::AboveContentCollapsible)
            ->deferFilters()
            ->headerActions([
                ExportAction::make()
                    ->exporter(UserExporter::class)
                    ->formats([
                        ExportFormat::Csv,
                    ])
                    ->fileDisk(config('filesystems.default'))
                    ->fileName('shop')
                    ->visible(auth()->user()->can('export_user'))
            ])
            ->paginated([10, 20, 50, 100])
            ->extremePaginationLinks(false)
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);

        if (!auth()->user()->can('use_paginated_has_overview_user')) {
            return $table->modifyQueryUsing(function (Builder $query) {
                $query->limit(self::DEFAULT_LIMIT);
            })
                ->paginated(false);
        }

        return $table;
    }

    /**
     * Infolist for displaying records.
     *
     * @param Infolist $infolist
     * @return Infolist
     */
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema(ViewUser::info());
    }

    /**
     * Get the relations for the resource.
     *
     * @return array|\Filament\Resources\RelationManagers\RelationGroup[]|\Filament\Resources\RelationManagers\RelationManagerConfiguration[]|string[]
     */
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /**
     * Get the pages for the resource.
     *
     * @return array|\Filament\Resources\Pages\PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
