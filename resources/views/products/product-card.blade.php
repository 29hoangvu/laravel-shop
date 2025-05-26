<div class="bg-white dark:bg-gray-800 shadow rounded-2xl overflow-hidden flex flex-col">
    <a href="{{ route('products.show', $product->Product_id) }}" class="block">
        <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : asset('images/no-image.jpg') }}" 
             alt="{{ $product->name }}"
             class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
    </a>
    <div class="p-4 flex flex-col flex-1">
        <h5 class="text-lg font-semibold text-gray-800 dark:text-white mb-2 line-clamp-2">
            <a href="{{ route('products.show', $product->Product_id) }}" class="hover:text-sky-500 transition-colors">
                {{ $product->name }}
            </a>
        </h5>

        <!-- Rating -->
        <div class="flex items-center text-yellow-400 mb-2 text-sm">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $product->rating)
                    <i class="fas fa-star"></i>
                @elseif($i - 0.5 <= $product->rating)
                    <i class="fas fa-star-half-alt"></i>
                @else
                    <i class="far fa-star"></i>
                @endif
            @endfor
            <span class="text-gray-500 dark:text-gray-400 text-xs ml-2">({{ $product->stock_quantity ?? 0 }})</span>
        </div>

        <!-- Price -->
        <p class="text-red-600 dark:text-red-400 font-semibold text-base mb-4">
            {{ number_format($product->price, 0, ',', '.') }} VNĐ
        </p>

        <!-- Buttons -->
        <div class="mt-auto flex justify-between items-center gap-2">
            <button class="add-to-cart-btn bg-sky-500 hover:bg-sky-600 text-white text-sm px-3 py-1.5 rounded-lg flex items-center gap-1 transition"
                data-product-id="{{ $product->Product_id }}">
                <i class="fas fa-cart-plus"></i> Thêm
            </button>

            <a href="#" class=" text-gray-600 dark:text-gray-300 hover:text-red-500 text-xl transition"
               data-product-id="{{ $product->Product_id }}" data-bs-toggle="tooltip" title="Thêm vào yêu thích">
                @if(Auth::check() && Auth::user()->favorites->contains($product->Product_id))
                    <i class="fas fa-heart text-red-500"></i>
                @else
                    <i class="far fa-heart"></i>
                @endif
            </a>
        </div>
    </div>
</div>
