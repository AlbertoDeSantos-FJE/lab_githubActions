@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-end">
        <div class="flex bg-white dark:bg-slate-900 p-1.5 rounded-[10px] border border-slate-100 dark:border-slate-800 shadow-sm items-center gap-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="w-10 h-10 flex items-center justify-center rounded-[10px] text-slate-200 dark:text-slate-800 cursor-not-allowed">
                    <span class="material-symbols-outlined text-sm">chevron_left</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center rounded-[10px] text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-sm">chevron_left</span>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="w-10 h-10 flex items-center justify-center text-slate-400 font-bold text-[10px]">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-10 h-10 flex items-center justify-center rounded-[10px] bg-primary text-white font-black text-xs shadow-lg shadow-primary/20">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center rounded-[10px] text-slate-500 dark:text-slate-400 font-bold text-xs hover:bg-primary/10 hover:text-primary transition-all">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center rounded-[10px] text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                </a>
            @else
                <span class="w-10 h-10 flex items-center justify-center rounded-[10px] text-slate-200 dark:text-slate-800 cursor-not-allowed">
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                </span>
            @endif
        </div>
    </nav>
@endif
