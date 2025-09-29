<div>
    <!-- He who is contented is rich. - Laozi -->
</div><x-table>
    <x-slot:head>
        <th class="px-4 py-2 text-[13px]">#</th>
        <th class="px-4 py-2 text-[13px] text-start whitespace-nowrap">ARE Information</th>
        <th class="px-4 py-2 text-[13px] text-start whitespace-nowrap">Received From</th>
        <th class="px-4 py-2 text-[13px] text-start whitespace-nowrap">Received By</th>
        <th class="px-4 py-2 text-[13px] text-start whitespace-nowrap">Remarks</th>
        <th class="px-4 py-2 text-[13px]">Actions</th>
    </x-slot:head>

    @foreach ($are as $index => $ar)
        <x-table-row class="">
            <td class="border-b border-gray-100 px-4 py-2 text-center whitespace-nowrap">{{ $index + 1 }}
            </td>
            <td class="border-b border-black-100 px-4 py-2">
                <a wire:navigate href="{{ route('admin.edit-are', ['encrypted_id' => $ar->encrypted_id]) }}" id="edit-are">
                    <p class="whitespace-nowrap font-bold mb-2 flex items-center gap-2">
                    <iconify-icon icon="fluent-color:document-text-28" width="22" height="22"></iconify-icon>
                    {{ $ar->areControlNumber }}
                </p>

                <ol class="">
                    @foreach ($ar->information as $areInfo)
                        <li class="flex items-center gap-2 space-y-2 italic text-[13px] ms-4">
                            <iconify-icon icon="solar:bag-check-line-duotone" class="text-green-500" width="18"
                                height="18"></iconify-icon>
                            <p class="truncate max-w-[300px]">{{ $areInfo->description }}</p> <b
                                class="whitespace-nowrap mb-2">( {{ $areInfo->quantity }} {{ $areInfo->unit }}
                                )</b>
                        </li>
                    @endforeach
                </ol>
                </a>
            </td>
            <td class="border-b border-gray-100 px-4 py-2 whitespace-nowrap">
                <div>
                    {{ $ar->receivedFrom->name }}
                </div>
                <p class="text-[13px]">{{ date('M d, Y', strtotime($ar->dateReceivedFrom)) }}</p>
            </td>
            <td class="border-b border-gray-100 px-4 py-2 whitespace-nowrap">
                <div>
                    {{ $ar->receivedBy != null ? $ar->receivedBy : '-' }}
                </div>
                <p class="text-[13px] {{ $ar->dateReceivedBy == null ? 'invisible' : '' }}">
                    {{ date('M d, Y', strtotime($ar->dateReceivedBy)) }}</p>
            </td>
            <td
                class="border-b border-gray-100 px-4 py-2 whitespace-nowrap uppercase text-[12px]  {{ $ar->remarks == 'active' ? 'text-green-500' : 'text-red-500' }}">
                {{ $ar->remarks }}</td>
            <td class="border-b border-gray-100 px-4 py-2 text-center whitespace-nowrap">
                <a wire:navigate href="{{ route('admin.edit-are', ['encrypted_id' => $ar->encrypted_id]) }}"
                    id="edit-are">
                    <iconify-icon icon="lets-icons:edit-duotone" width="24" height="24"></iconify-icon>
                </a>

                <a href="javascript:;" id="delete-are" data-id="{{ $ar->encrypted_id }}">
                    <iconify-icon icon="lets-icons:trash-duotone" width="24" height="24"></iconify-icon>
                </a>

                <a wire:navigate href="{{ route('admin.are-print', ['encrypted_id' => $ar->encrypted_id]) }}"
                    id="print-are">
                    <iconify-icon icon="lets-icons:print-duotone" width="24" height="24"></iconify-icon>
                </a>
            </td>
        </x-table-row>
    @endforeach

    @if ($are->isEmpty())
        <x-table-row>
            <td colspan="10" class="border-b border-gray-100 px-4 py-2 text-center text-gray-500">No ARE
                found.</td>
        </x-table-row>
    @endif
</x-table>

