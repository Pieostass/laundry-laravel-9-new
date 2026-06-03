@extends('layouts.app')

@section('title', $post->title . ' - Tin Tức Global Partner')

@section('content')

<article style="background: #F7F6F2; padding: 0 0 80px;">

    {{-- ── HERO ────────────────────────────────────────────────── --}}
    <div style="background: #F9F7F3; border-bottom: 1px solid #e8e4de; padding: 56px 0 48px;">
        <div style="max-width: 720px; margin: 0 auto; padding: 0 24px;">

            <nav style="font-size: 12px; color: #9a8f82; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('home') }}" style="color: #9a8f82; text-decoration: none;">Trang chủ</a>
                <span>›</span>
                <a href="{{ route('news.index') }}" style="color: #9a8f82; text-decoration: none;">Tin tức</a>
                <span>›</span>
                <span style="color: #28251d;">{{ Str::limit($post->title, 40) }}</span>
            </nav>

            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <span style="font-size: 10px; letter-spacing: 0.2em; text-transform: uppercase; color: #8B7355; font-weight: 600; background: #f0ede8; padding: 4px 12px; border-radius: 999px;">{{ $post->category_label }}</span>
                @if($post->read_time)
                <span style="font-size: 12px; color: #9a8f82;">{{ $post->read_time }} phút đọc</span>
                @endif
                <span style="font-size: 12px; color: #bab9b4;">{{ $post->views }} lượt xem</span>
            </div>

            <h1 style="font-family: 'Cormorant Garamond', Georgia, serif; font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 400; color: #28251d; line-height: 1.25; margin: 0 0 16px;">{{ $post->title }}</h1>

            @if($post->excerpt)
            <p style="font-size: 1.05rem; color: #7a7974; line-height: 1.7; margin: 0 0 20px; font-style: italic; border-left: 3px solid #8B7355; padding-left: 16px;">{{ $post->excerpt }}</p>
            @endif

            <div style="display: flex; align-items: center; gap: 12px; font-size: 12px; color: #9a8f82; padding-top: 16px; border-top: 1px solid #e8e4de;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                {{ $post->published_at?->format('d/m/Y') }}
                @if($post->author)
                <span>·</span>
                {{ $post->author->name }}
                @endif
            </div>
        </div>
    </div>

    {{-- ── THUMBNAIL ───────────────────────────────────────────── --}}
    @if($post->thumbnail)
    <div style="max-width: 720px; margin: -1px auto 0; padding: 0 24px;">
        <img src="{{ $post->thumbnail_src }}" alt="{{ $post->title }}"
             style="width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: 0 0 8px 8px;" loading="lazy">
    </div>
    @endif

    {{-- ── CONTENT + SIDEBAR ───────────────────────────────────── --}}
    <div class="news-layout" style="max-width: 1100px; margin: 48px auto 0; padding: 0 24px; display: grid; grid-template-columns: 1fr 280px; gap: 48px; align-items: start;">

        {{-- Content --}}
        <div style="background: #fff; border-radius: 8px; padding: 40px; border: 1px solid #e8e4de;">
            <div class="prose-content" style="color: #28251d; font-size: 1rem; line-height: 1.8;">
                {!! $post->content !!}
            </div>

            @if($post->tags)
            <div style="margin-top: 36px; padding-top: 24px; border-top: 1px solid #e8e4de; display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
                <span style="font-size: 11px; color: #9a8f82; text-transform: uppercase; letter-spacing: 0.1em;">Tags:</span>
                @foreach($post->tags as $tag)
                <a href="{{ route('news.index', ['tag' => $tag]) }}"
                   style="font-size: 11px; padding: 4px 12px; border: 1px solid #d4d1ca; border-radius: 999px; color: #7a7974; text-decoration: none;">{{ $tag }}</a>
                @endforeach
            </div>
            @endif

            <div style="margin-top: 36px; padding-top: 24px; border-top: 1px solid #e8e4de; display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                @if($prevPost)
                <a href="{{ route('news.show', $prevPost->slug) }}" style="text-decoration: none; padding: 16px; background: #F9F7F3; border-radius: 6px; border: 1px solid #e8e4de; display: block;">
                    <p style="font-size: 10px; color: #9a8f82; text-transform: uppercase; letter-spacing: 0.15em; margin: 0 0 6px;">← Bài trước</p>
                    <p style="font-size: 13px; color: #28251d; margin: 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $prevPost->title }}</p>
                </a>
                @else <div></div>
                @endif

                @if($nextPost)
                <a href="{{ route('news.show', $nextPost->slug) }}" style="text-decoration: none; padding: 16px; background: #F9F7F3; border-radius: 6px; border: 1px solid #e8e4de; display: block; text-align: right;">
                    <p style="font-size: 10px; color: #9a8f82; text-transform: uppercase; letter-spacing: 0.15em; margin: 0 0 6px;">Bài tiếp →</p>
                    <p style="font-size: 13px; color: #28251d; margin: 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $nextPost->title }}</p>
                </a>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <aside style="position: sticky; top: 80px;">
            <div style="background: #fff; border-radius: 8px; padding: 24px; border: 1px solid #e8e4de; margin-bottom: 24px;">
                <h3 style="font-size: 11px; letter-spacing: 0.2em; text-transform: uppercase; color: #9a8f82; margin: 0 0 20px; padding-bottom: 12px; border-bottom: 1px solid #e8e4de;">Bài viết mới nhất</h3>
                @foreach($recentPosts as $recent)
                <a href="{{ route('news.show', $recent->slug) }}" style="display: flex; gap: 12px; margin-bottom: 16px; text-decoration: none; align-items: flex-start;">
                    <div style="width: 56px; height: 56px; flex-shrink: 0; border-radius: 6px; overflow: hidden; background: #f0ede8;">
                        @if($recent->thumbnail)
                            <img src="{{ $recent->thumbnail_src }}" alt="{{ $recent->title }}"
 style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                        @else
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <svg width="20" height="20" fill="none" stroke="#c4bdb4" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159M3.75 18h16.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div>
                        <p style="font-size: 13px; color: #28251d; line-height: 1.4; margin: 0 0 4px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $recent->title }}</p>
                        <span style="font-size: 11px; color: #bab9b4;">{{ $recent->published_at?->format('d/m/Y') }}</span>
                    </div>
                </a>
                @endforeach
            </div>

            @if($relatedPosts->count() > 0)
            <div style="background: #fff; border-radius: 8px; padding: 24px; border: 1px solid #e8e4de;">
                <h3 style="font-size: 11px; letter-spacing: 0.2em; text-transform: uppercase; color: #9a8f82; margin: 0 0 20px; padding-bottom: 12px; border-bottom: 1px solid #e8e4de;">Bài liên quan</h3>
                @foreach($relatedPosts as $related)
                <a href="{{ route('news.show', $related->slug) }}" style="display: block; margin-bottom: 12px; text-decoration: none;">
                    <p style="font-size: 13px; color: #28251d; line-height: 1.4; margin: 0 0 4px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $related->title }}</p>
                    <span style="font-size: 11px; color: #bab9b4;">{{ $related->category_label }} · {{ $related->published_at?->format('d/m/Y') }}</span>
                </a>
                @if(!$loop->last)<div style="height: 1px; background: #f0ede8; margin: 12px 0;"></div>@endif
                @endforeach
            </div>
            @endif
        </aside>
    </div>
</article>

<style>
.prose-content h2 { font-family: 'Cormorant Garamond', Georgia, serif; font-size: 1.6rem; font-weight: 400; color: #28251d; margin: 36px 0 16px; line-height: 1.3; }
.prose-content h3 { font-size: 1.15rem; font-weight: 600; color: #28251d; margin: 28px 0 12px; }
.prose-content p  { margin: 0 0 20px; }
.prose-content ul, .prose-content ol { margin: 0 0 20px 20px; }
.prose-content li { margin-bottom: 8px; }
.prose-content blockquote { border-left: 3px solid #8B7355; padding: 12px 20px; margin: 24px 0; background: #f9f7f3; border-radius: 0 6px 6px 0; font-style: italic; color: #7a7974; }
.prose-content img { max-width: 100%; border-radius: 8px; margin: 24px 0; }
.prose-content a { color: #8B7355; }
@media (max-width: 768px) {
    .news-layout { grid-template-columns: 1fr !important; }
    aside { position: static !important; }
}
</style>

@endsection
