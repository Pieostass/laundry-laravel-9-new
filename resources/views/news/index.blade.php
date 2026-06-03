@extends('layouts.app')

@section('title', 'Tin Tức - Global Partner')

@section('content')

{{-- ── HERO ────────────────────────────────────────────────────── --}}
<section style="padding: 80px 0 48px; background: #F9F7F3; border-bottom: 1px solid #e8e4de;">
    <div style="max-width: 960px; margin: 0 auto; padding: 0 24px; text-align: center;">
        <p style="font-size: 11px; letter-spacing: 0.2em; text-transform: uppercase; color: #9a8f82; margin-bottom: 12px;">Cập nhật mới nhất</p>
        <h1 style="font-family: 'Cormorant Garamond', Georgia, serif; font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 400; color: #28251d; line-height: 1.2; margin-bottom: 16px;">Tin Tức & Góc Chia Sẻ</h1>
        <p style="color: #7a7974; font-size: 1rem; max-width: 520px; margin: 0 auto;">Kiến thức chăm sóc gia đình, thông tin sản phẩm mới và ưu đãi hấp dẫn từ SOCCON & PINKMEE.</p>
    </div>
</section>

{{-- ── FILTER TABS ─────────────────────────────────────────────── --}}
<section style="background: #F9F7F3; padding: 24px 0; border-bottom: 1px solid #e8e4de; position: sticky; top: 64px; z-index: 40;">
    <div style="max-width: 960px; margin: 0 auto; padding: 0 24px; display: flex; gap: 8px; flex-wrap: wrap; align-items: center; justify-content: center;">
        @php
            $cats = [
                'all'        => 'Tất cả',
                'san-pham'   => 'Sản phẩm',
                'khuyen-mai' => 'Khuyến mãi',
                'kien-thuc'  => 'Kiến thức',
                'cong-ty'    => 'Công ty',
            ];
            $current = request('cat', 'all');
        @endphp
        @foreach($cats as $key => $label)
            <a href="{{ route('news.index', array_merge(request()->except('cat', 'page'), $key !== 'all' ? ['cat' => $key] : [])) }}"
               style="display: inline-block; padding: 7px 18px; font-size: 11px; letter-spacing: 0.12em; text-transform: uppercase; border-radius: 999px; text-decoration: none; transition: all 0.18s;
                      {{ $current === $key ? 'background: #8B7355; color: #fff; border: 1px solid #8B7355;' : 'background: transparent; color: #7a7974; border: 1px solid #d4d1ca;' }}">
                {{ $label }}
            </a>
        @endforeach

        {{-- Search --}}
        <form method="GET" action="{{ route('news.index') }}" style="margin-left: auto; display: flex; gap: 8px;">
            @if(request('cat')) <input type="hidden" name="cat" value="{{ request('cat') }}"> @endif
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm..."
                   style="height: 36px; padding: 0 14px; border: 1px solid #d4d1ca; border-radius: 999px; font-size: 13px; color: #28251d; background: #fff; outline: none; width: 180px;">
            <button type="submit" style="height: 36px; padding: 0 16px; background: #8B7355; color: #fff; border: none; border-radius: 999px; font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; cursor: pointer;">Tìm</button>
        </form>
    </div>
</section>

