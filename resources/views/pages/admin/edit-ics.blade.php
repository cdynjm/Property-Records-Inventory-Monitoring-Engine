<x-layouts.app :title="__('Edit ICS')">
    <div class="flex min-h-screen flex-col">

        <div class="flex-1">
            <div class="flex items-center justify-center mb-4 gap-2">
               <img src="{{ asset('/img/document.png') }}" alt="" class="w-8 h-auto" draggable="false">
                <flux:heading level="1" class="text-[15px]">Inventory Custodian Slip <span class="text-blue-500">(Edit)</span></flux:heading>
            </div>

            <div class="border border-gray-200 rounded-lg p-5 mb-10">
                <div class="w-full p-2 bg-gray-100 mb-4 rounded-md"></div>
                <form action="" id="update-ics-form" class="space-y-4">
                    <flux:input class="mb-0" name="icsID" autocomplete="off" type="hidden"
                        value="{{ $ics->encrypted_id }}" />
                    <p class="font-bold text-[13px] mb-2">ICS NUMBER</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Office
                            </label>
                            <flux:select variant="default" name="offices_id" placeholder="Choose Office..." required>
                                @foreach ($offices as $office)
                                <option value="{{ $office->encrypted_id }}" @selected($ics->encrypted_offices_id ==
                                    $office->encrypted_id)>
                                    {{ $office->officeName }}</option>
                                @endforeach
                            </flux:select>
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Year
                            </label>
                            <flux:input class="mb-0" name="icsYear" value="{{ $ics->icsYear }}" />
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Code
                            </label>
                            <flux:input class="mb-0" name="icsCode" value="{{ $ics->icsCode }}" required />
                        </div>

                    </div>

                    <hr />

                    <p class="font-bold text-[13px] mb-2">TABLE</p>

                    <div x-data="{
                        rows: [
                            @foreach ($ics->information as $icsInfo)
                            {
                                id: '{{ $icsInfo->id }}',
                                quantity: '{{ $icsInfo->quantity }}',
                                unit: '{{ $icsInfo->unit }}',
                                officeCode: '{{ $icsInfo->officeCode }}',
                                dateAcquired: '{{ $icsInfo->dateAcquired }}',
                                estUsefulLife: '{{ $icsInfo->estUsefulLife }}',
                                unitCost: '{{ $icsInfo->unitCost }}',
                                description: `{{ $icsInfo->description }}`
                            }@if (!$loop->last),@endif @endforeach
                        ]
                    }" class="">

                        <template x-for="(row, index) in rows" :key="index">
                            <div class="rows">
                                <flux:input type="hidden" x-model="row.id" x-bind:name="'rows[' + index + '][id]'" />
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-3">

                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Quantity</label>
                                        <flux:input class="mb-0" type="number" min="0" x-model="row.quantity"
                                            x-bind:name="'rows[' + index + '][quantity]'" />


                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Unit</label>
                                        <flux:select variant="default" placeholder="Choose Unit..." x-model="row.unit"
                                            x-bind:name="'rows[' + index + '][unit]'">
                                            @foreach ($units as $unit)
                                            <option value="{{ $unit->unit }}">{{ $unit->unit }}</option>
                                            @endforeach
                                        </flux:select>
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Office Code</label>
                                        <flux:input class="mb-0" x-model="row.officeCode"
                                            x-bind:name="'rows[' + index + '][officeCode]'" />
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Date Acquired</label>
                                        <flux:input class="mb-0" type="date" x-model="row.dateAcquired" max="{{ now()->toDateString() }}"
                                            x-bind:name="'rows[' + index + '][dateAcquired]'" />
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Est. Useful Life</label>
                                        <flux:input class="mb-0" x-model="row.estUsefulLife"
                                            x-bind:name="'rows[' + index + '][estUsefulLife]'" />
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Unit Cost</label>
                                        <flux:input class="mb-0" type="number" min="0" step="0.1" x-model="row.unitCost"
                                            x-bind:name="'rows[' + index + '][unitCost]'" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-4 mb-3">
                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Description</label>
                                        <flux:textarea class="mb-0" x-text="row.description"
                                            x-bind:name="'rows[' + index + '][description]'" />
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-2 mb-4">
                                    <button type="button"
                                        class="p-1 pb-0 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600"
                                        x-show="rows.length > 1" x-on:click="rows.splice(index, 1)">
                                        <iconify-icon icon="pajamas:remove" width="16" height="16"></iconify-icon>
                                    </button>
                                    <button type="button"
                                        class="p-1 pb-0 text-sm bg-green-500 text-white rounded-lg hover:bg-green-600"
                                        x-on:click="rows.push({
                        quantity: '',
                        unit: '',
                        officeCode: '',
                        dateAcquired: '',
                        estUsefulLife: '',
                        unitCost: '',
                        description: ''
                    })">
                                        <iconify-icon icon="basil:add-outline" width="24" height="24"></iconify-icon>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <hr />

                    <p class="font-bold text-[13px] mb-2">PERSONNEL</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Received From
                            </label>
                            <flux:select variant="default" name="receivedFrom_id" id="received-from"
                                placeholder="Choose Personnel..." required>
                                @foreach ($receivedFrom as $rf)
                                <option value="{{ $rf->encrypted_id }}" data-position="{{ $rf->position }}"
                                    @selected($ics->encrypted_receivedFrom_id == $rf->encrypted_id)>
                                    {{ $rf->name }}</option>
                                @endforeach
                            </flux:select>
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Position/Office
                            </label>
                            <flux:input class="mb-0" name="receivedFromPosition" id="received-from-position"
                                value="{{ $ics->receivedFromPosition }}" readonly />
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Date
                            </label>
                            <flux:input class="mb-0" type="date" name="dateReceivedFrom" max="{{ now()->toDateString() }}"
                                value="{{ $ics->dateReceivedFrom }}" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">

                        <div class="flex flex-col relative">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Received By
                            </label>

                            <flux:input class="mb-0" id="received-by" name="receivedBy" autocomplete="off"
                                value="{{ $ics->receivedBy }}" />
                            <flux:input class="mb-0" id="received-by-id" name="receivedBy_id" autocomplete="off"
                                type="hidden" value="{{ $ics->encrypted_receivedBy_id }}" />
                            <div id="receivedByResults"
                                class="absolute top-full mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden">
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Position/Office
                            </label>
                            <flux:input class="mb-0" name="receivedByPosition" id="received-by-position"
                                value="{{ $ics->receivedByPosition }}" />
                        </div>


                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Date
                            </label>
                            <flux:input class="mb-0" type="date" name="dateReceivedBy" max="{{ now()->toDateString() }}"
                                value="{{ $ics->dateReceivedBy }}" />
                        </div>
                    </div>



                    <p class="font-bold text-[13px] mb-2">OTHERS</p>

                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-4 mb-6">
                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Furnished By
                            </label>
                            <flux:input class="mb-0" name="furnishedBy" value="{{ $ics->furnishedBy }}" />
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <flux:button type="submit" variant="primary" class="save-ics-btn">Save changes</flux:button>
                        <a wire:navigate href="{{ route('admin.ics-print', ['encrypted_id' => $ics->encrypted_id]) }}" id="print-ics">
                            <flux:button type="button" variant="ghost">
                                <iconify-icon icon="lets-icons:print-duotone" width="24" height="24"></iconify-icon>
                                Print
                            </flux:button>
                        </a>
                    </div>
                </form>
                <div class="w-full p-2 bg-gray-100 mt-4 rounded-md"></div>
            </div>

        </div>

        <x-footer class="mt-auto" />
    </div>

    @if (Session::get('success'))
    <x-success-toast>
        {{ Session::get('success') }}
    </x-success-toast>
    @endif
</x-layouts.app>