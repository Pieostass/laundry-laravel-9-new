<?php

namespace App\Enums;

/**
 * PHP 8.0 compatible replacement for backed enum.
 * Mirrors Java: com.laundryshop.enums.Role
 * Stored as string in DB column 'role'.
 */
class Role
{
    public const ROLE_USER  = 'ROLE_USER';
    public const ROLE_STAFF = 'ROLE_STAFF';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    public string $value;
    public string $name;

    private static array $instances = [];

    private function __construct(string $value)
    {
        $this->value = $value;
        $this->name  = $value;
    }

    public static function from(string $value): self
    {
        $valid = [self::ROLE_USER, self::ROLE_STAFF, self::ROLE_ADMIN];
        if (!in_array($value, $valid, true)) {
            throw new \ValueError("{$value} is not a valid Role");
        }
        if (!isset(self::$instances[$value])) {
            self::$instances[$value] = new self($value);
        }
        return self::$instances[$value];
    }

    public static function tryFrom(string $value): ?self
    {
        try {
            return self::from($value);
        } catch (\ValueError $e) {
            return null;
        }
    }

    /** Human-readable label used in Blade templates */
    public function label(): string
    {
        return match ($this->value) {
            self::ROLE_USER  => 'Khách hàng',
            self::ROLE_STAFF => 'Nhân viên',
            self::ROLE_ADMIN => 'Quản trị viên',
            default          => $this->value,
        };
    }

    /** Tailwind badge class for admin user-list table */
    public function badgeClass(): string
    {
        return match ($this->value) {
            self::ROLE_USER  => 'bg-gray-100 text-gray-700',
            self::ROLE_STAFF => 'bg-blue-100 text-blue-700',
            self::ROLE_ADMIN => 'bg-red-100 text-red-700',
            default          => 'bg-gray-100 text-gray-700',
        };
    }

    /** Returns all cases as instances - mirrors PHP 8.1 enum::cases() */
    public static function cases(): array
    {
        return array_map(fn($v) => self::from($v), [
            self::ROLE_USER, self::ROLE_STAFF, self::ROLE_ADMIN,
        ]);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
