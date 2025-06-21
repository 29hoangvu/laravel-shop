@extends('layouts.app')

@section('title', $product->name)

@section('scripts')
<script>
    function increaseQuantity(button) {
        const input = button.parentElement.querySelector('.quantity-input');
        const max = parseInt(input.getAttribute('max'));
        let value = parseInt(input.value);
        if (value < max) input.value = value + 1;
    }

    function decreaseQuantity(button) {
        const input = button.parentElement.querySelector('.quantity-input');
        let value = parseInt(input.value);
        if (value > 1) input.value = value - 1;
    }

    // Kiểm tra nhập tay số lượng
    document.querySelector('.quantity-input').addEventListener('input', function() {
        let value = parseInt(this.value);
        const max = parseInt(this.getAttribute('max'));
        if (isNaN(value) || value < 1) this.value = 1;
        else if (value > max) this.value = max;
    });

    // Toggle favorite với AJAX
    document.querySelector('.toggle-favorite').addEventListener('click', function(e) {
        e.preventDefault();
        const btn = this;
        const productId = btn.getAttribute('data-product-id');

        fetch("{{ route('favorites.toggle', '') }}/" + productId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        }).then(res => res.json())
        .then(data => {
            if (data.status === 'added') {
                btn.innerHTML = '<i class="fas fa-heart"></i> Đã yêu thích';
                btn.classList.remove('text-red-500');
                btn.classList.add('text-red-700');
            } else {
                btn.innerHTML = '<i class="far fa-heart"></i> Yêu thích';
                btn.classList.remove('text-red-700');
                btn.classList.add('text-red-500');
            }
        });
    });
</script>
@endsection
@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-6">
        <ol class="list-reset flex">
            <li><a href="{{ route('home') }}" class="hover:underline">Trang chủ</a></li>
            <li><span class="mx-2">/</span><a href="{{ route('products.index') }}" class="hover:underline">Sản phẩm</a></li>
            <li><span class="mx-2">/</span><a href="{{ route('products.category', $product->category_id) }}" class="hover:underline">{{ $product->category->name }}</a></li>
            <li><span class="mx-2">/</span><span class="text-gray-700">{{ $product->name }}</span></li>
        </ol>
    </nav>

    <div class="grid md:grid-cols-2 gap-8">
        {{-- Hình ảnh sản phẩm --}}
        <div>
            <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : asset('images/no-image.jpg') }}"
                alt="{{ $product->name }}" class="w-full rounded shadow">
        </div>

        {{-- Thông tin sản phẩm --}}
        <div>
            <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>

            <div class="text-sm mb-4 text-gray-600">
                <span>Danh mục: </span>
                <a href="{{ route('products.category', $product->category_id) }}" class="text-blue-500 hover:underline">
                    {{ $product->category->name }}
                </a>
            </div>

            <div class="mb-4">
                <p class="text-2xl font-semibold text-red-600">{{ number_format($product->price, 0, ',', '.') }}₫</p>
                @if($product->old_price && $product->old_price > $product->price)
                    <p class="text-gray-500 line-through">{{ number_format($product->old_price, 0, ',', '.') }}₫</p>
                    <span class="inline-block mt-1 text-sm text-white bg-red-500 px-2 py-1 rounded">Giảm {{ number_format((1 - $product->price / $product->old_price) * 100, 0) }}%</span>
                @endif
            </div>

            <div class="mb-4 text-gray-700">
                {!! nl2br(e($product->description)) !!}
            </div>

            <p class="mb-4">
                <span class="font-semibold text-gray-700">Tình trạng: </span>
                @if($product->stock_quantity > 0)
                    <span class="text-green-600">Còn hàng ({{ $product->stock_quantity }})</span>
                @else
                    <span class="text-red-600">Hết hàng</span>
                @endif
            </p>

            {{-- Form thêm giỏ hàng --}}
            <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                <div class="flex items-center gap-3">
                    <button type="button" onclick="decreaseQuantity(this)" class="px-3 py-1 bg-gray-200 rounded">-</button>
                    <input type="number" class="quantity-input w-16 text-center border border-gray-300 rounded"
                        name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}">
                    <button type="button" onclick="increaseQuantity(this)" class="px-3 py-1 bg-gray-200 rounded">+</button>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
                        {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                        <i class="fas fa-cart-plus mr-1"></i> Thêm vào giỏ hàng
                    </button>
                </div>
            </form>

            {{-- Chia sẻ --}}
            <div class="mt-6">
                <span class="text-gray-600">Chia sẻ:</span>
                <div class="inline-flex gap-3 mt-1 text-xl">
                    <a href="#" class="text-blue-600 hover:scale-110 transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-sky-500 hover:scale-110 transition"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-red-500 hover:scale-110 transition"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="mt-10">
        <h2 class="text-xl font-semibold mb-3">Thông tin chi tiết</h2>
        <div class="bg-white border rounded p-4 text-gray-700">
            <p>{!! nl2br(e($product->detail)) !!}</p>
        </div>
    </div>

    {{-- Sản phẩm liên quan --}}
    <div class="mt-12">
        <h3 class="text-xl font-semibold mb-6">Sản phẩm liên quan</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($relatedProducts as $relatedProduct)
                @include('products.product-card', ['product' => $relatedProduct])
            @endforeach
        </div>
    </div>
</div>

@endsection

