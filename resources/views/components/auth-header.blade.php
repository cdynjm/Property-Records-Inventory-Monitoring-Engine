@props([
    'title',
    'description',
])

<div class="flex w-full items-center gap-4">
    <!-- Logo -->
    <img src="{{ asset('/img/province-logo-official.png') }}" class="h-auto w-13" alt="" draggable="false">

    <!-- Text -->
    <div class="flex flex-col text-left">
        <h5 class="font-bold text-[15px]">{{ $title }}</h5>
        <small class="text-gray-500">{{ $description }}</small>
    </div>
    
</div>
