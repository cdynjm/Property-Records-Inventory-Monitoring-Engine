<x-table>
    <x-slot:head>
        <th class="border-b border-b-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">#</th>
        <th class="border-b border-b-gray-200 px-4 py-2 text-[13px] text-start text-nowrap">Item Description</th>
        <th class="border-b border-b-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">Property Number</th>
        <th class="border-b border-b-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">Unit Measure</th>
        <th class="border-b border-b-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">Unit Value</th>
        <th class="border-b border-b-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">Accountable Officer</th>
        <th class="border-b border-b-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">Date Acquired</th>
        <th class="border-b border-b-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">Remarks</th>
    </x-slot:head>

    @foreach ($are as $index => $ar)
        @foreach ($ar->information as $infoIndex => $areInfo)
            <x-table-row>

                @if ($infoIndex === 0)
                    <td class="border-b border-b-gray-200 px-4 py-2 text-center align-middle whitespace-nowrap"
                        rowspan="{{ count($ar->information) }}">
                        {{ $index + 1 }}
                    </td>
                @endif
                {{-- Item Description --}}
                <td class="{{ $loop->last ? 'border-b border-b-gray-200' : 'no-border' }} px-4 py-2 align-middle max-w-[350px]">
                    <flux:heading class="flex items-center">
                        <flux:tooltip toggleable>
                           <flux:button size="sm" variant="ghost">
                                <iconify-icon icon="duo-icons:info" width="20" height="20"
                                    class="text-green-600"></iconify-icon>
                            </flux:button>
                            <flux:tooltip.content class="max-w-[20rem] space-y-2">
                                {!! nl2br(e($areInfo->description)) !!}
                            </flux:tooltip.content>
                        </flux:tooltip>

                         <p class="text-[13px] leading-snug truncate min-w-0">
                            {{ $areInfo->description }}
                        </p>
                    </flux:heading>
                </td>

                <td class="{{ $loop->last ? 'border-b border-b-gray-200' : 'no-border' }} text-center px-4 py-2 align-middle text-[13px] whitespace-nowrap">
                    <p>{{ $areInfo->propertyNumber }}</p>
                </td>

                <td class="{{ $loop->last ? 'border-b border-b-gray-200' : 'no-border' }} text-center px-4 py-2 align-middle text-[13px] whitespace-nowrap">
                    <p>{{ $areInfo->unit }}</p>
                </td>

                <td class="{{ $loop->last ? 'border-b border-b-gray-200' : 'no-border' }} text-center px-4 py-2 align-middle text-[13px] whitespace-nowrap">
                    <p>{{ number_format($areInfo->unitCost, 2) }}</p>
                </td>

                {{-- Only show personnel and actions once per ARE --}}
                @if ($infoIndex === 0)
                    <td class="border-b border-b-gray-200 px-4 py-2 align-middle text-center whitespace-nowrap"
                        rowspan="{{ count($ar->information) }}">
                        <div class="text-[13px]">
                            <div>
                                <p class="font-semibold text-gray-500">Received By:</p>
                                <p>{{ $ar->receivedBy != null ? $ar->receivedBy : '-' }}</p>
                                @if ($ar->dateReceivedBy)
                                    <p class="text-gray-500">{{ date('M d, Y', strtotime($ar->dateReceivedBy)) }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                @endif
                <td class="{{ $loop->last ? 'border-b border-b-gray-200' : 'no-border' }} px-4 py-2 align-middle whitespace-nowrap text-center">
                    <p>{{ date('M d, Y', strtotime($areInfo->dateAcquired)) }}</p>
                </td>
                @if ($infoIndex === 0)
                    <td class="border-b border-b-gray-200 px-4 py-2 align-middle text-center whitespace-nowrap"
                        rowspan="{{ count($ar->information) }}">
                        <div class="text-[13px]">
                            <div>

                                <p>{{ $ar->remarks }}</p>
                            </div>
                        </div>
                    </td>
                @endif
            </x-table-row>
        @endforeach
    @endforeach
</x-table>

@if ($are->isEmpty())
    <div class="grid grid-cols-1 gap-6 mt-4">
        <div class="bg-white border rounded-lg transition p-4 flex flex-col">
            <iconify-icon icon="solar:sad-square-line-duotone" width="24" height="24"
                class="mb-3"></iconify-icon>
            <small class="text-center text-gray-500">Sorry, no RPCPPE records found.</small>
        </div>
    </div>
@endif
