<?php

use Filament\Actions\Exports\Http\Controllers\DownloadExport;
use Illuminate\Support\Facades\Route;

Route::get('/filament/exports/{export}/download', DownloadExport::class)
    ->name('filament.exports.download');

