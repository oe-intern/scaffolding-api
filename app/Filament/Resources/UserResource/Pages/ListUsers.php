<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class ListUsers extends ListRecords
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
            //
        ];
    }

    /**
     * Paginate the table query.
     *
     * @param Builder $query
     * @return CursorPaginator|Paginator
     */
    protected function paginateTableQuery(Builder $query): Paginator| CursorPaginator
    {
        $per_page = $this->getTableRecordsPerPage() === 'all' ? $query->count() : $this->getTableRecordsPerPage();

        if (auth()->user()->can('use_paginated_has_overview_user')) {
            return $query->paginate($per_page);
        }

        return $query->cursorPaginate($per_page);
    }

    /**
     * Group Filters
     *
     * @throws \Exception
     */
    public static function  groupFilters(): array
    {
        $result = [
            TrashedFilter::make(),
        ];

        if(!auth()->user()->can('advanced_filter_user')) {
            return $result;
        }

        $added_filters = [
            Filter::make('Country')
                ->form([
                    TextInput::make('country')
                ])
                ->query(function (Builder $query, array $data) {
                    return $query->where('country', 'like', "%{$data['country']}%");
                }),
            DateRangeFilter::make('created_at')
                ->autoApply(),
        ];

        return array_merge($result, $added_filters);
    }
}
