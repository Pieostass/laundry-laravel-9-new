<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'category',
        'tags',
        'status',
        'published_at',
        'read_time',
        'views',
        'author_id',   // sửa từ user_id → author_id cho khớp PostService
        
    ];

    protected $casts = [
        'tags'         => 'array',
        'published_at' => 'datetime',
    ];

    // ── Category labels ──────────────────────────────────────────────
    public const CATEGORY_LABELS = [
        'san-pham'   => 'Sản phẩm',
        'khuyen-mai' => 'Khuyến mãi',
        'kien-thuc'  => 'Kiến thức',
        'cong-ty'    => 'Công ty',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORY_LABELS[$this->category] ?? 'Tin tức';
    }

    // ── Thumbnail accessor ───────────────────────────────────────────
    public function getThumbnailSrcAttribute(): string
    {
        if (empty($this->thumbnail)) {
            return asset('images/post-placeholder.png');
        }

        // Là link ngoài (http/https) → dùng trực tiếp
        if (str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }

        // Là file local → trỏ vào public_html
        return 'https://globalmart24.com/' . $this->thumbnail;
    }

    // ── Relations ────────────────────────────────────────────────────
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // ── Scopes ───────────────────────────────────────────────────────
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}