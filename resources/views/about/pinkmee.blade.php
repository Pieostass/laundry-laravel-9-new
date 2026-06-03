@extends('layouts.app')
@section('title', 'Mỹ Phẩm PINKMEE — ' . ($siteConfig['site_name'] ?? 'LaundryShop'))

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
    .product-card {
        border:1px solid var(--border); background:#fff;
        transition:box-shadow .3s,transform .3s;
    }
    .product-card:hover {
        box-shadow:0 10px 40px rgba(28,25,23,.09);
        transform:translateY(-4px);
    }
    .ingredient-tag {
        display:inline-block; font-size:.6rem; letter-spacing:.1em;
        text-transform:uppercase; border:1px solid var(--border);
        padding:.2rem .7rem; color:var(--ink-muted);
    }
</style>
@endpush

@section('content')

{{-- ── HERO ─────────────────────────────────────────────────────────────── --}}
<section class="relative h-72 lg:h-96 overflow-hidden">
    <img src="/images/intro_pinkmee.jpg" alt="PINKMEE"
         class="absolute inset-0 w-full h-full object-cover scale-105">
    <div class="absolute inset-0 bg-gradient-to-r from-black/65 via-black/45 to-transparent"></div>
    <div class="absolute inset-0 flex items-center">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-12 w-full">
            <p class="section-tag text-white/60 mb-4">Mỹ phẩm thiên nhiên</p>
            <h1 class="headline text-4xl lg:text-6xl font-medium text-white leading-tight mb-3">
                {{ $aboutConfig['pinkmee_hero_title'] ?? 'PINKMEE' }}
            </h1>
            <p class="text-white/60 text-sm mt-2">
                {{ $aboutConfig['pinkmee_hero_subtitle'] ?? 'Natural Beauty — Vẻ đẹp thuần khiết từ thiên nhiên' }}
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
        <a href="{{ url('/gioi-thieu-cong-ty') }}" class="hover:text-bronze transition-colors">Giới thiệu</a>
        <span class="opacity-40">/</span>
        <span class="text-bronze">Mỹ Phẩm PINKMEE</span>
    </div>
</div>

{{-- ── § 1  TỔNG QUAN ───────────────────────────────────────────────────── --}}
<section class="max-w-screen-xl mx-auto px-6 lg:px-12 py-20 lg:py-28">
    <div class="max-w-3xl" data-reveal>
        <p class="section-tag mb-5">Thương hiệu</p>
        <h2 class="headline text-3xl lg:text-4xl font-medium text-ink leading-tight mb-6">
            {!! nl2br(e($aboutConfig['pinkmee_intro_heading'] ?? "PINKMEE —\nVẻ đẹp bền vững từ thiên nhiên")) !!}
        </h2>
        <p class="text-[13px] text-ink-muted leading-8 mb-5">
            {{ $aboutConfig['pinkmee_intro_text1'] ?? 'PINKMEE là thương hiệu mỹ phẩm thiên nhiên thuần chay được phát triển bởi Global Partner, hướng đến phụ nữ hiện đại yêu thích lối sống lành mạnh và bền vững.' }}
        </p>
        <p class="text-[13px] text-ink-muted leading-8 mb-8">
            {{ $aboutConfig['pinkmee_intro_text2'] ?? 'Mỗi sản phẩm PINKMEE được chiết xuất từ các nguyên liệu tự nhiên, không chứa paraben, không thử nghiệm trên động vật và thân thiện với môi trường.' }}
        </p>
        <div class="flex flex-wrap gap-2 mb-8">
            @foreach(['Thuần chay (Vegan)', 'Không paraben', 'Không thử nghiệm động vật', 'Nguyên liệu tự nhiên', 'Thân thiện môi trường'] as $tag)
            <span class="ingredient-tag">{{ $tag }}</span>
            @endforeach
        </div>
        <a href="{{ route('shop') }}?brand=pinkmee" class="btn-bronze">Khám phá PINKMEE</a>
    </div>
