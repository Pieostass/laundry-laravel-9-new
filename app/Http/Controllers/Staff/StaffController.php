<?php

namespace App\Http\Controllers\Staff;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Mirrors Java StaffController — @RequestMapping("/delivery")
 * Access enforced by Route::middleware(['auth', 'role:ROLE_STAFF,ROLE_ADMIN'])
 */
class StaffController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function dashboard(): View
    {
        $allOrders = $this->orderService->findAll();

        $processingOrders = $allOrders->filter(fn($o) =>
            in_array($o->status, [
                OrderStatus::PROCESSING,
                OrderStatus::DELIVERING,
            ], true)
        );

        return view('staff.dashboard', [
            'processingOrders' => $processingOrders,
            'orders'           => $allOrders,
            'totalOrders'      => $allOrders->count(),
            'pendingCount'     => $this->orderService->countByStatus(OrderStatus::PENDING),
            'processingCount'  => $this->orderService->countByStatus(OrderStatus::PROCESSING),
            'deliveringCount'  => $this->orderService->countByStatus(OrderStatus::DELIVERING),
            'doneCount'        => $this->orderService->countByStatus(OrderStatus::DONE),
            'cancelledCount'   => $this->orderService->countByStatus(OrderStatus::CANCELLED),
        ]);
    }

    public function deliveryOrders(): View
    {
        $orders = $this->orderService->findAll()->reject(fn($o) =>
            in_array($o->status, [
                OrderStatus::DONE,
                OrderStatus::CANCELLED,
            ], true)
        );

        return view('staff.delivery', [
            'orders'   => $orders,
            'statuses' => OrderStatus::cases(),
        ]);
    }

    public function allOrders(Request $request): View
    {
        $status = $request->input('status');
        return view('staff.orders', [
            'orders'        => $this->orderService->findAll($status ?: null),
            'statuses'      => OrderStatus::cases(),
            'currentStatus' => $status,
        ]);
    }

    public function orderDetail(int $id): View
    {
        return view('staff.order-detail', [
            'order'    => $this->orderService->findById($id),
            'statuses' => OrderStatus::cases(),
        ]);
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $request->validate(['status' => ['required', 'string']]);
        try {
            $this->orderService->updateStatus($id, $request->input('status'));
            return redirect()->route('delivery.order.show', $id)
                ->with('success', 'Cập nhật trạng thái thành công!');
        } catch (\Exception $e) {
            return redirect()->route('delivery.order.show', $id)
                ->with('error', $e->getMessage());
        }
    }
}
