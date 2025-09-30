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
            <td class="border-b border-gray-100 px-4 py-2 text-center whitespace-nowrap font-bold">{{ $index + 1 }}
            </td>
            <td class="border-b border-black-100 px-4 py-2">
                <a wire:navigate href="{{ route('admin.edit-ics', ['encrypted_id' => $ic->encrypted_id]) }}"
                    id="edit-ics">
                    <p class="whitespace-nowrap font-bold mb-2 flex items-center gap-2">
                        <iconify-icon icon="fluent-color:document-text-28" width="22" height="22"></iconify-icon>
                        {{ $ic->icsNumber }}
                    </p>

                    <table class="min-w-full border-none border-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left border-b text-gray-500 text-[13px]">Description</th>
                                <th class="px-3 py-2 text-left border-b text-gray-500 text-[13px]">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ic->information as $icsInfo)
                                <tr>
                                    <td class="px-3 py-2 text-[13px]">
                                        <div class="flex items-center gap-2">
                                            <iconify-icon icon="solar:bag-check-line-duotone" class="text-green-500"
                                                width="18" height="18"></iconify-icon>
                                            {!! nl2br(e($icsInfo->description)) !!}
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 text-[13px]">{{ $icsInfo->quantity }}
                                        {{ $icsInfo->unit }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </a>
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
                <p class="text-[13px] {{ $ic->dateReceivedBy == null ? 'invisible' : '' }}">
                    {{ date('M d, Y', strtotime($ic->dateReceivedBy)) }}</p>
            </td>
            <td
                class="border-b border-gray-100 px-4 py-2 whitespace-nowrap uppercase text-[12px]  {{ $ic->remarks == 'active' ? 'text-green-500' : 'text-red-500' }}">
                {{ $ic->remarks }}</td>
            <td class="border-b border-gray-100 px-4 py-2 text-center whitespace-nowrap">
                <a wire:navigate href="{{ route('admin.edit-ics', ['encrypted_id' => $ic->encrypted_id]) }}"
                    id="edit-ics">
                    <iconify-icon icon="lets-icons:edit-duotone" width="24" height="24"></iconify-icon>
                </a>

                <flux:modal.trigger name="delete-ics">
                    <a href="javascript:;" id="delete-ics" data-id="{{ $ic->encrypted_id }}">
                        <iconify-icon icon="lets-icons:trash-duotone" width="24" height="24"></iconify-icon>
                    </a>
                </flux:modal.trigger>

                <a wire:navigate href="{{ route('admin.ics-print', ['encrypted_id' => $ic->encrypted_id]) }}"
                    id="print-ics">
                    <iconify-icon icon="lets-icons:print-duotone" width="24" height="24"></iconify-icon>
                </a>
            </td>
        </x-table-row>
    @endforeach

    @if ($ics->isEmpty())
        <x-table-row>
            <td colspan="10" class="border-b border-gray-100 px-4 py-2 text-center text-gray-500">No ICS
                found.</td>
        </x-table-row>
    @endif
</x-table>

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
