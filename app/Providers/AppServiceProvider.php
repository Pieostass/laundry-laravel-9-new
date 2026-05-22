<?php

namespace App\Providers;

use App\Enums\Role;
use App\Models\User;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\SiteConfigService;
use App\Services\UserService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ProductService::class);
        $this->app->singleton(OrderService::class);
        $this->app->singleton(UserService::class);
        $this->app->singleton(SiteConfigService::class);
    }

    public function boot(): void
    {
        $this->defineGates();
        $this->shareGlobalViewData();
    }

    private function defineGates(): void
    {
        Gate::define('admin', fn(User $user) => $user->role === Role::ROLE_ADMIN);
        Gate::define('staff', fn(User $user) => $user->role === Role::ROLE_STAFF);
        Gate::define('staff-or-admin', fn(User $user) => in_array($user->role, [
            Role::ROLE_STAFF,
            Role::ROLE_ADMIN,
        ], true));
    }

    private function shareGlobalViewData(): void
    {
        View::composer('*', function ($view) {
            $siteConfigService = app(SiteConfigService::class);
            $view->with('siteConfig', $siteConfigService->asMap());
        });
    }
}
