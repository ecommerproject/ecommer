@if ($paginator->hasPages())
    <nav class="custom-admin-pagination" role="navigation" aria-label="Pagination Navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="page-step is-disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                <span>Prev</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-step" rel="prev" aria-label="@lang('pagination.previous')">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                <span>Prev</span>
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div class="page-numbers-list">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="page-number is-dots">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-number is-active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-number">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-step" rel="next" aria-label="@lang('pagination.next')">
                <span>Next</span>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
        @else
            <span class="page-step is-disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span>Next</span>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </span>
        @endif
    </nav>
@endif
