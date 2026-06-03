@extends('layouts.app')
@section('title', 'Hồ sơ của tôi')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Hồ sơ của tôi</h1>

    @if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-xl bg-green-50 text-green-700 text-sm border border-green-100">
        ✅ {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 text-red-700 text-sm border border-red-100">
        ⚠️ {{ session('error') }}
    </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}"
          class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
        @csrf
        @method('PUT')

        {{-- Họ và tên --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
            <input type="text" name="full_name"
                   value="{{ old('full_name', $user->full_name) }}"
                   class="w-full px-4 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none @error('full_name') border-red-400 @enderror">
            @error('full_name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email"
                   value="{{ old('email', $user->email) }}"
                   class="w-full px-4 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none @error('email') border-red-400 @enderror">
            @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Số điện thoại --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
            <input type="text" name="phone"
                   value="{{ old('phone', $user->phone) }}"
                   placeholder="VD: 0901234567"
                   class="w-full px-4 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none @error('phone') border-red-400 @enderror">
            @error('phone')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Địa chỉ --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ</label>
            <textarea name="address" rows="3"
                      placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố"
                      class="w-full px-4 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none @error('address') border-red-400 @enderror">{{ old('address', $user->address) }}</textarea>
            @error('address')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <div class="pt-2 flex items-center gap-3">
            <button type="submit"
                    class="px-6 py-2 rounded-xl text-white text-sm font-medium hover:opacity-90 transition"
                    style="background: {{ $siteConfig['primary_color'] ?? '#1352a1' }}">
                Lưu thay đổi
            </button>
            <a href="{{ route('home') }}"
               class="px-6 py-2 rounded-xl border border-gray-300 text-sm text-gray-600 hover:bg-gray-50 transition">
                Huỷ
            </a>
        </div>
    </form>

    {{-- Link tới lịch sử đơn hàng --}}
    <div class="mt-4 text-center">
        <a href="{{ route('user.orders') }}" class="text-sm text-blue-600 hover:underline">
            Xem lịch sử đơn hàng →
        </a>
    </div>
</div>
@endsection