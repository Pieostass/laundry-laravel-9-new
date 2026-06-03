<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Danh sách bài viết — có filter theo category, tag, search
     */
    public function index(Request $request)
    {
        $query = Post::query()
            ->where('is_published', true)
            ->latest('published_at');

        // Filter theo category
        if ($request->filled('cat') && $request->cat !== 'all') {
            $query->where('category', $request->cat);
        }

        // Filter theo tag
        if ($request->filled('tag')) {
            $query->whereJsonContains('tags', $request->tag);
        }

        // Tìm kiếm theo tiêu đề / excerpt
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('excerpt', 'like', "%{$q}%");
            });
        }

        $posts = $query->paginate(9)->withQueryString();

        return view('news.index', compact('posts'));
    }

    /**
     * Chi tiết bài viết
     */
    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Tăng lượt xem
        $post->increment('views');

        // Bài viết mới nhất cho sidebar (trừ bài hiện tại)
        $recentPosts = Post::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        // Bài liên quan (cùng category, trừ bài hiện tại)
        $relatedPosts = Post::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        // Nếu không đủ 3 bài cùng category, lấy thêm bài mới nhất bù vào
        if ($relatedPosts->count() < 3) {
            $existingIds = $relatedPosts->pluck('id')->push($post->id);
            $extra = Post::where('is_published', true)
                ->whereNotIn('id', $existingIds)
                ->latest('published_at')
                ->take(3 - $relatedPosts->count())
                ->get();
            $relatedPosts = $relatedPosts->merge($extra);
        }

        // Điều hướng bài trước / bài sau
        $prevPost = Post::where('is_published', true)
            ->where('published_at', '<', $post->published_at)
            ->latest('published_at')
            ->first();

        $nextPost = Post::where('is_published', true)
            ->where('published_at', '>', $post->published_at)
            ->oldest('published_at')
            ->first();

        return view('news.show', compact(
            'post',
            'recentPosts',
            'relatedPosts',
            'prevPost',
            'nextPost'
        ));
    }
}
