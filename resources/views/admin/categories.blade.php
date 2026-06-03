@extends('layouts.admin')
@section('title', 'Danh mục')
@section('page-title', '🗂️ Quản lý danh mục')

@section('content')

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

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Form thêm danh mục mới ──────────────────────────────────── --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-800 mb-4">➕ Thêm danh mục mới</h3>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên danh mục <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="VD: Nước giặt, Nước xả...">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none"
                              placeholder="Mô tả ngắn về danh mục...">{{ old('description') }}</textarea>
                </div>
                <button type="submit"
                        class="w-full px-4 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition">
                    Thêm danh mục
                </button>
            </form>
        </div>
    </div>

    {{-- ── Danh sách danh mục ───────────────────────────────────────── --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 uppercase text-xs border-b border-gray-100">
                            <th class="px-5 py-3 text-left">ID</th>
                            <th class="px-5 py-3 text-left">Tên danh mục</th>
                            <th class="px-5 py-3 text-left">Mô tả</th>
                            <th class="px-5 py-3 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($categories as $cat)
                        <tr class="hover:bg-gray-50 transition" id="row-{{ $cat->id }}">
                            <td class="px-5 py-3 text-gray-500">#{{ $cat->id }}</td>

                            {{-- View mode --}}
                            <td class="px-5 py-3 font-medium text-gray-800 view-mode-{{ $cat->id }}">{{ $cat->name }}</td>
                            <td class="px-5 py-3 text-gray-500 view-mode-{{ $cat->id }}">{{ $cat->description ?? '—' }}</td>

                            {{-- Edit mode (hidden by default) --}}
                            <td colspan="2" class="px-5 py-3 edit-mode-{{ $cat->id }} hidden">
                                <form method="POST" action="{{ route('admin.categories.update', $cat->id) }}" class="flex gap-2 items-start">
                                    @csrf @method('PUT')
                                    <div class="flex-1 space-y-2">
                                        <input type="text" name="name" value="{{ $cat->name }}" required
                                               class="w-full px-3 py-1.5 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                        <input type="text" name="description" value="{{ $cat->description }}"
                                               class="w-full px-3 py-1.5 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                                               placeholder="Mô tả...">
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-medium hover:bg-blue-700">Lưu</button>
                                        <button type="button" onclick="cancelEdit({{ $cat->id }})"
                                                class="px-3 py-1.5 bg-gray-100 text-gray-600 rounded-lg text-xs font-medium hover:bg-gray-200">Huỷ</button>
                                    </div>
                                </form>
                            </td>

                            <td class="px-5 py-3 text-center view-mode-{{ $cat->id }}">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="startEdit({{ $cat->id }})"
                                            class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 text-xs font-medium hover:bg-blue-100 transition">
                                        Sửa
                                    </button>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Xóa danh mục \"{{ $cat->name }}\"?')"
                                                class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100 transition">
                                            Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-gray-400">Chưa có danh mục nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($categories->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $categories->links('vendor.pagination.custom') }}
            </div>
            @endif
        </div>
    </div>

</div>

<script>
function startEdit(id) {
    document.querySelectorAll('.view-mode-' + id).forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.edit-mode-' + id).forEach(el => el.classList.remove('hidden'));
}
function cancelEdit(id) {
    document.querySelectorAll('.view-mode-' + id).forEach(el => el.classList.remove('hidden'));
    document.querySelectorAll('.edit-mode-' + id).forEach(el => el.classList.add('hidden'));
}
</script>

@endsection