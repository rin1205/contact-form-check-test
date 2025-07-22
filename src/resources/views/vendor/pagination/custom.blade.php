@if ($paginator->hasPages())
<div class="custom-pagination">
    {{-- 前へ --}}
    @if ($paginator->onFirstPage())
    <span class="custom-page-link disabled">&lt;</span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" class="custom-page-link">&lt;</a>
    @endif

    {{-- ページ番号 --}}
    @foreach ($elements as $element)
    @if (is_string($element))
    <span class="custom-page-link disabled">{{ $element }}</span>
    @endif

    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <span class="custom-page-link active">{{ $page }}</span>
    @else
    <a href="{{ $url }}" class="custom-page-link">{{ $page }}</a>
    @endif
    @endforeach
    @endif
    @endforeach

    {{-- 次へ --}}
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="custom-page-link">&gt;</a>
    @else
    <span class="custom-page-link disabled">&gt;</span>
    @endif
</div>
@endif