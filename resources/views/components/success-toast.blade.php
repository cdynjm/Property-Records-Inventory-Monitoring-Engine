<div x-data="{ show: true }"
     x-show="show"
     x-transition
     id="toast-success"
     class="fixed top-5 right-5 text-gray-500 bg-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 z-100">
    
    <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
        <iconify-icon icon="line-md:folder-check-twotone" width="24" height="24"></iconify-icon>
        <span class="sr-only">Success</span>
    </div>

    <div class="ms-3 text-sm font-normal">{{ $slot }}</div>

    <button type="button"
        x-on:click="show = false"
        class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg
               focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center
               justify-center h-8 w-8"
        aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
    </button>
</div>
