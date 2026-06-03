@extends('layouts.app')
@section('title', 'Về Công Ty — ' . ($siteConfig['site_name'] ?? 'LaundryShop'))

@push('styles')
<style>
    [data-reveal] {
        opacity:0; transform:translateY(20px);
        transition:opacity .6s ease,transform .6s ease;
    }
    [data-reveal].visible { opacity:1; transform:translateY(0); }
    .section-tag {
        font-size:.65rem; letter-spacing:.3em;
        text-transform:uppercase; color:var(--bronze);
    }
    .timeline-item { position:relative; padding-left:1.75rem; }
    .timeline-item::before {
        content:''; position:absolute; left:0; top:.45rem;
        width:.5rem; height:.5rem; border-radius:9999px;
        background:var(--bronze);
    }
    .timeline-item::after {
        content:''; position:absolute; left:.22rem; top:1.1rem;
        bottom:-1.5rem; width:1px; background:var(--border);
    }
    .timeline-item:last-child::after { display:none; }
</style>
@endpush

@section('content')

{{-- ── HERO ─────────────────────────────────────────────────────────────── --}}
<section class="relative h-72 lg:h-96 overflow-hidden">
    <img src="/images/intro_company.jpg" alt="Về Công Ty"
         class="absolute inset-0 w-full h-full object-cover scale-105">
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
    <div class="absolute inset-0 flex items-center">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-12 w-full">
            <p class="section-tag text-white/60 mb-4">Về chúng tôi</p>
            <h1 class="headline text-4xl lg:text-6xl font-medium text-white leading-tight mb-3">
                {{ $aboutConfig['about_hero_title'] ?? 'Global Partner' }}
            </h1>
            <p class="text-white/60 text-sm max-w-sm leading-relaxed">
                {{ $aboutConfig['about_hero_subtitle'] ?? 'Đối tác tin cậy trong lĩnh vực hoá phẩm & mỹ phẩm thiên nhiên' }}
            </p>
        </div>
    </div>
</section>

{{-- ── Breadcrumb ───────────────────────────────────────────────────────── --}}
<div class="border-b border-border-soft bg-warm-gray">
    <div class="max-w-screen-xl mx-auto px-6 lg:px-12 py-3 flex items-center gap-2
                text-[11px] tracking-wide text-ink-muted">
        <a href="{{ route('home') }}" class="hover:text-bronze transition-colors">Trang chủ</a>
        <span class="opacity-40">/</span>
        <span class="text-bronze">Về Công Ty</span>
    </div>
</div>

{{-- ── § 1  TỔNG QUAN ───────────────────────────────────────────────────── --}}
<section class="max-w-screen-xl mx-auto px-6 lg:px-12 py-20 lg:py-28">
    <div class="max-w-3xl" data-reveal>
        <p class="section-tag mb-5">Tổng quan</p>
        <h2 class="headline text-3xl lg:text-4xl font-medium text-ink leading-tight mb-6">
            {!! nl2br(e($aboutConfig['about_intro_heading'] ?? 'Công ty TNHH XNK & Thương Mại Global Partner')) !!}
        </h2>
        <p class="text-[13px] text-ink-muted leading-8 mb-5">
            {{ $aboutConfig['about_intro_text1'] ?? '' }}
        </p>
        <p class="text-[13px] text-ink-muted leading-8 mb-8">
            {{ $aboutConfig['about_intro_text2'] ?? '' }}
        </p>
        <div class="flex flex-col gap-3">
            @foreach([
                $aboutConfig['about_point1'] ?? 'Hoạt động hơn 10 năm trong ngành hoá phẩm & mỹ phẩm',
                $aboutConfig['about_point2'] ?? 'Phục vụ hàng nghìn khách hàng trên toàn quốc',
                $aboutConfig['about_point3'] ?? 'Sở hữu 2 thương hiệu: SOCCON Living Well & PINKMEE',
                $aboutConfig['about_point4'] ?? 'Đối tác xuất nhập khẩu uy tín tại nhiều thị trường',
            ] as $p)
            @if(!empty($p))
            <div class="flex items-start gap-3">
                <span class="text-bronze text-xs flex-shrink-0 mt-1">✦</span>
                <p class="text-[13px] text-ink-muted">{{ $p }}</p>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>

