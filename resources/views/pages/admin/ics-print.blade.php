<x-layouts.app :title="__($ics->icsNumber . ' - ICS')">
    <div class="flex min-h-screen flex-col">
        
        <div class="flex-1">
             <iframe src="{{ route('admin.ics-form', ['encrypted_id' => $encrypted_id]) }}" width="100%" height="1000" frameborder="0"></iframe>
        </div>

        <x-footer class="mt-auto" />
    </div>
</x-layouts.app>
