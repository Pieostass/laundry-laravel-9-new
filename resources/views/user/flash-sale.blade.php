@extends('layouts.app')
@section('title', 'Flash Sale')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
    <div class="text-center mb-10 md:mb-12">
        <div class="inline-flex items-center gap-2 text-gold text-sm font-medium tracking-wider uppercase mb-4">
            <span class="w-8 h-px bg-gold/30"></span>
            <span>⚡ Thời gian có hạn</span>
            <span class="w-8 h-px bg-gold/30"></span>
        </div>
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-medium text-ink mb-3">Flash Sale</h1>
        <p class="text-ink-muted max-w-2xl mx-auto text-sm leading-relaxed px-4">
            Những sản phẩm được giảm giá mạnh nhất chỉ trong thời gian ngắn. Nhanh tay sở hữu ngay!
        </p>
    </div>

    @if($products->isEmpty())
    <div class="text-center py-16 bg-cream rounded-2xl border border-border-soft">
        <div class="text-5xl mb-3">⏳</div>
        <p class="text-ink-muted">Chưa có sản phẩm flash sale nào.</p>
    </div>
    @else
    {{-- Grid sản phẩm - responsive 2-3-4 cột --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
        @foreach($products as $product)
        <div class="group bg-white rounded-xl border border-border-soft hover:shadow-md transition-all duration-300 overflow-hidden">
            <a href="{{ route('product.detail', $product->id) }}" class="block overflow-hidden bg-gray-50">
                {{--  QUAN TRỌNG: ĐÃ SỬA ẢNH - object-contain + padding --}}
                <div class="w-full aspect-square flex items-center justify-center p-4 md:p-5">
                    <img src="{{ $product->image_src }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105">
                </div>
            </a>
            <div class="p-3 md:p-4">
                <p class="text-[10px] md:text-xs text-bronze font-medium mb-1 truncate">{{ $product->category?->name ?? 'Sản phẩm' }}</p>
                <h3 class="font-semibold text-ink text-xs md:text-sm line-clamp-2 min-h-[36px] md:min-h-[40px]">
                    <a href="{{ route('product.detail', $product->id) }}" class="hover:text-bronze transition">
                        {{ $product->name }}
                    </a>
                </h3>
                <div class="mt-2 md:mt-3 flex items-baseline gap-2 flex-wrap">
                    <span class="text-bronze font-bold text-sm md:text-lg">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                    @if(isset($product->old_price))
                    <span class="text-ink-muted line-through text-[10px] md:text-xs">{{ number_format($product->old_price, 0, ',', '.') }}₫</span>
                    @endif
                </div>
                <div class="mt-3 md:mt-4">
                    @auth
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" 
                                class="w-full py-2 md:py-2.5 text-center text-[11px] md:text-sm font-medium rounded-full transition-all bg-bronze text-cream hover:bg-bronze-dark active:scale-95">
                            + Thêm vào giỏ
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" 
                       class="block w-full py-2 md:py-2.5 text-center text-[11px] md:text-sm font-medium rounded-full transition-all bg-bronze text-cream hover:bg-bronze-dark">
                        Đăng nhập để mua
                    </a>
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Phân trang (nếu có) --}}
    @if(method_exists($products, 'links') && $products->hasPages())
    <div class="mt-10">
        {{ $products->links() }}
    </div>
    @endif
    @endif

    {{-- Banner cuối trang --}}
    <div class="mt-12 md:mt-16 text-center bg-warm-gray rounded-xl p-6 md:p-8 border border-border-soft">
        <p class="text-ink-muted text-xs md:text-sm">Đừng bỏ lỡ cơ hội sở hữu sản phẩm chất lượng với giá ưu đãi nhất!</p>
        <a href="{{ route('shop') }}" class="inline-block mt-3 md:mt-4 text-bronze hover:text-bronze-dark underline text-xs md:text-sm font-medium transition">
            Xem tất cả sản phẩm →
        </a>
    </div>
</div>
@endsection