<x-filament-panels::page>
    <div class="space-y-16 mx-12 py-4">
        {{-- The form for sending notifications --}}
        <div class="p-4 bg-gray-50/10 rounded-xl">
            <form wire:submit="submit">
                {{ $this->form }}
                <span >&nbsp;</span>
                <div class="my-12 flex justify-end">
                    <x-filament::button type="submit" icon="heroicon-o-paper-airplane" size="lg">
                        {{ __('admin.send_notification_now') }}
                    </x-filament::button>
                </div>
                <span >&nbsp;</span>
            </form>
        </div>

        {{-- The table showing recent notifications --}}
        <div class="my-16 pt-8 border-t border-gray-200">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">{{ __('admin.recent_notifications') }}</h2>
            <span >&nbsp;</span>
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>
