@extends('layouts.admin')
@section('title', 'Pedidos')

@push('styles')
<style>
    .filter-bar {
        display: flex;
        gap: 10px;
        margin-bottom: 24px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-input, .filter-select {
        padding: 9px 13px;
        background: #161616;
        border: 1px solid #252525;
        border-radius: 8px;
        color: #e0e0e0;
        font-size: 0.87rem;
        font-family: inherit;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .filter-input { width: 200px; }
    .filter-select { min-width: 150px; }

    .filter-input:focus, .filter-select:focus {
        outline: none;
        border-color: #d4af37;
        box-shadow: 0 0 0 3px rgba(212,175,55,0.1);
    }

    .filter-select option { background: #1a1a1a; }

    .btn-filter {
        padding: 9px 18px;
        background: linear-gradient(135deg, #d4af37, #b8941f);
        border: none; border-radius: 8px;
        color: #121212; font-size: 0.85rem; font-weight: 700;
        cursor: pointer; font-family: inherit;
        transition: all 0.2s;
    }

    .btn-filter:hover { background: linear-gradient(135deg, #e8c84e, #d4af37); }

    .btn-reset {
        padding: 9px 14px;
        background: transparent;
        border: 1px solid #2a2a2a;
        border-radius: 8px;
        color: #666; font-size: 0.85rem;
        cursor: pointer; font-family: inherit;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-reset:hover { border-color: #444; color: #999; }

    .data-table-wrap {
        background: #161616;
        border: 1px solid #1f1f1f;
        border-radius: 12px;
        overflow: hidden;
    }

    .data-table { width: 100%; border-collapse: collapse; }

    .data-table thead th {
        padding: 13px 18px;
        font-size: 0.67rem; font-weight: 700; color: #444;
        text-transform: uppercase; letter-spacing: 1.5px;
        background: #141414; border-bottom: 1px solid #1a1a1a;
        text-align: left; white-space: nowrap;
    }

    .data-table tbody td {
        padding: 13px 18px;
        font-size: 0.87rem; color: #aaa;
        border-bottom: 1px solid #1a1a1a;
        vertical-align: middle;
    }

    .data-table tbody tr:last-child td { border-bottom: none; }
    .data-table tbody tr:hover td { background: rgba(255,255,255,0.02); }

    .ped-id { color: #d4af37; font-weight: 700; font-size: 0.82rem; }
    .ped-user { color: #ddd; font-weight: 500; }
    .ped-total { color: #e0e0e0; font-weight: 700; white-space: nowrap; }

    .badge {
        display: inline-block; padding: 3px 10px;
        border-radius: 20px; font-size: 0.68rem;
        font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .badge-pendiente  { background: rgba(255,193,7,0.12);  color: #ffc107; }
    .badge-enviado    { background: rgba(13,110,253,0.12); color: #6ea8fe; }
    .badge-entregado  { background: rgba(25,135,84,0.12);  color: #75b798; }
    .badge-cancelado  { background: rgba(220,53,69,0.12);  color: #ea868f; }

    .btn-ver {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 14px; border-radius: 6px;
        border: 1px solid #2a2a2a; background: transparent;
        color: #777; font-size: 0.78rem; font-weight: 600;
        text-decoration: none; transition: all 0.2s;
    }

    .btn-ver:hover { border-color: #d4af37; color: #d4af37; background: rgba(212,175,55,0.05); }
    .btn-ver svg { width: 13px; height: 13px; }

    .empty-state {
        padding: 60px 24px; text-align: center;
        color: #3a3a3a; font-size: 0.9rem; font-style: italic;
    }

    .pagination-wrap {
        padding: 16px 18px; border-top: 1px solid #1a1a1a;
        display: flex; justify-content: flex-end; gap: 6px;
    }

    .page-link {
        padding: 6px 12px; border: 1px solid #252525;
        border-radius: 6px; color: #888; font-size: 0.82rem;
        text-decoration: none; transition: all 0.2s;
    }

    .page-link:hover, .page-link.active {
        border-color: #d4af37; color: #d4af37;
        background: rgba(212,175,55,0.06);
    }
</style>
@endpush

@section('content')
<div class="content-header">
    <h2>Pedidos</h2>
    <p>Gestión y seguimiento de pedidos</p>
</div>

<form method="GET" action="{{ route('admin.pedidos.index') }}" class="filter-bar">
    <input type="text" name="buscar" class="filter-input" placeholder="Nº pedido..." value="{{ request('buscar') }}">
    <select name="estado" class="filter-select">
        <option value="">Todos los estados</option>
        @foreach($estados as $e)
            <option value="{{ $e }}" {{ request('estado') == $e ? 'selected' : '' }}>{{ ucfirst($e) }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn-filter">Filtrar</button>
    @if(request()->hasAny(['buscar','estado']))
        <a href="{{ route('admin.pedidos.index') }}" class="btn-reset">Limpiar</a>
    @endif
</form>

<div class="data-table-wrap">
    @if($pedidos->isEmpty())
        <p class="empty-state">No hay pedidos con los filtros aplicados.</p>
    @else
    <table class="data-table">
        <thead><tr>
            <th>#</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Estado</th>
            <th></th>
        </tr></thead>
        <tbody>
            @foreach($pedidos as $p)
            <tr>
                <td><span class="ped-id">#{{ $p->cod_ped }}</span></td>
                <td>{{ \Carbon\Carbon::parse($p->fecha)->format('d/m/Y') }}</td>
                <td><span class="ped-user">{{ $p->usuario->nombre ?? '—' }} {{ $p->usuario->ape1 ?? '' }}</span></td>
                <td><span class="ped-total">{{ number_format($p->total, 2, ',', '.') }} €</span></td>
                <td>
                    <span class="badge badge-{{ $p->estado ?? 'pendiente' }}">
                        {{ ucfirst($p->estado ?? 'pendiente') }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.pedidos.show', $p->cod_ped) }}" class="btn-ver">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        Ver
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($pedidos->hasPages())
    <div class="pagination-wrap">
        @if($pedidos->onFirstPage())
            <span class="page-link" style="opacity:0.3">← Anterior</span>
        @else
            <a href="{{ $pedidos->previousPageUrl() }}" class="page-link">← Anterior</a>
        @endif
        @foreach($pedidos->getUrlRange(1, $pedidos->lastPage()) as $page => $url)
            <a href="{{ $url }}" class="page-link {{ $page == $pedidos->currentPage() ? 'active' : '' }}">{{ $page }}</a>
        @endforeach
        @if($pedidos->hasMorePages())
            <a href="{{ $pedidos->nextPageUrl() }}" class="page-link">Siguiente →</a>
        @else
            <span class="page-link" style="opacity:0.3">Siguiente →</span>
        @endif
    </div>
    @endif
    @endif
</div>
@endsection
