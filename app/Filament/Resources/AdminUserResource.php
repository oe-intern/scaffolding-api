<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminUserResource\Pages;
use App\Models\AdminUser;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class AdminUserResource extends Resource implements HasShieldPermissions
{
    /**
     * @var string|null
     */
    protected static ?string $model = AdminUser::class;

    /**
     * @var string|null
     */
    protected static ?string $recordTitleAttribute = 'name';

    /**
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-user';

    /**
     * @return string|null
     */
    public static function getNavigationGroup(): ?string
    {
        return Utils::isResourceNavigationGroupEnabled()
            ? __('filament-shield::filament-shield.nav.group')
            : '';
    }

    /**
     * Get permission prefixes
     *
     * @return string[]
     */
    public static function getPermissionPrefixes(): array
    {
        return [
            'view_list',
            'view_detail',
            'create',
            'update',
            'delete',
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
     * Form
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->placeholder('John Doe'),
                TextInput::make('email')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->email()
                    ->placeholder('example@gmail.com'),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->autocomplete()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->placeholder('••••••••'),
                TextInput::make('password_confirmation')
                    ->label('Password Confirmation')
                    ->password()
                    ->autocomplete()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->placeholder('••••••••'),
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
                Select::make('permissions')
                    ->relationship('permissions', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),

                DateTimePicker::make('email_verified_at')
                    ->label('Email Verified At')
                    ->nullable(),

                TextInput::make('created_at')
                    ->disabled()
                    ->hidden(fn (string $context): bool => $context === 'create'),
                TextInput::make('updated_at')
                    ->disabled()
                    ->hidden(fn (string $context): bool => $context === 'create'),
            ]);
    }

    /**
     * Table
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->toggleable(),
                TextColumn::make('name')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('email')
                    ->toggleable()
                    ->copyable()
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label('Roles')
                    ->toggleable()
                    ->badge()
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->toggleable()
                    ->dateTime('Y-m-d H:i:s'),
                TextColumn::make('created_at')
                    ->toggleable()
                    ->dateTime('Y-m-d H:i:s'),
                TextColumn::make('updated_at')
                    ->toggleable()
                    ->dateTime('Y-m-d H:i:s'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /***
     * Infolist
     *
     * @param Infolist $infolist
     * @return Infolist
     */
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Profile information')
                ->description('Personal information and email address')
                ->aside()
                ->inlineLabel()
                ->schema([
                    TextEntry::make('id')
                        ->label('ID'),
                    TextEntry::make('name')
                        ->label('Name'),
                    TextEntry::make('email')
                        ->label('Email'),
                ]),
            Section::make('Roles & Permissions')
                ->description('Roles and custom permissions assigned to this user')
                ->aside()
                ->inlineLabel()
                ->schema([
                    TextEntry::make('role_names')
                        ->badge()
                        ->color(Color::Green)
                        ->separator(',')
                        ->label('Roles'),
                    TextEntry::make('custom_permissions')
                        ->badge()
                        ->separator(',')
                        ->label('Custom Permissions'),
                ]),
            Section::make('Timestamps')
                ->description('When this user was created and last updated')
                ->aside()
                ->inlineLabel()
                ->schema([
                    TextEntry::make('email_verified_at')
                        ->label('Email Verified At'),
                    TextEntry::make('created_at')
                        ->label('Created At'),
                    TextEntry::make('updated_at')
                        ->label('Updated At'),
                ]),
        ]);
    }

    /**
     * Get relations
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
     * Get pages
     *
     * @return array|\Filament\Resources\Pages\PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdminUsers::route('/'),
            'create' => Pages\CreateAdminUser::route('/create'),
            'view' => Pages\ViewAdminUser::route('/{record}'),
            'edit' => Pages\EditAdminUser::route('/{record}/edit'),
        ];
    }
}
