<x-table>
    <x-slot:head>
        <th class="border border-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">#</th>
        <th class="border border-gray-200 px-4 py-2 text-[13px] text-start text-nowrap">ARE Control Number</th>
        <th class="border border-gray-200 px-4 py-2 text-[13px] text-start text-nowrap">Item Description</th>
        <th class="border border-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">Property No. & Remarks</th>
        <th class="border border-gray-200 px-4 py-2 text-[13px] text-start text-nowrap">Accountable</th>
        <th class="border border-gray-200 px-4 py-2 text-[13px] text-center text-nowrap">Actions</th>
    </x-slot:head>

    @foreach ($are as $index => $ar)
        @foreach ($ar->information as $infoIndex => $areInfo)
            <x-table-row>
                @if ($infoIndex === 0)
                    <td class="border border-gray-200 px-4 py-2 text-center align-top whitespace-nowrap"
                        rowspan="{{ count($ar->information) }}">
                        {{ $index + 1 }}
                    </td>
                    <td class="border border-gray-200 py-2 align-top text-nowrap"
                        rowspan="{{ count($ar->information) }}">
                        <div class="flex items-center justify-between px-4 mb-4">
                            <a wire:navigate
                                href="{{ route('admin.are-print', ['encrypted_id' => $ar->encrypted_id]) }}">
                                <p class="font-bold flex items-center gap-2 text-[13px]">
                                    <iconify-icon icon="fluent-color:document-text-28" width="20"
                                        height="20"></iconify-icon>
                                    {{ $ar->areControlNumber }}
                                </p>
                            </a>
                        </div>
                    </td>
                @endif

                {{-- Item Description --}}
                <td class="border border-gray-200 px-4 py-2 align-middle text-nowrap xl:text-wrap">
                    <div class="flex items-start gap-2">
                        <iconify-icon icon="solar:bag-check-line-duotone" class="text-green-500" width="18"
                            height="18"></iconify-icon>
                        <p class="text-[13px] leading-snug">{!! nl2br(e($areInfo->description)) !!}</p>
                    </div>
                    <p class="text-[12px] mt-1">
                        <span class="font-semibold mr-1">Quantity:</span>
                        {{ $areInfo->quantity }} {{ $areInfo->unit }}
                    </p>
                    <p class="text-[12px]">
                        <span class="font-semibold mr-1">PPE:</span>
                        {{ $areInfo->accountsCode->description }}
                    </p>
                    <p class="text-[12px]">
                        <span class="font-semibold mr-1">Date Acquired:</span>
                        {{ $areInfo->dateAcquired ? date('M d, Y', strtotime($areInfo->dateAcquired)) : '-' }}
                    </p>
                </td>

                {{-- Property Number --}}
                <td class="border border-gray-200 text-center px-4 py-2 align-middle text-[13px] whitespace-nowrap">
                    <p>{{ $areInfo->propertyNumber }}</p>
                    <p class="text-blue-600">{{ $ar->remarks }}</p>
                </td>

                {{-- Only show personnel and actions once per ARE --}}
                @if ($infoIndex === 0)
                    <td class="border border-gray-200 px-4 py-2 align-middle whitespace-nowrap"
                        rowspan="{{ count($ar->information) }}">
                        <div class="text-[13px]">
                            <div class="mb-4">
                                <p class="font-semibold text-gray-500">Received From:</p>
                                <p>{{ $ar->receivedFrom->name }}</p>
                                <p class="text-gray-500">{{ date('M d, Y', strtotime($ar->dateReceivedFrom)) }}</p>
                            </div>

                            <div>
                                <p class="font-semibold text-gray-500">Received By:</p>
                                <p>{{ $ar->receivedBy != null ? $ar->receivedBy : '-' }}</p>
                                @if ($ar->dateReceivedBy)
                                    <p class="text-gray-500">{{ date('M d, Y', strtotime($ar->dateReceivedBy)) }}</p>
                                @endif
                            </div>
                        </div>
                    </td>

                    <td class="border border-gray-200 px-4 py-2 align-middle whitespace-nowrap"
                        rowspan="{{ count($ar->information) }}">
                        <div class="flex items-center justify-center gap-2">
                            <div class="flex flex-col items-center">
                                <a wire:navigate
                                    href="{{ route('admin.edit-are', ['encrypted_id' => $ar->encrypted_id]) }}">
                                    <small class="text-gray-500">Edit</small>
                                </a>
                                
                            </div>
                           <span class="text-gray-300">|</span>
                            <div class="flex flex-col items-center">
                                <a wire:navigate
                                    href="{{ route('admin.are-print', ['encrypted_id' => $ar->encrypted_id]) }}">
                                   <small class="text-blue-500">Print</small>
                                </a>
                                
                            </div>
                           
                            <div class="flex flex-col items-center text-red-500">
                                <flux:modal.trigger name="delete-are">
                                    <a href="javascript:;" data-id="{{ $ar->encrypted_id }}" id="delete-are" class="mt-1">
                                        <iconify-icon icon="lets-icons:trash-duotone" width="22"
                                            height="22"></iconify-icon>
                                    </a>
                                </flux:modal.trigger>
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
            <small class="text-center text-gray-500">Sorry, no ARE records found.</small>
        </div>
    </div>
@endif

<x-modal name="delete-are" class="w-auto md:m-auto mx-4">
    <x-slot name="header">
        <flux:modal.close class="text-gray-500 hover:text-gray-700" />
        <flux:heading size="lg">Delete ARE and PPE Record</flux:heading>
        <flux:text class="mt-2">Are you sure you want to delete this ARE and PPE Record?</flux:text>
    </x-slot>
    <div class="flex">
        <flux:spacer />
        <flux:button type="button" variant="outline" class="me-3" x-on:click="$flux.modal('delete-are').close()">
            Cancel</flux:button>
        <flux:button type="submit" variant="danger" id="delete-are-btn">Delete</flux:button>
    </div>
</x-modal>

@if (Session::get('success'))
    <x-success-toast>
        {{ Session::get('success') }}
    </x-success-toast>
@endif
