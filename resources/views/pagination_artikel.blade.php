@if ($paginator->hasPages())
    <div class="flex items-center justify-center md:justify-between border-t border-brand-50 pt-5">
        <div class="hidden md:block">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a href="#" class="flex items-center flex items-center text-sm font-medium text-neutral-400 hover:text-brand-400">
                    <span class="material-icons-outlined text-18 mr-2">
                            arrow_back
                        </span>
                    Sebelumnya
                </a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center flex items-center text-sm font-medium text-neutral-400 hover:text-brand-400">
                    <span class="material-icons-outlined text-18 mr-2">
                            arrow_back
                        </span>
                    Sebelumnya
                </a>
            @endif
        </div>
        <div class="flex">
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a href="{{ $url }}" class="flex justify-center items-center rounded-full md:mx-1 w-10 h-10 text-base font-normal hover:text-brand-500 text-brand-500 bg-brand-50">
                                {{ $page }}
                            </a>
                        @else
                            <a href="{{ $url }}" class="flex justify-center items-center rounded-full md:mx-1 w-10 h-10 text-base font-normal hover:text-brand-500 text-neutral-400 bg-white">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        <div class="hidden md:block">
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="flex items-center flex items-center text-sm font-medium text-neutral-400 hover:text-brand-400">
                    Selanjutnya
                    <span class="material-icons-outlined text-18 ml-2">
                        arrow_forward
                    </span>
                </a>
            @else
                <a href="#" class="flex items-center flex items-center text-sm font-medium text-neutral-400 hover:text-brand-400">
                    Selanjutnya
                    <span class="material-icons-outlined text-18 ml-2">
                        arrow_forward
                    </span>
                </a>
            @endif
        </div>
    </div>
@endif
