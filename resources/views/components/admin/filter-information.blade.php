<div class="flex flex-row items-center gap-3 w-full md:w-auto">
    {{-- Year Filter --}}
    <div class="flex items-center w-full md:w-80 gap-2">
        @if (session('year') != '')
            <a href="javascript:;" class="me-1 text-red-600 flex items-center gap-1" id="clear-year">
                <iconify-icon icon="mdi:clear" width="18" height="18"></iconify-icon>
                <span class="text-[11px]">Clear</span>
            </a>
        @endif
        <flux:select id="search-year" size="sm">
            <option value="">All</option>
            @for ($year = now()->year; $year >= 2000; $year--)
                <option value="{{ $year }}" {{ session('year') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endfor
        </flux:select>
        <flux:button variant="primary" type="button" size="sm" id="search-year-records">
            <iconify-icon icon="lets-icons:search-duotone" width="20" height="20"></iconify-icon>
        </flux:button>
    </div>

    {{-- Search Bar --}}
    <div class="flex items-center w-full md:w-80 gap-2">
        @if (session('search'))
            <a href="javascript:;" class="me-1 text-red-600 flex items-center gap-1" id="clear-keyword">
                <iconify-icon icon="mdi:clear" width="18" height="18"></iconify-icon>
                <span class="text-[11px]">Clear</span>
            </a>
        @endif

        <flux:input placeholder="Search..." id="search-keyword" size="sm" value="{{ session('search') }}"
            class="flex-1 rounded-r-none" />
        <flux:button variant="primary" type="button" size="sm" id="search-records">
            <iconify-icon icon="lets-icons:search-duotone" width="20" height="20"></iconify-icon>
        </flux:button>
    </div>
</div>
