<div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6">
    @foreach ($ics as $index => $ic)
         <div class="bg-white border rounded-lg transition flex flex-col">
            <a wire:navigate href="{{ route('admin.edit-ics', ['encrypted_id' => $ic->encrypted_id]) }}" class="flex-1">
                {{-- Header / ARE Control Number --}}
                <div class="flex items-center justify-between px-4 pt-4 mb-4">
                    <p class="font-bold flex items-center gap-2 text-[15px]">
                        <iconify-icon icon="fluent-color:document-text-28" width="22" height="22"></iconify-icon>
                        {{ $ic->icsNumber }}
                    </p>
                    <span class="text-gray-400 text-sm">#{{ $index + 1 }}</span>
                </div>

                {{-- ICS Information --}}
                 <div class="grid grid-cols-1 gap-3 px-4 mb-4">
                    @foreach ($ic->information as $icsInfo)
                        <div class="p-2 border rounded-md bg-gray-50">
                            <div class="flex items-start gap-2 mb-2">
                                <iconify-icon icon="solar:bag-check-line-duotone" class="text-green-500" width="18"
                                    height="18"></iconify-icon>
                                <p class="text-[13px] leading-snug">
                                    {!! nl2br(e($icsInfo->description)) !!}
                                </p>
                            </div>
                            <p class="text-[12px]"><span class="font-semibold">Quantity:</span>
                                {{ $icsInfo->quantity }} {{ $icsInfo->unit }}</p>
                        </div>
                    @endforeach
                </div>
            </a>

            {{-- Received From / By --}}
            <div class="text-[13px] px-4 mb-4">
                <div>
                    <p class="font-semibold text-gray-500">Received From:</p>
                    <p>{{ $ic->receivedFrom->name }}</p>
                    <p class="text-gray-500">{{ date('M d, Y', strtotime($ic->dateReceivedFrom)) }}</p>
                </div>
                <hr class="my-3">
                <div>
                    <p class="font-semibold text-gray-500">Received By:</p>
                    <p>{{ $ic->receivedBy != null ? $ic->receivedBy : '-' }}</p>
                    @if ($ic->dateReceivedBy)
                        <p class="text-gray-500">{{ date('M d, Y', strtotime($ic->dateReceivedBy)) }}</p>
                    @endif
                </div>
            </div>

            {{-- Remarks --}}
            <div class="px-4 mb-3">
                <span
                    class="uppercase text-[12px] font-bold
                    {{ $ic->remarks === 'active' ? 'text-green-500' : 'text-red-500' }}">
                    {{ $ic->remarks }}
                </span>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-around mt-auto bg-gray-50 py-2 border-t rounded-b-lg">
                <div class="flex flex-col items-center">
                    <a wire:navigate href="{{ route('admin.edit-ics', ['encrypted_id' => $ic->encrypted_id]) }}">
                        <iconify-icon icon="lets-icons:edit-duotone" width="22" height="22" class="text-gray-500"></iconify-icon>
                    </a>
                    <span class="text-[11px] text-gray-600">Edit</span>
                </div>
                <div class="flex flex-col items-center">
                    <a wire:navigate href="{{ route('admin.ics-print', ['encrypted_id' => $ic->encrypted_id]) }}">
                        <iconify-icon icon="lets-icons:print-duotone" width="22" height="22" class="text-gray-500"></iconify-icon>
                    </a>
                    <span class="text-[11px] text-gray-600">Print</span>
                </div>
                <div class="flex flex-col items-center text-red-500">
                    <flux:modal.trigger name="delete-ics">
                        <a href="javascript:;" data-id="{{ $ic->encrypted_id }}" id="delete-ics">
                            <iconify-icon icon="lets-icons:trash-duotone" width="22" height="22"></iconify-icon>
                        </a>
                    </flux:modal.trigger>
                    <span class="text-[11px] text-red-500">Delete</span>
                </div>
            </div>
        </div>
    @endforeach
</div>

@if ($ics->isEmpty())
    <div class="grid grid-cols-1 gap-6">
        <div class="bg-white border rounded-lg transition p-4 flex flex-col">
            <iconify-icon icon="solar:sad-square-line-duotone" width="24" height="24"
                class="mb-3"></iconify-icon>
            <small class="text-center text-gray-500">Sorry, no ICS records found.</small>
        </div>
    </div>
@endif

<x-modal name="delete-ics" class="w-auto md:m-auto mx-4">
    <x-slot name="header">
        <flux:modal.close class="text-gray-500 hover:text-gray-700" />
        <flux:heading size="lg">Delete ICS Record</flux:heading>
        <flux:text class="mt-2">Are you sure you want to delete this ICS Record?</flux:text>
    </x-slot>
    <div class="flex">
        <flux:spacer />
        <flux:button type="button" variant="outline" class="me-3" x-on:click="$flux.modal('delete-ics').close()">
            Cancel</flux:button>
        <flux:button type="submit" variant="danger" id="delete-ics-btn">Delete</flux:button>
    </div>
</x-modal>

@if (Session::get('success'))
    <x-success-toast>
        {{ Session::get('success') }}
    </x-success-toast>
@endif