{{-- ── § 2  CHỈ SỐ ─────────────────────────────────────────────────────── --}}
<section class="bg-ink py-16">
    <div class="max-w-screen-xl mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            @foreach([
                [$aboutConfig['about_stat1_number'] ?? '10+',    $aboutConfig['about_stat1_label'] ?? 'Năm kinh nghiệm'],
                [$aboutConfig['about_stat2_number'] ?? '5.000+', $aboutConfig['about_stat2_label'] ?? 'Khách hàng'],
                [$aboutConfig['about_stat3_number'] ?? '2',      $aboutConfig['about_stat3_label'] ?? 'Thương hiệu'],
                [$aboutConfig['about_stat4_number'] ?? '99%',    $aboutConfig['about_stat4_label'] ?? 'Hài lòng'],
            ] as $s)
            <div data-reveal>
                <p class="headline text-4xl lg:text-5xl font-medium text-bronze mb-2">{{ $s[0] }}</p>
                <p class="text-[11px] tracking-widest uppercase text-white/40">{{ $s[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── § 3  SỨ MỆNH — TẦM NHÌN — GIÁ TRỊ ─────────────────────────────── --}}
<section class="max-w-screen-xl mx-auto px-6 lg:px-12 py-20 lg:py-28">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach([
            ['◎', 'Sứ mệnh',  $aboutConfig['about_mission'] ?? ''],
            ['◉', 'Tầm nhìn', $aboutConfig['about_vision']  ?? ''],
            ['○', 'Giá trị',  $aboutConfig['about_values']  ?? ''],
        ] as $item)
        @if(!empty($item[2]))
        <div class="bg-warm-gray p-8" data-reveal>
            <span class="text-bronze text-xl block mb-5">{{ $item[0] }}</span>
            <h3 class="headline text-xl font-medium text-ink mb-3">{{ $item[1] }}</h3>
            <p class="text-[13px] text-ink-muted leading-7">{{ $item[2] }}</p>
        </div>
        @endif
        @endforeach
    </div>
</section>

{{-- ── § 4  LỊCH SỬ HÌNH THÀNH ─────────────────────────────────────────── --}}
@php
$timelines = [];
for ($i = 1; $i <= 5; $i++) {
    $year  = $aboutConfig["about_timeline{$i}_year"]  ?? '';
    $title = $aboutConfig["about_timeline{$i}_title"] ?? '';
    $desc  = $aboutConfig["about_timeline{$i}_desc"]  ?? '';
    if (!empty($year) && !empty($title)) {
        $timelines[] = [$year, $title, $desc];
    }
}
@endphp

@if(count($timelines))
<section class="bg-warm-gray py-20 lg:py-28">
    <div class="max-w-screen-xl mx-auto px-6 lg:px-12">
        <div class="flex flex-col items-center text-center mb-16" data-reveal>
            <p class="section-tag mb-4">Hành trình</p>
            <h2 class="headline text-3xl lg:text-4xl font-medium text-ink mb-4">Lịch Sử Hình Thành</h2>
            <div class="w-12 h-px bg-bronze"></div>
        </div>
        <div class="max-w-2xl mx-auto space-y-10">
            @foreach($timelines as $i => $e)
            <div class="timeline-item" data-reveal data-delay="{{ $i * 0.1 }}s">
                <span class="text-[10px] tracking-widest uppercase text-bronze">{{ $e[0] }}</span>
                <h4 class="headline text-base font-medium text-ink mt-1 mb-2">{{ $e[1] }}</h4>
                <p class="text-[13px] text-ink-muted leading-7">{{ $e[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── § 5  HAI THƯƠNG HIỆU ─────────────────────────────────────────────── --}}
<section class="max-w-screen-xl mx-auto px-6 lg:px-12 py-20 lg:py-28">
    <div class="flex flex-col items-center text-center mb-16" data-reveal>
        <p class="section-tag mb-4">Hệ sinh thái</p>
        <h2 class="headline text-3xl font-medium text-ink mb-4">Hai Thương Hiệu Của Chúng Tôi</h2>
        <div class="w-12 h-px bg-bronze"></div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <a href="{{ url('/gioi-thieu-hoa-pham-soccon') }}"
           class="group border border-border p-10 hover:border-bronze transition-colors block">
            <div class="flex items-center gap-4 mb-6">
                <img src="/images/soccon_logo.png" alt="SOCCON" class="h-8 w-auto"
                     onerror="this.outerHTML='<span class=\'headline text-2xl font-medium text-bronze\'>SOCCON</span>'">
                <span class="text-[10px] tracking-widest uppercase text-ink-muted/60">Living Well</span>
            </div>
            <p class="text-[13px] text-ink-muted leading-7 mb-6">
                {{ $aboutConfig['about_brand_soccon_desc'] ?? 'Dòng hoá phẩm giặt tẩy & vệ sinh gia đình chuyên dụng — làm sạch mạnh mẽ, hương thơm dễ chịu, an toàn cho cả gia đình.' }}
            </p>
            <span class="text-[11px] tracking-widest uppercase text-bronze flex items-center gap-2 group-hover:gap-4 transition-all">
                Tìm hiểu thêm <span>→</span>
            </span>
        </a>
        <a href="{{ url('/gioi-thieu-my-pham-pinkmee') }}"
           class="group border border-border p-10 hover:border-bronze transition-colors block">
            <div class="flex items-center gap-4 mb-6">
                <img src="/images/pinkmee_logo.png" alt="PINKMEE" class="h-8 w-auto"
                     onerror="this.outerHTML='<span class=\'headline text-2xl font-medium text-bronze\'>PINKMEE</span>'">
                <span class="text-[10px] tracking-widest uppercase text-ink-muted/60">Natural Beauty</span>
            </div>
            <p class="text-[13px] text-ink-muted leading-7 mb-6">
                {{ $aboutConfig['about_brand_pinkmee_desc'] ?? 'Bộ sưu tập mỹ phẩm thiên nhiên thuần chay — chăm sóc da & tóc từ nguyên liệu tự nhiên, lành tính và bền vững với môi trường.' }}
            </p>
            <span class="text-[11px] tracking-widest uppercase text-bronze flex items-center gap-2 group-hover:gap-4 transition-all">
                Tìm hiểu thêm <span>→</span>
            </span>
        </a>
    </div>
</section>

{{-- ── CTA ──────────────────────────────────────────────────────────────── --}}
<section class="bg-warm-gray py-20 text-center" data-reveal>
    <p class="section-tag mb-4">Hợp tác</p>
    <h2 class="headline text-3xl font-medium text-ink mb-8">Bắt đầu hành trình cùng chúng tôi</h2>
    <div class="flex flex-wrap justify-center gap-4">
        <a href="{{ route('shop') }}"         class="btn-bronze">Xem sản phẩm</a>
        <a href="{{ route('home') }}#contact" class="btn-ghost">Liên hệ ngay</a>
    </div>
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