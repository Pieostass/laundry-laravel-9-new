@props(['product', 'showCategory' => true, 'showAddToCart' => true])

<article class="product-card group relative flex flex-col bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300">
    {{-- QUAN TRỌNG: khung ảnh không có aspect-ratio, không có chiều cao cố định --}}
    <a href="{{ route('product.detail', $product->id) }}" class="block overflow-hidden bg-gray-100">
        <img src="{{ $product->image_src }}"
             alt="{{ $product->name }}"
             loading="lazy"
             class="w-full h-auto">   {{-- h-auto là chìa khóa --}}
        
        @if($product->stock_quantity <= 0)
            <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-full">
                <span class="text-[10px] font-semibold text-red-600 uppercase">Hết hàng</span>
            </div>
        @endif
    </a>

    {{-- Nút thêm giỏ hàng --}}
    @if($showAddToCart && $product->stock_quantity > 0)
        <div class="absolute bottom-0 left-0 right-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-10">
            @auth
                <form method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full bg-gray-900 text-white text-xs tracking-wider uppercase py-3 hover:bg-amber-700 transition-colors">
                        Thêm vào giỏ
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block w-full text-center bg-gray-900 text-white text-xs tracking-wider uppercase py-3 hover:bg-amber-700 transition-colors">
                    Mua ngay
                </a>
            @endauth
        </div>
    @endif

    {{-- Thông tin sản phẩm --}}
    <div class="p-4 flex flex-col flex-1">
        @if($showCategory && $product->category)
            <a href="{{ route('shop', ['categoryId' => $product->category_id]) }}" class="text-[10px] tracking-wider uppercase text-amber-600 mb-1 hover:text-amber-800 transition">
                {{ $product->category->name }}
            </a>
        @endif

        <h3 class="font-medium text-gray-800 text-sm leading-snug line-clamp-2 mb-1">
            <a href="{{ route('product.detail', $product->id) }}" class="hover:text-amber-600 transition">
                {{ $product->name }}
            </a>
        </h3>

        @if(!empty($product->description))
            <p class="text-[11px] text-gray-500 leading-relaxed line-clamp-2 mt-1 mb-2">
                {{ $product->description }}
            </p>
        @endif

        <div class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between">
            <span class="text-base font-bold text-amber-600">
                {{ number_format($product->price, 0, ',', '.') }}<span class="text-xs ml-0.5 text-gray-500">₫</span>
            </span>
            <button type="button" aria-label="Yêu thích" class="text-gray-400 hover:text-amber-500 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
            </button>
        </div>
    </div>
</article>