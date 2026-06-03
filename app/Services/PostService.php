<?php
namespace App\Services;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
class PostService
{
    public function findAllPaged(int $perPage = 15, ?string $status = null, ?string $keyword = null): LengthAwarePaginator
    {
        return Post::query()
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($keyword, fn($q) => $q->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('excerpt', 'like', "%{$keyword}%");
            }))
            ->latest('published_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(int $id): Post
    {
        return Post::findOrFail($id);
    }

    public function save(array $data, $thumbnail = null): Post
    {
        $data['slug']      = $this->uniqueSlug($data['title']);
        $data['author_id'] = auth()->id();
        $data['status']    = $data['status'] ?? 'draft';

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if ($thumbnail) {
            $data['thumbnail'] = $this->storeThumbnail($thumbnail);
        }

        if (!empty($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags'])));
        }

        return Post::create($data);
    }

    public function update(int $id, array $data, $thumbnail = null): Post
    {
        $post = $this->findById($id);

        if ($thumbnail) {
            // Xóa ảnh cũ nếu là file local
            if ($post->thumbnail && !str_starts_with($post->thumbnail, 'http')) {
                $oldPath = '/home/anhnguyen/domains/globalmart24.com/public_html/'
                           . $post->thumbnail;
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $data['thumbnail'] = $this->storeThumbnail($thumbnail);
        }

        if ($data['status'] === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        if (!empty($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags'])));
        }

        $post->update($data);
        return $post->fresh();
    }

    public function delete(int $id): void
    {
        $post = $this->findById($id);

        // Xóa ảnh cũ nếu là file local
        if ($post->thumbnail && !str_starts_with($post->thumbnail, 'http')) {
            $oldPath = '/home/anhnguyen/domains/globalmart24.com/public_html/'
                       . $post->thumbnail;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $post->delete();
    }

    public function countByStatus(string $status): int
    {
        return Post::where('status', $status)->count();
    }

    // ── Private ───────────────────────────────────────────────────────────────

    private function storeThumbnail($file): string
    {
        $filename  = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $directory = '/home/anhnguyen/domains/globalmart24.com/public_html/uploads/posts';

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $file->move($directory, $filename);

        return 'uploads/posts/' . $filename;
    }

    private function uniqueSlug(string $title): string
    {
        $slug  = Str::slug($title);
        $count = Post::where('slug', 'like', "{$slug}%")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }
}