@extends('layouts.app')

@section('title', 'Cửa hàng')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">🛒 Cửa hàng</h1>
        <p class="text-gray-500 text-sm mt-1">
            Tìm thấy {{ $products->total() }} sản phẩm
            @if($keyword) cho "<strong>{{ $keyword }}</strong>" @endif
        </p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Sidebar category --}}
        <aside class="lg:w-60 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-semibold text-gray-800 mb-4 text-sm uppercase tracking-wide">Danh mục</h3>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('shop') }}"
                           class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition
                                  {{ !$selectedCategory ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            Tất cả
                        </a>
                    </li>
                    @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('shop', ['categoryId' => $cat->id]) }}"
                           class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition
                                  {{ $selectedCategory == $cat->id ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            {{ $cat->name }}
                            <span class="text-xs text-gray-400">{{ $cat->products()->active()->count() }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1">
            {{-- Search bar --}}
            <form method="GET" action="{{ route('shop') }}" class="mb-6 flex gap-2">
                <input type="text" name="keyword" value="{{ $keyword }}"
                       placeholder="Tìm kiếm sản phẩm..."
                       class="flex-1 px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                @if($selectedCategory)
                    <input type="hidden" name="categoryId" value="{{ $selectedCategory }}">
                @endif
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl text-white text-sm font-medium transition hover:opacity-90"
                        style="background: {{ $siteConfig['accent_color'] ?? '#2e88f6' }}">
                    Tìm
                </button>
                @if($keyword || $selectedCategory)
                    <a href="{{ route('shop') }}"
                       class="px-4 py-2.5 rounded-xl border border-gray-300 text-sm text-gray-600 hover:bg-gray-50 transition">
                        Xoá
                    </a>
                @endif
            </form>

            {{-- Products grid --}}
            @if($products->isEmpty())
                <div class="text-center py-20 text-gray-400">
                    <div class="text-5xl mb-4">🔍</div>
                    <p class="font-medium">Không tìm thấy sản phẩm nào.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($products->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $products->withQueryString()->links('vendor.pagination.custom') }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection