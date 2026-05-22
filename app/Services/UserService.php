<?php

namespace App\Services;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Mirrors Java UserServiceImpl.
 */
class UserService
{
    // ── register ──────────────────────────────────────────────────────────────

    public function register(array $data): User
    {
        if (User::where('username', $data['username'])->exists()) {
            throw ValidationException::withMessages([
                'username' => 'Tên đăng nhập đã tồn tại!',
            ]);
        }

        if (User::where('email', $data['email'])->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Email đã được sử dụng!',
            ]);
        }

        return User::create([
            'username'  => $data['username'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'full_name' => $data['full_name'],
            'phone'     => $data['phone'] ?? null,
            'role'      => Role::ROLE_USER,  // string constant
            'active'    => true,
        ]);
    }

    // ── findByUsername ────────────────────────────────────────────────────────

    public function findByUsername(string $username): User
    {
        return User::where('username', $username)->firstOrFail();
    }

    // ── findAll ───────────────────────────────────────────────────────────────

    public function findAll(): Collection
    {
        return User::orderByDesc('created_at')->get();
    }

    // ── toggleUserEnabled ─────────────────────────────────────────────────────

    public function toggleUserEnabled(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->update(['active' => !$user->active]);
    }

    // ── updateProfile ─────────────────────────────────────────────────────────

    public function updateProfile(string $username, array $data): User
    {
        $user = $this->findByUsername($username);
        $user->update(array_filter([
            'full_name' => $data['full_name'] ?? null,
            'phone'     => $data['phone'] ?? null,
            'email'     => $data['email'] ?? null,
            'address'   => $data['address'] ?? null,
        ], fn($v) => $v !== null));

        return $user->fresh();
    }

    // ── changePassword ────────────────────────────────────────────────────────

    public function changePassword(User $user, string $newPassword): void
    {
        $user->update(['password' => Hash::make($newPassword)]);
    }
}
