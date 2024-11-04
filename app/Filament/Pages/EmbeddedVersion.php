<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Cache;

class EmbeddedVersion extends Page implements HasForms
{
    use InteractsWithForms, HasPageShield;

    /**
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-shield-exclamation';

    /**
     * @var string
     */
    protected static string $view = 'filament.pages.embedded-version';

    /**
     * @var string|null
     */
    protected static ?string $navigationGroup = 'Development tools';

    /**
     * @var array|null
     */
    public ?array $data = [];

    /**
     * Mount the page.
     *
     * @return void
     */
    public function mount(): void
    {
        $current_version = Cache::get('embedded_version') ?: $this->setEmbeddedVersion(time());
        $this->form->fill([
            'current_version' => $current_version,
        ]);
    }

    /**
     * Get form.
     *
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Current Version')
                    ->aside()
                    ->schema([
                        TextInput::make('current_version')
                            ->label('')
                    ]),
            ])
            ->statePath('data');
    }

    /**
     * Save the form.
     *
     * @return void
     */
    public function save(): void
    {
        try {
            Cache::forget('embedded_version');
            $data = $this->form->getState();
            $new_version = (int) data_get($data, 'current_version');
            $this->setEmbeddedVersion($new_version);

        } catch (\Throwable $exception) {
            Notification::make()
                ->title('Error')
                ->body($exception->getMessage())
                ->color(Color::Red)
                ->duration(5000)
                ->icon('heroicon-o-exclamation-circle')
                ->status('error')
                ->send();
            return;
        }

        Notification::make()
            ->title('Embedded version')
            ->body('Update successfully')
            ->color(Color::Green)
            ->duration(5000)
            ->icon('heroicon-o-check-circle')
            ->status('success')
            ->send();
    }

    /**
     * Get the view that renders the page.
     *
     * @return array
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->submit('save'),
        ];
    }

    /**
     * Set embedded version
     *
     * @param $version
     * @return mixed
     */
    private function setEmbeddedVersion($version)
    {
        $ttl = config('cache.redis_ttl.embedded_version');

        Cache::remember('embedded_version', $ttl, function () use ($version) {
            return $version;
        });

        return $version;
    }
}
