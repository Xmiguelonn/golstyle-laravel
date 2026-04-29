@extends('layouts.admin')

@section('title', 'Stock / Variantes')

@push('styles')
<style>
    .cam-row {
        background: #161616;
        border: 1px solid #1f1f1f;
        border-radius: 12px;
        margin-bottom: 16px;
        overflow: hidden;
        transition: border-color 0.2s;
    }

    .cam-row:hover { border-color: #2a2a2a; }

    .cam-header {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 18px 24px;
        border-bottom: 1px solid #1a1a1a;
    }

    .cam-thumb {
        width: 48px; height: 48px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #252525;
        background: #1e1e1e;
        flex-shrink: 0;
    }

    .cam-thumb-ph {
        width: 48px; height: 48px;
        border-radius: 8px;
        background: #1e1e1e;
        border: 1px solid #252525;
        display: flex; align-items: center; justify-content: center;
        color: #333; flex-shrink: 0;
    }

    .cam-info { flex: 1; min-width: 0; }
    .cam-nombre {
        font-size: 0.95rem;
        font-weight: 600;
        color: #ddd;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .cam-meta { font-size: 0.78rem; color: #555; margin-top: 2px; }

    .cam-edit-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 18px;
        background: transparent;
        border: 1px solid #2a2a2a;
        border-radius: 7px;
        color: #888;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .cam-edit-btn:hover {
        border-color: #d4af37;
        color: #d4af37;
        background: rgba(212,175,55,0.05);
    }

    .cam-edit-btn svg { width: 14px; height: 14px; }

    /* TALLAS CHIPS */
    .tallas-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        padding: 16px 24px;
        align-items: center;
    }

    .talla-chip {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 3px;
        padding: 8px 14px;
        border-radius: 8px;
        border: 1px solid #222;
        background: #111;
        min-width: 56px;
    }

    .talla-chip .t-label {
        font-size: 0.72rem;
        font-weight: 700;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .talla-chip .t-stock {
        font-size: 1rem;
        font-weight: 700;
        line-height: 1;
    }

    .t-stock.zero  { color: #dc3545; }
    .t-stock.low   { color: #fd7e14; }
    .t-stock.ok    { color: #75b798; }

    .no-variantes {
        padding: 14px 24px;
        font-size: 0.83rem;
        color: #3a3a3a;
        font-style: italic;
    }

    /* PAGINATION */
    .pagination-wrap {
        margin-top: 24px;
        display: flex;
        justify-content: flex-end;
        gap: 6px;
    }

    .page-link {
        padding: 6px 12px;
        border: 1px solid #252525;
        border-radius: 6px;
        color: #888;
        font-size: 0.82rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .page-link:hover, .page-link.active {
        border-color: #d4af37;
        color: #d4af37;
        background: rgba(212,175,55,0.06);
    }
</style>
@endpush

@section('content')

<div class="content-header">
    <h2>Stock / Variantes</h2>
    <p>Gestión de tallas y unidades disponibles por camiseta</p>
</div>

@foreach($camisetas as $cam)
<div class="cam-row">
    <div class="cam-header">
        @if($cam->imagen_principal)
            <img src="{{ $cam->imagen_principal }}" alt="{{ $cam->nombre }}" class="cam-thumb">
        @else
            <div class="cam-thumb-ph">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="width:20px;height:20px"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
            </div>
        @endif

        <div class="cam-info">
            <div class="cam-nombre">{{ $cam->nombre }}</div>
            <div class="cam-meta">
                {{ $cam->variantes->count() }} talla(s) &middot;
                {{ $cam->variantes->sum('stock') }} uds. totales
                @if($cam->variantes->where('stock', 0)->count())
                    &middot; <span style="color:#dc3545">{{ $cam->variantes->where('stock', 0)->count() }} agotada(s)</span>
                @endif
            </div>
        </div>

        <a href="{{ route('admin.variantes.edit', $cam->cod_cam) }}" class="cam-edit-btn">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Gestionar
        </a>
    </div>

    @if($cam->variantes->isEmpty())
        <p class="no-variantes">Sin variantes registradas.</p>
    @else
        <div class="tallas-row">
            @foreach($cam->variantes->sortBy('talla') as $v)
            <div class="talla-chip">
                <span class="t-label">{{ $v->talla }}</span>
                <span class="t-stock {{ $v->stock == 0 ? 'zero' : ($v->stock <= 3 ? 'low' : 'ok') }}">
                    {{ $v->stock }}
                </span>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endforeach

@if($camisetas->hasPages())
<div class="pagination-wrap">
    @if($camisetas->onFirstPage())
        <span class="page-link" style="opacity:0.3">← Anterior</span>
    @else
        <a href="{{ $camisetas->previousPageUrl() }}" class="page-link">← Anterior</a>
    @endif

    @foreach($camisetas->getUrlRange(1, $camisetas->lastPage()) as $page => $url)
        <a href="{{ $url }}" class="page-link {{ $page == $camisetas->currentPage() ? 'active' : '' }}">{{ $page }}</a>
    @endforeach

    @if($camisetas->hasMorePages())
        <a href="{{ $camisetas->nextPageUrl() }}" class="page-link">Siguiente →</a>
    @else
        <span class="page-link" style="opacity:0.3">Siguiente →</span>
    @endif
</div>
@endif

@endsection
