<?php

namespace App\Filament\Logger;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Z3d0X\FilamentLogger\Loggers\AbstractModelLogger;

class CustomAbstractModelLogger extends AbstractModelLogger
{
    /**
     * @inheritdoc
     */
    protected function getLogName(): string
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    protected function log(Model $model, string $event, ?string $description = null, mixed $attributes = null)
    {
        if (!Str::contains(request()->url(), 'livewire')) {
            return;
        }

        if(is_null($description)) {
            $description = $this->getModelName($model).' '.$event;
        }

        if (auth()->check()) {
            $description .= ' by '.$this->getUserName(auth()->user());
        }

        $this->activityLogger()
            ->event($event)
            ->performedOn($model)
            ->withProperties($this->getLoggableAttributes($model, $attributes))
            ->log($description);
    }
}
