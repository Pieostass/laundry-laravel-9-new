<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Replaces Laravel Breeze's default AuthenticatedSessionController.
 * Login with 'username' field. Role-based redirect after login.
 */
class AuthenticatedSessionController extends Controller
{
    // ── GET /login ────────────────────────────────────────────────────────────

    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    // ── POST /login ───────────────────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Tên đăng nhập hoặc mật khẩu không đúng.']);
        }

        if (!Auth::user()->active) {
            Auth::logout();
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Tài khoản của bạn đã bị vô hiệu hóa.']);
        }

        $request->session()->regenerate();

        return $this->redirectByRole(Auth::user());
    }

    // ── POST /logout ──────────────────────────────────────────────────────────

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('logoutSuccess', true);
    }

    // ── Helper: role-based redirect ───────────────────────────────────────────

    private function redirectByRole($user): RedirectResponse
    {
        if ($user->role === Role::ROLE_ADMIN) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->role === Role::ROLE_STAFF) {
            return redirect()->route('delivery.dashboard');
        }
        return redirect()->route('home');
    }
}
