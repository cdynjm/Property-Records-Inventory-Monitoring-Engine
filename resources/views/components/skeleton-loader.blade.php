<div id="skeleton-loader" class="fixed inset-0 bg-white z-[9999]">
    <div class="flex h-full">
        <!-- Sidebar skeleton (hidden on lg and below) -->
        <div class="hidden xl:flex flex-col gap-3 w-1/7 bg-gray-100 p-5">
            <div class="animate-pulse bg-gray-200 rounded-lg w-full h-8"></div>
            <div class="animate-pulse bg-gray-200 rounded-lg w-3/4 h-8"></div>
            <div class="animate-pulse bg-gray-200 rounded-lg w-1/2 h-8"></div>
            <div class="mt-auto animate-pulse bg-gray-200 rounded-lg w-full h-8"></div>
        </div>

        <!-- Main content skeleton -->
        <div class="flex-1 p-10">
            <!-- Header -->
            <div class="flex items-center gap-3 mb-6">
                <div class="animate-pulse bg-gray-200 rounded-full w-12 h-12"></div>
                <div class="flex-1">
                    <div class="animate-pulse bg-gray-200 rounded-lg h-8 w-1/2 mb-2"></div>
                    <div class="animate-pulse bg-gray-200 rounded-lg h-8 w-2/5"></div>
                </div>
            </div>

            <!-- Content blocks -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <div class="animate-pulse bg-gray-200 rounded-lg h-48 mb-3"></div>
                </div>
                <div>
                    <div class="animate-pulse bg-gray-200 rounded-lg h-[500px] mb-3"></div>
                </div>
                <div>
                    <div class="animate-pulse bg-gray-200 rounded-lg h-48 mb-4"></div>
                    <div class="animate-pulse bg-gray-200 rounded-lg h-48"></div>
                </div>
            </div>
        </div>
    </div>
</div>
