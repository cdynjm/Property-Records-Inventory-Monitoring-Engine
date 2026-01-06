<x-table>
    <x-slot:head>
        <th class="border border-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">#</th>
        <th class="border border-gray-200 px-4 py-2 text-[13px] text-start text-nowrap">Item Description</th>
        <th class="border border-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">Property Number</th>
        <th class="border border-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">Unit Measure</th>
        <th class="border border-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">Unit Value</th>
        <th class="border border-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">Accountable Officer</th>
        <th class="border border-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">Date Acquired</th>
        <th class="border border-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">Remarks</th>
    </x-slot:head>

    @foreach ($are as $index => $ar)
        @foreach ($ar->information as $infoIndex => $areInfo)
            <x-table-row>

                @if ($infoIndex === 0)
                    <td class="border border-gray-200 px-4 py-2 text-center align-top whitespace-nowrap"
                        rowspan="{{ count($ar->information) }}">
                        {{ $index + 1 }}
                    </td>
                @endif
                {{-- Item Description --}}
                <td class="border border-gray-200 px-4 py-2 align-middle text-nowrap xl:text-wrap">
                    <div class="flex items-start gap-2">
                        <iconify-icon icon="solar:bag-check-line-duotone" class="text-green-500" width="18"
                            height="18"></iconify-icon>
                        <p class="text-[13px] leading-snug">{!! nl2br(e($areInfo->description)) !!}</p>
                    </div>

                </td>

                <td class="border border-gray-200 text-center px-4 py-2 align-middle text-[13px] whitespace-nowrap">
                    <p>{{ $areInfo->propertyNumber }}</p>
                </td>

                <td class="border border-gray-200 text-center px-4 py-2 align-middle text-[13px] whitespace-nowrap">
                    <p>{{ $areInfo->unit }}</p>
                </td>

                <td class="border border-gray-200 text-center px-4 py-2 align-middle text-[13px] whitespace-nowrap">
                    <p>{{ number_format($areInfo->unitCost, 2) }}</p>
                </td>

                {{-- Only show personnel and actions once per ARE --}}
                @if ($infoIndex === 0)
                    <td class="border border-gray-200 px-4 py-2 align-middle text-center whitespace-nowrap"
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
                <td class="border border-gray-200 px-4 py-2 align-middle whitespace-nowrap">
                    <p>{{ date('M d, Y', strtotime($areInfo->dateAcquired)) }}</p>
                </td>
                @if ($infoIndex === 0)
                    <td class="border border-gray-200 px-4 py-2 align-middle text-center whitespace-nowrap"
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
