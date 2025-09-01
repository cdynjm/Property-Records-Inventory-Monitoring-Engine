<x-layouts.app :title="__('Dashboard')">
    <div class="flex min-h-screen flex-col">

        <div class="flex-1">
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
