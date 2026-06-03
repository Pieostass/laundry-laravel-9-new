<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ImageUploadController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// ═══════════════════════════════════════════════════════════════
// PUBLIC ROUTES
// ═══════════════════════════════════════════════════════════════
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/flash-sale', [HomeController::class, 'flashSale'])->name('flash-sale');
Route::post('/contact', [HomeController::class, 'contact'])->name('contact');

// ── Shop & Product ──────────────────────────────────────────────
Route::get('/shop', [UserController::class, 'shop'])->name('shop');
Route::get('/product/{id}', [UserController::class, 'productDetail'])->name('product.detail');

// ── Giới thiệu ─────────────────────────────────────────────────
Route::get('/gioi-thieu-cong-ty',         [AboutController::class, 'company'])->name('about.company');
Route::get('/gioi-thieu-hoa-pham-soccon', [AboutController::class, 'soccon'])->name('about.soccon');
Route::get('/gioi-thieu-my-pham-pinkmee', [AboutController::class, 'pinkmee'])->name('about.pinkmee');

// ── Tin Tức ─────────────────────────────────────────────────────
Route::get('/tin-tuc',        [NewsController::class, 'index'])->name('news.index');
Route::get('/tin-tuc/{slug}', [NewsController::class, 'show'])->name('news.show');