</section>

{{-- ── § 2  GIÁ TRỊ CỐT LÕI ────────────────────────────────────────────── --}}
<section class="bg-warm-gray py-20 lg:py-24">
    <div class="max-w-screen-xl mx-auto px-6 lg:px-12">
        <div class="flex flex-col items-center text-center mb-14" data-reveal>
            <p class="section-tag mb-4">Triết lý</p>
            <h2 class="headline text-3xl font-medium text-ink mb-4">Vì Sao Chọn PINKMEE?</h2>
            <div class="w-12 h-px bg-bronze"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['🌿', 'Thuần thiên nhiên',  'Chiết xuất từ thực vật, hoa và khoáng chất tự nhiên — không hoá chất độc hại.'],
                ['🛡️', 'An toàn tuyệt đối', 'Kiểm định bởi các tổ chức uy tín, phù hợp mọi loại da kể cả da nhạy cảm.'],
                ['♻️', 'Bền vững',           'Bao bì tái chế, quy trình sản xuất giảm thiểu carbon — đẹp có trách nhiệm.'],
                ['✨', 'Hiệu quả thật sự',   'Kết quả nhìn thấy sau 4 tuần sử dụng liên tục — không chỉ là lời hứa.'],
            ] as $i => $v)
            <div class="bg-white border border-border-soft p-7 text-center" data-reveal data-delay="{{ $i * 0.1 }}s">
                <span class="text-3xl block mb-4">{{ $v[0] }}</span>
                <h3 class="text-sm font-semibold text-ink mb-2">{{ $v[1] }}</h3>
                <p class="text-[12px] text-ink-muted leading-relaxed">{{ $v[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>



{{-- ── § 4  THÀNH PHẦN & CAM KẾT ────────────────────────────────────────── --}}
<section class="bg-ink py-20 lg:py-24">
    <div class="max-w-screen-xl mx-auto px-6 lg:px-12">
        <div class="max-w-3xl" data-reveal>
            <p class="section-tag mb-5">Nguyên liệu</p>
            <h2 class="headline text-3xl font-medium text-white mb-6">
                Thành Phần Được<br>
                <em class="text-bronze/80">Chọn Lọc Kỹ Càng</em>
            </h2>
            <p class="text-[13px] text-white/50 leading-8 mb-8">
                {{ $aboutConfig['pinkmee_mission'] ?? 'Mỗi thành phần trong sản phẩm PINKMEE đều được kiểm định nghiêm ngặt, đảm bảo nguồn gốc rõ ràng và tác động tích cực đến làn da của bạn.' }}
            </p>
            <div class="grid grid-cols-2 gap-4">
                @foreach([
                    ['Hoa hồng Bulgaria', '0% Paraben'],
                    ['Nha đam hữu cơ',    '0% Sulfate'],
                    ['Tinh dầu tự nhiên', '0% Silicon'],
                    ['Bơ hạt mỡ',         '0% Hương nhân tạo'],
                ] as $ing)
                <div class="bg-white/5 border border-white/10 px-4 py-4">
                    <p class="text-[11px] text-white/70 font-medium">{{ $ing[0] }}</p>
                    <p class="text-[10px] text-bronze/70 mt-1 tracking-wide">{{ $ing[1] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ── CTA ──────────────────────────────────────────────────────────────── --}}
<section class="py-20 px-6 text-center bg-warm-gray" data-reveal>
    <p class="section-tag mb-4">Trải nghiệm</p>
    <h2 class="headline text-3xl font-medium text-ink mb-6">
        Khám phá vẻ đẹp thiên nhiên cùng PINKMEE
    </h2>
    <div class="flex flex-wrap justify-center gap-4 mt-8">
        <a href="{{ route('shop') }}?brand=pinkmee" class="btn-bronze">Mua ngay</a>
        <a href="{{ route('home') }}#contact"       class="btn-ghost">Tư vấn miễn phí</a>
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
