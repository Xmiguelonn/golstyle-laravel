@extends('layouts.admin')

@section('title', 'Gestionar stock')

@push('styles')
<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #666;
        font-size: 0.82rem;
        text-decoration: none;
        margin-bottom: 28px;
        transition: color 0.2s;
    }
    .back-link:hover { color: #d4af37; }
    .back-link svg { width: 14px; height: 14px; }

    .cam-identity {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 32px;
        padding: 20px 24px;
        background: #161616;
        border: 1px solid #1f1f1f;
        border-radius: 12px;
    }

    .cam-identity img, .cam-identity .ph {
        width: 64px; height: 64px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid #252525;
        flex-shrink: 0;
    }

    .cam-identity .ph {
        background: #1e1e1e;
        display: flex; align-items: center; justify-content: center;
        color: #333;
    }

    .ci-text h3 { font-size: 1.05rem; font-weight: 700; color: #ddd; }
    .ci-text p  { font-size: 0.8rem; color: #555; margin-top: 3px; }

    /* STOCK TABLE */
    .stock-card {
        background: #161616;
        border: 1px solid #1f1f1f;
        border-radius: 12px;
        border-top: 3px solid #d4af37;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .stock-card-header {
        padding: 16px 24px;
        border-bottom: 1px solid #1e1e1e;
        font-size: 0.72rem;
        font-weight: 700;
        color: #555;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .stock-table { width: 100%; border-collapse: collapse; }

    .stock-table th {
        padding: 11px 24px;
        font-size: 0.68rem;
        font-weight: 700;
        color: #444;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        background: #141414;
        border-bottom: 1px solid #1a1a1a;
        text-align: left;
    }

    .stock-table td {
        padding: 14px 24px;
        border-bottom: 1px solid #1a1a1a;
        vertical-align: middle;
    }

    .stock-table tr:last-child td { border-bottom: none; }

    .talla-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px; height: 42px;
        border-radius: 8px;
        background: #1a1a1a;
        border: 1px solid #252525;
        font-size: 0.85rem;
        font-weight: 700;
        color: #ccc;
        letter-spacing: 0.5px;
    }

    .stock-input {
        width: 90px;
        padding: 9px 12px;
        background: #121212;
        border: 1px solid #272727;
        border-radius: 7px;
        color: #e0e0e0;
        font-size: 0.95rem;
        font-weight: 600;
        font-family: inherit;
        text-align: center;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .stock-input:focus {
        outline: none;
        border-color: #d4af37;
        box-shadow: 0 0 0 3px rgba(212,175,55,0.1);
    }

    .stock-indicator {
        width: 8px; height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }
    .ind-zero { background: #dc3545; }
    .ind-low  { background: #fd7e14; }
    .ind-ok   { background: #75b798; }

    .btn-del-var {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px; height: 34px;
        border-radius: 7px;
        border: 1px solid #2a2a2a;
        background: transparent;
        color: #666;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
    }

    .btn-del-var:hover {
        border-color: #dc3545;
        color: #ff6b6b;
        background: rgba(220,53,69,0.06);
    }

    .btn-del-var svg { width: 14px; height: 14px; }

    /* ADD VARIANT */
    .add-card {
        background: #161616;
        border: 1px solid #1f1f1f;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .add-card-header {
        padding: 16px 24px;
        border-bottom: 1px solid #1e1e1e;
        font-size: 0.72rem;
        font-weight: 700;
        color: #555;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .add-body {
        padding: 20px 24px;
        display: flex;
        gap: 12px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .add-group { display: flex; flex-direction: column; gap: 6px; }

    .add-group label {
        font-size: 0.7rem;
        font-weight: 600;
        color: #d4af37;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .add-select, .add-input {
        padding: 9px 14px;
        background: #121212;
        border: 1px solid #272727;
        border-radius: 7px;
        color: #e0e0e0;
        font-size: 0.9rem;
        font-family: inherit;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .add-select { width: 120px; }
    .add-input  { width: 100px; text-align: center; }

    .add-select:focus, .add-input:focus {
        outline: none;
        border-color: #d4af37;
        box-shadow: 0 0 0 3px rgba(212,175,55,0.1);
    }

    .add-select option { background: #1a1a1a; }

    .tallas-existentes {
        font-size: 0.75rem;
        color: #444;
        margin-top: 4px;
    }

    /* FOOTER */
    .form-footer {
        display: flex;
        gap: 12px;
        margin-top: 8px;
    }

    .btn-save {
        padding: 11px 28px;
        background: linear-gradient(135deg, #d4af37, #b8941f);
        border: none;
        border-radius: 8px;
        color: #121212;
        font-size: 0.88rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.2s;
        box-shadow: 0 4px 16px rgba(212,175,55,0.2);
    }

    .btn-save:hover {
        background: linear-gradient(135deg, #e8c84e, #d4af37);
        transform: translateY(-1px);
        box-shadow: 0 6px 22px rgba(212,175,55,0.35);
    }

    .btn-cancel {
        padding: 11px 24px;
        background: transparent;
        border: 1px solid #2a2a2a;
        border-radius: 8px;
        color: #666;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-cancel:hover { border-color: #444; color: #999; }

    .empty-state {
        padding: 32px 24px;
        text-align: center;
        color: #3a3a3a;
        font-size: 0.85rem;
        font-style: italic;
    }
</style>
@endpush

@section('content')

<div class="content-header">
    <h2>Gestionar stock</h2>
    <p>Tallas y unidades disponibles</p>
</div>

<a href="{{ route('admin.variantes.index') }}" class="back-link">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Volver al listado
</a>

{{-- Identidad de la camiseta --}}
<div class="cam-identity">
    @if($camiseta->imagen_principal)
        <img src="{{ $camiseta->imagen_principal }}" alt="{{ $camiseta->nombre }}">
    @else
        <div class="ph">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="width:24px;height:24px"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
        </div>
    @endif
    <div class="ci-text">
        <h3>{{ $camiseta->nombre }}</h3>
        <p>{{ $camiseta->color }} &middot; {{ number_format($camiseta->precio, 2, ',', '.') }} € &middot; #{{ $camiseta->cod_cam }}</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.variantes.update', $camiseta->cod_cam) }}">
    @csrf @method('PUT')

    {{-- Variantes existentes --}}
    <div class="stock-card">
        <div class="stock-card-header">Tallas registradas</div>

        @if($camiseta->variantes->isEmpty())
            <p class="empty-state">No hay variantes registradas. Añade la primera talla abajo.</p>
        @else
            <table class="stock-table">
                <thead>
                    <tr>
                        <th>Talla</th>
                        <th>Stock actual</th>
                        <th>Nuevo stock</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($camiseta->variantes->sortBy('talla') as $v)
                    <tr>
                        <td><span class="talla-badge">{{ $v->talla }}</span></td>
                        <td>
                            <span class="stock-indicator {{ $v->stock == 0 ? 'ind-zero' : ($v->stock <= 3 ? 'ind-low' : 'ind-ok') }}"></span>
                            <span style="color:{{ $v->stock == 0 ? '#dc3545' : ($v->stock <= 3 ? '#fd7e14' : '#75b798') }};font-weight:600">
                                {{ $v->stock }} uds.
                            </span>
                        </td>
                        <td>
                            <input type="number"
                                   name="stock[{{ $v->cod_var }}]"
                                   value="{{ $v->stock }}"
                                   min="0"
                                   class="stock-input">
                        </td>
                        <td>
                            <button type="button"
                                    class="btn-del-var"
                                    title="Eliminar talla {{ $v->talla }}"
                                    onclick="eliminarVariante({{ $camiseta->cod_cam }}, {{ $v->cod_var }}, '{{ $v->talla }}')">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Añadir nueva talla --}}
    <div class="add-card">
        <div class="add-card-header">Añadir talla</div>
        <div class="add-body">
            <div class="add-group">
                <label for="nueva_talla">Talla</label>
                <select name="nueva_talla" id="nueva_talla" class="add-select">
                    <option value="">— Seleccionar —</option>
                    @foreach($tallas as $t)
                        @if(!$camiseta->variantes->pluck('talla')->contains($t))
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endif
                    @endforeach
                </select>
                @php $tallasUsadas = $camiseta->variantes->pluck('talla')->join(', '); @endphp
                @if($tallasUsadas)
                    <span class="tallas-existentes">Ya registradas: {{ $tallasUsadas }}</span>
                @endif
            </div>

            <div class="add-group">
                <label for="nuevo_stock">Stock inicial</label>
                <input type="number" name="nuevo_stock" id="nuevo_stock"
                       value="0" min="0" class="add-input">
            </div>
        </div>
    </div>

    <div class="form-footer">
        <button type="submit" class="btn-save">Guardar cambios</button>
        <a href="{{ route('admin.variantes.index') }}" class="btn-cancel">Cancelar</a>
    </div>
</form>

{{-- Formulario oculto para eliminar variante --}}
<form id="form-del-variante" method="POST" style="display:none">
    @csrf @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
function eliminarVariante(codCam, codVar, talla) {
    if (!confirm('¿Eliminar la talla ' + talla + '? Esta acción no se puede deshacer.')) return;
    const form = document.getElementById('form-del-variante');
    form.action = '/admin/variantes/' + codCam + '/' + codVar;
    form.submit();
}
</script>
@endpush
