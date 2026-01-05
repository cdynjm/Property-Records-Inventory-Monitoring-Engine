<x-layouts.app :title="__('Print RPCPPE')">
    <div class="flex min-h-screen flex-col">

        <div class="flex-1">
            <div class="flex flex-col md:flex-row md:items-center gap-3 w-full md:w-auto mb-5">
                <div class="flex-1">
             <iframe src="{{ route('admin.rpcppe-report') }}" width="100%" height="1000" frameborder="0"></iframe>
        </div>
            </div>

            <x-footer class="mt-auto" />
        </div>
</x-layouts.app>
