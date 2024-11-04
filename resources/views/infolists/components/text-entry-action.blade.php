<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div x-data="{ isCollapsed: false, maxLength: @js($getMaxLength()), originalContent: '', content: '' }"
         x-init="originalContent = @js($getState()); content = originalContent.length > maxLength ? originalContent.slice(0, maxLength) + '...' : originalContent"
         style="max-width: 100%; word-wrap: break-word;">
        <span x-text="isCollapsed ? originalContent : content" class="text-sm" style="white-space: pre-wrap; display: block;"></span>
        <x-filament::button
            size="xs"
            color="gray"
            @click="isCollapsed = !isCollapsed"
            x-show="originalContent.length > maxLength"
            x-text="isCollapsed ? 'Show less' : 'Show more'"
            style="display: block; margin-top: 8px;"
        ></x-filament::button>
    </div>
</x-dynamic-component>
