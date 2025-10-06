<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($are as $index => $ar)
        <div class="bg-white border rounded-lg shadow-sm hover:shadow-md transition p-4 flex flex-col">
            <a wire:navigate href="{{ route('office.are-print', ['encrypted_id' => $ar->encrypted_id]) }}">
                {{-- Header / ARE Control Number --}}
                <div class="flex items-center justify-between mb-4">
                    <p class="font-bold flex items-center gap-2 text-[15px]">
                        <iconify-icon icon="fluent-color:document-text-28" width="22" height="22"></iconify-icon>
                        {{ $ar->areControlNumber }}
                    </p>
                    <span class="text-gray-400 text-sm">#{{ $index + 1 }}</span>
                </div>

                {{-- ARE Information --}}
                <div class="grid grid-cols-1 gap-3 mb-4">
                    @foreach ($ar->information as $areInfo)
                        <div class="p-2 border rounded-md bg-gray-50">
                            <div class="flex items-center gap-2 mb-2">
                                <iconify-icon icon="solar:bag-check-line-duotone" class="text-green-500" width="18"
                                    height="18"></iconify-icon>
                                <p class="text-[13px] leading-snug">
                                    {!! nl2br(e($areInfo->description)) !!}
                                </p>
                            </div>
                            <p class="text-[12px] mt-1"><span class="font-semibold">PPE:</span>
                                {{ $areInfo->accountsCode->description }}</p>
                            <p class="text-[12px]"><span class="font-semibold">Quantity:</span>
                                {{ $areInfo->quantity }} {{ $areInfo->unit }}</p>
                        </div>
                    @endforeach
                </div>
            </a>

            {{-- Received From / By --}}
            <div class="text-[13px] mb-4">
                <div>
                    <p class="font-semibold text-gray-500">Received From:</p>
                    <p>{{ $ar->receivedFrom->name }}</p>
                    <p class="text-gray-500">{{ date('M d, Y', strtotime($ar->dateReceivedFrom)) }}</p>
                </div>
                <hr class="my-3">
                <div>
                    <p class="font-semibold text-gray-500">Received By:</p>
                    <p>{{ $ar->receivedBy ?? '-' }}</p>
                    @if ($ar->dateReceivedBy)
                        <p class="text-gray-500">{{ date('M d, Y', strtotime($ar->dateReceivedBy)) }}</p>
                    @endif
                </div>
            </div>

            {{-- Remarks --}}
            <div class="mb-4">
                <span
                    class="uppercase text-[12px] font-bold
                    {{ $ar->remarks === 'active' ? 'text-green-500' : 'text-red-500' }}">
                    {{ $ar->remarks }}
                </span>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 mt-auto">
                <a wire:navigate href="{{ route('office.are-print', ['encrypted_id' => $ar->encrypted_id]) }}">
                    <flux:button type="button" variant="filled" size="sm" class="me-3">
                        <iconify-icon icon="lets-icons:print-duotone" width="22" height="22"></iconify-icon>
                        <span class="text-[13px]">Print</span>
                    </flux:button>
                </a>
            </div>
        </div>
    @endforeach
</div>

@if ($are->isEmpty())
    <div class="grid grid-cols-1 gap-6">
        <div class="bg-white border rounded-lg transition p-4 flex flex-col">
            <iconify-icon icon="solar:sad-square-line-duotone" width="24" height="24"
                class="mb-3"></iconify-icon>
            <small class="text-center text-gray-500">Sorry, no ARE records found.</small>
        </div>
    </div>
@endif

@if (Session::get('success'))
    <x-success-toast>
        {{ Session::get('success') }}
    </x-success-toast>
@endif
