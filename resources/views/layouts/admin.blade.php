<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GolStyle Admin — @yield('title', 'Panel')</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            background: #0f0f0f;
            color: #e0e0e0;
            min-height: 100vh;
            display: flex;
        }

        /* ── SIDEBAR ────────────────────────────────────────── */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #141414;
            border-right: 1px solid #222;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 28px 24px 22px;
            border-bottom: 1px solid #222;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            font-size: 1.6rem;
            line-height: 1;
        }

        .brand-text { display: flex; flex-direction: column; line-height: 1.2; }
        .brand-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: #d4af37;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .brand-sub {
            font-size: 0.65rem;
            color: #666;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 0;
            overflow-y: auto;
        }

        .nav-section { margin-bottom: 8px; }

        .nav-section-label {
            padding: 10px 24px 6px;
            font-size: 0.62rem;
            font-weight: 600;
            color: #444;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 24px;
            color: #888;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-link svg { width: 18px; height: 18px; flex-shrink: 0; opacity: 0.7; transition: opacity 0.2s; }

        .nav-link:hover {
            color: #ccc;
            background: rgba(255,255,255,0.03);
            border-left-color: #333;
        }

        .nav-link:hover svg { opacity: 1; }

        .nav-link.active {
            color: #d4af37;
            background: rgba(212, 175, 55, 0.07);
            border-left-color: #d4af37;
            font-weight: 600;
        }

        .nav-link.active svg { opacity: 1; }

        .nav-badge {
            margin-left: auto;
            background: #d4af37;
            color: #121212;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
            min-width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 18px 24px;
            border-top: 1px solid #1e1e1e;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #d4af37, #b8941f);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.9rem; color: #121212;
            flex-shrink: 0;
        }

        .user-info { flex: 1; min-width: 0; }
        .user-name { font-size: 0.85rem; font-weight: 600; color: #ddd; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 0.7rem; color: #d4af37; text-transform: uppercase; letter-spacing: 1px; }

        /* ── MAIN WRAPPER ───────────────────────────────────── */
        .main-wrapper {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            min-width: 0;
        }

        /* ── TOPBAR ─────────────────────────────────────────── */
        .topbar {
            height: 64px;
            background: #141414;
            border-bottom: 1px solid #1e1e1e;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 50;
            flex-shrink: 0;
        }

        .topbar-left { display: flex; align-items: center; gap: 16px; }

        .page-title {
            font-size: 1.05rem;
            font-weight: 600;
            color: #ddd;
            letter-spacing: 0.3px;
        }

        .topbar-right { display: flex; align-items: center; gap: 16px; }

        .btn-logout {
            padding: 8px 18px;
            background: transparent;
            border: 1px solid #333;
            border-radius: 7px;
            color: #888;
            font-size: 0.82rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .btn-logout:hover {
            border-color: #dc3545;
            color: #ff6b6b;
            background: rgba(220,53,69,0.06);
        }

        /* ── CONTENT ────────────────────────────────────────── */
        .content {
            flex: 1;
            padding: 36px 40px;
            background: #0f0f0f;
        }

        .content-header {
            margin-bottom: 32px;
        }

        .content-header h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #e8e8e8;
            letter-spacing: 0.3px;
            margin-bottom: 4px;
        }

        .content-header p {
            font-size: 0.88rem;
            color: #555;
        }

        /* ── ALERTS ─────────────────────────────────────────── */
        .alert {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-ok {
            background: rgba(212,175,55,0.08);
            border: 1px solid rgba(212,175,55,0.3);
            color: #d4af37;
        }

        .alert-error {
            background: rgba(220,53,69,0.08);
            border: 1px solid rgba(220,53,69,0.3);
            color: #ff6b6b;
        }

        /* ── HAMBURGER ──────────────────────────────────────── */
        .btn-hamburger {
            display: none;
            align-items: center;
            justify-content: center;
            width: 38px; height: 38px;
            background: transparent;
            border: 1px solid #2a2a2a;
            border-radius: 8px;
            color: #888;
            cursor: pointer;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        .btn-hamburger:hover { border-color: #d4af37; color: #d4af37; }
        .btn-hamburger svg { width: 20px; height: 20px; }

        /* ── OVERLAY ────────────────────────────────────────── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 99;
            backdrop-filter: blur(2px);
        }
        .sidebar-overlay.active { display: block; }

        /* ── GLOBAL RESPONSIVE FIX ─────────────────────────── */
        .main-wrapper { min-width: 0; }
        .content      { overflow-x: hidden; }
        img           { max-width: 100%; height: auto; }

        /* Todas las tablas: contenedor con scroll horizontal */
        .data-table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .data-table        { min-width: 620px; border-collapse: collapse; }

        /* Cards y filas flex */
        .page-actions { flex-wrap: wrap; }
        .actions      { flex-wrap: nowrap; }

        /* ── RESPONSIVE ─────────────────────────────────────── */
        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .btn-hamburger { display: flex; }
            .topbar { padding: 0 16px; }
            .content { padding: 20px 12px; }
            .btn-logout-text { display: none; }
            .btn-logout { padding: 8px 10px; }
            .content-header h2 { font-size: 1.3rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <span class="brand-icon">⚽</span>
        <div class="brand-text">
            <span class="brand-name">GolStyle</span>
            <span class="brand-sub">Admin Panel</span>
        </div>
    </div>

    <nav class="sidebar-nav">

        <div class="nav-section">
            <span class="nav-section-label">General</span>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
        </div>

        <div class="nav-section">
            <span class="nav-section-label">Catálogo</span>
            <a href="{{ route('admin.camisetas.index') }}" class="nav-link {{ request()->routeIs('admin.camisetas*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.57a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.57a2 2 0 00-1.34-2.23z"/></svg>
                Camisetas
            </a>
            <a href="{{ route('admin.variantes.index') }}" class="nav-link {{ request()->routeIs('admin.variantes*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
                Stock / Variantes
            </a>
        </div>

        <div class="nav-section">
            <span class="nav-section-label">Categorías</span>
            <a href="{{ route('admin.ligas.index') }}" class="nav-link {{ request()->routeIs('admin.ligas*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/><path d="M2 12h20"/></svg>
                Ligas
            </a>
            <a href="{{ route('admin.equipos.index') }}" class="nav-link {{ request()->routeIs('admin.equipos*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                Equipos
            </a>
            <a href="{{ route('admin.selecciones.index') }}" class="nav-link {{ request()->routeIs('admin.selecciones*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Selecciones
            </a>
            <a href="{{ route('admin.temporadas.index') }}" class="nav-link {{ request()->routeIs('admin.temporadas*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                Temporadas
            </a>
        </div>

        <div class="nav-section">
            <span class="nav-section-label">Gestión</span>
            <a href="{{ route('admin.pedidos.index') }}" class="nav-link {{ request()->routeIs('admin.pedidos*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                Pedidos
            </a>
            <a href="{{ route('admin.usuarios.index') }}" class="nav-link {{ request()->routeIs('admin.usuarios*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Usuarios
            </a>
            <a href="{{ route('admin.contactos.index') }}" class="nav-link {{ request()->routeIs('admin.contactos*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Mensajes
            </a>
        </div>

    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->nombre }} {{ Auth::user()->ape1 }}</div>
                <div class="user-role">Administrador</div>
            </div>
        </div>
    </div>
</aside>

<div class="main-wrapper">
    <header class="topbar">
        <div class="topbar-left">
            <button class="btn-hamburger" id="btnHamburger" aria-label="Abrir menú">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <span class="page-title">@yield('title', 'Dashboard')</span>
        </div>
        <div class="topbar-right">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout" title="Cerrar sesión">
                    <svg style="width:16px;height:16px;display:inline-block;vertical-align:middle;margin-right:6px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    <span class="btn-logout-text">Cerrar sesión</span>
                </button>
            </form>
        </div>
    </header>

    <main class="content">
        @if(session('success'))
            <div class="alert alert-ok">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">✕ {{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>

@stack('scripts')
<script>
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebarOverlay');
    const btnHamb  = document.getElementById('btnHamburger');

    function openSidebar()  { sidebar.classList.add('open');  overlay.classList.add('active'); }
    function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('active'); }

    btnHamb.addEventListener('click', () => sidebar.classList.contains('open') ? closeSidebar() : openSidebar());
    overlay.addEventListener('click', closeSidebar);

    // Cierra el menú al navegar en móvil
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => { if (window.innerWidth <= 900) closeSidebar(); });
    });
</script>
</body>
</html>
