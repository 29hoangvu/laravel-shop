@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.category', $product->category_id) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : asset('images/no-image.jpg') }}"
                        class="img-fluid product-detail-img" alt="{{ $product->name }}">
                </div>
            </div>
        </div>
        
        <!-- Product Details -->
        <div class="col-md-7">
            <h1>{{ $product->name }}</h1>
            
            {{-- Bỏ phần rating và số lượng đánh giá --}}
            
            <div class="mb-3">
                <span class="text-muted">Danh mục: </span>
                <a href="{{ route('products.category', $product->category_id) }}">{{ $product->category->name }}</a>
            </div>
            
            <div class="mb-3">
                <h3 class="product-price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</h3>
                @if($product->old_price && $product->old_price > $product->price)
                <span class="text-muted text-decoration-line-through">{{ number_format($product->old_price, 0, ',', '.') }} VNĐ</span>
                <span class="badge bg-danger ms-2">Giảm {{ number_format((1 - $product->price / $product->old_price) * 100, 0) }}%</span>
                @endif
            </div>
            
            <div class="mb-4">
                {!! nl2br(e($product->description)) !!}
            </div>
            
            <div class="mb-3">
                <span class="text-muted">Tình trạng: </span>
                @if($product->stock_quantity > 0)
                <span class="text-success">Còn hàng ({{ $product->quantity }})</span>
                @else
                <span class="text-danger">Hết hàng</span>
                @endif
            </div>
            
            <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                <div class="row">
                    <div class="col-md-3 col-5">
                        <div class="input-group">
                            <button type="button" class="btn btn-outline-secondary" onclick="decreaseQuantity()">-</button>
                            <input type="number" class="form-control text-center" id="quantity" name="quantity" value="1" min="1" max="{{ $product->quantity }}">
                            <button type="button" class="btn btn-outline-secondary" onclick="increaseQuantity()">+</button>
                        </div>
                    </div>
                    <div class="col-md-9 col-7">
                        <button type="submit" class="btn btn-primary {{ $product->quantity <= 0 ? 'disabled' : '' }}" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                        </button>
                        <a href="#" class="btn btn-outline-danger ms-2 toggle-favorite" data-product-id="{{ $product->product_id }}">
                            @if(Auth::check() && Auth::user()->favorites->contains($product->product_id))
                                <i class="fas fa-heart"></i> Đã yêu thích
                            @else
                                <i class="far fa-heart"></i> Yêu thích
                            @endif
                        </a>
                    </div>
                </div>
            </form>
            
            <div class="mb-3">
                <span class="text-muted">Chia sẻ: </span>
                <a href="#" class="text-primary me-2"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-info me-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-danger"><i class="fab fa-pinterest"></i></a>
            </div>
        </div>
    </div>
    
    <!-- Product Tabs -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Chi tiết sản phẩm</button>
                </li>
                {{-- Bỏ tab đánh giá --}}
            </ul>
            <div class="tab-content p-4 border border-top-0 rounded-bottom" id="productTabsContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                    <h4>Thông tin chi tiết</h4>
                    <p>{!! nl2br(e($product->detail)) !!}</p>
                </div>
                {{-- Bỏ nội dung tab đánh giá --}}
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    <div class="row mt-5">
        <div class="col-12">
            <h3>Sản phẩm liên quan</h3>
        </div>
    </div>
    <div class="row">
        @foreach($relatedProducts as $product)
        <div class="col-md-3 col-6 mb-4">
            @include('products.product-card', ['product' => $product])
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
    function increaseQuantity() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.getAttribute('max'));
        let value = parseInt(input.value);
        if (value < max) {
            input.value = value + 1;
        }
    }
    
    function decreaseQuantity() {
        const input = document.getElementById('quantity');
        let value = parseInt(input.value);
        if (value > 1) {
            input.value = value - 1;
        }
    }
</script>
@endsection
