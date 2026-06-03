@extends('layouts.admin')
@section('title', 'Quản lý bài viết')
@section('page-title', '📝 Quản lý bài viết')

@section('content')

{{-- Toolbar --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div class="flex items-center gap-3 flex-wrap">
        {{-- Status tabs --}}
        @php $tabBase = 'px-4 py-2 rounded-xl text-sm font-medium transition'; @endphp
        <a href="{{ route('admin.posts', request()->except('status','page')) }}"
           class="{{ $tabBase }} {{ !$currentStatus ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Tất cả
        </a>
        <a href="{{ route('admin.posts', array_merge(request()->except('page'), ['status'=>'published'])) }}"
           class="{{ $tabBase }} {{ $currentStatus==='published' ? 'bg-emerald-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            ✅ Đã đăng <span class="ml-1 opacity-70">({{ $totalPublished }})</span>
        </a>
        <a href="{{ route('admin.posts', array_merge(request()->except('page'), ['status'=>'draft'])) }}"
           class="{{ $tabBase }} {{ $currentStatus==='draft' ? 'bg-yellow-500 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            ✏️ Nháp <span class="ml-1 opacity-70">({{ $totalDraft }})</span>
        </a>
        <a href="{{ route('admin.posts', array_merge(request()->except('page'), ['status'=>'archived'])) }}"
           class="{{ $tabBase }} {{ $currentStatus==='archived' ? 'bg-gray-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            📦 Lưu trữ
        </a>

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.posts') }}" class="flex gap-2">
            @if($currentStatus) <input type="hidden" name="status" value="{{ $currentStatus }}"> @endif
            <input type="text" name="keyword" value="{{ $keyword }}" placeholder="Tìm tiêu đề..."
                   class="px-4 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none w-52">
            <button class="px-4 py-2 bg-gray-100 rounded-xl text-sm hover:bg-gray-200 transition">Tìm</button>
        </form>
    </div>

    <a href="{{ route('admin.posts.create') }}"
       class="px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Viết bài mới
    </a>
</div>

{{-- Flash messages --}}
@if(session('success'))
<div class="mb-4 px-5 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center gap-2">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="mb-4 px-5 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">⚠️ {{ session('error') }}</div>
@endif

{{-- Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 uppercase text-xs border-b border-gray-100">
                    <th class="px-5 py-3 text-left w-16">Ảnh</th>
                    <th class="px-5 py-3 text-left">Tiêu đề</th>
                    <th class="px-5 py-3 text-left">Danh mục</th>
                    <th class="px-5 py-3 text-center">Trạng thái</th>
                    <th class="px-5 py-3 text-center">Lượt xem</th>
                    <th class="px-5 py-3 text-left">Ngày đăng</th>
                    <th class="px-5 py-3 text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($posts as $post)
                <tr class="hover:bg-gray-50 transition">
                    {{-- Thumbnail --}}
                    <td class="px-5 py-3">
                        <div class="w-14 h-10 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                            @if($post->thumbnail)
<img src="{{ $post->thumbnail_src }}" alt="" class="w-full h-full object-cover">                            @else
                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159M3.75 18h16.5"/></svg>
                            @endif
                        </div>
                    </td>

                    {{-- Title --}}
                    <td class="px-5 py-3 max-w-xs">
                        <p class="font-medium text-gray-800 truncate">{{ $post->title }}</p>
                        @if($post->excerpt)
                        <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $post->excerpt }}</p>
                        @endif
                        <p class="text-xs text-gray-300 mt-0.5 font-mono">/tin-tuc/{{ $post->slug }}</p>
                    </td>

                    {{-- Category --}}
                    <td class="px-5 py-3 text-gray-500">{{ $post->category ?? '—' }}</td>

                    {{-- Status --}}
                    <td class="px-5 py-3 text-center">
                        @php
                            $badge = match($post->status) {
                                'published' => 'bg-emerald-100 text-emerald-700',
                                'draft'     => 'bg-yellow-100 text-yellow-700',
                                'archived'  => 'bg-gray-100 text-gray-600',
                                default     => 'bg-gray-100 text-gray-500',
                            };
                            $label = match($post->status) {
                                'published' => 'Đã đăng',
                                'draft'     => 'Nháp',
                                'archived'  => 'Lưu trữ',
                                default     => $post->status,
                            };
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }}">{{ $label }}</span>
                    </td>

                    {{-- Views --}}
                    <td class="px-5 py-3 text-center text-gray-500">
                        {{ number_format($post->views ?? 0) }}
                    </td>

                    {{-- Date --}}
                    <td class="px-5 py-3 text-gray-500 whitespace-nowrap">
                        {{ $post->published_at?->format('d/m/Y') ?? $post->created_at->format('d/m/Y') }}
                    </td>

                    {{-- Actions --}}
                    <td class="px-5 py-3">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('news.show', $post->slug) }}" target="_blank"
                               class="text-gray-400 hover:text-blue-600 transition" title="Xem bài">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                            </a>
                            <a href="{{ route('admin.posts.edit', $post->id) }}"
                               class="text-gray-400 hover:text-blue-600 transition" title="Sửa">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" data-confirm="Xóa bài viết này?"
                                        class="text-gray-400 hover:text-red-500 transition" title="Xóa">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-16 text-center text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        Chưa có bài viết nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $posts->links('vendor.pagination.custom') }}
    </div>
</div>

@endsection
