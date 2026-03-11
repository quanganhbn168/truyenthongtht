@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between mt-12 mb-8">
        
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 bg-gray-50 border border-gray-200 cursor-not-allowed leading-5 rounded-full select-none">
                <i class="fa-solid fa-arrow-left mr-2 text-xs"></i> Trước
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-red-700 bg-white border border-red-200 hover:bg-red-50 hover:border-red-300 active:bg-red-100 focus:outline-none focus:ring focus:ring-red-300 focus:border-red-400 transition-all duration-200 ease-in-out leading-5 rounded-full shadow-sm group">
                <i class="fa-solid fa-arrow-left mr-2 text-xs group-hover:-translate-x-1 transition-transform"></i> Trước
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div class="hidden sm:flex items-center justify-center space-x-2">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span aria-disabled="true">
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-transparent select-none">
                            {{ $element }}
                        </span>
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page">
                                <span class="relative inline-flex items-center justify-center w-10 h-10 text-sm font-bold text-white bg-red-700 border border-red-700 shadow-md cursor-default rounded-full select-none transform scale-110">
                                    {{ $page }}
                                </span>
                            </span>
                        @else
                            <a href="{{ $url }}" class="relative inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white border border-gray-200 hover:text-red-700 hover:bg-red-50 hover:border-red-300 focus:outline-none focus:ring focus:ring-red-300 focus:border-red-400 transition-all duration-200 ease-in-out rounded-full shadow-sm hover:shadow-md hover:-translate-y-0.5">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-red-700 bg-white border border-red-200 hover:bg-red-50 hover:border-red-300 active:bg-red-100 focus:outline-none focus:ring focus:ring-red-300 focus:border-red-400 transition-all duration-200 ease-in-out leading-5 rounded-full shadow-sm group">
                Sau <i class="fa-solid fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        @else
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 bg-gray-50 border border-gray-200 cursor-not-allowed leading-5 rounded-full select-none">
                 Sau <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </span>
        @endif
        
    </nav>
    
    {{-- Pagination Mobile Text --}}
    <div class="sm:hidden flex items-center justify-center mt-3 text-sm text-gray-500 font-medium">
        Đang xem trang {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
    </div>
@endif
