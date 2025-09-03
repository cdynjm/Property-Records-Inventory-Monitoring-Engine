@if ($paginator->hasPages())
    <nav class="flex justify-center items-center mb-4">
        <ul class="flex space-x-1 text-sm">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-1 border rounded text-gray-400 cursor-not-allowed">&lsaquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="px-3 py-1 border rounded hover:bg-gray-100 livewire-nav-link"
                       data-url="{{ $paginator->previousPageUrl() }}">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span class="px-3 py-1 border rounded text-gray-400">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == 1 || $page == $paginator->lastPage() || 
                            ($page >= $paginator->currentPage() - 1 && $page <= $paginator->currentPage() + 1))
                            @if ($page == $paginator->currentPage())
                                <li>
                                    <span class="px-3 py-1 border rounded bg-blue-500 text-white">{{ $page }}</span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $url }}"
                                       class="px-3 py-1 border rounded hover:bg-gray-100 livewire-nav-link"
                                       data-url="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @elseif ($page == 2 || $page == $paginator->lastPage() - 1)
                            <li>
                                <span class="px-3 py-1 border rounded text-gray-400">...</span>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="px-3 py-1 border rounded hover:bg-gray-100 livewire-nav-link"
                       data-url="{{ $paginator->nextPageUrl() }}">&rsaquo;</a>
                </li>
            @else
                <li>
                    <span class="px-3 py-1 border rounded text-gray-400 cursor-not-allowed">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
