@extends('layouts.admin')
@section('title', 'Về Công Ty')
@section('page-title', '🏢 Trang Về Công Ty')

@section('content')
<form method="POST" action="{{ route('admin.settings.about.update') }}" class="max-w-3xl space-y-6">
    @csrf

    @php
    $configMap = collect($configs)->keyBy('config_key');

    $groups = [
        'Hero' => [
            'about_hero_title'    => 'Tiêu đề hero',
            'about_hero_subtitle' => 'Phụ đề hero',
        ],
        'Phần tổng quan' => [
            'about_intro_heading' => 'Heading tổng quan',
            'about_intro_text1'   => 'Đoạn văn 1',
            'about_intro_text2'   => 'Đoạn văn 2',
        ],
        'Bullet điểm nổi bật' => [
            'about_point1' => 'Điểm nổi bật 1',
            'about_point2' => 'Điểm nổi bật 2',
            'about_point3' => 'Điểm nổi bật 3',
            'about_point4' => 'Điểm nổi bật 4',
        ],
        'Chỉ số thống kê' => [
            'about_stat1_number' => 'Chỉ số 1 — Con số',
            'about_stat1_label'  => 'Chỉ số 1 — Nhãn',
            'about_stat2_number' => 'Chỉ số 2 — Con số',
            'about_stat2_label'  => 'Chỉ số 2 — Nhãn',
            'about_stat3_number' => 'Chỉ số 3 — Con số',
            'about_stat3_label'  => 'Chỉ số 3 — Nhãn',
            'about_stat4_number' => 'Chỉ số 4 — Con số',
            'about_stat4_label'  => 'Chỉ số 4 — Nhãn',
        ],
        'Sứ mệnh / Tầm nhìn / Giá trị' => [
            'about_mission' => 'Sứ mệnh',
            'about_vision'  => 'Tầm nhìn',
            'about_values'  => 'Giá trị cốt lõi',
        ],
        'Lịch sử — Mốc 1' => [
            'about_timeline1_year'  => 'Năm',
            'about_timeline1_title' => 'Tiêu đề',
            'about_timeline1_desc'  => 'Mô tả',
        ],
        'Lịch sử — Mốc 2' => [
            'about_timeline2_year'  => 'Năm',
            'about_timeline2_title' => 'Tiêu đề',
            'about_timeline2_desc'  => 'Mô tả',
        ],
        'Lịch sử — Mốc 3' => [
            'about_timeline3_year'  => 'Năm',
            'about_timeline3_title' => 'Tiêu đề',
            'about_timeline3_desc'  => 'Mô tả',
        ],
        'Lịch sử — Mốc 4' => [
            'about_timeline4_year'  => 'Năm',
            'about_timeline4_title' => 'Tiêu đề',
            'about_timeline4_desc'  => 'Mô tả',
        ],
        'Lịch sử — Mốc 5' => [
            'about_timeline5_year'  => 'Năm',
            'about_timeline5_title' => 'Tiêu đề',
            'about_timeline5_desc'  => 'Mô tả',
        ],
        'Hệ sinh thái thương hiệu' => [
            'about_brand_soccon_desc'  => 'Mô tả SOCCON',
            'about_brand_pinkmee_desc' => 'Mô tả PINKMEE',
        ],
    ];

    $timelineGroups = ['Lịch sử — Mốc 1','Lịch sử — Mốc 2','Lịch sử — Mốc 3','Lịch sử — Mốc 4','Lịch sử — Mốc 5'];
    @endphp

    @if(session('success'))
    <div class="px-5 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Header card --}}
    <div class="bg-blue-50 border border-blue-100 rounded-2xl px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-blue-400"></span>
            <h3 class="font-semibold text-sm text-blue-700">🏢 Trang Về Công Ty</h3>
        </div>
        <a href="{{ url('/gioi-thieu-cong-ty') }}" target="_blank"
           class="text-xs text-gray-400 hover:text-gray-600 flex items-center gap-1 transition">
            Xem trang
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
            </svg>
        </a>
    </div>

    {{-- Divider trước timeline --}}
    @php $shownTimelineDivider = false; @endphp

    @foreach($groups as $groupName => $fields)

    @if(in_array($groupName, $timelineGroups) && !$shownTimelineDivider)
    @php $shownTimelineDivider = true; @endphp
    <div class="flex items-center gap-3 pt-2">
        <div class="h-px flex-1 bg-gray-200"></div>
        <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Lịch sử hình thành</span>
        <div class="h-px flex-1 bg-gray-200"></div>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-3 border-b border-gray-100 bg-gray-50">
            <h3 class="font-semibold text-gray-600 text-xs uppercase tracking-wider">{{ $groupName }}</h3>
        </div>
        <div class="p-6 space-y-4">
            @foreach($fields as $key => $label)
            @php
                $value = $configMap->get($key)?->config_value ?? '';
                $isTextarea = str_contains($key, 'desc') || str_contains($key, 'text')
                           || str_contains($key, 'mission') || str_contains($key, 'vision')
                           || str_contains($key, 'values') || strlen($value) > 80;
            @endphp
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ $label }}
                    <span class="text-xs text-gray-400 font-mono ml-1">[{{ $key }}]</span>
                </label>
                @if($isTextarea)
                    <textarea name="{{ $key }}" rows="3"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none text-sm resize-y">{{ $value }}</textarea>
                @else
                    <input type="text" name="{{ $key }}" value="{{ $value }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none text-sm">
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