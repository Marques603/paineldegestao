@if ($paginator->hasPages())
    <nav class="pagination">
        <ul class="pagination-list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="pagination-item disabled">
                    <span class="pagination-link pagination-link-prev-icon">
                        <i data-feather="chevron-left" width="1em" height="1em"></i>
                    </span>
                </li>
            @else
                <li class="pagination-item">
                    <a class="pagination-link pagination-link-prev-icon" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i data-feather="chevron-left" width="1em" height="1em"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="pagination-item disabled"><span class="pagination-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination-item active"><span class="pagination-link">{{ $page }}</span></li>
                        @else
                            <li class="pagination-item">
                                <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="pagination-item">
                    <a class="pagination-link pagination-link-next-icon" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <i data-feather="chevron-right" width="1em" height="1em"></i>
                    </a>
                </li>
            @else
                <li class="pagination-item disabled">
                    <span class="pagination-link pagination-link-next-icon">
                        <i data-feather="chevron-right" width="1em" height="1em"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
