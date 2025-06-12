@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<div class="container py-5">
    @if (!empty($recommendedProducts) && $recommendedProducts->count())
        <div class="mb-4">
            <h2 class="text-center">Sản phẩm dành cho bạn</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
            @foreach ($recommendedProducts as $product)
                <div>
                    @include('products.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    @endif

    <div class="mb-4">
        <h2 class="text-center">Tất cả sản phẩm</h2>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
        @forelse($products as $product)
            <div>
                @include('products.product-card', ['product' => $product])
            </div>
        @empty
            <p class="col-span-full text-center">Hiện chưa có sản phẩm nào.</p>
        @endforelse
    </div>

    <div class="flex justify-center mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
