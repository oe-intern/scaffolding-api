<?php

namespace App\Filament\Infolists\Components;

use Filament\Infolists\Components\Entry;

class TextEntryAction extends Entry
{
    /**
     * @var string
     */
    protected string $view = 'infolists.components.text-entry-action';

    /**
     * @var int|\Closure|null
     */
    protected int | \Closure | null $maxLength = 50;

    /**
     * Max length of the text.
     *
     * @param int|\Closure|null $maxLength
     * @return $this
     */
    public function maxLength(int | \Closure | null $maxLength): static
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    /**
     * Get the max length of the text.
     *
     * @return int|null
     */
    public function getMaxLength(): ?int
    {
        return $this->evaluate($this->maxLength);
    }
}
