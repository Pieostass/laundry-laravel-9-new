<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'full_name',
        'phone',
        'address',
        'role',
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Laravel 9 uses $casts property (not casts() method)
    protected $casts = [
        'active' => 'boolean',
        // role stored as plain string - use getRoleObjectAttribute accessor
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)->orderByDesc('created_at');
    }

    // ── Role Accessors ────────────────────────────────────────────────────────

    /**
     * Get role as Role object.
     * Usage: $user->roleObject->label()
     */
    public function getRoleObjectAttribute(): ?Role
    {
        return $this->role ? Role::tryFrom($this->role) : null;
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === Role::ROLE_ADMIN;
    }

    public function isStaff(): bool
    {
        return $this->role === Role::ROLE_STAFF;
    }

    public function isUser(): bool
    {
        return $this->role === Role::ROLE_USER;
    }

    public function isActive(): bool
    {
        return (bool) $this->active;
    }
}
