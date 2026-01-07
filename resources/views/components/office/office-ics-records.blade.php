<x-table>
    <x-slot:head>
        <th class="border-b border-b-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">#</th>
        <th class="border-b border-b-gray-200 px-4 py-2 text-[13px] text-start text-nowrap">ICS Number</th>
        <th class="border-b border-b-gray-200 px-4 py-2 text-[13px] text-start text-nowrap">Item Description</th>
        <th class="border-b border-b-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">Inventory Item No.</th>
        <th class="border-b border-b-gray-200 px-4 py-2 text-[13px] text-start text-nowrap">Accountable</th>
        <th class="border-b border-b-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">Actions</th>
    </x-slot:head>

    @foreach ($ics as $index => $ic)
        @foreach ($ic->information as $infoIndex => $icsInfo)
            <x-table-row>
                @if ($infoIndex === 0)
                    <td class="border-b border-b-gray-200 px-4 py-2 text-center align-middle whitespace-nowrap"
                        rowspan="{{ count($ic->information) }}">
                        {{ $index + 1 }}
                    </td>
                    <td class="border-b border-b-gray-200 py-2 align-middle text-nowrap"
                        rowspan="{{ count($ic->information) }}">
                        <div class="flex items-center justify-between px-4">
                            <a wire:navigate
                                href="{{ route('office.ics-print', ['encrypted_id' => $ic->encrypted_id]) }}">
                                <p class="font-bold flex items-center gap-2 text-[13px]">
                                    <iconify-icon icon="fluent-color:document-text-28" width="20"
                                        height="20"></iconify-icon>
                                    {{ $ic->icsNumber }}
                                </p>
                            </a>
                        </div>
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
                                {!! nl2br(e($icsInfo->description)) !!}

                                <p class="text-[12px] mt-4">
                                    <span class="font-semibold mr-1">Quantity:</span>
                                    {{ $icsInfo->quantity }} {{ $icsInfo->unit }}
                                </p>
                                <p class="text-[12px]">
                                    <span class="font-semibold mr-1">Date Acquired:</span>
                                    {{ $icsInfo->dateAcquired ? date('M d, Y', strtotime($icsInfo->dateAcquired)) : '-' }}
                                </p>
                            </flux:tooltip.content>
                        </flux:tooltip>

                        <p class="text-[13px] leading-snug truncate min-w-0">
                            {{ $icsInfo->description }}
                        </p>
                    </flux:heading>
                </td>

                {{-- Property Number --}}
                <td class="border-b border-b-gray-200 text-center px-4 py-2 align-middle text-[13px] whitespace-nowrap">
                    {{ $icsInfo->invItemNumber }}
                </td>

                {{-- Only show personnel and actions once per ARE --}}
                @if ($infoIndex === 0)
                    <td class="border-b border-b-gray-200 px-4 py-2 align-middle whitespace-nowrap"
                        rowspan="{{ count($ic->information) }}">
                        <div class="text-[13px]">
                            <div class="mb-4">
                                <p class="font-semibold text-gray-500">Received From:</p>
                                <p>{{ $ic->receivedFrom->name }}</p>
                                <p class="text-gray-500">{{ date('M d, Y', strtotime($ic->dateReceivedFrom)) }}</p>
                            </div>

                            <div>
                                <p class="font-semibold text-gray-500">Received By:</p>
                                <p>{{ $ic->receivedBy != null ? $ic->receivedBy : '-' }}</p>
                                @if ($ic->dateReceivedBy)
                                    <p class="text-gray-500">{{ date('M d, Y', strtotime($ic->dateReceivedBy)) }}</p>
                                @endif
                            </div>
                        </div>
                    </td>

                    <td class="border-b border-b-gray-200 px-4 py-2 align-middle whitespace-nowrap"
                        rowspan="{{ count($ic->information) }}">
                        <div class="flex items-center justify-around gap-2">
                            <div class="flex flex-col items-center">
                                <a wire:navigate
                                    href="{{ route('office.ics-print', ['encrypted_id' => $ic->encrypted_id]) }}">
                                   <small class="text-blue-500">View</small>
                                </a>
                               
                            </div>
                        </div>
                    </td>
                @endif
            </x-table-row>
        @endforeach
    @endforeach
</x-table>

@if ($ics->isEmpty())
    <div class="grid grid-cols-1 gap-6 mt-4">
        <div class="bg-white border rounded-lg transition p-4 flex flex-col">
            <iconify-icon icon="solar:sad-square-line-duotone" width="24" height="24"
                class="mb-3"></iconify-icon>
            <small class="text-center text-gray-500">Sorry, no ICS records found.</small>
        </div>
    </div>
@endif
