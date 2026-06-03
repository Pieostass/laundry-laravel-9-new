<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $siteConfig['site_name'] ?? 'LaundryShop')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Be+Vietnam+Pro:wght@300;400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                        sans:  ['"Be Vietnam Pro"', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        cream:          '#FDFCF8',
                        bronze:         '#9C7C52',
                        'bronze-light': '#B8976A',
                        'bronze-dark':  '#7A5E38',
                        'ink':          '#1C1917',
                        'ink-muted':    '#6B6560',
                        'gold':         '#C9A96E',
                        'warm-gray':    '#F5F1EB',
                        'border-soft':  '#E8E2D9',
                    },
                    letterSpacing: { 'widest-xl': '0.25em' }
                }
            }
        }
    </script>

    <style>
        :root {
            --bg:           {{ $siteConfig['background_color'] ?? '#FDFCF8' }};
            --bronze:       {{ $siteConfig['primary_color']    ?? '#9C7C52' }};
            --bronze-light: {{ $siteConfig['accent_color']     ?? '#B8976A' }};
            --ink:          #1C1917;
            --border:       #E8E2D9;
            --warm-gray:    #F5F1EB;
            --nav-height:   72px;
        }
        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        html, body {
            background-color: var(--bg);
            color: var(--ink);
            font-family: 'Be Vietnam Pro', sans-serif;
        }
        ::-webkit-scrollbar       { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--bronze); }

        /* ── Navbar ──────────────────────────────────────────────────── */
        #site-nav {
            height: var(--nav-height);
            transition: background 0.4s ease, box-shadow 0.4s ease, backdrop-filter 0.4s ease;
        }
        #site-nav.scrolled {
            background: rgba(253, 252, 248, 0.94);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 1px 0 var(--border);
        }

        /* ── Nav links ───────────────────────────────────────────────── */
        .nav-link {
            position: relative;
            font-size: 0.72rem;
            letter-spacing: 0.13em;
            text-transform: uppercase;
            color: #6B6560;
            transition: color 0.25s;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            white-space: nowrap;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px; left: 0;
            width: 0; height: 1px;
            background: var(--bronze);
            transition: width 0.3s ease;
        }
        .nav-link:hover          { color: var(--ink); }
        .nav-link:hover::after,
        .nav-link.active::after  { width: 100%; }
        .nav-link.active         { color: var(--bronze); }

        /* ── Dropdown ────────────────────────────────────────────────── */
        .nav-dropdown {
            position: absolute;
            top: calc(100% + 14px);
            width: 15rem;
            background: #FDFCF8;
            border: 1px solid var(--border);
            box-shadow: 0 12px 40px rgba(28,25,23,0.08);
            opacity: 0;
            visibility: hidden;
            transform: translateY(6px);
            transition: opacity 0.22s ease, transform 0.22s ease, visibility 0.22s;
            z-index: 60;
        }
        /* Left side dropdown: open to the right */
        .nav-dropdown-wrap.drop-left .nav-dropdown  { left: 0; }
        /* Right side dropdown: open to the left */
        .nav-dropdown-wrap.drop-right .nav-dropdown { right: 0; }

        .nav-dropdown-wrap:hover .nav-dropdown,
        .nav-dropdown-wrap:focus-within .nav-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .nav-dropdown-wrap:hover .nav-chevron {
            transform: rotate(180deg);
        }
        .nav-chevron {
            transition: transform 0.22s ease;
            display: inline-block;
        }
        .dropdown-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.85rem 1.1rem;
            border-bottom: 1px solid var(--border);
            transition: background 0.2s;
            text-decoration: none;
        }
        .dropdown-item:last-child  { border-bottom: none; }
        .dropdown-item:hover       { background: var(--warm-gray); }
        .dropdown-item .di-icon    { color: var(--bronze); font-size: 0.9rem; flex-shrink: 0; margin-top: 1px; }
        .dropdown-item .di-title   { font-size: 0.7rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--ink); font-weight: 500; }
        .dropdown-item .di-sub     { font-size: 0.65rem; color: #6B6560; margin-top: 2px; line-height: 1.5; }

        /* ── Typography ──────────────────────────────────────────────── */
        .headline { font-family: 'Playfair Display', Georgia, serif; }
        .btn-bronze {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 0.75rem 2rem;
            background: var(--bronze);
            color: #FDFCF8;
            font-size: 0.7rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            transition: background 0.3s, transform 0.2s;
        }
        .btn-bronze:hover { background: var(--bronze-light); transform: translateY(-1px); }
        .btn-ghost {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 0.75rem 2rem;
            background: transparent;
            color: var(--ink);
            font-size: 0.7rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            border: 1px solid var(--border);
            transition: border-color 0.3s, color 0.3s, background 0.3s;
        }
        .btn-ghost:hover {
            border-color: var(--bronze);
            color: var(--bronze);
            background: rgba(156, 124, 82, 0.04);
        }

        /* ── Animations ──────────────────────────────────────────────── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up   { animation: fadeUp 0.7s ease both; }
        .flash-bar { animation: fadeUp 0.5s ease both; }

        /* ── Mobile drawer ───────────────────────────────────────────── */
        #mobile-drawer {
            transform: translateX(-100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #mobile-drawer.open    { transform: translateX(0); }
        #drawer-overlay        { opacity: 0; pointer-events: none; transition: opacity 0.4s; }
        #drawer-overlay.open   { opacity: 1; pointer-events: all; }

        /* ── Mobile accordion ────────────────────────────────────────── */
        .mobile-sub-menu          { display: none; }
        .mobile-sub-menu.open     { display: block; }
        .mobile-acc-chevron       { transition: transform 0.25s ease; }
        .mobile-acc-chevron.open  { transform: rotate(180deg); }

        /* ── Footer ──────────────────────────────────────────────────── */
        .footer-link {
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #6B6560;
            border-bottom: 1px solid transparent;
            transition: color 0.25s, border-color 0.25s;
        }
        .footer-link:hover { color: var(--bronze); border-bottom-color: var(--bronze); }

        /* ── Nav divider ─────────────────────────────────────────────── */
        .nav-divider {
            width: 1px;
            height: 14px;
            background: var(--border);
            flex-shrink: 0;
        }
    </style>
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen" style="background-color: var(--bg);">

{{-- ══════════════════════════════════════════════════════════════════════ --}}
{{--  NAVBAR — Split layout: left links | centre logo | right links+auth   --}}
{{-- ══════════════════════════════════════════════════════════════════════ --}}
<header id="site-nav" class="fixed top-0 inset-x-0 z-50">
    <div class="max-w-screen-xl mx-auto px-6 lg:px-12 h-full flex items-center">

        {{-- ── [MOBILE] Hamburger ─────────────────────────────────── --}}
        <button id="drawer-open" aria-label="Mở menu"
                class="lg:hidden flex flex-col gap-1.5 p-1 group mr-4">
            <span class="block w-5 h-px bg-ink transition-all group-hover:w-7 group-hover:bg-bronze"></span>
            <span class="block w-7 h-px bg-ink transition-all group-hover:bg-bronze"></span>
            <span class="block w-6 h-px bg-ink transition-all group-hover:w-7 group-hover:bg-bronze"></span>
        </button>

        {{-- ── [DESKTOP] Left nav ──────────────────────────────────── --}}
        <nav class="hidden lg:flex items-center gap-7 flex-1">
            <a href="{{ route('home') }}"
               class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                Trang Chủ
            </a>

            <span class="nav-divider"></span>

            <a href="{{ route('shop') }}"
               class="nav-link {{ request()->routeIs('shop') ? 'active' : '' }}">
                Cửa Hàng
            </a>

            <span class="nav-divider"></span>

            <a href="{{ route('flash-sale') }}"
               class="nav-link {{ request()->routeIs('flash-sale') ? 'active' : '' }}">
                Flash Sale
            </a>
        </nav>

        {{-- ── Logo (centre — absolute so it doesn't affect flex flow) ── --}}
        <a href="{{ route('home') }}"
           class="absolute left-1/2 -translate-x-1/2 text-center z-10 pointer-events-auto">
            @if(!empty($siteConfig['logo_url']))
                <img src="{{ $siteConfig['logo_url'] }}"
                     alt="{{ $siteConfig['site_name'] }}"
                     class="h-10 w-auto mx-auto">
            @else
                <p class="headline text-xl font-medium tracking-wide text-ink leading-none">
                    {{ $siteConfig['site_name'] ?? 'LaundryShop' }}
                </p>
                <p class="text-[9px] tracking-widest-xl text-ink-muted uppercase mt-0.5 font-light">
                    {{ $siteConfig['site_tagline'] ?? 'Giặt sạch · Giao nhanh' }}
                </p>
            @endif
        </a>

        {{-- ── [DESKTOP] Right nav + auth ─────────────────────────── --}}
        <div class="hidden lg:flex items-center gap-7 flex-1 justify-end">

            {{-- Dropdown: Giới Thiệu --}}
            <div class="nav-dropdown-wrap drop-right relative flex items-center">
                <button class="nav-link flex items-center gap-1
                               {{ request()->is('gioi-thieu*') ? 'active' : '' }}">
                    Giới Thiệu
                    <svg class="nav-chevron w-3 h-3 ml-0.5 opacity-50"
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div class="nav-dropdown">
                    <a href="{{ url('/gioi-thieu-cong-ty') }}" class="dropdown-item">
                        <span class="di-icon">◎</span>
                        <div>
                            <p class="di-title">Về Công Ty</p>
                            <p class="di-sub">Lịch sử hình thành, sứ mệnh &amp; đội ngũ</p>
                        </div>
                    </a>
                    <a href="{{ url('/gioi-thieu-hoa-pham-soccon') }}" class="dropdown-item">
                        <span class="di-icon">◉</span>
                        <div>
                            <p class="di-title">Hoá Phẩm SOCCON</p>
                            <p class="di-sub">Dòng hoá phẩm chuyên dụng, an toàn &amp; hiệu quả</p>
                        </div>
                    </a>
                    <a href="{{ url('/gioi-thieu-my-pham-pinkmee') }}" class="dropdown-item">
                        <span class="di-icon">○</span>
                        <div>
                            <p class="di-title">Mỹ Phẩm PINKMEE</p>
                            <p class="di-sub">Bộ sưu tập mỹ phẩm thiên nhiên</p>
                        </div>
                    </a>
                </div>
            </div>

            <span class="nav-divider"></span>

            <a href="{{ url('/tin-tuc') }}"
               class="nav-link {{ request()->is('tin-tuc*') ? 'active' : '' }}">
                Tin Tức
            </a>

            <span class="nav-divider"></span>

            {{-- Auth: Guest --}}
            @guest
                <a href="{{ route('login') }}" class="nav-link">Đăng nhập</a>
                <a href="{{ route('register') }}" class="btn-bronze text-[11px] py-2 px-5">Đăng ký</a>
            @else
                {{-- Cart icon --}}
                <a href="{{ route('cart') }}" class="relative text-ink-muted hover:text-bronze transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                    </svg>
                    <span id="cart-badge"
                          class="absolute -top-2.5 -right-2.5 w-4 h-4 rounded-full bg-bronze text-cream
                                 text-[9px] font-semibold flex items-center justify-center hidden">0</span>
                </a>

                {{-- User dropdown --}}
                <div class="relative" id="user-menu-wrap">
                    <button id="user-menu-btn"
                            class="flex items-center gap-2 text-ink-muted hover:text-bronze transition group">
                        <span class="w-7 h-7 rounded-full border border-border-soft flex items-center justify-center
                                     text-xs font-semibold text-bronze group-hover:border-bronze transition">
                            {{ strtoupper(substr(auth()->user()->full_name ?? auth()->user()->username ?? 'U', 0, 1)) }}
                        </span>
                        <svg class="w-3 h-3 transition-transform" id="user-chevron"
                             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="user-dropdown"
                         class="absolute right-0 top-full mt-3 w-52 bg-cream border border-border-soft shadow-lg hidden z-50">
                        <div class="px-4 py-3 border-b border-border-soft">
                            <p class="text-xs font-semibold text-ink">{{ auth()->user()->full_name }}</p>
                            <p class="text-[11px] text-ink-muted mt-0.5">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="py-1">
                            @can('admin')
                            <a href="{{ route('admin.dashboard') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-[11px] tracking-wide
                                      text-ink-muted hover:text-bronze hover:bg-warm-gray transition">
                                ◈ Quản trị
                            </a>
                            @endcan
                            @can('staff-or-admin')
                            <a href="{{ route('delivery.dashboard') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-[11px] tracking-wide
                                      text-ink-muted hover:text-bronze hover:bg-warm-gray transition">
                                ◉ Giao hàng
                            </a>
                            @endcan
                            <a href="{{ route('user.orders') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-[11px] tracking-wide
                                      text-ink-muted hover:text-bronze hover:bg-warm-gray transition">
                                ◎ Đơn hàng
                            </a>
                            <a href="{{ route('profile') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-[11px] tracking-wide
                                      text-ink-muted hover:text-bronze hover:bg-warm-gray transition">
                                ○ Hồ sơ
                            </a>
                            <div class="border-t border-border-soft mt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full text-left flex items-center gap-3 px-4 py-2.5
                                                   text-[11px] tracking-wide text-ink-muted
                                                   hover:text-bronze hover:bg-warm-gray transition">
                                        → Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
        </div>

        {{-- ── [MOBILE] Cart + right side ─────────────────────────── --}}
        <div class="flex lg:hidden items-center gap-4 ml-auto">
            @auth
            <a href="{{ route('cart') }}" class="relative text-ink-muted hover:text-bronze transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                </svg>
                <span id="cart-badge-mobile"
                      class="absolute -top-2.5 -right-2.5 w-4 h-4 rounded-full bg-bronze text-cream
                             text-[9px] font-semibold flex items-center justify-center hidden">0</span>
            </a>
            @endauth
        </div>

    </div>
</header>

{{-- ══════════════════════════════════════════════════════════════════════ --}}
{{--  MOBILE DRAWER                                                         --}}
{{-- ══════════════════════════════════════════════════════════════════════ --}}
<div id="drawer-overlay" class="fixed inset-0 bg-ink/30 z-40 lg:hidden" onclick="closeDrawer()"></div>

<div id="mobile-drawer" class="fixed top-0 left-0 h-full w-72 bg-cream z-50 lg:hidden flex flex-col shadow-2xl">

    <div class="flex items-center justify-between px-6 py-5 border-b border-border-soft">
        <span class="headline text-lg text-ink">{{ $siteConfig['site_name'] ?? 'LaundryShop' }}</span>
        <button onclick="closeDrawer()" class="text-ink-muted hover:text-bronze transition text-xl leading-none">✕</button>
    </div>

    <nav class="flex-1 px-6 py-6 overflow-y-auto space-y-0">

        <a href="{{ route('home') }}"
           class="block py-3 border-b border-border-soft text-sm text-ink-muted hover:text-bronze
                  tracking-wide transition {{ request()->routeIs('home') ? 'text-bronze font-medium' : '' }}">
            Trang Chủ
        </a>
        <a href="{{ route('shop') }}"
           class="block py-3 border-b border-border-soft text-sm text-ink-muted hover:text-bronze
                  tracking-wide transition {{ request()->routeIs('shop') ? 'text-bronze font-medium' : '' }}">
            Cửa Hàng
        </a>
        <a href="{{ route('flash-sale') }}"
           class="block py-3 border-b border-border-soft text-sm text-ink-muted hover:text-bronze
                  tracking-wide transition {{ request()->routeIs('flash-sale') ? 'text-bronze font-medium' : '' }}">
            Flash Sale
        </a>

        {{-- Giới Thiệu accordion --}}
        <div>
            <button onclick="toggleMobileAcc(this)"
                    class="w-full flex items-center justify-between py-3 border-b border-border-soft
                           text-sm text-ink-muted hover:text-bronze tracking-wide transition text-left
                           {{ request()->is('gioi-thieu*') ? 'text-bronze font-medium' : '' }}">
                Giới Thiệu
                <svg class="mobile-acc-chevron w-3 h-3 flex-shrink-0 opacity-50"
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="mobile-sub-menu bg-warm-gray border-b border-border-soft">
                <a href="{{ url('/gioi-thieu-cong-ty') }}"
                   class="flex items-center gap-3 px-4 py-3 border-b border-border-soft/60
                          text-[12px] text-ink-muted hover:text-bronze transition">
                    <span class="text-bronze text-xs">◎</span> Về Công Ty
                </a>
                <a href="{{ url('/gioi-thieu-hoa-pham-soccon') }}"
                   class="flex items-center gap-3 px-4 py-3 border-b border-border-soft/60
                          text-[12px] text-ink-muted hover:text-bronze transition">
                    <span class="text-bronze text-xs">◉</span> Hoá Phẩm SOCCON
                </a>
                <a href="{{ url('/gioi-thieu-my-pham-pinkmee') }}"
                   class="flex items-center gap-3 px-4 py-3
                          text-[12px] text-ink-muted hover:text-bronze transition">
                    <span class="text-bronze text-xs">○</span> Mỹ Phẩm PINKMEE
                </a>
            </div>
        </div>

        <a href="{{ url('/tin-tuc') }}"
           class="block py-3 border-b border-border-soft text-sm text-ink-muted hover:text-bronze
                  tracking-wide transition {{ request()->is('tin-tuc*') ? 'text-bronze font-medium' : '' }}">
            Tin Tức
        </a>

        @auth
        <a href="{{ route('user.orders') }}"
           class="block py-3 border-b border-border-soft text-sm text-ink-muted hover:text-bronze tracking-wide transition">
            Đơn Hàng
        </a>
        <a href="{{ route('profile') }}"
           class="block py-3 border-b border-border-soft text-sm text-ink-muted hover:text-bronze tracking-wide transition">
            Hồ Sơ
        </a>
        @endauth

    </nav>

    <div class="px-6 pb-8 pt-4 space-y-3 border-t border-border-soft">
        @guest
            <a href="{{ route('register') }}" class="btn-bronze w-full">Đăng ký</a>
            <a href="{{ route('login') }}"    class="btn-ghost w-full">Đăng nhập</a>
        @else
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-ghost w-full">Đăng xuất</button>
            </form>
        @endauth
    </div>

</div>

{{-- ══════════════════════════════════════════════════════════════════════ --}}
{{--  FLASH MESSAGES                                                        --}}
{{-- ══════════════════════════════════════════════════════════════════════ --}}
@if(session('success') || session('error') || session('contactSuccess'))
<div class="fixed top-[var(--nav-height)] inset-x-0 z-40 flex flex-col items-center gap-2 pt-4 px-4 pointer-events-none">

    @if(session('success'))
    <div class="flash-bar pointer-events-auto flex items-center gap-3 bg-cream border border-border-soft
                shadow-sm px-5 py-3 max-w-md w-full">
        <span class="w-1.5 h-1.5 rounded-full bg-bronze flex-shrink-0"></span>
        <p class="text-[11px] tracking-wide text-ink flex-1">{{ session('success') }}</p>
        <button onclick="this.closest('.flash-bar').remove()"
                class="text-ink-muted hover:text-bronze text-xs transition ml-2">✕</button>
    </div>
    @endif

    @if(session('contactSuccess'))
    <div class="flash-bar pointer-events-auto flex items-center gap-3 bg-cream border border-border-soft
                shadow-sm px-5 py-3 max-w-md w-full">
        <span class="w-1.5 h-1.5 rounded-full bg-gold flex-shrink-0"></span>
        <p class="text-[11px] tracking-wide text-ink flex-1">{{ session('contactSuccess') }}</p>
        <button onclick="this.closest('.flash-bar').remove()"
                class="text-ink-muted hover:text-bronze text-xs transition ml-2">✕</button>
    </div>
    @endif

    @if(session('error'))
    <div class="flash-bar pointer-events-auto flex items-center gap-3 bg-cream border border-gold/40
                shadow-sm px-5 py-3 max-w-md w-full">
        <span class="w-1.5 h-1.5 rounded-full bg-gold flex-shrink-0"></span>
        <p class="text-[11px] tracking-wide text-ink flex-1">{{ session('error') }}</p>
        <button onclick="this.closest('.flash-bar').remove()"
                class="text-ink-muted hover:text-bronze text-xs transition ml-2">✕</button>
    </div>
    @endif

</div>
@endif

{{-- ══════════════════════════════════════════════════════════════════════ --}}
{{--  MAIN CONTENT                                                          --}}
{{-- ══════════════════════════════════════════════════════════════════════ --}}
<main class="flex-1 pt-[var(--nav-height)]">
    @yield('content')
</main>

{{-- ══════════════════════════════════════════════════════════════════════ --}}
{{--  FOOTER                                                                --}}
{{-- ══════════════════════════════════════════════════════════════════════ --}}
<footer class="bg-ink text-cream/70 mt-24">
    <div class="max-w-screen-xl mx-auto px-6 lg:px-12">
        <div class="py-16 grid grid-cols-1 md:grid-cols-12 gap-12">

            {{-- Brand --}}
            <div class="md:col-span-4">
                <p class="headline text-2xl font-medium text-cream mb-3">
                    {{ $siteConfig['site_name'] ?? 'CÔNG TY TNHH XUẤT NHẬP KHẨU VÀ THƯƠNG MẠI GLOBAL PARTNER' }}
                </p>
                <p class="text-[11px] tracking-widest uppercase text-cream/40 mb-5">
                    {{ $siteConfig['site_tagline'] ?? 'Giặt sạch · Giao nhanh' }}
                </p>
                <p class="text-[13px] leading-relaxed text-cream/50 max-w-xs">
                    GLOBAL PARTNER IMPORT EXPORT AND TRADING COMPANY LIMITED
                </p>
            </div>

            {{-- Khám phá --}}
            <div class="md:col-span-2 md:col-start-6">
                <h4 class="text-[10px] tracking-widest uppercase text-cream/30 mb-5 font-semibold">Khám phá</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}"       class="footer-link">Trang chủ</a></li>
                    <li><a href="{{ route('shop') }}"       class="footer-link">Cửa hàng</a></li>
                    <li><a href="{{ route('flash-sale') }}" class="footer-link">Flash Sale</a></li>
                    <li><a href="{{ url('/tin-tuc') }}"     class="footer-link">Tin Tức</a></li>
                </ul>
            </div>

            {{-- Giới thiệu --}}
            <div class="md:col-span-2">
                <h4 class="text-[10px] tracking-widest uppercase text-cream/30 mb-5 font-semibold">Giới Thiệu</h4>
                <ul class="space-y-3">
                    <li><a href="{{ url('/gioi-thieu-cong-ty') }}"         class="footer-link">Về Công Ty</a></li>
                    <li><a href="{{ url('/gioi-thieu-hoa-pham-soccon') }}" class="footer-link">Hoá Phẩm SOCCON</a></li>
                    <li><a href="{{ url('/gioi-thieu-my-pham-pinkmee') }}" class="footer-link">Mỹ Phẩm PINKMEE</a></li>
                </ul>
            </div>

            {{-- Liên hệ --}}
            <div class="md:col-span-3 md:col-start-10">
                <h4 class="text-[10px] tracking-widest uppercase text-cream/30 mb-5 font-semibold">Liên hệ</h4>
                <ul class="space-y-3 text-[13px] text-cream/50">
                    <li>{{ $siteConfig['footer_address'] ?? '' }}</li>
                    <li>{{ $siteConfig['footer_phone']   ?? '' }}</li>
                    <li>{{ $siteConfig['footer_email']   ?? '' }}</li>
                    <li class="text-cream/30">{{ $siteConfig['footer_hours'] ?? '' }}</li>
                </ul>
            </div>

        </div>

        <div class="border-t border-cream/10 py-6 flex flex-col sm:flex-row items-center justify-between
                    gap-3 text-[11px] text-cream/25">
            <p>© {{ date('Y') }} {{ $siteConfig['site_name'] ?? 'LaundryShop' }}. All rights reserved.</p>
            <p class="tracking-widest uppercase text-[9px]">Chất lượng · Tinh tế · Tận tâm</p>
        </div>
    </div>
</footer>

{{-- ══════════════════════════════════════════════════════════════════════ --}}
{{--  SCRIPTS                                                               --}}
{{-- ══════════════════════════════════════════════════════════════════════ --}}
<script>
    /* ── Navbar scrolled state ──────────────────────────────────────────── */
    const nav      = document.getElementById('site-nav');
    const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 20);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    /* ── Mobile drawer ──────────────────────────────────────────────────── */
    const drawer  = document.getElementById('mobile-drawer');
    const overlay = document.getElementById('drawer-overlay');

    document.getElementById('drawer-open')?.addEventListener('click', () => {
        drawer.classList.add('open');
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    });
    function closeDrawer() {
        drawer.classList.remove('open');
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    /* ── Mobile accordion ───────────────────────────────────────────────── */
    function toggleMobileAcc(btn) {
        const sub     = btn.nextElementSibling;
        const chevron = btn.querySelector('.mobile-acc-chevron');
        const isOpen  = sub.classList.contains('open');
        sub.classList.toggle('open', !isOpen);
        chevron.classList.toggle('open', !isOpen);
    }

    /* ── User dropdown ──────────────────────────────────────────────────── */
    const menuBtn  = document.getElementById('user-menu-btn');
    const menuDrop = document.getElementById('user-dropdown');
    const uChevron = document.getElementById('user-chevron');

    menuBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        const open = !menuDrop.classList.contains('hidden');
        menuDrop.classList.toggle('hidden', open);
        uChevron?.classList.toggle('rotate-180', !open);
    });
    document.addEventListener('click', () => {
        menuDrop?.classList.add('hidden');
        uChevron?.classList.remove('rotate-180');
    });

    /* ── Cart badge ─────────────────────────────────────────────────────── */
    @auth
    async function refreshCartBadge() {
        try {
            const r = await fetch('{{ route("cart.count") }}');
            const d = await r.json();
            ['cart-badge','cart-badge-mobile'].forEach(id => {
                const b = document.getElementById(id);
                if (b) { b.textContent = d.count; b.classList.toggle('hidden', d.count === 0); }
            });
        } catch {}
    }
    refreshCartBadge();
    @endauth

    /* ── Flash auto-hide ────────────────────────────────────────────────── */
    document.querySelectorAll('.flash-bar').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.6s';
            el.style.opacity    = '0';
            setTimeout(() => el.remove(), 600);
        }, 4500);
    });

    /* ── Data-confirm ───────────────────────────────────────────────────── */
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', e => {
            if (!confirm(el.dataset.confirm)) e.preventDefault();
        });
    });
</script>
@stack('scripts')
</body>
</html>