@if ($paginator->hasPages())
    <nav class="flex items-center justify-between px-4 py-3">
        {{-- Mobile View --}}
        <div class="flex flex-1 justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="relative inline-flex items-center px-4 py-2 cursor-not-allowed text-sm font-medium text-[var(--secondary-text-clr)] bg-[var(--secondary-base-clr)] rounded-md">
                    <span class="material-symbols-outlined text-lg">chevron_left</span>
                </span>
            @else
                <button wire:click="previousPage"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-[var(--text-clr)] bg-[var(--secondary-base-clr)] rounded-md hover:bg-[var(--hover-clr)] transition-colors">
                    <span class="material-symbols-outlined text-lg">chevron_left</span>
                </button>
            @endif

            @if ($paginator->hasMorePages())
                <button wire:click="nextPage"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-[var(--text-clr)] bg-[var(--secondary-base-clr)] rounded-md hover:bg-[var(--hover-clr)] transition-colors">
                    <span class="material-symbols-outlined text-lg">chevron_right</span>
                </button>
            @else
                <span
                    class="relative inline-flex items-center px-4 py-2 cursor-not-allowed text-sm font-medium text-[var(--secondary-text-clr)] bg-[var(--secondary-base-clr)] rounded-md">
                    <span class="material-symbols-outlined text-lg">chevron_right</span>
                </span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-[var(--secondary-text-clr)]">
                    Showing
                    <span class="font-medium text-[var(--text-clr)]">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="font-medium text-[var(--text-clr)]">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="font-medium text-[var(--text-clr)]">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>

            <div>
                <nav class="isolate inline-flex gap-1 rounded-md" aria-label="Pagination">
                    {{-- Previous Page --}}
                    @if ($paginator->onFirstPage())
                        <span
                            class="relative inline-flex items-center px-2 py-2 cursor-not-allowed text-[var(--secondary-text-clr)] bg-[var(--secondary-base-clr)] rounded-md">
                            <span class="material-symbols-outlined text-lg">chevron_left</span>
                        </span>
                    @else
                        <button wire:click="previousPage"
                            class="relative inline-flex items-center px-2 py-2 cursor-pointer text-[var(--text-clr)] bg-[var(--secondary-base-clr)] rounded-md hover:bg-[var(--hover-clr)] transition-colors">
                            <span class="material-symbols-outlined text-lg">chevron_left</span>
                        </button>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span
                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-[var(--secondary-text-clr)]">
                                ...
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium bg-[var(--accent-clr)] text-white rounded-md">
                                        {{ $page }}
                                    </span>
                                @else
                                    <button wire:click="gotoPage({{ $page }})"
                                        class="relative inline-flex items-center px-4 py-2 cursor-pointer text-sm font-medium text-[var(--text-clr)] bg-[var(--secondary-base-clr)] rounded-md hover:bg-[var(--hover-clr)] transition-colors">
                                        {{ $page }}
                                    </button>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page --}}
                    @if ($paginator->hasMorePages())
                        <button wire:click="nextPage"
                            class="relative inline-flex items-center px-2 py-2 cursor-pointer text-[var(--text-clr)] bg-[var(--secondary-base-clr)] rounded-md hover:bg-[var(--hover-clr)] transition-colors">
                            <span class="material-symbols-outlined text-lg">chevron_right</span>
                        </button>
                    @else
                        <span
                            class="relative inline-flex items-center px-2 py-2 cursor-not-allowed text-[var(--secondary-text-clr)] bg-[var(--secondary-base-clr)] rounded-md">
                            <span class="material-symbols-outlined text-lg">chevron_right</span>
                        </span>
                    @endif
                </nav>
            </div>
        </div>
    </nav>
@endif
