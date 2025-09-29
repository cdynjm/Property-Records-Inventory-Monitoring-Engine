<x-layouts.app :title="__('Issuer Records')">
    <div class="flex min-h-screen flex-col">

        <div class="flex-1">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
                 <div class="flex items-center gap-2">
                    <img src="{{ asset('/img/user.png') }}" alt="" class="w-8 h-auto" draggable="false">
                   <div>
                     <h6 class="font-bold">{{ $issuer->name }}</h6>
                     <small>{{ $issuer->position }}</small>
                   </div>
                </div>
                <x-filter-information />
            </div>

            <div class="mb-4">
                <flux:heading class="my-4">ICS Records</flux:heading>

                <x-ics-records :ics="$ics" />

                <div class="mt-8">
                    {{ $ics->links('vendor.pagination.custom-pagination') }}
                </div>
            </div>

            <div class="mb-4">
                <flux:heading class="my-4">ARE Records</flux:heading>

                <x-are-records :are="$are" />

                <div class="mt-8">
                    {{ $are->links('vendor.pagination.custom-pagination') }}
                </div>
            </div>
        </div>

        <x-footer class="mt-auto" />
    </div>
</x-layouts.app>
