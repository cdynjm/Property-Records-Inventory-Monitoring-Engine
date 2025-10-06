<x-layouts.app :title="__('ARE Records')">
    <div class="flex min-h-screen flex-col">
        
        <div class="flex-1">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
                <flux:heading level="1">List of ARE Records</flux:heading>
                <x-office-filter-information />
            </div>

            <x-office-are-records :are="$are" />

            <div class="mt-8">
                {{ $are->links('vendor.pagination.custom-pagination') }}
            </div>
            
        </div>

        <x-footer class="mt-auto" />
    </div>
</x-layouts.app>
