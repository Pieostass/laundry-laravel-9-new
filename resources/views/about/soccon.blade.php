@extends('layouts.app')
@section('title', 'Hoá Phẩm SOCCON Living Well — ' . ($siteConfig['site_name'] ?? 'LaundryShop'))

@push('styles')
<style>
    [data-reveal] {
        opacity: 0; transform: translateY(20px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    [data-reveal].visible { opacity: 1; transform: translateY(0); }
    .product-card {
        border: 1px solid var(--border);
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        background: #fff;
    }
    .product-card:hover {
        box-shadow: 0 10px 40px rgba(28,25,23,0.09);
        transform: translateY(-4px);
    }
    .value-card { border-left: 2px solid var(--bronze); padding-left: 1.25rem; }
    .insight-bar { background: linear-gradient(135deg, #1C1917 0%, #2d2926 100%); }
    .section-tag {
        font-size: 0.65rem; letter-spacing: 0.3em;
        text-transform: uppercase; color: var(--bronze);
    }
    .tag-pill {
        display: inline-block; font-size: 0.6rem; letter-spacing: 0.15em;
        text-transform: uppercase; padding: 0.25rem 0.7rem;
        background: var(--bronze); color: #FDFCF8;
    }
    .problem-item {
        display: flex; align-items: flex-start; gap: 0.75rem;
        padding: 1rem 1.25rem; border: 1px solid var(--border); background: #fff;
    }
</style>
@endpush

@section('content')

{{-- ── HERO ─────────────────────────────────────────────────────────────── --}}
<section class="relative h-72 lg:h-96 overflow-hidden">
    <img src="/images/intro_soccon.jpg" alt="SOCCON Living Well"
         class="absolute inset-0 w-full h-full object-cover scale-105">
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/30"></div>
    <div class="absolute inset-0 flex items-center">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-12 w-full">
            <p class="section-tag text-white/60 mb-4">Hoá phẩm chuyên dụng</p>
            <h1 class="headline text-4xl lg:text-6xl font-medium text-white leading-tight mb-3">
                {{ $aboutConfig['soccon_hero_title'] ?? 'SOCCON Living Well' }}
            </h1>
            <p class="text-white/60 text-sm tracking-widest uppercase mt-4">
                {{ $aboutConfig['soccon_hero_subtitle'] ?? 'Sạch sâu · Sống lành' }}
            </p>
        </div>
    </div>
</section>

{{-- ── Breadcrumb ────────────────────────────────────────── --}}
<div class="border-b border-border-soft bg-warm-gray">
    <div class="max-w-screen-xl mx-auto px-6 lg:px-12 py-3 flex items-center gap-2
                text-[11px] tracking-wide text-ink-muted">
        <a href="{{ route('home') }}" class="hover:text-bronze transition-colors">Trang chủ</a>
        <span class="opacity-40">/</span>
        <a href="{{ url('/gioi-thieu-cong-ty') }}" class="hover:text-bronze transition-colors">Giới thiệu</a>
        <span class="opacity-40">/</span>
        <span class="text-bronze">Hoá Phẩm SOCCON</span>
    </div>
</div>

{{-- ── § 1  GIỚI THIỆU CHUNG ─────────────────────────────────────────────── --}}
<section class="max-w-screen-xl mx-auto px-6 lg:px-12 py-20 lg:py-28">
    <div class="max-w-3xl" data-reveal>
        <p class="section-tag mb-5">Giới thiệu chung</p>
        <h2 class="headline text-3xl lg:text-4xl font-medium text-ink leading-tight mb-6">
            {!! nl2br(e($aboutConfig['soccon_intro_heading'] ?? 'Giải pháp làm sạch toàn diện cho gia đình')) !!}
        </h2>
        <p class="text-[13px] text-ink-muted leading-8 mb-5">
            {{ $aboutConfig['soccon_intro_text1'] ?? '' }}
        </p>
        <p class="text-[13px] text-ink-muted leading-8 mb-8">
            {{ $aboutConfig['soccon_intro_text2'] ?? '' }}
        </p>
        <div class="flex flex-col gap-4">
            @foreach([
                ['◎', $aboutConfig['soccon_point1'] ?? 'Làm sạch hiệu quả – loại bỏ nhanh dầu mỡ, vi khuẩn và mùi hôi'],
                ['◉', $aboutConfig['soccon_point2'] ?? 'Tiện lợi & đa năng – tiết kiệm thời gian, phù hợp nhiều bề mặt'],
                ['○', $aboutConfig['soccon_point3'] ?? 'Trải nghiệm dễ chịu – hương thơm tinh tế, không gian thư giãn'],
            ] as $point)
            @if(!empty($point[1]))
            <div class="flex items-start gap-4">
                <span class="text-bronze text-sm flex-shrink-0 mt-0.5">{{ $point[0] }}</span>
                <p class="text-[13px] text-ink-muted leading-relaxed">{{ $point[1] }}</p>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>

{{-- ── § 2  MARKET INSIGHT ───────────────────────────────────────────────── --}}
@php
$problems = [];
for ($i = 1; $i <= 4; $i++) {
    $title = $aboutConfig["soccon_problem{$i}_title"] ?? '';
    $desc  = $aboutConfig["soccon_problem{$i}_desc"]  ?? '';
    if (!empty($title)) $problems[] = [$title, $desc];
}
@endphp

@if(count($problems))
<section class="bg-warm-gray py-20 lg:py-24">
    <div class="max-w-screen-xl mx-auto px-6 lg:px-12">
        <div class="flex flex-col items-center text-center mb-14" data-reveal>
            <p class="section-tag mb-4">Vấn đề thị trường</p>
            <h2 class="headline text-3xl lg:text-4xl font-medium text-ink mb-4">Khoảng trống SOCCON lấp đầy</h2>
            <div class="w-12 h-px bg-bronze"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($problems as $i => $item)
            <div class="problem-item" data-reveal data-delay="{{ $i * 0.1 }}s">
                <span class="text-bronze/40 text-lg font-light flex-shrink-0 mt-0.5">✗</span>
                <div>
                    <p class="text-[12px] font-semibold text-ink mb-1">{{ $item[0] }}</p>
                    <p class="text-[11px] text-ink-muted leading-relaxed">{{ $item[1] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @if(!empty($aboutConfig['soccon_market_summary']))
        <div class="mt-10 bg-bronze/8 border border-bronze/20 px-8 py-6 text-center" data-reveal>
            <p class="text-[13px] text-ink-muted leading-relaxed max-w-2xl mx-auto">
                {!! $aboutConfig['soccon_market_summary'] !!}
            </p>
        </div>
        @endif
    </div>
</section>
@endif

{{-- ── § 3  SẢN PHẨM CHÍNH 

{{-- ── § 4  VÌ SAO CHỌN SOCCON ─────────────────────────────────────────── --}}
@php
$whys = [];
for ($i = 1; $i <= 6; $i++) {
    $title = $aboutConfig["soccon_why{$i}_title"] ?? '';
    $desc  = $aboutConfig["soccon_why{$i}_desc"]  ?? '';
    if (!empty($title)) $whys[] = [$title, $desc];
}
$symbols = ['◎','◉','○','◈','◎','◉'];
@endphp

@if(count($whys))
<section class="insight-bar py-20 lg:py-24">
    <div class="max-w-screen-xl mx-auto px-6 lg:px-12">
        <div class="flex flex-col items-center text-center mb-14" data-reveal>
            <p class="section-tag text-bronze mb-4">Lý do chọn SOCCON</p>
            <h2 class="headline text-3xl lg:text-4xl font-medium text-white mb-4">Vì Sao Chọn SOCCON?</h2>
            <div class="w-12 h-px bg-bronze"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($whys as $i => $why)
            <div class="bg-white/5 border border-white/10 px-6 py-7 hover:bg-white/8 transition-colors"
                 data-reveal data-delay="{{ ($i % 3) * 0.1 }}s">
                <span class="text-bronze text-lg block mb-4">{{ $symbols[$i] ?? '◎' }}</span>
                <h3 class="text-sm font-semibold text-white mb-2 tracking-wide">{{ $why[0] }}</h3>
                <p class="text-[12px] text-white/50 leading-relaxed">{{ $why[1] }}</p>
            </div>
            @endforeach
        </div>
        @if(!empty($aboutConfig['soccon_why_quote']))
        <div class="mt-14 text-center" data-reveal>
            <p class="headline text-xl lg:text-2xl font-medium text-white/40 italic">
                "{{ $aboutConfig['soccon_why_quote'] }}"
            </p>
        </div>
        @endif
    </div>
</section>
@endif

{{-- ── § 5  GIÁ TRỊ CỐT LÕI ───────────────────────────────────────────── --}}
@php
$values = [];
for ($i = 1; $i <= 4; $i++) {
    $title = $aboutConfig["soccon_value{$i}_title"] ?? '';
    $desc  = $aboutConfig["soccon_value{$i}_desc"]  ?? '';
    if (!empty($title)) $values[] = [$title, $desc];
}
@endphp

@if(count($values))
<section class="max-w-screen-xl mx-auto px-6 lg:px-12 py-20 lg:py-28">
    <div class="flex flex-col items-center text-center mb-16" data-reveal>
        <p class="section-tag mb-4">Triết lý thương hiệu</p>
        <h2 class="headline text-3xl lg:text-4xl font-medium text-ink mb-4">Giá Trị Cốt Lõi</h2>
        <div class="w-12 h-px bg-bronze"></div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
        @foreach($values as $i => $val)
        <div class="value-card" data-reveal data-delay="{{ ($i % 2) * 0.12 }}s">
            <h3 class="headline text-xl font-medium text-ink mb-2">{{ $val[0] }}</h3>
            <p class="text-[13px] text-ink-muted leading-7">{{ $val[1] }}</p>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- ── § 6  SỨ MỆNH & TẦM NHÌN + CAM KẾT ─────────────────────────────── --}}
@php
$commits = [];
for ($i = 1; $i <= 4; $i++) {
    $c = $aboutConfig["soccon_commit{$i}"] ?? '';
    if (!empty($c)) $commits[] = $c;
}
@endphp

<section class="bg-warm-gray py-20 lg:py-24">
    <div class="max-w-screen-xl mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="bg-white border border-border-soft p-10" data-reveal>
                <span class="text-bronze text-2xl block mb-6">◎</span>
                <p class="section-tag mb-3">Sứ mệnh</p>
                <h3 class="headline text-2xl font-medium text-ink mb-5">Mang lại cuộc sống<br>sạch hơn mỗi ngày</h3>
                <p class="text-[13px] text-ink-muted leading-8">{{ $aboutConfig['soccon_mission'] ?? '' }}</p>
            </div>
            <div class="bg-bronze text-cream p-10" data-reveal data-delay="0.15s">
                <span class="text-cream/50 text-2xl block mb-6">◉</span>
                <p class="text-[10px] tracking-widest uppercase text-cream/50 mb-3">Tầm nhìn</p>
                <h3 class="headline text-2xl font-medium text-cream mb-5">Thương hiệu chăm sóc<br>gia đình toàn diện</h3>
                <p class="text-[13px] text-cream/70 leading-8">{{ $aboutConfig['soccon_vision'] ?? '' }}</p>
            </div>
        </div>
        @if(count($commits))
        <div class="mt-12 bg-white border border-border-soft p-8 lg:p-10" data-reveal>
            <p class="section-tag mb-5 text-center">Cam kết thương hiệu</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($commits as $cam)
                <div class="flex items-start gap-3">
                    <span class="text-bronze flex-shrink-0 mt-0.5">✦</span>
                    <p class="text-[12px] text-ink-muted leading-relaxed">{{ $cam }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

{{-- ── § 7  ĐỊNH HƯỚNG PHÁT TRIỂN ─────────────────────────────────────── --}}
@php
$futures = [];
for ($i = 1; $i <= 4; $i++) {
    $title = $aboutConfig["soccon_future{$i}_title"] ?? '';
    $desc  = $aboutConfig["soccon_future{$i}_desc"]  ?? '';
    if (!empty($title)) $futures[] = [$title, $desc];
}
@endphp

@if(count($futures))
<section class="max-w-screen-xl mx-auto px-6 lg:px-12 py-20 lg:py-24">
    <div class="max-w-3xl" data-reveal>
        <p class="section-tag mb-5">Tương lai</p>
        <h2 class="headline text-3xl lg:text-4xl font-medium text-ink leading-tight mb-7">
            Định Hướng<br><em>Phát Triển</em>
        </h2>
        <div class="space-y-5">
            @foreach($futures as $i => $dir)
            <div class="flex gap-5">
                <span class="text-bronze/30 text-2xl font-light flex-shrink-0 leading-none mt-1 headline">
                    0{{ $i + 1 }}
                </span>
                <div>
                    <h4 class="text-sm font-semibold text-ink mb-1">{{ $dir[0] }}</h4>
                    <p class="text-[12px] text-ink-muted leading-relaxed">{{ $dir[1] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── § 8  CTA ─────────────────────────────────────────────────────────── --}}
<section class="bg-ink py-20 px-6 text-center" data-reveal>
    <p class="section-tag text-bronze mb-5">Liên hệ & Hợp tác</p>
    <h2 class="headline text-3xl lg:text-4xl font-medium text-white mb-4">
        {{ $aboutConfig['soccon_cta_heading'] ?? 'Trở thành đối tác phân phối SOCCON' }}
    </h2>
    <p class="text-white/50 text-[13px] leading-relaxed max-w-md mx-auto mb-10">
        {{ $aboutConfig['soccon_cta_subtext'] ?? '' }}
    </p>
    <div class="flex flex-wrap justify-center gap-4">
        <a href="{{ route('shop') }}" class="btn-bronze">Mua ngay</a>
        <a href="{{ route('home') }}#contact" class="btn-ghost border border-white/20 text-white
           hover:border-bronze hover:text-bronze">Liên hệ tư vấn</a>
    </div>
    @if(!empty($siteConfig['footer_phone']))
    <p class="text-white/30 text-[11px] tracking-widest uppercase mt-10">
        Hotline: <span class="text-bronze">{{ $siteConfig['footer_phone'] }}</span>
    </p>
    @endif
</section>

@endsection

@push('scripts')
<script>
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.style.transitionDelay = e.target.dataset.delay ?? '0s';
                e.target.classList.add('visible');
                obs.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('[data-reveal]').forEach(el => obs.observe(el));
</script>
@endpush
