@extends('layouts.admin')

@section('title', 'Camisetas')

@push('styles')
<style>
    .page-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        background: linear-gradient(135deg, #d4af37, #b8941f);
        border: none;
        border-radius: 8px;
        color: #121212;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        letter-spacing: 0.5px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 16px rgba(212,175,55,0.2);
        font-family: inherit;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #e8c84e, #d4af37);
        transform: translateY(-1px);
        box-shadow: 0 6px 22px rgba(212,175,55,0.35);
        color: #121212;
    }

    .btn-primary svg { width: 16px; height: 16px; }

    .search-form {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .search-input {
        padding: 9px 14px;
        background: #161616;
        border: 1px solid #252525;
        border-radius: 8px;
        color: #e0e0e0;
        font-size: 0.87rem;
        font-family: inherit;
        width: 240px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .search-input:focus {
        outline: none;
        border-color: #d4af37;
        box-shadow: 0 0 0 3px rgba(212,175,55,0.1);
    }

    /* TABLE */
    .data-table-wrap {
        background: #161616;
        border: 1px solid #1f1f1f;
        border-radius: 12px;
        overflow: hidden;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead th {
        padding: 14px 20px;
        font-size: 0.68rem;
        font-weight: 700;
        color: #555;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        background: #141414;
        border-bottom: 1px solid #1e1e1e;
        text-align: left;
        white-space: nowrap;
    }

    .data-table tbody td {
        padding: 14px 20px;
        font-size: 0.87rem;
        color: #aaa;
        border-bottom: 1px solid #1a1a1a;
        vertical-align: middle;
    }

    .data-table tbody tr:last-child td { border-bottom: none; }

    .data-table tbody tr {
        transition: background 0.15s;
    }

    .data-table tbody tr:hover td {
        background: rgba(255,255,255,0.02);
        color: #ccc;
    }

    .cam-thumb {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        object-fit: cover;
        background: #1e1e1e;
        border: 1px solid #252525;
        display: block;
    }

    .cam-thumb-placeholder {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        background: #1e1e1e;
        border: 1px solid #252525;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
    }

    .cam-nombre {
        font-weight: 600;
        color: #ddd;
        font-size: 0.9rem;
    }

    .cam-id {
        font-size: 0.78rem;
        color: #d4af37;
        font-weight: 600;
    }

    .price-tag {
        font-weight: 700;
        color: #d4af37;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .tag {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        background: rgba(212,175,55,0.08);
        color: #b8941f;
        border: 1px solid rgba(212,175,55,0.15);
    }

    .tag-muted {
        background: rgba(255,255,255,0.04);
        color: #444;
        border: 1px solid #222;
    }

    /* ACTIONS */
    .actions { display: flex; gap: 8px; align-items: center; }

    .btn-edit, .btn-del {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px; height: 34px;
        border-radius: 7px;
        border: 1px solid;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        background: transparent;
        font-family: inherit;
    }

    .btn-edit {
        border-color: #2a2a2a;
        color: #888;
    }

    .btn-edit:hover {
        border-color: #d4af37;
        color: #d4af37;
        background: rgba(212,175,55,0.06);
    }

    .btn-del {
        border-color: #2a2a2a;
        color: #888;
    }

    .btn-del:hover {
        border-color: #dc3545;
        color: #ff6b6b;
        background: rgba(220,53,69,0.06);
    }

    .btn-edit svg, .btn-del svg { width: 15px; height: 15px; }

    /* PAGINATION */
    .pagination-wrap {
        padding: 18px 20px;
        border-top: 1px solid #1a1a1a;
        display: flex;
        justify-content: flex-end;
        gap: 6px;
        align-items: center;
    }

    .pagination-wrap .page-link {
        padding: 6px 12px;
        border: 1px solid #252525;
        border-radius: 6px;
        color: #888;
        font-size: 0.82rem;
        text-decoration: none;
        transition: all 0.2s;
        background: transparent;
    }

    .pagination-wrap .page-link:hover,
    .pagination-wrap .page-link.active {
        border-color: #d4af37;
        color: #d4af37;
        background: rgba(212,175,55,0.06);
    }

    .empty-state {
        padding: 60px 24px;
        text-align: center;
        color: #3a3a3a;
        font-size: 0.9rem;
    }

    .empty-state svg {
        width: 40px; height: 40px;
        color: #222;
        margin: 0 auto 16px;
        display: block;
    }
</style>
@endpush

@section('content')

<div class="content-header">
    <h2>Camisetas</h2>
    <p>Gestión del catálogo de camisetas</p>
</div>

<div class="page-actions">
    <a href="{{ route('admin.camisetas.create') }}" class="btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Nueva camiseta
    </a>
</div>

<div class="data-table-wrap">
    @if($camisetas->isEmpty())
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.57a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.57a2 2 0 00-1.34-2.23z"/></svg>
            No hay camisetas en el catálogo.
        </div>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Color</th>
                    <th>Precio</th>
                    <th>Equipo / Selección</th>
                    <th>Temporada</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($camisetas as $cam)
                <tr>
                    <td><span class="cam-id">#{{ $cam->cod_cam }}</span></td>
                    <td>
                        @if($cam->imagen_principal)
                            <img src="{{ $cam->imagen_principal }}"
                                 alt="{{ $cam->nombre }}"
                                 class="cam-thumb">
                        @else
                            <div class="cam-thumb-placeholder">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="width:20px;height:20px"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                            </div>
                        @endif
                    </td>
                    <td><span class="cam-nombre">{{ $cam->nombre }}</span></td>
                    <td>{{ $cam->color }}</td>
                    <td><span class="price-tag">{{ number_format($cam->precio, 2, ',', '.') }} €</span></td>
                    <td>
                        @if($cam->equipo)
                            <span class="tag">{{ $cam->equipo->nombre }}</span>
                        @elseif($cam->seleccion)
                            <span class="tag">{{ $cam->seleccion->nombre }}</span>
                        @else
                            <span class="tag tag-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($cam->temporada)
                            <span class="tag">{{ $cam->temporada->inicio }}/{{ $cam->temporada->fin }}</span>
                        @else
                            <span class="tag tag-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.camisetas.edit', $cam->cod_cam) }}" class="btn-edit" title="Editar">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.camisetas.destroy', $cam->cod_cam) }}"
                                  onsubmit="return confirm('¿Eliminar «{{ addslashes($cam->nombre) }}»? Esta acción no se puede deshacer.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-del" title="Eliminar">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

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
    @endif
</div>

@endsection
