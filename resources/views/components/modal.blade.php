<flux:modal name="{{ $name ?? 'default-modal' }}" class="{{ $class ?? 'md:w-96 w-full' }}">
    <div class="space-y-6">
        @isset($header)
            <div class="flex items-center justify-between">
                <div>{{ $header }}</div>
            </div>
        @endisset

        {{ $slot }}
    </div>
</flux:modal>
