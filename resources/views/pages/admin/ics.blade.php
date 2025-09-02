<x-layouts.app :title="__('ICS')">
    <div class="flex min-h-screen flex-col">

        <div class="flex-1">
            <div class="flex items-center justify-center mb-4">
                <iconify-icon icon="ic:twotone-inventory" class="me-2 text-gray-500" width="25" height="25"></iconify-icon>
                <flux:heading level="1" class="text-[15px]">Inventory Custodian Slip</flux:heading>
            </div>

            <div class="border border-gray-200 rounded-lg p-5">
                <form action="" id="create-ics-form" class="space-y-4">
                    <p class="font-bold text-[13px] mb-2">ICS NUMBER</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Office
                            </label>
                            <flux:select variant="default" name="offices_id" placeholder="Choose Office..." required>
                                @foreach ($offices as $office)
                                    <option value="{{ $office->encrypted_id }}">{{ $office->officeName }}</option>
                                @endforeach
                            </flux:select>
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Year
                            </label>
                            <flux:input class="mb-0" name="icsYear" value="{{ date('y') }}" readonly />
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Code
                            </label>
                            <flux:input class="mb-0" name="icsCode" required />
                        </div>

                    </div>

                    <hr />

                    <p class="font-bold text-[13px] mb-2">TABLE</p>

                    <div x-data="{ rows: [Date.now()] }" class="">
                        <template x-for="(row, index) in rows" :key="row">
                            <div class="rows">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-3">
                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Quantity</label>
                                        <flux:input class="mb-0" type="number" min="0"
                                            x-bind:name="'rows[' + index + '][quantity]'" />
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Unit</label>
                                        <flux:select variant="default" placeholder="Choose Unit..."
                                            x-bind:name="'rows[' + index + '][unit]'">
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->unit }}">{{ $unit->unit }}</option>
                                            @endforeach
                                        </flux:select>
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Office Code</label>
                                        <flux:input class="mb-0" x-bind:name="'rows[' + index + '][officeCode]'" />
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Date Acquired</label>
                                        <flux:input class="mb-0" type="date"
                                            x-bind:name="'rows[' + index + '][dateAcquired]'" />
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Est. Useful Life</label>
                                        <flux:input class="mb-0" x-bind:name="'rows[' + index + '][estUsefulLife]'" />
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Unit Cost</label>
                                        <flux:input class="mb-0" type="number" min="0" step="0.1"
                                            x-bind:name="'rows[' + index + '][unitCost]'" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-4 mb-3">
                                    <div class="flex flex-col">
                                        <label class="mb-1 text-sm font-medium text-gray-700">Description</label>
                                        <flux:textarea class="mb-0"
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
                                        x-on:click="rows.push(Date.now() + index)">
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
                            <flux:select variant="default" name="receivedFrom_id" id="received-from" placeholder="Choose Personnel..." required>
                                @foreach ($receivedFrom as $rf)
                                    <option value="{{ $rf->encrypted_id }}" data-position="{{ $rf->position }}">{{ $rf->name }}</option>
                                @endforeach
                            </flux:select>
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Position/Office
                            </label>
                            <flux:input class="mb-0" name="receivedFromPosition" id="received-from-position" readonly />
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Date
                            </label>
                            <flux:input class="mb-0" type="date" name="dateReceivedFrom" required />
                        </div>
                    </div>

                    <p class="font-bold text-[13px] mb-2">OTHERS</p>

                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-4 mb-6">
                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Furnished By
                            </label>
                            <flux:input class="mb-0" name="furnishedBy" />
                        </div>
                    </div>

                    <flux:button type="submit" variant="primary" class="save-ics-btn">Save changes</flux:button>
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
