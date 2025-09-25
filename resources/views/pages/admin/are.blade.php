<x-layouts.app :title="__('ARE')">
    <div class="flex min-h-screen flex-col">
        
        <div class="flex-1">
            <div class="flex items-center justify-center mb-4 gap-2">
                <img src="{{ asset('/img/document.png') }}" alt="" class="w-8 h-auto" draggable="false">
                <flux:heading level="1" class="text-[15px]">Acknowledgement Receipt for Equipment</flux:heading>
            </div>

            <div class="border border-gray-200 rounded-lg p-5 mb-10">
                <form action="" id="create-are-form" class="space-y-4">
                    <p class="font-bold text-[13px] mb-2">ARE CONTROL NUMBER</p>
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
                            <flux:input class="mb-0" name="areYear" />
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700">
                                Code
                            </label>
                            <flux:input class="mb-0" name="areCode" required />
                        </div>
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
                            <flux:input class="mb-0" type="date" name="dateReceivedFrom" max="{{ now()->toDateString() }}" required />
                        </div>
                    </div>

                    <flux:button type="submit" variant="primary" class="save-are-btn">Save changes</flux:button>
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
