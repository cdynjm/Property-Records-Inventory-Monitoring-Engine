<x-layouts.app :title="__('ICS Print')">
    <div class="flex min-h-screen flex-col">
        
        <div class="flex-1">
             <iframe src="/admin/ics-form/{{ $encrypted_id }}" width="100%" height="1000" frameborder="0"></iframe>
        </div>

        <x-footer class="mt-auto" />
    </div>
</x-layouts.app>
