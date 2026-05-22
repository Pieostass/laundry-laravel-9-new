<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Mirrors Java OrderServiceImpl.
 */
class OrderService
{
    // ── placeOrder ────────────────────────────────────────────────────────────

    public function placeOrder(?string $username, array $cart, array $dto): int
    {
        if (empty($cart)) {
            throw new \RuntimeException('Giỏ hàng trống');
        }

        $userId = null;
        if ($username) {
            $user   = User::where('username', $username)->firstOrFail();
            $userId = $user->id;
        }

        return DB::transaction(function () use ($userId, $cart, $dto) {
            $order = Order::create([
                'user_id'     => $userId,
                'full_name'   => $dto['full_name'] ?? null,
                'phone'       => $dto['phone'],
                'address'     => $dto['address'],
                'note'        => $dto['note'] ?? null,
                'status'      => OrderStatus::PENDING,
                'total_price' => 0,
            ]);

            $total = 0;
            foreach ($cart as $productId => $quantity) {
                $product = Product::findOrFail($productId);
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $quantity,
                    'price'      => $product->price,
                ]);
                $total += $product->price * $quantity;
            }

            $order->update(['total_price' => $total]);
            return $order->id;
        });
    }
// OrderService.php
public function placeOrderGuest(
    string $fullName, ?string $email, string $phone,
    string $address, ?string $note, array $cart
): int {
    if (empty($cart)) {
        throw new \RuntimeException('Giỏ hàng trống');
    }

    return DB::transaction(function () use ($fullName, $email, $phone, $address, $note, $cart) {
        $order = Order::create([
            'user_id'     => null,
            'full_name'   => $fullName,
            'email'       => $email,
            'phone'       => $phone,
            'address'     => $address,
            'note'        => $note,
            'status'      => OrderStatus::PENDING,
            'total_price' => 0,
        ]);

        $total = 0;
        foreach ($cart as $productId => $quantity) {
            $product = Product::findOrFail($productId);
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'price'      => $product->price,
            ]);
            $total += $product->price * $quantity;
        }

        $order->update(['total_price' => $total]);
        return $order->id;
    });
}
 
    public function placeOrderFromProfile(
        string $username, string $fullName, string $phone,
        string $address, ?string $note, array $cart
    ): int {
        return $this->placeOrder($username, $cart, [
            'phone'   => $phone,
            'address' => $address,
            'note'    => $note,
        ]);
    }

    // ── findByUsername ────────────────────────────────────────────────────────

    public function findByUsername(string $username): Collection
    {
        return Order::with(['orderItems.product'])
            ->whereHas('user', fn($q) => $q->where('username', $username))
            ->orderByDesc('created_at')
            ->get();
    }

    // ── findById ──────────────────────────────────────────────────────────────

    public function findById(int $id): Order
    {
        return Order::with(['orderItems.product', 'user'])->findOrFail($id);
    }

    // ── findAll ───────────────────────────────────────────────────────────────

    public function findAll(?string $status = null): Collection
    {
        return Order::with(['user', 'orderItems'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->get();
    }

    // ── findAllPaged ──────────────────────────────────────────────────────────

    public function findAllPaged(int $perPage = 15, ?string $status = null): LengthAwarePaginator
    {
        return Order::with(['user', 'orderItems'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    // ── updateStatus ──────────────────────────────────────────────────────────

    public function updateStatus(int $orderId, string $status): Order
    {
        $order = Order::findOrFail($orderId);
        // Accept both string and OrderStatus object
        $statusValue = $status instanceof OrderStatus ? $status->value : $status;
        $order->update(['status' => $statusValue]);
        return $order->fresh();
    }

    // ── countByStatus ─────────────────────────────────────────────────────────

    public function countByStatus(string $status): int
    {
        // Accept both string and OrderStatus object
        $value = $status instanceof OrderStatus ? $status->value : $status;
        return Order::where('status', $value)->count();
    }

    // ── totalRevenue ──────────────────────────────────────────────────────────

    public function totalRevenue(): float
    {
        return (float) Order::where('status', '!=', OrderStatus::CANCELLED)
            ->sum('total_price');
    }
}
