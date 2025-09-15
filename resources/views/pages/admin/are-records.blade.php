<x-layouts.app :title="__('ARE Records')">
    <div class="flex min-h-screen flex-col">
        
        <div class="flex-1">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
                <flux:heading level="1">List of ARE Records</flux:heading>
                <x-filter-information />
            </div>
        </div>

        <x-footer class="mt-auto" />
    </div>
</x-layouts.app>
