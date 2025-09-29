<x-layouts.app :title="__('Office Records')">
    <div class="flex min-h-screen flex-col">

        <div class="flex-1">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('/img/office-chair.png') }}" alt="" class="w-8 h-auto" draggable="false">
                   <div>
                     <h6 class="font-bold">{{ $office->officeName }}</h6>
                     
                   </div>
                </div>
                <x-filter-information />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full mx-auto">

                <!-- Stat Card -->
                <div class="bg-white shadow-sm rounded-xl p-4 sm:p-6 border border-gray-100">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <!-- icon -->
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center">
                                <!-- replace with your icon -->
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 17a4 4 0 100-8 4 4 0 000 8zM21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7">
                                    </path>
                                </svg>
                            </div>

                            <!-- stat text -->
                            <div>
                                <p class="text-xs font-semibold text-gray-500">Total ARE</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $are->count() }}</p>
                            </div>
                        </div>

                        <!-- delta -->
                        <div class="flex flex-col items-end">
                            <span
                                class="mb-2 inline-flex items-center text-sm font-medium text-green-600 bg-green-50 px-2 py-1 rounded">
                                <a wire:navigate href="{{ route('admin.are') }}" class="flex items-center gap-2">
                                    <iconify-icon icon="solar:document-bold-duotone" width="24"
                                        height="24"></iconify-icon>
                                    Generate ARE
                                </a>
                            </span>
                            <span class="text-xs text-gray-400 mt-1">Year {{ session('year') }}</span>
                        </div>
                    </div>

                    <!-- optional sparkline (SVG) -->
                    <div class="mt-4">
                        <svg class="w-full h-8" viewBox="0 0 100 20" preserveAspectRatio="none" aria-hidden="true">
                            <polyline fill="none" stroke="#3b82f6" stroke-width="2"
                                points="0,16 20,12 40,8 60,10 80,6 100,4"></polyline>
                        </svg>
                    </div>
                    <small class="text-sm mb-0 text-gray-600 text-start">Acknowledgement Receipt for Equipment</small>
                </div>

                <!-- Stat Card -->
                <div class="bg-white shadow-sm rounded-xl p-4 sm:p-6 border border-gray-100">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <!-- icon -->
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center">
                                <!-- replace with your icon -->
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 17a4 4 0 100-8 4 4 0 000 8zM21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7">
                                    </path>
                                </svg>
                            </div>

                            <!-- stat text -->
                            <div>
                                <p class="text-xs font-semibold text-gray-500">Total ICS</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $ics->count() }}</p>
                            </div>
                        </div>

                        <!-- delta -->
                        <div class="flex flex-col items-end">
                            <span
                                class="mb-2 inline-flex items-center text-sm font-medium text-green-600 bg-green-50 px-2 py-1 rounded">
                                <a wire:navigate href="{{ route('admin.ics') }}" class="flex items-center gap-2">
                                    <iconify-icon icon="solar:document-bold-duotone" width="24"
                                        height="24"></iconify-icon>
                                    Generate ICS
                                </a>
                            </span>
                            <span class="text-xs text-gray-400 mt-1">Year {{ session('year') }}</span>
                        </div>
                    </div>

                    <!-- optional sparkline (SVG) -->
                    <div class="mt-4">
                        <svg class="w-full h-8" viewBox="0 0 100 20" preserveAspectRatio="none" aria-hidden="true">
                            <polyline fill="none" stroke="#3b82f6" stroke-width="2"
                                points="0,16 20,12 40,8 60,10 80,6 100,4"></polyline>
                        </svg>
                    </div>
                    <small class="text-sm mb-0 text-gray-600 text-start">Inventory Custodian Slip</small>
                </div>
            </div>

            <div class="mb-4">
                <flux:heading class="my-4">ICS Records</flux:heading>

                <x-ics-records :ics="$ics" />

                <div class="mt-8">
                    {{ $ics->links('vendor.pagination.custom-pagination') }}
                </div>
            </div>

            <div class="mb-4">
                <flux:heading class="my-4">ARE Records</flux:heading>

                <x-are-records :are="$are" />

                <div class="mt-8">
                    {{ $are->links('vendor.pagination.custom-pagination') }}
                </div>
            </div>
        </div>

        <x-footer class="mt-auto" />
    </div>
</x-layouts.app>
