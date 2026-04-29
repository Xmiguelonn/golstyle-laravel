@extends('layouts.admin')
@section('title', 'Equipos')
@push('styles')@include('admin.categorias._cat_styles')@endpush

@section('content')
<div class="content-header">
    <h2>Equipos</h2>
    <p>Gestión de equipos de fútbol</p>
</div>

<div class="cat-layout">

    <div class="cat-table-wrap">
        <div class="cat-table-header">
            <span>{{ $equipos->count() }} equipo(s) registrado(s)</span>
        </div>
        @if($equipos->isEmpty())
            <p class="empty-state">No hay equipos todavía.</p>
        @else
        <table class="cat-table">
            <thead><tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Liga</th>
                <th></th>
            </tr></thead>
            <tbody>
                @foreach($equipos as $item)
                <tr>
                    <td class="id-col">#{{ $item->cod_equi }}</td>
                    <td class="name-col">{{ $item->nombre }}</td>
                    <td>
                        @if($item->liga)
                            <span class="liga-tag">{{ $item->liga->nombre }}</span>
                        @else
                            <span style="color:#444">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="row-actions">
                            <button class="btn-row-edit"
                                onclick="openEdit({{ $item->cod_equi }}, '{{ addslashes($item->nombre) }}', {{ $item->cod_lig }})"
                                title="Editar">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.equipos.destroy', $item->cod_equi) }}"
                                  onsubmit="return confirm('¿Eliminar «{{ addslashes($item->nombre) }}»?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-row-del" title="Eliminar">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <div class="cat-side">
        <div class="side-card">
            <div class="side-card-title">Añadir equipo</div>
            <form method="POST" action="{{ route('admin.equipos.store') }}">
                @csrf
                <div class="side-field">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="side-input @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre') }}" placeholder="Ej: Real Madrid" required>
                    @error('nombre')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="side-field">
                    <label>Liga</label>
                    <select name="cod_lig" class="side-input @error('cod_lig') is-invalid @enderror" required>
                        <option value="">— Seleccionar —</option>
                        @foreach($ligas as $liga)
                            <option value="{{ $liga->cod_lig }}" {{ old('cod_lig') == $liga->cod_lig ? 'selected' : '' }}>
                                {{ $liga->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('cod_lig')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn-side-save">Guardar</button>
            </form>
        </div>
    </div>

</div>

<div class="modal-overlay" id="modalOverlay" onclick="closeEdit()">
    <div class="modal-card" onclick="event.stopPropagation()">
        <div class="modal-header">
            <span>Editar equipo</span>
            <button class="modal-close" onclick="closeEdit()">✕</button>
        </div>
        <form method="POST" id="editForm">
            @csrf @method('PUT')
            <div class="side-field">
                <label>Nombre</label>
                <input type="text" name="nombre" id="editNombre" class="side-input" required>
            </div>
            <div class="side-field">
                <label>Liga</label>
                <select name="cod_lig" id="editLiga" class="side-input" required>
                    @foreach($ligas as $liga)
                        <option value="{{ $liga->cod_lig }}">{{ $liga->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-side-save">Guardar cambios</button>
                <button type="button" class="btn-side-cancel" onclick="closeEdit()">Cancelar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openEdit(id, nombre, codLig) {
    document.getElementById('editNombre').value = nombre;
    document.getElementById('editLiga').value = codLig;
    document.getElementById('editForm').action = '/admin/equipos/' + id;
    document.getElementById('modalOverlay').classList.add('open');
}
function closeEdit() {
    document.getElementById('modalOverlay').classList.remove('open');
}
</script>
@endpush
