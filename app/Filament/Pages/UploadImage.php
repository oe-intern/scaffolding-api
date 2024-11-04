<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class UploadImage extends Page implements HasForms
{
    use InteractsWithForms, HasPageShield;

    /**
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-cloud-arrow-up';

    /**
     * @var string
     */
    protected static string $view = 'filament.pages.upload-image';

    /**
     * @var string|null
     */
    protected static ?string $title = 'Upload Image';

    /**
     * @var string|null
     */
    protected static ?string $navigationGroup = 'Marketing tools';

    /**
     * @var
     */
    public ?array $data = [];

    /**
     * @var
     */
    public $url;


    /**
     * Mount the page.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->form->fill();
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
                ->label('Upload')
                ->submit('save'),
        ];
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
                FileUpload::make('image')
                    ->image()
                    ->disk(config('filesystems.default'))
                    ->preserveFilenames()
                    ->label('Image')
                    ->acceptedFileTypes(['image/*'])
                    ->directory('images')
                    ->required()
            ])
            ->statePath('data');
    }

    /**
     * Upload image.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->form->getState();
        $file_name = Arr::get($data, 'image');

        $this->url = Storage::url($file_name);
    }
}
