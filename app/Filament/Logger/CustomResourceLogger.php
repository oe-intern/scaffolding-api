<?php

namespace App\Filament\Logger;

class CustomResourceLogger extends CustomAbstractModelLogger
{
    /**
     * @inheritdoc
     */
    protected function getLogName(): string
    {
        return config('filament-logger.resources.log_name');
    }
}
