<x-layouts.app :title="__('ICS Records')">
    <div class="flex min-h-screen flex-col">

        <div class="flex-1">
            <div class="flex items-center justify-between mb-4">
                <flux:heading level="3">List of ICS Records</flux:heading>
            </div>

            <x-table>
                <x-slot:head>
                    <th class="px-4 py-2 text-[13px]">#</th>
                    <th class="px-4 py-2 text-[13px] text-start whitespace-nowrap">ICS Information</th>
                    <th class="px-4 py-2 text-[13px] text-start whitespace-nowrap">Received From</th>
                    <th class="px-4 py-2 text-[13px] text-start whitespace-nowrap">Received By</th>
                    <th class="px-4 py-2 text-[13px] text-start whitespace-nowrap">Remarks</th>
                    <th class="px-4 py-2 text-[13px]">Actions</th>
                </x-slot:head>

                @foreach ($ics as $index => $ic)
                    <x-table-row class="">
                        <td class="border-b border-gray-100 px-4 py-2 text-center whitespace-nowrap">{{ $index + 1 }}
                        </td>
                        <td class="border-b border-black-100 px-4 py-2">
                            <p class="whitespace-nowrap font-bold mb-2 flex items-center gap-2">
                                <iconify-icon icon="fluent-color:document-text-28" width="22" height="22"></iconify-icon>
                                {{ $ic->icsNumber }}
                            </p>

                            <ol class="">
                                @foreach ($ic->information as $icInfo)
                                    <li class="flex items-center gap-2 space-y-2 italic text-[13px] ms-4">
                                      <iconify-icon icon="solar:bag-check-line-duotone" class="text-green-500" width="18" height="18"></iconify-icon>  <p class="truncate max-w-[300px]">{{ $icInfo->description }}</p> <b class="whitespace-nowrap mb-2">( {{ $icInfo->quantity }} {{ $icInfo->unit }} )</b>
                                    </li>
                                @endforeach
                            </ol>
                        </td>
                        <td class="border-b border-gray-100 px-4 py-2 whitespace-nowrap">
                            <div>
                                {{ $ic->receivedFrom->name }}
                            </div>
                            <p class="text-[13px]">{{ date('M d, Y', strtotime($ic->dateReceivedFrom)) }}</p>
                        </td>
                        <td class="border-b border-gray-100 px-4 py-2 whitespace-nowrap">
                            <div>
                            {{ $ic->receivedBy != null ? $ic->receivedBy : '-' }}
                            </div>
                             <p class="text-[13px] {{ $ic->dateReceivedBy == null ? 'invisible' : '' }}">{{ date('M d, Y', strtotime($ic->dateReceivedBy)) }}</p>
                        </td>
                        <td
                            class="border-b border-gray-100 px-4 py-2 whitespace-nowrap uppercase text-[12px]  {{ $ic->remarks == 'active' ? 'text-green-500' : 'text-red-500' }}">
                            {{ $ic->remarks }}</td>
                        <td class="border-b border-gray-100 px-4 py-2 text-center whitespace-nowrap">
                            <a wire:navigate href="{{ route('admin.edit-ics', ['encrypted_id' => $ic->encrypted_id]) }}" id="edit-ics">
                                <iconify-icon icon="lets-icons:edit-duotone" width="24"
                                    height="24"></iconify-icon>
                            </a>

                            <a href="javascript:;" id="delete-ics" data-id="{{ $ic->encrypted_id }}">
                                <iconify-icon icon="lets-icons:trash-duotone" width="24"
                                    height="24"></iconify-icon>
                            </a>

                            <a href="{{ route('admin.ics-form', ['encrypted_id' => $ic->encrypted_id]) }}" id="print-ics">
                                <iconify-icon icon="lets-icons:print-duotone" width="24" height="24"></iconify-icon>
                            </a>
                        </td>
                    </x-table-row>
                @endforeach

                @if ($ics->isEmpty())
                    <x-table-row>
                        <td colspan="4" class="border-b border-gray-100 px-4 py-2 text-center text-gray-500">No ICS
                            found.</td>
                    </x-table-row>
                @endif
            </x-table>
        </div>

        <x-footer class="mt-auto" />
    </div>
</x-layouts.app>
