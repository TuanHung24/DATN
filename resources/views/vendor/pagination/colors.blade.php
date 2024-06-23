<style>
.pagination-link, .pagination-disabled {
    padding: 8px 16px; /* Điều chỉnh kích thước padding */
    margin: 4px;
    border: 1px solid #ddd; /* Đường viền */
    border-radius: 4px; /* Bo góc */
    text-decoration: none; /* Loại bỏ gạch chân */
    color: #333; /* Màu chữ */
    background-color: #f8f8f8; /* Màu nền */
}

.pagination-link:hover {
    background-color: #e9e9e9; /* Màu nền khi hover */
}

.pagination-disabled {
    color: #aaa; /* Màu chữ cho phần không hoạt động */
    cursor: not-allowed; /* Con trỏ */
}

.pagination-info {
    padding: 8px 16px; /* Điều chỉnh kích thước padding */
    margin: 4px;
    color: #333; /* Màu chữ */
}
</style>


@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="pagination-nav">
   
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span class="pagination-disabled">
            << 
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link">
            << 
        </a>
    @endif

    {{-- Pagination Info --}}
    <span class="pagination-info">
        Trang {{ $paginator->currentPage() }} trên {{ $paginator->lastPage() }}
    </span>

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link">
            >>
        </a>
    @else
        <span class="pagination-disabled">
            >>
        </span>
    @endif
</nav>
@endif