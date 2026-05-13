@extends('layouts.admin')
@section('title', 'Pedido #' . $pedido->cod_ped)

@push('styles')
<style>
    .back-link {
        display: inline-flex; align-items: center; gap: 6px;
        color: #666; font-size: 0.82rem; text-decoration: none;
        margin-bottom: 28px; transition: color 0.2s;
    }
    .back-link:hover { color: #d4af37; }
    .back-link svg { width: 14px; height: 14px; }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 900px) { .detail-grid { grid-template-columns: 1fr; } }

    .detail-card {
        background: #161616; border: 1px solid #1f1f1f;
        border-radius: 12px; overflow: hidden;
        margin-bottom: 20px;
    }

    .card-head {
        padding: 14px 22px; border-bottom: 1px solid #1e1e1e;
        font-size: 0.72rem; font-weight: 700; color: #555;
        text-transform: uppercase; letter-spacing: 2px;
        background: #141414;
    }

    .card-body { padding: 20px 22px; }

    /* INFO GRID */
    .info-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 14px;
    }

    .info-item { display: flex; flex-direction: column; gap: 3px; }
    .info-label { font-size: 0.7rem; color: #555; text-transform: uppercase; letter-spacing: 1px; }
    .info-value { font-size: 0.9rem; color: #ddd; font-weight: 500; }

    /* ITEMS TABLE */
    .items-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; border-radius: 10px; }
    .items-table { width: 100%; min-width: 480px; border-collapse: collapse; }

    .items-table th {
        padding: 10px 16px; font-size: 0.67rem; font-weight: 700;
        color: #444; text-transform: uppercase; letter-spacing: 1.5px;
        background: #141414; border-bottom: 1px solid #1a1a1a; text-align: left;
    }

    .items-table td {
        padding: 12px 16px; font-size: 0.87rem; color: #aaa;
        border-bottom: 1px solid #1a1a1a; vertical-align: middle;
    }

    .items-table tr:last-child td { border-bottom: none; }

    .item-img { width: 38px; height: 38px; border-radius: 6px; object-fit: cover; border: 1px solid #252525; }
    .item-img-ph { width: 38px; height: 38px; border-radius: 6px; background: #1e1e1e; border: 1px solid #252525; display: flex; align-items: center; justify-content: center; color: #333; }

    .item-name { color: #ddd; font-weight: 500; }
    .item-sub  { font-size: 0.75rem; color: #555; margin-top: 2px; }
    .talla-chip {
        display: inline-flex; align-items: center; justify-content: center;
        width: 34px; height: 34px; border-radius: 6px;
        background: #1a1a1a; border: 1px solid #252525;
        font-size: 0.78rem; font-weight: 700; color: #bbb;
    }

    .item-total { color: #d4af37; font-weight: 700; }

    .order-total-row td {
        padding: 14px 16px; border-top: 2px solid #252525 !important;
        font-size: 1rem; font-weight: 700; color: #d4af37;
    }

    /* STATUS CARD */
    .status-card {
        background: #161616; border: 1px solid #1f1f1f;
        border-radius: 12px; border-top: 3px solid #d4af37;
        overflow: hidden; position: relative;
    }

    .status-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(212,175,55,0.3), transparent);
    }

    .status-body { padding: 22px; }

    .status-label { font-size: 0.72rem; font-weight: 700; color: #555; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 14px; }

    .badge {
        display: inline-block; padding: 5px 14px;
        border-radius: 20px; font-size: 0.75rem;
        font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
        margin-bottom: 20px;
    }
    .badge-pendiente  { background: rgba(255,193,7,0.12);  color: #ffc107; }
    .badge-enviado    { background: rgba(13,110,253,0.12); color: #6ea8fe; }
    .badge-entregado  { background: rgba(25,135,84,0.12);  color: #75b798; }
    .badge-cancelado  { background: rgba(220,53,69,0.12);  color: #ea868f; }

    .estado-select {
        width: 100%; padding: 10px 12px;
        background: #121212; border: 1px solid #272727;
        border-radius: 7px; color: #e0e0e0;
        font-size: 0.9rem; font-family: inherit;
        margin-bottom: 12px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .estado-select:focus { outline: none; border-color: #d4af37; box-shadow: 0 0 0 3px rgba(212,175,55,0.1); }
    .estado-select option { background: #1a1a1a; }

    .btn-update-estado {
        width: 100%; padding: 11px;
        background: linear-gradient(135deg, #d4af37, #b8941f);
        border: none; border-radius: 7px; color: #121212;
        font-size: 0.88rem; font-weight: 700; cursor: pointer;
        font-family: inherit; transition: all 0.2s;
        box-shadow: 0 4px 14px rgba(212,175,55,0.2);
    }

    .btn-update-estado:hover {
        background: linear-gradient(135deg, #e8c84e, #d4af37);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(212,175,55,0.32);
    }

    .divider { border: none; border-top: 1px solid #1e1e1e; margin: 16px 0; }

    .client-row { display: flex; flex-direction: column; gap: 4px; }
    .client-name { font-size: 0.9rem; font-weight: 600; color: #ddd; }
    .client-email { font-size: 0.78rem; color: #555; }
</style>
@endpush

@section('content')
<div class="content-header">
    <h2>Pedido <span style="color:#d4af37">#{{ $pedido->cod_ped }}</span></h2>
    <p>{{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') }}</p>
</div>

<a href="{{ route('admin.pedidos.index') }}" class="back-link">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Volver a pedidos
</a>

<div class="detail-grid">

    {{-- Columna izquierda --}}
    <div>
        {{-- Artículos --}}
        <div class="detail-card">
            <div class="card-head">Artículos del pedido</div>
            <div class="items-table-wrap">
            <table class="items-table">
                <thead><tr>
                    <th></th>
                    <th>Producto</th>
                    <th>Talla</th>
                    <th>Precio u.</th>
                    <th>Cant.</th>
                    <th>Subtotal</th>
                </tr></thead>
                <tbody>
                    @foreach($pedido->detalles as $det)
                    @php $cam = $det->variante->camiseta ?? null; @endphp
                    <tr>
                        <td>
                            @if($cam?->imagen_principal)
                                <img src="{{ $cam->imagen_principal }}" alt="" class="item-img">
                            @else
                                <div class="item-img-ph">
                                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="width:16px;height:16px"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="item-name">{{ $cam->nombre ?? '—' }}</div>
                            @if($det->nombre_personalizado)
                                <div class="item-sub">Nombre: {{ $det->nombre_personalizado }} · Dorsal: {{ $det->dorsal_personalizado }}</div>
                            @endif
                        </td>
                        <td><span class="talla-chip">{{ $det->variante->talla ?? '—' }}</span></td>
                        <td>{{ number_format($det->precio_unid, 2, ',', '.') }} €</td>
                        <td>× {{ $det->cantidad }}</td>
                        <td class="item-total">{{ number_format($det->precio_unid * $det->cantidad, 2, ',', '.') }} €</td>
                    </tr>
                    @endforeach
                    <tr class="order-total-row">
                        <td colspan="5" style="text-align:right; color:#888; font-size:0.85rem">Total</td>
                        <td>{{ number_format($pedido->total, 2, ',', '.') }} €</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>

        {{-- Dirección --}}
        @if($pedido->direccion && $pedido->direccion->cod_dir)
        <div class="detail-card">
            <div class="card-head">Dirección de envío</div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Calle</span>
                        <span class="info-value">{{ $pedido->direccion->calle ?? '—' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Ciudad</span>
                        <span class="info-value">{{ $pedido->direccion->ciudad ?? '—' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Código postal</span>
                        <span class="info-value">{{ $pedido->direccion->cod_postal ?? '—' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">País</span>
                        <span class="info-value">{{ $pedido->direccion->pais ?? '—' }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Columna derecha --}}
    <div>
        {{-- Cambiar estado --}}
        <div class="status-card" style="margin-bottom:20px">
            <div class="status-body">
                <div class="status-label">Estado actual</div>
                <div>
                    <span class="badge badge-{{ $pedido->estado ?? 'pendiente' }}">
                        {{ ucfirst($pedido->estado ?? 'pendiente') }}
                    </span>
                </div>
                <hr class="divider">
                <form method="POST" action="{{ route('admin.pedidos.estado', $pedido->cod_ped) }}">
                    @csrf @method('PUT')
                    <select name="estado" class="estado-select">
                        @foreach($estados as $e)
                            <option value="{{ $e }}" {{ $pedido->estado == $e ? 'selected' : '' }}>
                                {{ ucfirst($e) }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-update-estado">Actualizar estado</button>
                </form>
            </div>
        </div>

        {{-- Cliente --}}
        <div class="detail-card">
            <div class="card-head">Cliente</div>
            <div class="card-body">
                <div class="client-row">
                    <span class="client-name">{{ $pedido->usuario->nombre ?? '—' }} {{ $pedido->usuario->ape1 ?? '' }}</span>
                    <span class="client-email">{{ $pedido->usuario->correo ?? '' }}</span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
