@extends('layouts.app')
@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Page heading --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-6">📦 Đơn hàng của tôi</h1>

    {{-- Flash success --}}
    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center justify-between">
        <span>✅ {{ session('success') }}</span>
        <button onclick="this.closest('div').remove()" class="text-green-500 hover:text-green-700">✕</button>
    </div>
    @endif

    {{-- Flash error --}}
    @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center justify-between">
        <span>❌ {{ session('error') }}</span>
        <button onclick="this.closest('div').remove()" class="text-red-500 hover:text-red-700">✕</button>
    </div>
    @endif

    {{-- Empty state --}}
    @if($orders->isEmpty())
    <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="text-5xl mb-4">📦</div>
        <p class="text-lg font-medium text-gray-700 mb-1">Chưa có đơn hàng nào</p>
        <p class="text-sm text-gray-400 mb-5">Bạn chưa thực hiện đơn hàng nào. Hãy khám phá sản phẩm nhé!</p>
        <a href="{{ route('shop') }}"
           class="inline-block px-6 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition">
            Mua sắm ngay
        </a>
    </div>

    @else
    {{-- Order list --}}
    <div class="space-y-4">
        @foreach($orders as $order)

        {{-- Resolve status value safely (works for both string and Enum) --}}
        @php
            $statusValue = $order->status instanceof \BackedEnum
                ? $order->status->value
                : (string) $order->status;
        @endphp

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">

            {{-- Header row --}}
            <div class="flex flex-wrap justify-between items-start gap-3">
                <div>
                    <p class="text-xs text-gray-400">
                        Mã đơn: <span class="font-mono font-medium text-gray-600">#{{ $order->id }}</span>
                    </p>
                    <p class="text-sm font-medium text-gray-700 mt-0.5">
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $order->status_badge_class }}">
                    {{ $order->status_label }}
                </span>
            </div>

            {{-- Order items --}}
            <div class="mt-3 space-y-1.5">
                @foreach($order->orderItems as $item)
                <div class="flex justify-between text-sm text-gray-700">
                    <span>
                        {{ $item->product->name ?? 'Sản phẩm không còn tồn tại' }}
                        <span class="text-gray-400">× {{ $item->quantity }}</span>
                    </span>
                    <span class="font-medium">
                        {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                    </span>
                </div>
                @endforeach
            </div>

            {{-- Total --}}
            <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between items-center font-semibold text-sm">
                <span class="text-gray-600">Tổng cộng</span>
                <span class="text-blue-600 text-base">
                    {{ number_format($order->total_price, 0, ',', '.') }}₫
                </span>
            </div>

            {{-- Status-specific notices --}}
            @if($statusValue === 'PENDING')
            <div class="mt-3 text-xs text-yellow-700 bg-yellow-50 border border-yellow-100 px-3 py-2 rounded-lg">
                ⏳ Đơn hàng đang chờ xác nhận. Vui lòng chờ trong giây lát.
            </div>
            @elseif($statusValue === 'CONFIRMED')
            <div class="mt-3 text-xs text-blue-700 bg-blue-50 border border-blue-100 px-3 py-2 rounded-lg">
                ✅ Đơn hàng đã được xác nhận và đang được chuẩn bị.
            </div>
            @elseif($statusValue === 'SHIPPING')
            <div class="mt-3 text-xs text-purple-700 bg-purple-50 border border-purple-100 px-3 py-2 rounded-lg">
                🚚 Đơn hàng đang được giao đến bạn.
            </div>
            @elseif($statusValue === 'DELIVERED')
            <div class="mt-3 text-xs text-green-700 bg-green-50 border border-green-100 px-3 py-2 rounded-lg">
                🎉 Đơn hàng đã được giao thành công. Cảm ơn bạn đã mua sắm!
            </div>
            @elseif($statusValue === 'CANCELLED')
            <div class="mt-3 text-xs text-red-700 bg-red-50 border border-red-100 px-3 py-2 rounded-lg">
                ❌ Đơn hàng đã bị huỷ.
            </div>
            @endif

        </div>
        @endforeach
    </div>

    {{-- Pagination (if applicable) --}}
    @if(method_exists($orders, 'hasPages') && $orders->hasPages())
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
    @endif

    @endif
</div>
@endsection