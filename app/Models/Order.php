<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'address',
        'note',
        'status',
        'total_price',
    ];

    // Laravel 9 uses $casts property (not casts() method)
    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeByStatus($query, ?string $status)
    {
        if ($status) {
            $query->where('status', $status);
        }
        return $query;
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Get the status as an OrderStatus object.
     * Replaces the enum cast from Laravel 10+.
     */
    public function getStatusObjectAttribute(): ?OrderStatus
    {
        return $this->status ? OrderStatus::tryFrom($this->status) : null;
    }

    /** Convenience: badge Tailwind class for order status */
    public function getStatusBadgeClassAttribute(): string
    {
        $statusObj = OrderStatus::tryFrom($this->status ?? '');
        return $statusObj ? $statusObj->badgeClass() : 'bg-gray-100 text-gray-800';
    }

    /** Human-readable Vietnamese label */
    public function getStatusLabelAttribute(): string
    {
        $statusObj = OrderStatus::tryFrom($this->status ?? '');
        return $statusObj ? $statusObj->label() : ($this->status ?? '');
    }
}
