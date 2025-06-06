@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
        </ol>
    </nav>
    
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">Lọc sản phẩm</div>
                <div class="card-body">
                    <form action="{{ route('products.category', $category->category_id) }}" method="GET">
                        <div class="mb-3">
                            <label for="sort" class="form-label">Sắp xếp theo</label>
                            <select class="form-select" id="sort" name="sort" onchange="this.form.submit()">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Đánh giá cao</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Khoảng giá</label>
                            <div class="d-flex">
                                <input type="number" class="form-control me-2" name="min_price" placeholder="Từ" value="{{ request('min_price') }}">
                                <input type="number" class="form-control" name="max_price" placeholder="Đến" value="{{ request('max_price') }}">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Áp dụng</button>
                    </form>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">Danh mục</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($categories as $cat)
                        <li class="list-group-item {{ $cat->category_id == $category->category_id ? 'active' : '' }}">
                            <a href="{{ route('products.category', $cat->category_id) }}" class="text-decoration-none {{ $cat->category_id == $category->category_id ? 'text-white' : '' }}">
                                {{ $cat->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Product Listing -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>{{ $category->name }}</h1>
                <span>Hiển thị {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} của {{ $products->total() ?? 0 }} sản phẩm</span>
            </div>
            
            <div class="row">
                @forelse($products as $product)
                <div class="col-md-4 col-6 mb-4">
                    @include('products.product-card', ['product' => $product])
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Không có sản phẩm nào thuộc danh mục này.
                    </div>
                </div>
                @endforelse
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection