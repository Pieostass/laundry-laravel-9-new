@extends('layouts.admin')
@section('title', 'Sản phẩm')
@section('page-title', '📦 Quản lý sản phẩm')

@section('content')

{{-- ── Flash Messages ───────────────────────────────────────────────────────── --}}
@if(session('success'))
<div class="mb-4 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm flex items-center gap-2">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="mb-4 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-2">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    {{ session('error') }}
</div>
@endif

{{-- ── Toolbar ─────────────────────────────────────────────────────────────── --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">

    <form method="GET" action="{{ route('admin.products') }}" class="flex flex-wrap gap-2">
        <input type="text" name="keyword" value="{{ $keyword }}"
               placeholder="Tìm sản phẩm..."
               class="px-4 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none w-52">

        <select name="categoryId"
                class="px-4 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                onchange="this.form.submit()">
            <option value="">Tất cả danh mục</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
            @endforeach
        </select>

        <button type="submit"
                class="px-4 py-2 rounded-xl text-white text-sm font-medium"
                style="background: {{ $siteConfig['accent_color'] ?? '#2e88f6' }}">
            Lọc
        </button>

        @if($keyword || $categoryId)
        <a href="{{ route('admin.products') }}"
           class="px-4 py-2 rounded-xl border border-gray-300 text-sm text-gray-600 hover:bg-gray-50">
            Xoá lọc
        </a>
        @endif
    </form>

    <a href="{{ route('admin.products.create') }}"
       class="flex items-center gap-2 px-5 py-2 rounded-xl text-white text-sm font-medium hover:opacity-90 transition flex-shrink-0"
       style="background: {{ $siteConfig['primary_color'] ?? '#1352a1' }}">
        + Thêm sản phẩm
    </a>
</div>

{{-- ── Products table ──────────────────────────────────────────────────────── --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 uppercase text-xs border-b border-gray-100">
                    <th class="px-5 py-3 text-left">Ảnh</th>
                    <th class="px-5 py-3 text-left">Tên sản phẩm</th>
                    <th class="px-5 py-3 text-left">Danh mục</th>
                    <th class="px-5 py-3 text-right">Giá</th>
                    <th class="px-5 py-3 text-right">Tồn kho</th>
                    <th class="px-5 py-3 text-center">Trạng thái</th>
                    <th class="px-5 py-3 text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition">

                    {{-- Ảnh --}}
                    <td class="px-5 py-3">
                        <img src="{{ $product->image_src }}"
                             alt="{{ $product->name }}"
                             class="w-12 aspect-square object-cover rounded-xl">
                    </td>

                    {{-- Tên + mô tả --}}
                    <td class="px-5 py-3">
                        <p class="font-medium text-gray-800">{{ $product->name }}</p>
                        <p class="text-xs text-gray-400 line-clamp-1">{{ $product->description }}</p>
                    </td>

                    {{-- Danh mục --}}
                    <td class="px-5 py-3 text-gray-600">
                        {{ $product->category?->name ?? '—' }}
                    </td>

                    {{-- Giá --}}
                    <td class="px-5 py-3 text-right font-semibold text-blue-600">
                        {{ number_format($product->price, 0, ',', '.') }}₫
                    </td>

                    {{-- Tồn kho --}}
                    <td class="px-5 py-3 text-right text-gray-700">
                        {{ $product->stock_quantity }}
                    </td>

                    {{-- Trạng thái --}}
                    <td class="px-5 py-3 text-center">
                        @if($product->active)
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">Hoạt động</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Ẩn</span>
                        @endif
                    </td>

                    {{-- Thao tác --}}
                    <td class="px-5 py-3">
                        <div class="flex items-center justify-center gap-2">

                            {{-- Sửa --}}
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                               class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 text-xs font-medium hover:bg-blue-100 transition">
                                Sửa
                            </a>

                            {{-- Toggle ẩn/hiện --}}
                            <form method="POST"
                                  action="{{ route('admin.products.toggle', $product->id) }}"
                                  class="inline">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('{{ $product->active ? 'Ẩn sản phẩm này?' : 'Hiện lại sản phẩm này?' }}')"
                                        class="{{ $product->active
                                            ? 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100'
                                            : 'bg-green-50 text-green-700 hover:bg-green-100' }}
                                               px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                    {{ $product->active ? 'Ẩn' : 'Hiện' }}
                                </button>
                            </form>

                            {{-- Xoá hẳn --}}
                            <form method="POST"
                                  action="{{ route('admin.products.destroy', $product->id) }}"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Vô hiệu hoá sản phẩm này?')"
                                        class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100 transition">
                                    Xoá
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                        <div class="text-3xl mb-2">📦</div>
                        <p>Chưa có sản phẩm nào.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $products->withQueryString()->links('vendor.pagination.custom') }}
    </div>
    @endif
</div>

@endsection