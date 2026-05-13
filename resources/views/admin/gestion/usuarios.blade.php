@extends('layouts.admin')
@section('title', 'Usuarios')

@push('styles')
<style>
    .filter-bar {
        display: flex; gap: 10px; margin-bottom: 24px; flex-wrap: wrap; align-items: center;
    }

    .filter-input, .filter-select {
        padding: 9px 13px; background: #161616; border: 1px solid #252525;
        border-radius: 8px; color: #e0e0e0; font-size: 0.87rem; font-family: inherit;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .filter-input { width: 220px; }

    @media (max-width: 520px) {
        .filter-input, .filter-select, .btn-filter, .btn-reset { width: 100%; }
    }

    .filter-input:focus, .filter-select:focus {
        outline: none; border-color: #d4af37; box-shadow: 0 0 0 3px rgba(212,175,55,0.1);
    }

    .filter-select option { background: #1a1a1a; }

    .btn-filter {
        padding: 9px 18px; background: linear-gradient(135deg, #d4af37, #b8941f);
        border: none; border-radius: 8px; color: #121212;
        font-size: 0.85rem; font-weight: 700; cursor: pointer; font-family: inherit;
        transition: all 0.2s;
    }

    .btn-filter:hover { background: linear-gradient(135deg, #e8c84e, #d4af37); }

    .btn-reset {
        padding: 9px 14px; background: transparent; border: 1px solid #2a2a2a;
        border-radius: 8px; color: #666; font-size: 0.85rem;
        cursor: pointer; font-family: inherit; text-decoration: none; transition: all 0.2s;
    }

    .btn-reset:hover { border-color: #444; color: #999; }

    .data-table-wrap { background: #161616; border: 1px solid #1f1f1f; border-radius: 12px; overflow: hidden; }
    .data-table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .data-table { width: 100%; min-width: 640px; border-collapse: collapse; }

    .data-table thead th {
        padding: 13px 18px; font-size: 0.67rem; font-weight: 700; color: #444;
        text-transform: uppercase; letter-spacing: 1.5px;
        background: #141414; border-bottom: 1px solid #1a1a1a; text-align: left;
    }

    .data-table tbody td {
        padding: 13px 18px; font-size: 0.87rem; color: #aaa;
        border-bottom: 1px solid #1a1a1a; vertical-align: middle;
    }

    .data-table tbody tr:last-child td { border-bottom: none; }
    .data-table tbody tr:hover td { background: rgba(255,255,255,0.02); }

    .user-avatar {
        width: 34px; height: 34px; border-radius: 50%;
        background: linear-gradient(135deg, #2a2a2a, #1e1e1e);
        border: 1px solid #333; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.82rem; color: #d4af37;
        flex-shrink: 0;
    }

    .user-info-cell { display: flex; align-items: center; gap: 12px; }
    .user-fullname { color: #ddd; font-weight: 500; font-size: 0.88rem; }
    .user-email    { color: #555; font-size: 0.78rem; margin-top: 2px; }

    .rol-badge-admin   { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; background: rgba(212,175,55,0.12); color: #d4af37; border: 1px solid rgba(212,175,55,0.2); }
    .rol-badge-usuario { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; background: rgba(255,255,255,0.05); color: #666; border: 1px solid #252525; }

    .pedidos-count { font-weight: 700; color: #aaa; }

    .row-actions { display: flex; gap: 6px; align-items: center; }

    .rol-form select {
        padding: 6px 10px; background: #121212; border: 1px solid #252525;
        border-radius: 6px; color: #e0e0e0; font-size: 0.8rem; font-family: inherit;
        cursor: pointer; transition: border-color 0.2s;
    }

    .rol-form select:focus { outline: none; border-color: #d4af37; }
    .rol-form select option { background: #1a1a1a; }

    .btn-rol-save {
        padding: 6px 12px; background: transparent; border: 1px solid #2a2a2a;
        border-radius: 6px; color: #888; font-size: 0.78rem; font-weight: 600;
        cursor: pointer; font-family: inherit; transition: all 0.2s;
    }

    .btn-rol-save:hover { border-color: #d4af37; color: #d4af37; background: rgba(212,175,55,0.05); }

    .btn-del {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px; border-radius: 7px; border: 1px solid #222;
        background: transparent; color: #666; cursor: pointer; transition: all 0.2s;
        font-family: inherit;
    }

    .btn-del:hover { border-color: #dc3545; color: #ff6b6b; background: rgba(220,53,69,0.06); }
    .btn-del svg { width: 14px; height: 14px; }

    .me-tag { font-size: 0.65rem; background: rgba(212,175,55,0.1); color: #d4af37; padding: 1px 6px; border-radius: 4px; margin-left: 6px; font-weight: 700; letter-spacing: 0.5px; }

    .pagination-wrap {
        padding: 16px 18px; border-top: 1px solid #1a1a1a;
        display: flex; justify-content: flex-end; gap: 6px;
    }

    .page-link {
        padding: 6px 12px; border: 1px solid #252525; border-radius: 6px;
        color: #888; font-size: 0.82rem; text-decoration: none; transition: all 0.2s;
    }

    .page-link:hover, .page-link.active { border-color: #d4af37; color: #d4af37; background: rgba(212,175,55,0.06); }

    .empty-state { padding: 60px 24px; text-align: center; color: #3a3a3a; font-size: 0.9rem; font-style: italic; }
</style>
@endpush

@section('content')
<div class="content-header">
    <h2>Usuarios</h2>
    <p>Gestión de clientes y administradores</p>
</div>

<form method="GET" action="{{ route('admin.usuarios.index') }}" class="filter-bar">
    <input type="text" name="buscar" class="filter-input" placeholder="Nombre o correo..." value="{{ request('buscar') }}">
    <select name="rol" class="filter-select">
        <option value="">Todos los roles</option>
        <option value="usuario" {{ request('rol') == 'usuario' ? 'selected' : '' }}>Usuario</option>
        <option value="admin"   {{ request('rol') == 'admin'   ? 'selected' : '' }}>Admin</option>
    </select>
    <button type="submit" class="btn-filter">Filtrar</button>
    @if(request()->hasAny(['buscar','rol']))
        <a href="{{ route('admin.usuarios.index') }}" class="btn-reset">Limpiar</a>
    @endif
</form>

<div class="data-table-wrap">
    @if($usuarios->isEmpty())
        <p class="empty-state">No hay usuarios con los filtros aplicados.</p>
    @else
    <div class="data-table-scroll">
    <table class="data-table">
        <thead><tr>
            <th>#</th>
            <th>Usuario</th>
            <th>Rol</th>
            <th>Pedidos</th>
            <th>Cambiar rol</th>
            <th></th>
        </tr></thead>
        <tbody>
            @foreach($usuarios as $u)
            @php $esYo = $u->cod_usu === Auth::id(); @endphp
            <tr>
                <td style="color:#d4af37;font-weight:600;font-size:0.78rem">#{{ $u->cod_usu }}</td>
                <td>
                    <div class="user-info-cell">
                        <div class="user-avatar">{{ strtoupper(substr($u->nombre, 0, 1)) }}</div>
                        <div>
                            <div class="user-fullname">
                                {{ $u->nombre }} {{ $u->ape1 }}
                                @if($esYo)<span class="me-tag">Tú</span>@endif
                            </div>
                            <div class="user-email">{{ $u->correo }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="rol-badge-{{ $u->rol }}">{{ $u->rol }}</span>
                </td>
                <td><span class="pedidos-count">{{ $u->pedidos_count }}</span></td>
                <td>
                    @if(!$esYo)
                    <form method="POST" action="{{ route('admin.usuarios.rol', $u->cod_usu) }}" class="rol-form" style="display:flex;gap:6px">
                        @csrf @method('PUT')
                        <select name="rol">
                            <option value="usuario" {{ $u->rol == 'usuario' ? 'selected' : '' }}>Usuario</option>
                            <option value="admin"   {{ $u->rol == 'admin'   ? 'selected' : '' }}>Admin</option>
                        </select>
                        <button type="submit" class="btn-rol-save">Guardar</button>
                    </form>
                    @else
                        <span style="color:#333;font-size:0.78rem">—</span>
                    @endif
                </td>
                <td>
                    @if(!$esYo)
                    <form method="POST" action="{{ route('admin.usuarios.destroy', $u->cod_usu) }}"
                          onsubmit="return confirm('¿Eliminar a «{{ addslashes($u->nombre) }}»? Se borrarán sus datos.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-del" title="Eliminar usuario">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                        </button>
                    </form>
                    @else
                        <span style="color:#333;font-size:0.78rem">—</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    @if($usuarios->hasPages())
    <div class="pagination-wrap">
        @if($usuarios->onFirstPage())
            <span class="page-link" style="opacity:0.3">← Anterior</span>
        @else
            <a href="{{ $usuarios->previousPageUrl() }}" class="page-link">← Anterior</a>
        @endif
        @foreach($usuarios->getUrlRange(1, $usuarios->lastPage()) as $page => $url)
            <a href="{{ $url }}" class="page-link {{ $page == $usuarios->currentPage() ? 'active' : '' }}">{{ $page }}</a>
        @endforeach
        @if($usuarios->hasMorePages())
            <a href="{{ $usuarios->nextPageUrl() }}" class="page-link">Siguiente →</a>
        @else
            <span class="page-link" style="opacity:0.3">Siguiente →</span>
        @endif
    </div>
    @endif
    @endif
</div>
@endsection
