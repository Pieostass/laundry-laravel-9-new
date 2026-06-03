@extends('layouts.admin')
@section('title', 'Cài đặt')
@section('page-title', '⚙️ Cài đặt giao diện')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-3xl space-y-6">
    @csrf

    @php
    $groups = [
        'Thương hiệu' => ['site_name', 'site_tagline'],
        'Giao diện'   => ['background_color', 'primary_color', 'accent_color', 'navbar_color'],
        'Logo'        => ['logo_url'],
        'Footer'      => ['footer_address', 'footer_phone', 'footer_email', 'footer_hours'],
        'Hero'        => ['hero_title', 'hero_subtitle', 'hero_btn1_text', 'hero_btn1_url', 'hero_btn2_text', 'hero_btn2_url'],
        'USP'         => ['usp1_icon', 'usp1_title', 'usp1_desc', 'usp2_icon', 'usp2_title', 'usp2_desc', 'usp3_icon', 'usp3_title', 'usp3_desc', 'usp4_icon', 'usp4_title', 'usp4_desc'],
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

    @foreach($groups as $groupName => $keys)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="font-semibold text-gray-700 text-sm">{{ $groupName }}</h3>
        </div>
        <div class="p-6 space-y-4">
            @foreach($keys as $key)
            @php
                $cfg   = $configMap->get($key);
                $value = $cfg?->config_value ?? '';
                $label = $cfg?->description ?? $key;
                $isTextarea = strlen($value) > 100;
            @endphp
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ $label }}
                    <span class="text-xs text-gray-400 font-mono ml-1">[{{ $key }}]</span>
                </label>
                @if(str_ends_with($key, '_color'))
                    <div class="flex items-center gap-3">
                        <input type="color" name="{{ $key }}" value="{{ $value ?: '#000000' }}"
                               class="h-10 w-16 rounded-lg border border-gray-300 cursor-pointer">
                        <input type="text" name="{{ $key }}" value="{{ $value }}"
                               class="flex-1 px-4 py-2 rounded-xl border border-gray-300 text-sm font-mono focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                @elseif($key === 'logo_url')
                    <div>
                        <input type="text" name="logo_url" value="{{ $value }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm"
                               placeholder="https://example.com/logo.png">
                        @if(!empty($value))
                        <div class="mt-2">
                            <img src="{{ $value }}" alt="Logo preview"
                                 class="h-12 object-contain border border-gray-200 rounded-lg p-1">
                        </div>
                        @endif
                    </div>
                @elseif($isTextarea)
                    <textarea name="{{ $key }}" rows="3"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm resize-y">{{ $value }}</textarea>
                @else
                    <input type="text" name="{{ $key }}" value="{{ $value }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <div class="flex gap-3 pb-6">
        <button type="submit"
                class="px-6 py-2.5 rounded-xl text-white font-medium text-sm hover:opacity-90 transition"
                style="background: {{ $siteConfig['primary_color'] ?? '#1352a1' }}">
            💾 Lưu cài đặt
        </button>
    </div>
</form>
@endsection