<x-layouts.app :title="__('Receivers')">
    <div class="flex min-h-screen flex-col">
        
        <div class="flex-1">
            <div class="flex items-center justify-between mb-4">
                <flux:heading level="3">List of Receivers</flux:heading>
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
                        <td class="border-b border-gray-100 px-4 py-2 text-center whitespace-nowrap">{{ $index + 1 }}</td>
                        <td class="border-b border-gray-100 px-4 py-2 whitespace-nowrap">{{ $rb->name }}</td>
                        <td class="border-b border-gray-100 px-4 py-2 whitespace-nowrap">{{ $rb->position }}</td>
                        <td class="border-b border-gray-100 px-4 py-2 text-center whitespace-nowrap">
                            
                        <a wire:navigate href="javascript:;">
                           <iconify-icon icon="lets-icons:view-duotone" width="24" height="24"></iconify-icon>
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
        </div>

        <x-footer class="mt-auto" />
    </div>
</x-layouts.app>
