@extends('layouts.app')

@section('title', $category->name)

@section('content')
<style>
    /* Breadcrumb */
    nav.breadcrumb {
        font-size: 0.9rem;
        background-color: #f8f9fa;
        box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 0.075);
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
    }

    nav.breadcrumb .breadcrumb-item a {
        color: #0d6efd;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    nav.breadcrumb .breadcrumb-item a:hover {
        color: #0a58ca;
        text-decoration: underline;
    }

    nav.breadcrumb .breadcrumb-item.active {
        color: #6c757d;
    }

    h2.fw-bold {
        font-size: 2rem;
        margin-bottom: 0;
    }

    span.text-muted.small {
        font-size: 0.9rem;
        color: #6c757d;
    }

    /* Horizontal scroll layout */
    .horizontal-scroll-wrapper {
        display: flex;
        overflow-x: auto;
        gap: 1rem;
        padding-bottom: 1rem;
        scroll-snap-type: x mandatory;
    }

    .product-horizontal-card {
        flex: 0 0 auto;
        width: 240px;
        scroll-snap-align: start;
    }

    .horizontal-scroll-wrapper::-webkit-scrollbar {
        height: 8px;
    }

    .horizontal-scroll-wrapper::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    /* Sidebar styling remains unchanged */
    .card {
        border-radius: 1rem;
        box-shadow: 0 0.25rem 0.5rem rgb(0 0 0 / 0.1);
        border: none;
        margin-bottom: 1.5rem;
    }

    .card-header {
        font-weight: 600;
        font-size: 1.25rem;
        padding: 0.75rem 1.25rem;
        border-radius: 1rem 1rem 0 0;
        border: none;
    }

    .card-header.bg-primary {
        background-color: #0d6efd !important;
        color: #fff;
    }

    .card-header.bg-secondary {
        background-color: #6c757d !important;
        color: #fff;
    }

    ul.list-group-flush li.list-group-item {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 0.5rem;
        transition: background-color 0.3s ease;
        margin-bottom: 0.25rem;
    }

    ul.list-group-flush li.list-group-item:hover {
        background-color: #e9ecef;
    }

    ul.list-group-flush li.list-group-item.bg-primary {
        background-color: #0d6efd !important;
    }

    ul.list-group-flush li.list-group-item.bg-primary a {
        color: #fff !important;
        font-weight: 700;
    }

    ul.list-group-flush li.list-group-item a {
        text-decoration: none;
        display: block;
        width: 100%;
        color: #212529;
        font-weight: 500;
    }

    @media (max-width: 576px) {
        h2.fw-bold {
            font-size: 1.3rem;
        }

        .card-header {
            font-size: 1.1rem;
        }
    }
</style>

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2 shadow-sm">
            <li class="breadcrumb-item active" aria-current="page">
                <i class="fas fa-tags me-1"></i>{{ $category->name }}
            </li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <!-- Bộ lọc -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary">
                    <i class="fas fa-filter me-1"></i> Lọc sản phẩm
                </div>
                <div class="card-body">
                    <form action="{{ route('products.category', $category->category_id) }}" method="GET">
                        <div class="mb-3">
                            <label for="sort" class="form-label fw-bold">Sắp xếp theo</label>
                            <select class="form-select" id="sort" name="sort" onchange="this.form.submit()">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Đánh giá cao</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Khoảng giá</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="min_price" placeholder="Từ" value="{{ request('min_price') }}">
                                <span class="input-group-text">-</span>
                                <input type="number" class="form-control" name="max_price" placeholder="Đến" value="{{ request('max_price') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-check-circle me-1"></i>Áp dụng
                        </button>
                    </form>
                </div>
            </div>

            <!-- Danh mục -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary">
                    <i class="fas fa-list me-1"></i> Danh mục
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($categories as $cat)
                        <li class="list-group-item {{ $cat->category_id == $category->category_id ? 'bg-primary text-white fw-bold' : '' }}">
                            <a href="{{ route('products.category', $cat->category_id) }}"
                               class="text-decoration-none d-block {{ $cat->category_id == $category->category_id ? 'text-white' : 'text-dark' }}">
                                {{ $cat->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm ngang -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <h2 class="fw-bold">{{ $category->name }}</h2>
                <span class="text-muted small">
                    Hiển thị {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} / {{ $products->total() ?? 0 }} sản phẩm
                </span>
            </div>

            @if($products->count())
            <div class="horizontal-scroll-wrapper">
                @foreach($products as $product)
                    <div class="product-horizontal-card">
                        @include('products.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
            @else
            <div class="alert alert-info">
                Không có sản phẩm nào thuộc danh mục này.
            </div>
            @endif

            <div class="d-flex justify-content-center mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
