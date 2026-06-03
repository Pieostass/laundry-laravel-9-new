@extends('layouts.admin')
@section('title', $post ? 'Sửa bài viết' : 'Viết bài mới')
@section('page-title', $post ? '✏️ Sửa bài viết' : '✏️ Viết bài mới')

@push('head')
{{-- TinyMCE CDN --}}
<script src="https://cdn.tiny.cloud/1/ft578rqxuzkkd4h3rqbcxn4li6etiqds5jmqb4b956pe6xx9/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<style>
    .field-label { display:block; font-size:13px; font-weight:500; color:#374151; margin-bottom:6px; }
    .field-input  { width:100%; padding:10px 14px; border:1px solid #e5e7eb; border-radius:10px; font-size:14px;
                    outline:none; transition: border-color .15s, box-shadow .15s; background:#fff; color:#111827; }
    .field-input:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.12); }
    .field-error  { font-size:12px; color:#ef4444; margin-top:4px; }
    .tox-tinymce  { border-radius:10px !important; border-color:#e5e7eb !important; }
    #char-count   { font-size:12px; color:#9ca3af; text-align:right; margin-top:4px; }
    /* Sticky sidebar */
    @media(min-width:1024px){ .sidebar-sticky { position:sticky; top:80px; } }
</style>
@endpush

@section('content')

<form method="POST"
      action="{{ $post ? route('admin.posts.update', $post->id) : route('admin.posts.store') }}"
      enctype="multipart/form-data"
      id="post-form">
    @csrf
    @if($post) @method('PUT') @endif

    <div class="flex flex-col lg:flex-row gap-6 items-start">

        {{-- ── MAIN COLUMN ─────────────────────────────────────────────────── --}}
        <div class="flex-1 space-y-5">

            {{-- Flash / Validation errors --}}
            @if($errors->any())
            <div class="px-5 py-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                <p class="font-semibold mb-1">⚠️ Vui lòng kiểm tra lại:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                </ul>
            </div>
            @endif

            {{-- Title --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <label class="field-label" for="title">Tiêu đề bài viết <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" class="field-input text-lg font-medium"
                       value="{{ old('title', $post?->title) }}"
                       placeholder="Nhập tiêu đề hấp dẫn..."
                       oninput="updateCharCount(this,'title-count',255)">
                <div id="title-count" class="flex justify-end text-xs text-gray-400 mt-1">
                    <span id="title-len">{{ strlen(old('title', $post?->title ?? '')) }}</span>/255
                </div>
                @error('title')<p class="field-error">{{ $message }}</p>@enderror
            </div>

            {{-- Excerpt --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <label class="field-label" for="excerpt">Mô tả ngắn (excerpt)</label>
                <textarea id="excerpt" name="excerpt" rows="3" class="field-input resize-none"
                          placeholder="Mô tả ngắn hiển thị ở trang danh sách và SEO (tối đa 500 ký tự)..."
                          maxlength="500"
                          oninput="updateCharCount(this,'excerpt-count',500)">{{ old('excerpt', $post?->excerpt) }}</textarea>
                <div id="excerpt-count" class="flex justify-between text-xs text-gray-400 mt-1">
                    <span class="text-gray-400">Hiển thị dưới tiêu đề & dùng cho meta description</span>
                    <span><span id="excerpt-len">{{ strlen(old('excerpt', $post?->excerpt ?? '')) }}</span>/500</span>
                </div>
                @error('excerpt')<p class="field-error">{{ $message }}</p>@enderror
            </div>

            {{-- TinyMCE Content --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <label class="field-label" for="content">Nội dung bài viết <span class="text-red-500">*</span></label>
                <textarea id="content" name="content">{{ old('content', $post?->content) }}</textarea>
                @error('content')<p class="field-error mt-2">{{ $message }}</p>@enderror
            </div>

            {{-- SEO Section --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0016.803 15.803z"/></svg>
                    SEO & Meta
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="field-label" for="meta_title">Meta Title</label>
                        <input type="text" id="meta_title" name="meta_title" class="field-input"
                               value="{{ old('meta_title', $post?->meta_title) }}"
                               placeholder="Bỏ trống để dùng tiêu đề bài viết" maxlength="255">
                    </div>
                    <div>
                        <label class="field-label" for="meta_desc">Meta Description</label>
                        <textarea id="meta_desc" name="meta_desc" rows="2" class="field-input resize-none"
                                  placeholder="Bỏ trống để dùng excerpt" maxlength="300">{{ old('meta_desc', $post?->meta_desc) }}</textarea>
                    </div>
                </div>

                {{-- SEO Preview --}}
                <div class="mt-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <p class="text-xs font-medium text-gray-500 mb-2 uppercase tracking-wider">Xem trước Google</p>
                    <p id="seo-title" class="text-blue-700 text-base font-medium leading-tight truncate">{{ $post?->meta_title ?? $post?->title ?? 'Tiêu đề bài viết...' }}</p>
                    <p class="text-green-700 text-xs mt-0.5">/tin-tuc/{{ $post?->slug ?? 'duong-dan-bai-viet' }}</p>
                    <p id="seo-desc" class="text-gray-600 text-sm mt-0.5 line-clamp-2">{{ $post?->meta_desc ?? $post?->excerpt ?? 'Mô tả ngắn sẽ hiển thị ở đây...' }}</p>
                </div>
            </div>

        </div>

        {{-- ── SIDEBAR ──────────────────────────────────────────────────────── --}}
        <div class="w-full lg:w-80 sidebar-sticky space-y-5">

            {{-- Publish box --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Xuất bản</h3>

                <div class="mb-4">
                    <label class="field-label" for="status">Trạng thái</label>
                    <select id="status" name="status" class="field-input">
                        <option value="draft"     {{ old('status', $post?->status) === 'draft'     ? 'selected' : '' }}>✏️ Nháp</option>
                        <option value="published" {{ old('status', $post?->status) === 'published' ? 'selected' : '' }}>✅ Đăng ngay</option>
                        <option value="archived"  {{ old('status', $post?->status) === 'archived'  ? 'selected' : '' }}>📦 Lưu trữ</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="field-label" for="published_at">Ngày đăng</label>
                    <input type="datetime-local" id="published_at" name="published_at" class="field-input"
                           value="{{ old('published_at', $post?->published_at?->format('Y-m-d\TH:i') ?? now()->format('Y-m-d\TH:i')) }}">
                </div>

                <div class="mb-5">
                    <label class="field-label" for="read_time">Thời gian đọc (phút)</label>
                    <input type="number" id="read_time" name="read_time" class="field-input"
                           value="{{ old('read_time', $post?->read_time ?? 5) }}" min="1" max="120">
                </div>

                <div class="flex gap-3 pt-1">
                    <a href="{{ route('admin.posts') }}"
                       class="flex-1 px-4 py-2.5 text-center text-sm text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                        Hủy
                    </a>
                    <button type="submit"
                            class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/></svg>
                        {{ $post ? 'Lưu thay đổi' : 'Đăng bài' }}
                    </button>
                </div>
            </div>

            {{-- Category & Tags --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Phân loại</h3>

                <div class="mb-4">
                    <label class="field-label" for="category">Danh mục</label>
                    <select id="category" name="category" class="field-input">
                        <option value="">— Chọn danh mục —</option>
                        @php
                            $cats = ['san-pham' => 'Sản phẩm', 'khuyen-mai' => 'Khuyến mãi', 'kien-thuc' => 'Kiến thức', 'cong-ty' => 'Công ty', 'tin-tuc' => 'Tin tức'];
                        @endphp
                        @foreach($cats as $val => $label)
                        <option value="{{ $val }}" {{ old('category', $post?->category) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="field-label" for="tags">Tags</label>
                    <input type="text" id="tags" name="tags" class="field-input"
                           value="{{ old('tags', is_array($post?->tags) ? implode(', ', $post->tags) : $post?->tags) }}"
                           placeholder="làm sạch, gia đình, soccon">
                    <p class="text-xs text-gray-400 mt-1">Cách nhau bằng dấu phẩy (,)</p>
                    @error('tags')<p class="field-error">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Thumbnail --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Ảnh đại diện</h3>

                <div id="thumbnail-preview" class="mb-3 rounded-xl overflow-hidden bg-gray-100 aspect-video flex items-center justify-center">
                    @if($post?->thumbnail)
                        <img src="{{ asset('storage/'.$post->thumbnail) }}" alt="Thumbnail"
                             class="w-full h-full object-cover" id="thumb-img">
                    @else
                        <div id="thumb-placeholder" class="text-center">
                            <svg class="w-8 h-8 text-gray-300 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159M3.75 18h16.5"/></svg>
                            <p class="text-xs text-gray-400">Chưa có ảnh</p>
                        </div>
                    @endif
                </div>

                <label class="block w-full cursor-pointer">
                    <span class="block w-full text-center px-4 py-2.5 border border-dashed border-gray-300 rounded-xl text-sm text-gray-600 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 transition">
                        📁 Chọn ảnh (JPG, PNG, WebP — tối đa 3MB)
                    </span>
                    <input type="file" name="thumbnail" accept="image/*" class="hidden" id="thumbnail-input"
                           onchange="previewThumbnail(this)">
                </label>
                <p class="text-xs text-gray-400 mt-2 text-center">Khuyến nghị: 1200×630px, tỷ lệ 16:9</p>
                @error('thumbnail')<p class="field-error">{{ $message }}</p>@enderror
            </div>

            {{-- Quick info (edit mode) --}}
            @if($post)
            <div class="bg-gray-50 rounded-2xl border border-gray-200 p-4 text-xs text-gray-500 space-y-2">
                <div class="flex justify-between"><span>ID</span><span class="font-mono">#{{ $post->id }}</span></div>
                <div class="flex justify-between"><span>Slug</span><span class="font-mono text-right max-w-[180px] truncate">{{ $post->slug }}</span></div>
                <div class="flex justify-between"><span>Lượt xem</span><span>{{ number_format($post->views ?? 0) }}</span></div>
                <div class="flex justify-between"><span>Tạo lúc</span><span>{{ $post->created_at->format('d/m/Y H:i') }}</span></div>
                @if($post->author)
                <div class="flex justify-between"><span>Tác giả</span><span>{{ $post->author->full_name }}</span></div>
                @endif
            </div>
            @endif

        </div>{{-- end sidebar --}}
    </div>
</form>

@push('scripts')
<script>
// ── TinyMCE Init ───────────────────────────────────────────────────────────────
tinymce.init({
    selector: '#content',
    language: 'vi',
    height: 520,
    menubar: 'file edit view insert format tools table',
    plugins: [
        'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists',
        'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
        'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed',
        'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste',
        'advtable', 'advcode', 'advtemplate', 'typography', 'inlinecss',
        'importword', 'exportword', 'exportpdf', 'image', 'fullscreen',
        'preview', 'autosave'
    ],
    toolbar: [
        'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor',
        'alignleft aligncenter alignright alignjustify | bullist numlist checklist outdent indent | link image media table | codesample emoticons | removeformat fullscreen'
    ],
    toolbar_mode: 'wrap',
    content_style: `
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 15px; color: #1f2937; line-height: 1.8; max-width: 100%; padding: 16px; }
        img  { max-width: 100%; height: auto; border-radius: 8px; }
        blockquote { border-left: 3px solid #8B7355; padding: 12px 20px; background: #f9f7f3; margin: 24px 0; border-radius: 0 8px 8px 0; font-style: italic; color: #6b7280; }
        h2,h3 { color: #111827; }
        pre   { background: #1e1e2e; color: #cdd6f4; padding: 16px; border-radius: 8px; overflow-x: auto; }
    `,
    images_upload_url: '{{ route("admin.upload.image") }}',
    images_upload_handler: function(blobInfo, progress) {
        return new Promise((resolve, reject) => {
            const fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            fd.append('file', blobInfo.blob(), blobInfo.filename());
            fetch('{{ route("admin.upload.image") }}', { method: 'POST', body: fd })
                .then(r => r.json())
                .then(data => { if(data.location) resolve(data.location); else reject(data.error || 'Upload failed'); })
                .catch(() => reject('Upload error'));
        });
    },
    autosave_ask_before_unload: true,
    autosave_interval: '30s',
    autosave_prefix: 'tinymce-autosave-{path}-{query}-{id}-',
    autosave_restore_when_empty: false,
    setup: function(editor) {
        editor.on('change', function() { editor.save(); });
        editor.on('wordCountUpdate', function(e) {
            const el = document.getElementById('word-count');
            if(el) el.textContent = e.wordCount.words + ' từ';
        });
    }
});

// ── Thumbnail preview ──────────────────────────────────────────────────────────
function previewThumbnail(input) {
    if (!input.files?.length) return;
    const file = input.files[0];
    if (file.size > 3 * 1024 * 1024) {
        alert('Ảnh không được vượt quá 3MB!');
        input.value = '';
        return;
    }
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('thumbnail-preview');
        preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">`;
    };
    reader.readAsDataURL(file);
}

// ── Character counter ──────────────────────────────────────────────────────────
function updateCharCount(el, countId, max) {
    const lenEl = document.getElementById(el.id + '-len');
    if (lenEl) lenEl.textContent = el.value.length;
}

// ── SEO preview live update ────────────────────────────────────────────────────
document.getElementById('title').addEventListener('input', function() {
    const metaTitle = document.getElementById('meta_title').value || this.value;
    document.getElementById('seo-title').textContent = metaTitle || 'Tiêu đề bài viết...';
});
document.getElementById('meta_title').addEventListener('input', function() {
    document.getElementById('seo-title').textContent = this.value || document.getElementById('title').value || 'Tiêu đề...';
});
document.getElementById('meta_desc').addEventListener('input', function() {
    document.getElementById('seo-desc').textContent = this.value || document.getElementById('excerpt').value || 'Mô tả...';
});
document.getElementById('excerpt').addEventListener('input', function() {
    if (!document.getElementById('meta_desc').value) {
        document.getElementById('seo-desc').textContent = this.value || 'Mô tả...';
    }
});

// ── Confirm delete ─────────────────────────────────────────────────────────────
document.querySelectorAll('[data-confirm]').forEach(btn => {
    btn.addEventListener('click', e => {
        if (!confirm(btn.dataset.confirm)) e.preventDefault();
    });
});
</script>
@endpush

@endsection