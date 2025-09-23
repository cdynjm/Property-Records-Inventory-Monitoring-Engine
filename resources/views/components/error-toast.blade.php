<div class="fixed top-5 right-5 toast-error text-gray-500 bg-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 z-100" 
     style="display: none">
    
    <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
        <iconify-icon icon="si:error-duotone" width="24" height="24"></iconify-icon>
        <span class="sr-only">Error</span>
    </div>

    <div class="toast-error-message ms-0 text-sm font-normal">{{ $slot }}</div>
</div>