{{-- ── POSTS GRID ──────────────────────────────────────────────── --}}
<section style="background: #F7F6F2; padding: 56px 0 80px;">
    <div style="max-width: 960px; margin: 0 auto; padding: 0 24px;">

        @if($posts->isEmpty())
            <div style="text-align: center; padding: 80px 0; color: #9a8f82;">
                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin: 0 auto 16px; opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                <p style="font-size: 1rem; margin-bottom: 8px; color: #28251d;">Không tìm thấy bài viết nào.</p>
                <a href="{{ route('news.index') }}" style="font-size: 12px; color: #8B7355; text-decoration: underline;">Xem tất cả bài viết</a>
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 28px;">
                @foreach($posts as $post)
                <article style="background: #fff; border-radius: 8px; overflow: hidden; border: 1px solid #e8e4de; transition: box-shadow 0.2s, transform 0.2s; display: flex; flex-direction: column;"
                         onmouseover="this.style.boxShadow='0 8px 24px rgba(0,0,0,0.08)';this.style.transform='translateY(-2px)'"
                         onmouseout="this.style.boxShadow='none';this.style.transform='translateY(0)'">

                    {{-- Thumbnail --}}
                    <a href="{{ route('news.show', $post->slug) }}"
                       style="display: block; height: 200px; overflow: hidden; background: #f0ede8; flex-shrink: 0;">
                        @if($post->thumbnail)
                            <img src="{{ $post->thumbnail_src }}" alt="{{ $post->title }}"
                                 style="width: 100%; height: 100%; object-fit: cover; object-position: center top; transition: transform 0.4s;"
                                 onmouseover="this.style.transform='scale(1.04)'"
                                 onmouseout="this.style.transform='scale(1)'">
                        @else
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #ede9e2;">
                                <svg width="40" height="40" fill="none" stroke="#c4bdb4" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        @endif
                    </a>

                    {{-- Content --}}
                    <div style="padding: 20px; display: flex; flex-direction: column; flex: 1;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                            <span style="font-size: 10px; letter-spacing: 0.15em; text-transform: uppercase; color: #8B7355; font-weight: 500;">{{ $post->category_label }}</span>
                            @if($post->read_time)
                            <span style="color: #d4d1ca;">·</span>
                            <span style="font-size: 11px; color: #9a8f82;">{{ $post->read_time }} phút đọc</span>
                            @endif
                        </div>

                        <h2 style="margin: 0 0 10px; font-size: 1rem; font-weight: 600; line-height: 1.4; color: #28251d;">
                            <a href="{{ route('news.show', $post->slug) }}" style="text-decoration: none; color: inherit;">{{ $post->title }}</a>
                        </h2>

                        @if($post->excerpt)
                        <p style="font-size: 13px; color: #7a7974; line-height: 1.6; margin: 0 0 16px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $post->excerpt }}</p>
                        @endif

                        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: auto;">
                            <span style="font-size: 11px; color: #bab9b4;">{{ $post->published_at?->format('d/m/Y') }}</span>
                            <a href="{{ route('news.show', $post->slug) }}" style="font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; color: #8B7355; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                                Đọc thêm
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($posts->hasPages())
            <div style="margin-top: 48px; display: flex; justify-content: center; gap: 8px; flex-wrap: wrap;">
                @if($posts->onFirstPage())
                    <span style="padding: 8px 16px; border: 1px solid #e8e4de; border-radius: 6px; font-size: 13px; color: #bab9b4;">← Trước</span>
                @else
                    <a href="{{ $posts->previousPageUrl() }}" style="padding: 8px 16px; border: 1px solid #d4d1ca; border-radius: 6px; font-size: 13px; color: #28251d; text-decoration: none;">← Trước</a>
                @endif

                @foreach($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                    @if($page == $posts->currentPage())
                        <span style="padding: 8px 14px; border: 1px solid #8B7355; border-radius: 6px; font-size: 13px; background: #8B7355; color: #fff;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="padding: 8px 14px; border: 1px solid #d4d1ca; border-radius: 6px; font-size: 13px; color: #28251d; text-decoration: none;">{{ $page }}</a>
                    @endif
                @endforeach

                @if($posts->hasMorePages())
                    <a href="{{ $posts->nextPageUrl() }}" style="padding: 8px 16px; border: 1px solid #d4d1ca; border-radius: 6px; font-size: 13px; color: #28251d; text-decoration: none;">Tiếp →</a>
                @else
                    <span style="padding: 8px 16px; border: 1px solid #e8e4de; border-radius: 6px; font-size: 13px; color: #bab9b4;">Tiếp →</span>
                @endif
            </div>
            @endif
        @endif
    </div>
</section>

@endsection