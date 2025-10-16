<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main class="pb-20 md:pb-0 mt-10">
        <x-skeleton-loader />
        {{ $slot }}
    </flux:main>
    <x-navbar />
</x-layouts.app.sidebar>
