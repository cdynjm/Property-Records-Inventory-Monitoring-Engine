<x-layouts.app :title="__('Dashboard')">
    <div class="flex min-h-screen flex-col">
        
        <div class="flex-1">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full mx-auto mb-10">
                
                <!-- ARE Card -->
                <a wire:navigate href="{{ route('admin.are') }}"
                   class="flex flex-col items-center justify-center border-1 border-green-600 text-green-600 bg-white rounded-2xl shadow-md p-8 h-38 transition hover:bg-green-50">
                    <iconify-icon icon="mdi:clipboard-text" width="50" height="50" class="mb-3"></iconify-icon>
                    <h3 class="text-2xl font-bold mb-1">ARE</h3>
                    <p class="text-sm text-center">Acknowledgement Receipt for Equipment</p>
                </a>
    
                <!-- ICS Card -->
                <a wire:navigate href="{{ route('admin.ics') }}"
                   class="flex flex-col items-center justify-center border-1 border-blue-600 text-blue-600 bg-white rounded-2xl shadow-md p-8 h-38 transition hover:bg-blue-50">
                    <iconify-icon icon="mdi:archive" width="50" height="50" class="mb-3"></iconify-icon>
                    <h3 class="text-2xl font-bold mb-1">ICS</h3>
                    <p class="text-sm text-center">Inventory Custodian Slip</p>
                </a>

            </div>

            <div class="flex items-center justify-between mb-4">
                <flux:heading level="3">Recent Activity</flux:heading>
            </div>

            <x-table>
                <x-slot:head>
                    <th class="px-4 py-2 text-[13px]">#</th>
                    <th class="px-4 py-2 text-[13px] text-start">Office Name</th>
                    <th class="px-4 py-2 text-[13px] text-start">Code</th>
                    <th class="px-4 py-2 text-[13px]">Actions</th>
                </x-slot:head>

              
                    <x-table-row class="">
                        <td class="border-b border-gray-100 px-4 py-2 text-center"></td>
                        <td class="border-b border-gray-100 px-4 py-2"></td>
                        <td class="border-b border-gray-100 px-4 py-2"></td>
                        <td class="border-b border-gray-100 px-4 py-2 text-center">
                            
                        </td>
                    </x-table-row>
            </x-table>
        </div>

        <x-footer class="mt-auto" />
    </div>
</x-layouts.app>
