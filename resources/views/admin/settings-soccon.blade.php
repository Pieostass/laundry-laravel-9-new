@extends('layouts.admin')
@section('title', 'SOCCON')
@section('page-title', '🧴 Trang SOCCON')

@section('content')
<form method="POST" action="{{ route('admin.settings.soccon.update') }}" class="max-w-3xl space-y-6">
    @csrf

    @php
    $configMap = collect($configs)->keyBy('config_key');

    $groups = [
        'Hero' => [
            'soccon_hero_title'    => 'Tiêu đề hero',
            'soccon_hero_subtitle' => 'Phụ đề hero',
        ],
        'Phần giới thiệu chung' => [
            'soccon_intro_heading' => 'Heading giới thiệu',
            'soccon_intro_text1'   => 'Đoạn văn 1',
            'soccon_intro_text2'   => 'Đoạn văn 2',
            'soccon_point1'        => 'Bullet điểm 1',
            'soccon_point2'        => 'Bullet điểm 2',
            'soccon_point3'        => 'Bullet điểm 3',
            'soccon_intro_quote'   => 'Quote (hộp vàng góc ảnh)',
        ],
        'Vấn đề thị trường — Mục 1' => [
            'soccon_problem1_title' => 'Tiêu đề',
            'soccon_problem1_desc'  => 'Mô tả',
        ],
        'Vấn đề thị trường — Mục 2' => [
            'soccon_problem2_title' => 'Tiêu đề',
            'soccon_problem2_desc'  => 'Mô tả',
        ],
        'Vấn đề thị trường — Mục 3' => [
            'soccon_problem3_title' => 'Tiêu đề',
            'soccon_problem3_desc'  => 'Mô tả',
        ],
        'Vấn đề thị trường — Mục 4' => [
            'soccon_problem4_title' => 'Tiêu đề',
            'soccon_problem4_desc'  => 'Mô tả',
        ],
        'Tổng kết thị trường' => [
            'soccon_market_summary' => 'Đoạn tổng kết (có thể dùng <span> để in đậm)',
        ],
        'Lý do chọn SOCCON — 1' => [
            'soccon_why1_title' => 'Tiêu đề',
            'soccon_why1_desc'  => 'Mô tả',
        ],
        'Lý do chọn SOCCON — 2' => [
            'soccon_why2_title' => 'Tiêu đề',
            'soccon_why2_desc'  => 'Mô tả',
        ],
        'Lý do chọn SOCCON — 3' => [
            'soccon_why3_title' => 'Tiêu đề',
            'soccon_why3_desc'  => 'Mô tả',
        ],
        'Lý do chọn SOCCON — 4' => [
            'soccon_why4_title' => 'Tiêu đề',
            'soccon_why4_desc'  => 'Mô tả',
        ],
        'Lý do chọn SOCCON — 5' => [
            'soccon_why5_title' => 'Tiêu đề',
            'soccon_why5_desc'  => 'Mô tả',
        ],
        'Lý do chọn SOCCON — 6' => [
            'soccon_why6_title' => 'Tiêu đề',
            'soccon_why6_desc'  => 'Mô tả',
        ],
        'Quote phần lý do' => [
            'soccon_why_quote' => 'Quote lớn (không cần dấu nháy)',
        ],
        'Giá trị cốt lõi — 1' => [
            'soccon_value1_title' => 'Tiêu đề',
            'soccon_value1_desc'  => 'Mô tả',
        ],
        'Giá trị cốt lõi — 2' => [
            'soccon_value2_title' => 'Tiêu đề',
            'soccon_value2_desc'  => 'Mô tả',
        ],
        'Giá trị cốt lõi — 3' => [
            'soccon_value3_title' => 'Tiêu đề',
            'soccon_value3_desc'  => 'Mô tả',
        ],
        'Giá trị cốt lõi — 4' => [
            'soccon_value4_title' => 'Tiêu đề',
            'soccon_value4_desc'  => 'Mô tả',
        ],
        'Sứ mệnh & Tầm nhìn' => [
            'soccon_mission' => 'Sứ mệnh',
            'soccon_vision'  => 'Tầm nhìn',
        ],
        'Cam kết thương hiệu' => [
            'soccon_commit1' => 'Cam kết 1',
            'soccon_commit2' => 'Cam kết 2',
            'soccon_commit3' => 'Cam kết 3',
            'soccon_commit4' => 'Cam kết 4',
        ],
        'Định hướng phát triển — 1' => [
            'soccon_future1_title' => 'Tiêu đề',
            'soccon_future1_desc'  => 'Mô tả',
        ],
        'Định hướng phát triển — 2' => [
            'soccon_future2_title' => 'Tiêu đề',
            'soccon_future2_desc'  => 'Mô tả',
        ],
        'Định hướng phát triển — 3' => [
            'soccon_future3_title' => 'Tiêu đề',
            'soccon_future3_desc'  => 'Mô tả',
        ],
        'Định hướng phát triển — 4' => [
            'soccon_future4_title' => 'Tiêu đề',
            'soccon_future4_desc'  => 'Mô tả',
        ],
        'CTA cuối trang' => [
            'soccon_cta_heading' => 'Tiêu đề CTA',
            'soccon_cta_subtext' => 'Mô tả CTA',
        ],
    ];

    // Nhóm các section để hiện divider
    $dividers = [
        'Vấn đề thị trường — Mục 1' => 'Vấn đề thị trường',
        'Lý do chọn SOCCON — 1'     => 'Lý do chọn SOCCON',
        'Giá trị cốt lõi — 1'       => 'Giá trị cốt lõi',
        'Sứ mệnh & Tầm nhìn'        => 'Sứ mệnh & Cam kết',
        'Định hướng phát triển — 1' => 'Định hướng phát triển',
        'CTA cuối trang'             => 'Kêu gọi hành động',
    ];
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
    <div class="bg-amber-50 border border-amber-100 rounded-2xl px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
            <h3 class="font-semibold text-sm text-amber-700">🧴 Trang SOCCON</h3>
        </div>
        <a href="{{ url('/gioi-thieu-hoa-pham-soccon') }}" target="_blank"
           class="text-xs text-gray-400 hover:text-gray-600 flex items-center gap-1 transition">
            Xem trang
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
            </svg>
        </a>
    </div>

    @foreach($groups as $groupName => $fields)

    @if(isset($dividers[$groupName]))
    <div class="flex items-center gap-3 pt-2">
        <div class="h-px flex-1 bg-gray-200"></div>
        <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">
            {{ $dividers[$groupName] }}
        </span>
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
                           || str_contains($key, 'summary') || str_contains($key, 'subtext')
                           || str_contains($key, 'quote') || strlen($value) > 80;
            @endphp
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ $label }}
                    <span class="text-xs text-gray-400 font-mono ml-1">[{{ $key }}]</span>
                </label>
                @if($isTextarea)
                    <textarea name="{{ $key }}" rows="3"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-400 outline-none text-sm resize-y">{{ $value }}</textarea>
                @else
                    <input type="text" name="{{ $key }}" value="{{ $value }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-400 outline-none text-sm">
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