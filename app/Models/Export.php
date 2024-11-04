<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Filament\Actions\Exports\Models\Export as FilamentExport;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Export extends FilamentExport
{
    /**
     * @inheritdoc
     * @throws Exception
     */
    public function user(): BelongsTo
    {
        if (static::hasPolymorphicUserRelationship()) {
            return $this->morphTo();
        }

        $authenticatable = app(Authenticatable::class);

        if ($authenticatable) {
            return $this->belongsTo($authenticatable::class);
        }

        if (! class_exists(AdminUser::class)) {
            throw new Exception('No [App\\Models\\AdminUser] model found. Please bind an authenticatable model to the [Illuminate\\Contracts\\Auth\\Authenticatable] interface in a service provider\'s [register()] method.');
        }

        return $this->belongsTo(AdminUser::class);
    }
}
