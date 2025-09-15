<x-layouts.app :title="__('ARE')">
    <div class="flex min-h-screen flex-col">
        
        <div class="flex-1">
            <div class="flex items-center justify-center mb-4 gap-2">
                <img src="{{ asset('/img/document.png') }}" alt="" class="w-8 h-auto" draggable="false">
                <flux:heading level="1" class="text-[15px]">Acknowledgement Receipt for Equipment</flux:heading>
            </div>
        </div>

        <x-footer class="mt-auto" />
    </div>
</x-layouts.app>
