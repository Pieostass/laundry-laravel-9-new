@extends('layouts.admin')
@section('title', 'PINKMEE')
@section('page-title', '🌸 Trang PINKMEE')

@section('content')
<form method="POST" action="{{ route('admin.settings.pinkmee.update') }}" class="max-w-3xl space-y-6">
    @csrf

    @php
    $keys = [
        'pinkmee_hero_title', 'pinkmee_hero_subtitle',
        'pinkmee_intro_heading', 'pinkmee_intro_text1', 'pinkmee_intro_text2',
        'pinkmee_mission',
    ];
    $labelMap = [
        'pinkmee_hero_title'    => 'Tiêu đề hero',
        'pinkmee_hero_subtitle' => 'Phụ đề hero',
        'pinkmee_intro_heading' => 'Heading phần giới thiệu',
        'pinkmee_intro_text1'   => 'Đoạn văn 1 - giới thiệu',
        'pinkmee_intro_text2'   => 'Đoạn văn 2 - giới thiệu',
        'pinkmee_mission'       => 'Sứ mệnh PINKMEE',
    ];
    $configMap = collect($configs)->keyBy('config_key');
    @endphp

    @if(session('success'))
    <div class="px-5 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-pink-100 bg-pink-50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-pink-400"></span>
                <h3 class="font-semibold text-sm text-pink-700">🌸 Trang PINKMEE</h3>
            </div>
            <a href="{{ url('/gioi-thieu-my-pham-pinkmee') }}" target="_blank"
               class="text-xs text-gray-400 hover:text-gray-600 flex items-center gap-1 transition">
                Xem trang
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                </svg>
            </a>
        </div>
        <div class="p-6 space-y-4">
            @foreach($keys as $key)
            @php
                $value = $configMap->get($key)?->config_value ?? '';
                $label = $labelMap[$key] ?? $key;
                $isTextarea = str_contains($key, 'text') || str_contains($key, 'mission')
                           || strlen($value) > 100;
            @endphp
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ $label }}
                    <span class="text-xs text-gray-400 font-mono ml-1">[{{ $key }}]</span>
                </label>
                @if($isTextarea)
                    <textarea name="{{ $key }}" rows="3"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-pink-500 outline-none text-sm resize-y">{{ $value }}</textarea>
                @else
                    <input type="text" name="{{ $key }}" value="{{ $value }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-pink-500 outline-none text-sm">
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <div class="flex gap-3 pb-6">
        <button type="submit"
                class="px-6 py-2.5 rounded-xl text-white font-medium text-sm hover:opacity-90 transition"
                style="background: {{ $siteConfig['primary_color'] ?? '#1352a1' }}">
            💾 Lưu cài đặt
        </button>
    </div>
</form>
@endsection