@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-2 mt-4">
        {{-- Link para a página anterior --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 border rounded-md text-gray-400 cursor-not-allowed">
                &laquo;
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 border rounded-md text-blue-600 hover:bg-blue-100">
                &laquo;
            </a>
        @endif

        {{-- Links para as páginas --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-1 text-gray-400">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 border rounded-md bg-blue-600 text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 border rounded-md text-blue-600 hover:bg-blue-100">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Link para a próxima página --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 border rounded-md text-blue-600 hover:bg-blue-100">
                &raquo;
            </a>
        @else
            <span class="px-3 py-1 border rounded-md text-gray-400 cursor-not-allowed">
                &raquo;
            </span>
        @endif
    </nav>
@endif
