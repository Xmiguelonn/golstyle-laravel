@extends('layouts.admin')
@section('title', 'Ligas')
@push('styles')@include('admin.categorias._cat_styles')@endpush

@section('content')
<div class="content-header">
    <h2>Ligas</h2>
    <p>Gestión de ligas de fútbol</p>
</div>

<div class="cat-layout">

    {{-- Tabla --}}
    <div class="cat-table-wrap">
        <div class="cat-table-header">
            <span>{{ $ligas->count() }} liga(s) registrada(s)</span>
        </div>
        @if($ligas->isEmpty())
            <p class="empty-state">No hay ligas todavía. Añade la primera.</p>
        @else
        <table class="cat-table">
            <thead><tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Equipos</th>
                <th></th>
            </tr></thead>
            <tbody>
                @foreach($ligas as $item)
                <tr>
                    <td class="id-col">#{{ $item->cod_lig }}</td>
                    <td class="name-col">{{ $item->nombre }}</td>
                    <td><span class="count-badge">{{ $item->equipos_count }}</span></td>
                    <td>
                        <div class="row-actions">
                            <button class="btn-row-edit"
                                onclick="openEdit({{ $item->cod_lig }}, '{{ addslashes($item->nombre) }}')"
                                title="Editar">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.ligas.destroy', $item->cod_lig) }}"
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

    {{-- Panel lateral: añadir --}}
    <div class="cat-side">
        <div class="side-card">
            <div class="side-card-title">Añadir liga</div>
            <form method="POST" action="{{ route('admin.ligas.store') }}">
                @csrf
                <div class="side-field">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="side-input @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre') }}" placeholder="Ej: Primera División" required>
                    @error('nombre')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn-side-save">Guardar</button>
            </form>
        </div>
    </div>

</div>

{{-- Modal editar --}}
<div class="modal-overlay" id="modalOverlay" onclick="closeEdit()">
    <div class="modal-card" onclick="event.stopPropagation()">
        <div class="modal-header">
            <span>Editar liga</span>
            <button class="modal-close" onclick="closeEdit()">✕</button>
        </div>
        <form method="POST" id="editForm">
            @csrf @method('PUT')
            <div class="side-field">
                <label>Nombre</label>
                <input type="text" name="nombre" id="editNombre" class="side-input" required>
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
function openEdit(id, nombre) {
    document.getElementById('editNombre').value = nombre;
    document.getElementById('editForm').action = '/admin/ligas/' + id;
    document.getElementById('modalOverlay').classList.add('open');
}
function closeEdit() {
    document.getElementById('modalOverlay').classList.remove('open');
}
</script>
@endpush
