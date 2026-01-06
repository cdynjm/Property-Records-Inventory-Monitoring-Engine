<x-layouts.app :title="__('Print RPCPPE')">
    <div class="flex min-h-screen flex-col">
        <div class="flex-1">
            <div class="grid grid-cols-1 md:grid-cols-2 mb-4 gap-4">
                <div class="flex flex-col">
                    <label for="" class="text-[12px] mb-1 ms-1">Select Year</label>
                    <flux:select id="office-rpcppe-year" size="sm">
                        <option value="">All</option>
                        @for ($year = now()->year; $year >= 2000; $year--)
                            <option value="{{ $year }}"
                                {{ session('rpcppe-year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </flux:select>
                </div>
                <div class="flex flex-col">
                    <label for="" class="text-[12px] mb-1 ms-1">Accounts Code</label>
                    <div class="flex items-center gap-2">
                        <flux:select id="office-rpcppe-accounts-code" size="sm">
                            <option value="">All</option>
                            @foreach ($accountsCode as $ac)
                                <option value="{{ $ac->encrypted_id }}"
                                    {{ session('rpcppe-accounts-code') == $ac->encrypted_id ? 'selected' : '' }}>
                                    {{ $ac->propertyCode }} - {{ $ac->propertySubCode }}
                                    - {{ $ac->description }}</option>
                            @endforeach
                        </flux:select>

                        <flux:button variant="primary" type="button" size="sm" id="office-search-rpcppe-records">
                            <iconify-icon icon="lets-icons:search-duotone" width="20" height="20"></iconify-icon>
                        </flux:button>
                    </div>
                </div>

            </div>
            <div class="flex flex-col md:flex-row md:items-center gap-3 w-full md:w-auto mb-5">
                <div class="flex-1">
                    <iframe src="{{ route('office.rpcppe-report') }}" width="100%" height="1000"
                        frameborder="0"></iframe>
                </div>
            </div>

            <x-footer class="mt-auto" />
        </div>
</x-layouts.app>
