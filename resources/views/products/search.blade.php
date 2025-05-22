@extends('layouts.app')

@section('title', 'Tìm kiếm: ' . $query)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tìm kiếm: {{ $query }}</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Kết quả tìm kiếm cho "{{ $query }}"</h1>
            
            @if($products->count() > 0)
            <p>Tìm thấy {{ $products->total() }} sản phẩm</p>
            
            <div class="row">
                @foreach($products as $product)
                <div class="col-md-3 col-6 mb-4">
                    @include('products.product-card', ['product' => $product])
                </div>
                @endforeach
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $products->appends(['q' => $query])->links() }}
            </div>
            
            @else
            <div class="alert alert-info">
                Không tìm thấy sản phẩm nào phù hợp với từ khóa "{{ $query }}".
                <div class="mt-3">
                    <h5>Gợi ý:</h5>
                    <ul>
                        <li>Kiểm tra lại chính tả của từ khóa tìm kiếm</li>
                        <li>Sử dụng từ khóa khác</li>
                        <li>Sử dụng từ khóa ngắn hơn</li>
                        <li>Xem tất cả sản phẩm trong <a href="{{ route('products.index') }}">danh mục sản phẩm</a></li>
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection