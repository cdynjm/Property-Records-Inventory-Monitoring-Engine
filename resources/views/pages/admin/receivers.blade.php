<x-layouts.app :title="__('Receivers')">
    <div class="flex min-h-screen flex-col">

        <div class="flex-1">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
                <flux:heading level="3">List of Receivers</flux:heading>

                <div class="flex flex-col md:flex-row md:items-center gap-3 w-full md:w-auto">
                    {{-- Search Bar --}}
                    <div class="flex items-center w-full md:w-80 gap-2">
                        @if (session('search-receiver'))
                            <a href="javascript:;" class="me-1 text-red-600 flex items-center gap-1" id="clear-receiver">
                                <iconify-icon icon="mdi:clear" width="18" height="18"></iconify-icon>
                                <span class="text-[11px]">Clear</span>
                            </a>
                        @endif

                        <flux:input placeholder="Search..." id="search-receiver" size="sm"
                            value="{{ session('search-receiver') }}" class="flex-1 rounded-r-none" />
                        <flux:button variant="primary" type="button" size="sm" id="search-receiver-records">
                            <iconify-icon icon="lets-icons:search-duotone" width="20" height="20"></iconify-icon>
                        </flux:button>
                    </div>
                </div>
            </div>

            <x-table>
                <x-slot:head>
                    <th class="px-4 py-2 text-[13px]">#</th>
                    <th class="px-4 py-2 text-[13px] text-start">Name</th>
                    <th class="px-4 py-2 text-[13px] text-start">Position</th>
                    <th class="px-4 py-2 text-[13px]">Actions</th>
                </x-slot:head>

                @foreach ($receivedBy as $index => $rb)
                    <x-table-row class="">
                        <td class="border-b border-gray-100 px-4 py-2 text-center whitespace-nowrap">{{ $index + 1 }}
                        </td>
                        <td class="border-b border-gray-100 px-4 py-2 whitespace-nowrap">
                            <a wire:navigate
                                href="{{ route('admin.receivers-property-inventory-records', ['encrypted_id' => $rb->encrypted_id]) }}">
                                {{ $rb->name }}
                            </a>
                        </td>
                        <td class="border-b border-gray-100 px-4 py-2 whitespace-nowrap">{{ $rb->position }}</td>
                        <td class="border-b border-gray-100 px-4 py-2 text-center whitespace-nowrap">

                            <a wire:navigate
                                href="{{ route('admin.receivers-property-inventory-records', ['encrypted_id' => $rb->encrypted_id]) }}">
                                <iconify-icon icon="lets-icons:view-duotone" width="24"
                                    height="24" class="text-gray-500"></iconify-icon>
                            </a>

                        </td>
                    </x-table-row>
                @endforeach

                @if ($receivedBy->isEmpty())
                    <x-table-row>
                        <td colspan="4" class="border-b border-gray-100 px-4 py-2 text-center text-gray-500">No
                            personnel
                            found.</td>
                    </x-table-row>
                @endif
            </x-table>

            <div class="mt-8">
                {{ $receivedBy->links('vendor.pagination.custom-pagination') }}
            </div>
        </div>

        <x-footer class="mt-auto" />
    </div>
</x-layouts.app>
