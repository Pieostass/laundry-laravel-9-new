<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\OrderService;
use App\Services\PostService;
use App\Services\ProductService;
use App\Services\SiteConfigService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct(
        private ProductService    $productService,
        private OrderService      $orderService,
        private UserService       $userService,
        private SiteConfigService $siteConfigService,
        private PostService       $postService,
    ) {}

    // ── DASHBOARD ─────────────────────────────────────────────────────────────

    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'totalProducts' => $this->productService->countActive(),
            'totalUsers'    => $this->userService->findAll()->count(),
            'totalRevenue'  => $this->orderService->totalRevenue(),
            'totalOrders'   => $this->orderService->findAll()->count(),
            'pendingOrders' => $this->orderService->countByStatus(OrderStatus::PENDING),
            'recentOrders'  => $this->orderService->findAllPaged(5)->items(),
            'totalPosts'    => $this->postService->countByStatus('published'),
            'draftPosts'    => $this->postService->countByStatus('draft'),
        ]);
    }

    // ── PRODUCTS ──────────────────────────────────────────────────────────────

    public function products(Request $request): View
    {
        $keyword    = $request->input('keyword');
        $categoryId = $request->input('categoryId');

        return view('admin.products', [
            'products'   => $this->productService->searchProducts($keyword, $categoryId, 10),
            'categories' => Category::orderBy('name')->get(),
            'keyword'    => $keyword,
            'categoryId' => $categoryId,
        ]);
    }

    public function createProduct(): View
    {
        return view('admin.product-form', [
            'product'    => null,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);
        try {
            $this->productService->save($validated, $request->file('image'));
            return redirect()->route('admin.products')
                ->with('success', 'Tạo sản phẩm thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function editProduct(int $id): View
    {
        return view('admin.product-form', [
            'product'    => $this->productService->findById($id),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function updateProduct(Request $request, int $id): RedirectResponse
    {
        $validated = $this->validateProduct($request);
        try {
            $this->productService->update($id, $validated, $request->file('image'));
            return redirect()->route('admin.products')
                ->with('success', 'Cập nhật sản phẩm thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    // ✅ Xóa hẳn khỏi DB
    public function deleteProduct(int $id): RedirectResponse
    {
        $this->productService->delete($id);
        return redirect()->route('admin.products')
            ->with('success', 'Đã xóa sản phẩm.');
    }

    // ✅ Ẩn/Hiện sản phẩm
    public function toggleProduct(int $id): RedirectResponse
    {
        $this->productService->toggleActive($id);
        return redirect()->route('admin.products')
            ->with('success', 'Đã cập nhật trạng thái sản phẩm.');
    }

    // ── CATEGORIES ────────────────────────────────────────────────────────────

    public function categories(): View
    {
        return view('admin.categories', [
            'categories' => Category::orderBy('name')->paginate(15),
        ]);
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
        ]);

        Category::create($request->only('name', 'description'));

        return redirect()->route('admin.categories')
            ->with('success', 'Thêm danh mục thành công!');
    }

    public function updateCategory(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        Category::findOrFail($id)->update($request->only('name', 'description'));

        return redirect()->route('admin.categories')
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    public function deleteCategory(int $id): RedirectResponse
    {
        Category::findOrFail($id)->delete();
        return redirect()->route('admin.categories')
            ->with('success', 'Đã xóa danh mục.');
    }

    // ── ORDERS ────────────────────────────────────────────────────────────────

    public function orders(Request $request): View
    {
        $status = $request->input('status');
        return view('admin.orders', [
            'orders'        => $this->orderService->findAllPaged(15, $status ?: null),
            'statuses'      => OrderStatus::cases(),
            'currentStatus' => $status,
        ]);
    }

    public function showOrder(int $id): View
    {
        return view('admin.order-detail', [
            'order'    => $this->orderService->findById($id),
            'statuses' => OrderStatus::cases(),
        ]);
    }

    public function updateOrderStatus(Request $request, int $id): RedirectResponse
    {
        $request->validate(['status' => ['required', 'string']]);
        $this->orderService->updateStatus($id, $request->input('status'));
        return redirect()->route('admin.orders')
            ->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    // ── USERS ─────────────────────────────────────────────────────────────────

    public function users(): View
    {
        return view('admin.users', [
            'users' => $this->userService->findAll(),
        ]);
    }

    public function showUser(int $id): View
    {
        return view('admin.user-detail', [
            'user' => $this->userService->findById($id),
        ]);
    }

    public function updateUserRole(Request $request, int $id): RedirectResponse
    {
        $request->validate(['role' => ['required', 'string']]);
        $this->userService->updateRole($id, $request->input('role'));
        return redirect()->route('admin.users')
            ->with('success', 'Cập nhật vai trò thành công!');
    }

    public function deleteUser(int $id): RedirectResponse
    {
        $this->userService->delete($id);
        return redirect()->route('admin.users')
            ->with('success', 'Đã xóa người dùng.');
    }

    public function toggleUser(int $id): RedirectResponse
    {
        $this->userService->toggleUserEnabled($id);
        return redirect()->route('admin.users')
            ->with('success', 'Cập nhật trạng thái người dùng thành công!');
    }

    // ── SITE SETTINGS ─────────────────────────────────────────────────────────

    public function settings(): View
    {
        return view('admin.settings', [
            'configs' => $this->siteConfigService->findAll(),
        ]);
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $data = $request->except('_token', '_method');
        if ($request->hasFile('logo')) {
            $path         = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $path;
        }
        $this->siteConfigService->saveAll($data);
        return redirect()->route('admin.settings')
            ->with('success', 'Đã lưu cài đặt giao diện thành công!');
    }

    public function settingsAbout(): View
    {
        return view('admin.settings-about', [
            'configs' => $this->siteConfigService->findAll(),
        ]);
    }

    public function updateSettingsAbout(Request $request): RedirectResponse
    {
        $this->siteConfigService->saveAll($request->except('_token', '_method'));
        return redirect()->route('admin.settings.about')
            ->with('success', 'Đã lưu cài đặt trang Về Công Ty!');
    }

    public function settingsSoccon(): View
    {
        return view('admin.settings-soccon', [
            'configs' => $this->siteConfigService->findAll(),
        ]);
    }

    public function updateSettingsSoccon(Request $request): RedirectResponse
    {
        $this->siteConfigService->saveAll($request->except('_token', '_method'));
        return redirect()->route('admin.settings.soccon')
            ->with('success', 'Đã lưu cài đặt trang SOCCON!');
    }

    public function settingsPinkmee(): View
    {
        return view('admin.settings-pinkmee', [
            'configs' => $this->siteConfigService->findAll(),
        ]);
    }

    public function updateSettingsPinkmee(Request $request): RedirectResponse
    {
        $this->siteConfigService->saveAll($request->except('_token', '_method'));
        return redirect()->route('admin.settings.pinkmee')
            ->with('success', 'Đã lưu cài đặt trang PINKMEE!');
    }

    // ── POSTS ─────────────────────────────────────────────────────────────────

    public function posts(Request $request): View
    {
        return view('admin.posts', [
            'posts'          => $this->postService->findAllPaged(15,
                                    $request->input('status'),
                                    $request->input('keyword')
                                ),
            'statuses'       => ['draft' => 'Nháp', 'published' => 'Đã đăng', 'archived' => 'Lưu trữ'],
            'currentStatus'  => $request->input('status'),
            'keyword'        => $request->input('keyword'),
            'totalDraft'     => $this->postService->countByStatus('draft'),
            'totalPublished' => $this->postService->countByStatus('published'),
        ]);
    }

    public function createPost(): View
    {
        return view('admin.post-form', ['post' => null]);
    }

    public function storePost(Request $request): RedirectResponse
    {
        $validated = $this->validatePost($request);
        try {
            $this->postService->save($validated, $request->file('thumbnail'));
            return redirect()->route('admin.posts')
                ->with('success', 'Đã đăng bài viết thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function editPost(int $id): View
    {
        return view('admin.post-form', [
            'post' => $this->postService->findById($id),
        ]);
    }

    public function updatePost(Request $request, int $id): RedirectResponse
    {
        $validated = $this->validatePost($request);
        try {
            $this->postService->update($id, $validated, $request->file('thumbnail'));
            return redirect()->route('admin.posts')
                ->with('success', 'Cập nhật bài viết thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function deletePost(int $id): RedirectResponse
    {
        $this->postService->delete($id);
        return redirect()->route('admin.posts')
            ->with('success', 'Đã xóa bài viết.');
    }

    // ── Private Helpers ───────────────────────────────────────────────────────

    private function validateProduct(Request $request): array
    {
        return $request->validate([
            'name'           => ['required', 'string', 'max:200'],
            'description'    => ['nullable', 'string', 'max:5000'],
            'price'          => ['required', 'numeric', 'min:0.01'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'category_id'    => ['required', 'exists:categories,id'],
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'image_url'      => ['nullable', 'string'],
        ], [
            'name.required'        => 'Tên sản phẩm là bắt buộc.',
            'price.required'       => 'Giá sản phẩm là bắt buộc.',
            'price.min'            => 'Giá phải lớn hơn 0.',
            'stock_quantity.min'   => 'Số lượng không được âm.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists'   => 'Danh mục không tồn tại.',
            'image.image'          => 'File tải lên phải là hình ảnh.',
            'image.max'            => 'Ảnh không được vượt quá 2MB.',
        ]);
    }

    private function validatePost(Request $request): array
    {
        return $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'excerpt'      => ['nullable', 'string', 'max:500'],
            'content'      => ['required', 'string'],
            'status'       => ['required', 'in:draft,published,archived'],
            'category'     => ['nullable', 'string', 'max:100'],
            'tags'         => ['nullable', 'string'],
            'thumbnail'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'read_time'    => ['nullable', 'integer', 'min:1', 'max:120'],
            'published_at' => ['nullable', 'date'],
            'meta_title'   => ['nullable', 'string', 'max:255'],
            'meta_desc'    => ['nullable', 'string', 'max:300'],
        ], [
            'title.required'   => 'Tiêu đề bài viết là bắt buộc.',
            'content.required' => 'Nội dung bài viết là bắt buộc.',
            'status.in'        => 'Trạng thái không hợp lệ.',
            'thumbnail.image'  => 'File phải là hình ảnh.',
            'thumbnail.max'    => 'Ảnh không được vượt quá 3MB.',
        ]);
    }
}