// ═══════════════════════════════════════════════════════════════
// AUTH (guest only)
// ═══════════════════════════════════════════════════════════════
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login',    [AuthenticatedSessionController::class, 'store']);
    Route::get('/register',  [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ═══════════════════════════════════════════════════════════════
// CART & CHECKOUT
// ═══════════════════════════════════════════════════════════════
Route::get('/cart',          [CartController::class, 'viewCart'])->name('cart');
Route::post('/cart/add',     [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update',  [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove',  [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/clear',    [CartController::class, 'clearCart'])->name('cart.clear');
Route::get('/cart/count',    [CartController::class, 'cartCount'])->name('cart.count');

Route::get('/checkout',      [CartController::class, 'checkoutPage'])->name('checkout');
Route::post('/checkout',     [CartController::class, 'placeOrder'])->name('checkout.place');

// ═══════════════════════════════════════════════════════════════
// AUTHENTICATED USER ROUTES
// ═══════════════════════════════════════════════════════════════
Route::middleware('auth')->group(function () {
    Route::get('/order/success', [UserController::class, 'orderSuccess'])->name('order.success');
    Route::get('/order/history', [UserController::class, 'orderHistory'])->name('order.history');
    Route::get('/user/orders',   [UserController::class, 'userOrders'])->name('user.orders');
    Route::get('/user/profile',  [UserController::class, 'profile'])->name('profile');
    Route::post('/user/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile', fn() => redirect()->route('profile'))->name('profile.redirect');
});

// ═══════════════════════════════════════════════════════════════
// ADMIN ROUTES (ROLE_ADMIN only)
// ═══════════════════════════════════════════════════════════════
Route::middleware(['auth', 'role:ROLE_ADMIN'])->group(function () {

    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::prefix('admin/products')->name('admin.products')->group(function () {
        Route::get('/',             [AdminController::class, 'products'])->name('');
        Route::get('/create',       [AdminController::class, 'createProduct'])->name('.create');
        Route::post('/',            [AdminController::class, 'storeProduct'])->name('.store');
        Route::get('/{id}/edit',    [AdminController::class, 'editProduct'])->name('.edit');
        Route::put('/{id}',         [AdminController::class, 'updateProduct'])->name('.update');
        Route::post('/{id}/toggle', [AdminController::class, 'toggleProduct'])->name('.toggle'); // ← Ẩn/Hiện
        Route::delete('/{id}',      [AdminController::class, 'deleteProduct'])->name('.destroy'); // ← Xóa hẳn
    });

    Route::prefix('admin/categories')->name('admin.categories')->group(function () {
        Route::get('/',        [AdminController::class, 'categories'])->name('');
        Route::post('/',       [AdminController::class, 'storeCategory'])->name('.store');
        Route::put('/{id}',    [AdminController::class, 'updateCategory'])->name('.update');
        Route::delete('/{id}', [AdminController::class, 'deleteCategory'])->name('.destroy');
    });

    Route::prefix('admin/orders')->name('admin.orders')->group(function () {
        Route::get('/',            [AdminController::class, 'orders'])->name('');
        Route::get('/{id}',        [AdminController::class, 'showOrder'])->name('.show');
        Route::put('/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('.status');
    });

    Route::prefix('admin/posts')->name('admin.posts')->group(function () {
        Route::get('/',          [AdminController::class, 'posts'])->name('');
        Route::get('/create',    [AdminController::class, 'createPost'])->name('.create');
        Route::post('/',         [AdminController::class, 'storePost'])->name('.store');
        Route::get('/{id}/edit', [AdminController::class, 'editPost'])->name('.edit');
        Route::put('/{id}',      [AdminController::class, 'updatePost'])->name('.update');
        Route::delete('/{id}',   [AdminController::class, 'deletePost'])->name('.destroy');
    });

    Route::prefix('admin/users')->name('admin.users')->group(function () {
        Route::get('/',             [AdminController::class, 'users'])->name('');
        Route::get('/{id}',         [AdminController::class, 'showUser'])->name('.show');
        Route::put('/{id}/role',    [AdminController::class, 'updateUserRole'])->name('.role');
        Route::post('/{id}/toggle', [AdminController::class, 'toggleUser'])->name('.toggle');
        Route::delete('/{id}',      [AdminController::class, 'deleteUser'])->name('.destroy');
    });

    Route::prefix('admin/settings')->name('admin.settings')->group(function () {
        Route::get('/',  [AdminController::class, 'settings'])->name('');
        Route::post('/', [AdminController::class, 'updateSettings'])->name('.update');
    });

    Route::post('/admin/upload/image', ImageUploadController::class)->name('admin.upload.image');
});

// ═══════════════════════════════════════════════════════════════
// STAFF + ADMIN ROUTES
// ═══════════════════════════════════════════════════════════════
Route::middleware(['auth', 'role:ROLE_STAFF,ROLE_ADMIN'])
    ->prefix('delivery')
    ->name('delivery.')
    ->group(function () {
        Route::get('/dashboard',          [StaffController::class, 'dashboard'])->name('dashboard');
        Route::get('/',                   [StaffController::class, 'deliveryOrders'])->name('index');
        Route::get('/orders',             [StaffController::class, 'allOrders'])->name('orders');
        Route::get('/order/{id}',         [StaffController::class, 'orderDetail'])->name('order.show');
        Route::post('/order/{id}/status', [StaffController::class, 'updateStatus'])->name('order.status');
    });

// ═══════════════════════════════════════════════════════════════
// DEV UTILITIES ⚠️ XOÁ SAU KHI DÙNG XONG
// ═══════════════════════════════════════════════════════════════
Route::get('/clear-view', function () {
    Artisan::call('view:clear');
    return 'Đã xóa cache view thành công!';
});

// ── Settings: Về Công Ty ──
Route::get('/admin/settings/about',  [AdminController::class, 'settingsAbout'])->name('admin.settings.about');
Route::post('/admin/settings/about', [AdminController::class, 'updateSettingsAbout'])->name('admin.settings.about.update');

// ── Settings: SOCCON ──
Route::get('/admin/settings/soccon',  [AdminController::class, 'settingsSoccon'])->name('admin.settings.soccon');
Route::post('/admin/settings/soccon', [AdminController::class, 'updateSettingsSoccon'])->name('admin.settings.soccon.update');

// ── Settings: PINKMEE ──
Route::get('/admin/settings/pinkmee',  [AdminController::class, 'settingsPinkmee'])->name('admin.settings.pinkmee');
Route::post('/admin/settings/pinkmee', [AdminController::class, 'updateSettingsPinkmee'])->name('admin.settings.pinkmee.update');