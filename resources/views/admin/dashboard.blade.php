@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
<style>
    /* ── STAT CARDS ─────────────────────────────── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 36px;
    }

    .stat-card {
        background: #161616;
        border: 1px solid #1f1f1f;
        border-radius: 12px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: border-color 0.2s, transform 0.2s;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: var(--accent, #d4af37);
        opacity: 0.6;
    }

    .stat-card:hover {
        border-color: #2a2a2a;
        transform: translateY(-2px);
    }

    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-label {
        font-size: 0.72rem;
        font-weight: 600;
        color: #555;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .stat-icon {
        width: 36px; height: 36px;
        border-radius: 8px;
        background: rgba(212,175,55,0.08);
        display: flex; align-items: center; justify-content: center;
    }

    .stat-icon svg { width: 18px; height: 18px; color: #d4af37; }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #e8e8e8;
        letter-spacing: -0.5px;
        line-height: 1;
    }

    .stat-value.gold { color: #d4af37; }

    .stat-sub {
        font-size: 0.78rem;
        color: #444;
    }

    /* ── PANELS ─────────────────────────────────── */
    .panels-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .panel {
        background: #161616;
        border: 1px solid #1f1f1f;
        border-radius: 12px;
        overflow: hidden;
    }

    .panel-header {
        padding: 18px 24px;
        border-bottom: 1px solid #1e1e1e;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .panel-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #ccc;
        letter-spacing: 0.2px;
    }

    .panel-link {
        font-size: 0.75rem;
        color: #d4af37;
        text-decoration: none;
        letter-spacing: 0.3px;
        opacity: 0.8;
        transition: opacity 0.2s;
    }

    .panel-link:hover { opacity: 1; }

    /* ── PEDIDOS TABLE ───────────────────────────── */
    .mini-table { width: 100%; border-collapse: collapse; }

    .mini-table td {
        padding: 13px 24px;
        font-size: 0.85rem;
        color: #aaa;
        border-bottom: 1px solid #1a1a1a;
        vertical-align: middle;
    }

    .mini-table tr:last-child td { border-bottom: none; }

    .mini-table tr:hover td { background: rgba(255,255,255,0.02); color: #ccc; }

    .order-id {
        font-weight: 600;
        color: #d4af37;
        font-size: 0.82rem;
    }

    .order-user { color: #ccc; font-weight: 500; }
    .order-total { font-weight: 600; color: #e0e0e0; white-space: nowrap; }

    .badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.68rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-pendiente  { background: rgba(255,193,7,0.12);  color: #ffc107; }
    .badge-enviado    { background: rgba(13,110,253,0.12); color: #6ea8fe; }
    .badge-entregado  { background: rgba(25,135,84,0.12);  color: #75b798; }
    .badge-cancelado  { background: rgba(220,53,69,0.12);  color: #ea868f; }

    /* ── STOCK TABLE ────────────────────────────── */
    .stock-row td { padding: 12px 24px; }

    .stock-nombre { font-weight: 500; color: #ccc; font-size: 0.85rem; }
    .stock-talla  { color: #666; font-size: 0.8rem; }

    .stock-num {
        font-weight: 700;
        font-size: 0.9rem;
    }

    .stock-num.zero   { color: #dc3545; }
    .stock-num.low    { color: #fd7e14; }
    .stock-num.ok     { color: #75b798; }

    .empty-state {
        padding: 40px 24px;
        text-align: center;
        color: #3a3a3a;
        font-size: 0.85rem;
        font-style: italic;
    }

    @media (max-width: 900px) {
        .panels-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<div class="content-header">
    <h2>Bienvenido, {{ Auth::user()->nombre }}</h2>
    <p>Resumen general de la tienda — {{ now()->format('d/m/Y') }}</p>
</div>

{{-- STAT CARDS --}}
<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Pedidos totales</span>
            <span class="stat-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            </span>
        </div>
        <div class="stat-value">{{ $stats['pedidos'] }}</div>
        <div class="stat-sub">{{ $stats['pedidos_pendientes'] }} pendientes de envío</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Ingresos totales</span>
            <span class="stat-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            </span>
        </div>
        <div class="stat-value gold">{{ number_format($stats['ingresos'], 2, ',', '.') }} €</div>
        <div class="stat-sub">Suma de todos los pedidos</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Camisetas</span>
            <span class="stat-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.57a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.57a2 2 0 00-1.34-2.23z"/></svg>
            </span>
        </div>
        <div class="stat-value">{{ $stats['camisetas'] }}</div>
        <div class="stat-sub">Productos en catálogo</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Usuarios</span>
            <span class="stat-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </span>
        </div>
        <div class="stat-value">{{ $stats['usuarios'] }}</div>
        <div class="stat-sub">Clientes registrados</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Mensajes</span>
            <span class="stat-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </span>
        </div>
        <div class="stat-value">{{ $stats['mensajes'] }}</div>
        <div class="stat-sub">Contactos recibidos</div>
    </div>

</div>

{{-- PANELS --}}
<div class="panels-grid">

    {{-- Últimos pedidos --}}
    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">Últimos pedidos</span>
            <a href="{{ route('admin.pedidos.index') }}" class="panel-link">Ver todos →</a>
        </div>
        @if($pedidos_recientes->isEmpty())
            <p class="empty-state">No hay pedidos todavía.</p>
        @else
            <table class="mini-table">
                @foreach($pedidos_recientes as $pedido)
                <tr>
                    <td><span class="order-id">#{{ $pedido->cod_ped }}</span></td>
                    <td><span class="order-user">{{ $pedido->usuario->nombre ?? '—' }}</span></td>
                    <td>
                        <span class="badge badge-{{ $pedido->estado ?? 'pendiente' }}">
                            {{ ucfirst($pedido->estado ?? 'pendiente') }}
                        </span>
                    </td>
                    <td class="order-total">{{ number_format($pedido->total, 2, ',', '.') }} €</td>
                </tr>
                @endforeach
            </table>
        @endif
    </div>

    {{-- Stock bajo --}}
    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">Stock bajo</span>
            <a href="{{ route('admin.camisetas.index') }}" class="panel-link">Gestionar →</a>
        </div>
        @if($stock_bajo->isEmpty())
            <p class="empty-state">Todo el stock está en niveles correctos.</p>
        @else
            <table class="mini-table">
                @foreach($stock_bajo as $variante)
                <tr class="stock-row">
                    <td>
                        <div class="stock-nombre">{{ $variante->camiseta->nombre ?? '—' }}</div>
                        <div class="stock-talla">Talla {{ $variante->talla }}</div>
                    </td>
                    <td>
                        <span class="stock-num {{ $variante->stock == 0 ? 'zero' : ($variante->stock <= 2 ? 'low' : 'ok') }}">
                            {{ $variante->stock }} uds.
                        </span>
                    </td>
                </tr>
                @endforeach
            </table>
        @endif
    </div>

</div>

@endsection
