<?php

namespace App\Enums;

/**
 * PHP 8.0 compatible replacement for backed enum.
 * Mirrors Java: com.laundryshop.enums.OrderStatus
 * Stored as string in DB column 'status'.
 */
class OrderStatus
{
    public const PENDING    = 'PENDING';
    public const CONFIRMED  = 'CONFIRMED';
    public const PROCESSING = 'PROCESSING';
    public const DELIVERING = 'DELIVERING';
    public const DELIVERED  = 'DELIVERED';
    public const DONE       = 'DONE';
    public const CANCELLED  = 'CANCELLED';

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
        $valid = [
            self::PENDING, self::CONFIRMED, self::PROCESSING,
            self::DELIVERING, self::DELIVERED, self::DONE, self::CANCELLED,
        ];
        if (!in_array($value, $valid, true)) {
            throw new \ValueError("{$value} is not a valid OrderStatus");
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

    /** Mirrors Java getLabel() */
    public function label(): string
    {
        return match ($this->value) {
            self::PENDING    => 'Chờ xác nhận',
            self::CONFIRMED  => 'Đã xác nhận',
            self::PROCESSING => 'Đang xử lý',
            self::DELIVERING => 'Đang giao',
            self::DELIVERED  => 'Đã giao',
            self::DONE       => 'Hoàn thành',
            self::CANCELLED  => 'Đã hủy',
            default          => $this->value,
        };
    }

    /** Tailwind CSS classes - mirrors Java getBadgeClass() */
    public function badgeClass(): string
    {
        return match ($this->value) {
            self::PENDING    => 'bg-yellow-100 text-yellow-800',
            self::CONFIRMED  => 'bg-blue-100 text-blue-800',
            self::PROCESSING => 'bg-indigo-100 text-indigo-800',
            self::DELIVERING => 'bg-purple-100 text-purple-800',
            self::DELIVERED  => 'bg-green-100 text-green-800',
            self::DONE       => 'bg-green-200 text-green-900',
            self::CANCELLED  => 'bg-red-100 text-red-800',
            default          => 'bg-gray-100 text-gray-800',
        };
    }

    /** Returns all cases as instances - mirrors PHP 8.1 enum::cases() */
    public static function cases(): array
    {
        return array_map(fn($v) => self::from($v), [
            self::PENDING, self::CONFIRMED, self::PROCESSING,
            self::DELIVERING, self::DELIVERED, self::DONE, self::CANCELLED,
        ]);
    }

    /** Active (in-progress) statuses for Staff dashboard filter */
    public static function activeStatuses(): array
    {
        return [self::PROCESSING, self::DELIVERING];
    }

    /** Statuses that should NOT appear on the delivery board */
    public static function closedStatuses(): array
    {
        return [self::DONE, self::CANCELLED];
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
