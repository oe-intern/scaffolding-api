<x-filament-panels::page>
    <x-filament-panels::form wire:submit.prevent="handle">
        {{ $this->form }}

        <div class="flex justify-center">
            <x-filament-panels::form.actions :actions="$this->getFormActions()" />
        </div>
    </x-filament-panels::form>

    @if ($this->url)
        <div class="mt-4 p-2 bg-gray-100 rounded text-blue-600 flex items-center space-x-2">
            <i class="flex-grow">
                {{ $this->url }}
            </i>
        </div>
    @endif

</x-filament-panels::page>

