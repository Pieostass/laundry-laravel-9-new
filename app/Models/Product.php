<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'image_url',
        'active',
        'category_id',
    ];

    protected $casts = [
        'price'          => 'decimal:2',
        'active'         => 'boolean',
        'stock_quantity' => 'integer',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeSearch($query, ?string $keyword)
    {
        if ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        }
        return $query;
    }

    public function scopeByCategory($query, ?int $categoryId)
    {
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        return $query;
    }

    // ── Helpers ───────────────────────────────────────────────────────────────
public function getImageSrcAttribute(): string
{
    if (empty($this->image_url)) {
        return asset('images/product-placeholder.png');
    }

    if (str_starts_with($this->image_url, 'http')) {
        return $this->image_url;
    }

    return 'https://globalmart24.com/' . $this->image_url;
}  
}