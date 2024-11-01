
@if ($paginator->hasPages())
    <div class="pagi-wrp mt-65">
        {{-- Nút "Trước" --}}
        @if ($paginator->onFirstPage())
            <span class="pagi-btn disabled">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="pagi-btn fa-regular ms-2 primary-hover fa-angle-left">&laquo;</a>
        @endif

        {{-- Số trang --}}
        @foreach ($elements as $element)
            {{-- Dấu chấm --}}
            @if (is_string($element))
                <span class="pagi-btn disabled">{{ $element }}</span>
            @endif

            {{-- Dãy số trang --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="pagi-btn active">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}" class="pagi-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Nút "Sau" --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="fa-regular ms-2 primary-hover fa-angle-right">&raquo;</a>
        @else
            <span class="pagi-btn disabled">&raquo;</span>
        @endif
    </div>
@endif
