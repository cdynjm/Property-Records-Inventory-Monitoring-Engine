<x-layouts.app :title="__($ics->icsNumber . ' - ICS')">
    <div class="flex min-h-screen flex-col">

        <div class="flex-1">

            <div class="flex flex-col items-center text-center">
                <label class="mb-1 text-sm font-medium text-gray-700">
                    Uploaded Scanned Document
                </label>

                @if ($ics->scannedDocument)
                    <a href="{{ route('admin.view-ics-file', ['filename' => $ics->scannedDocument]) }}" target="_blank"
                        class="flex items-center justify-center gap-2">
                        <iconify-icon icon="material-icon-theme:folder-pdf-open" width="22"
                            height="22"></iconify-icon>
                        <span class="text-green-600 text-sm truncate max-w-xs">
                            {{ $ics->scannedDocument }}
                        </span>
                    </a>
                @else
                    <div class="flex items-center justify-center gap-2">
                        <iconify-icon icon="material-icon-theme:folder-pdf-open" width="22"
                            height="22"></iconify-icon>
                        <span class="text-red-600 text-sm">No file uploaded yet.</span>
                    </div>
                @endif
            </div>

            <hr class="my-4" />

            <iframe src="{{ route('admin.ics-form', ['encrypted_id' => $encrypted_id]) }}" width="100%" height="1000"
                frameborder="0"></iframe>
        </div>

        <x-footer class="mt-auto" />
    </div>
</x-layouts.app>
