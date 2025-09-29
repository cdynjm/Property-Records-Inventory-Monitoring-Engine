<x-layouts.app :title="__('Edit ICS')">
    <div class="flex min-h-screen flex-col">

        <div class="flex-1">
            <div class="flex items-center justify-center mb-4 gap-2">
               <img src="{{ asset('/img/document.png') }}" alt="" class="w-8 h-auto" draggable="false">
                <flux:heading level="1" class="text-[15px]">Acknowledgement Receipt for Equipment <span class="text-blue-500">(Edit)</span></flux:heading>
            </div>

            <div class="border border-gray-200 rounded-lg p-5 mb-10">
                <form action="" id="update-are-form" class="space-y-4">
                    <flux:input class="mb-0" name="areID" autocomplete="off" type="hidden"
                        value="{{ $are->encrypted_id }}" />
                    <p class="font-bold text-[13px] mb-2">ARE CONTROL NUMBER</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Office
                            </label>
                            <flux:select variant="default" name="offices_id" placeholder="Choose Office..." required>
                                @foreach ($offices as $office)
                                <option value="{{ $office->encrypted_id }}" @selected($are->encrypted_offices_id ==
                                    $office->encrypted_id)>
                                    {{ $office->officeName }}</option>
                                @endforeach
                            </flux:select>
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Year
                            </label>
                            <flux:select name="areYear" required class="mb-0" placeholder="Select Year...">
                                @php
                                    $currentYear = date('y');
                                    $years = [];
                                    for ($year = $currentYear; $year >= 0; $year--) {
                                        $years[] = str_pad($year, 2, '0', STR_PAD_LEFT);
                                    }
                                    for ($year = 99; $year >= 90; $year--) {
                                        $years[] = (string) $year;
                                    }
                                @endphp

                                @foreach ($years as $year)
                                    <option value="{{ $year }}" @selected($are->areYear == $year)>{{ $year }}</option>
                                @endforeach
                            </flux:select>
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Code
                            </label>
                            <flux:input class="mb-0" name="areCode" value="{{ $are->areCode }}" required />
                        </div>

                    </div>

                    <hr />

                    <p class="font-bold text-[13px] mb-2">TABLE</p>

                    <!-- no-minify:start -->
                        <div x-data="{
                            rows: [
                                @foreach ($are->information as $areInfo)
                                {
                                    id: '{{ $aes->encrypt($areInfo->id) }}',
                                    quantity: '{{ $areInfo->quantity }}',
                                    unit: '{{ $areInfo->unit }}',
                                    account_codes_id: '{{ $aes->encrypt($areInfo->account_codes_id) }}',
                                    propertyCount: '{{ $areInfo->propertyCount }}',
                                    unitCost: '{{ $areInfo->unitCost }}',
                                    totalValue: '{{ $areInfo->totalValue }}',
                                    dateAcquired: '{{ $areInfo->dateAcquired }}',
                                    description: `{{ $areInfo->description }}`
                                }@if (!$loop->last),@endif
                                @endforeach
                            ]
                        }" class="">
                    <!-- no-minify:end -->

                        <template x-for="(row, index) in rows" :key="index">
                            <div class="rows">
                                <flux:input type="hidden" x-model="row.id" x-bind:name="'rows[' + index + '][id]'" />
                                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-7 gap-4 mb-3">

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
                                        <label class="mb-1 text-sm font-medium text-gray-700">Account Code</label>
                                        <flux:select variant="default" placeholder="Choose Unit..." x-model="row.account_codes_id"
                                            x-bind:name="'rows[' + index + '][account_codes_id]'">
                                            @foreach ($accountsCode as $ac)
                                                <option value="{{ $ac->encrypted_id }}">{{ $ac->propertyCode }} - {{ $ac->propertySubCode }} - {{ $ac->description }}</option>
                                            @endforeach
                                        </flux:select>
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Series Number</label>
                                        <flux:input class="mb-0" x-model="row.propertyCount" x-bind:name="'rows[' + index + '][propertyCount]'" />
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Unit Cost</label>
                                        <flux:input class="mb-0" type="number" x-model="row.unitCost" min="0" step="0.1"
                                            x-bind:name="'rows[' + index + '][unitCost]'" />
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Total Value</label>
                                        <flux:input class="mb-0" type="number" x-model="row.totalValue" min="0" step="0.1" 
                                            x-bind:name="'rows[' + index + '][totalValue]'" />
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Date Acquired</label>
                                        <flux:input class="mb-0" type="date" x-model="row.dateAcquired" max="{{ now()->toDateString() }}"
                                            x-bind:name="'rows[' + index + '][dateAcquired]'" />
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
                        account_codes_id: '',
                        propertyCount: '',
                        unitCost: '',
                        totalValue: '',
                        dateAcquired: '',
                        description: ``
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
                                    @selected($are->encrypted_receivedFrom_id == $rf->encrypted_id)>
                                    {{ $rf->name }}</option>
                                @endforeach
                            </flux:select>
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Position/Office
                            </label>
                            <flux:input class="mb-0" name="receivedFromPosition" id="received-from-position"
                                value="{{ $are->receivedFromPosition }}" readonly />
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Date
                            </label>
                            <flux:input class="mb-0" type="date" name="dateReceivedFrom" max="{{ now()->toDateString() }}"
                                value="{{ $are->dateReceivedFrom }}" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">

                        <div class="flex flex-col relative">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Received By
                            </label>

                            <flux:input class="mb-0" id="received-by" name="receivedBy" autocomplete="off"
                                value="{{ $are->receivedBy }}" />
                            <flux:input class="mb-0" id="received-by-id" name="receivedBy_id" autocomplete="off"
                                type="hidden" value="{{ $are->encrypted_receivedBy_id }}" />
                            <div id="receivedByResults"
                                class="absolute top-full mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden">
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Position/Office
                            </label>
                            <flux:input class="mb-0" name="receivedByPosition" id="received-by-position"
                                value="{{ $are->receivedByPosition }}" />
                        </div>


                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Date
                            </label>
                            <flux:input class="mb-0" type="date" name="dateReceivedBy" max="{{ now()->toDateString() }}"
                                value="{{ $are->dateReceivedBy }}" />
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <flux:button type="submit" variant="primary" class="save-are-btn">Save changes</flux:button>
                        <a wire:navigate href="{{ route('admin.are-print', ['encrypted_id' => $are->encrypted_id]) }}"  id="print-are">
                            <flux:button type="button" variant="ghost">
                                <iconify-icon icon="lets-icons:print-duotone" width="24" height="24"></iconify-icon>
                                Print
                            </flux:button>
                        </a>
                    </div>
                </form>
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