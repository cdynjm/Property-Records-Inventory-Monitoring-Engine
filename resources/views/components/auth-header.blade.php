@props([
    'title',
    'description',
])

<div class="flex w-full items-center gap-4">
    <!-- Logo -->
    <img src="{{ asset('/img/province-logo-official.png') }}" class="h-auto w-13" alt="" draggable="false">

    <!-- Text -->
    <div class="flex flex-col text-left">
        <flux:heading size="sm">{{ $title }}</flux:heading>
        <flux:subheading>{{ $description }}</flux:subheading>
    </div>
    
</div>
