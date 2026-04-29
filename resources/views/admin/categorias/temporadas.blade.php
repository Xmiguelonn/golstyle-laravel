@extends('layouts.admin')
@section('title', 'Temporadas')
@push('styles')@include('admin.categorias._cat_styles')@endpush

@section('content')
<div class="content-header">
    <h2>Temporadas</h2>
    <p>Gestión de temporadas del catálogo</p>
</div>

<div class="cat-layout">

    <div class="cat-table-wrap">
        <div class="cat-table-header">
            <span>{{ $temporadas->count() }} temporada(s) registrada(s)</span>
        </div>
        @if($temporadas->isEmpty())
            <p class="empty-state">No hay temporadas todavía.</p>
        @else
        <table class="cat-table">
            <thead><tr>
                <th>#</th>
                <th>Temporada</th>
                <th>Camisetas</th>
                <th></th>
            </tr></thead>
            <tbody>
                @foreach($temporadas as $item)
                <tr>
                    <td class="id-col">#{{ $item->cod_tem }}</td>
                    <td class="name-col">{{ $item->inicio }}/{{ $item->fin }}</td>
                    <td><span class="count-badge">{{ $item->camisetas_count }}</span></td>
                    <td>
                        <div class="row-actions">
                            <button class="btn-row-edit"
                                onclick="openEdit({{ $item->cod_tem }}, {{ $item->inicio }}, {{ $item->fin }})"
                                title="Editar">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.temporadas.destroy', $item->cod_tem) }}"
                                  onsubmit="return confirm('¿Eliminar temporada {{ $item->inicio }}/{{ $item->fin }}?')">
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
            <div class="side-card-title">Añadir temporada</div>
            <form method="POST" action="{{ route('admin.temporadas.store') }}">
                @csrf
                <div class="side-field">
                    <label>Año inicio</label>
                    <input type="number" name="inicio" class="side-input @error('inicio') is-invalid @enderror"
                           value="{{ old('inicio') }}" placeholder="{{ date('Y') }}" min="2000" max="2099" required>
                    @error('inicio')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="side-field">
                    <label>Año fin</label>
                    <input type="number" name="fin" class="side-input @error('fin') is-invalid @enderror"
                           value="{{ old('fin') }}" placeholder="{{ date('Y') + 1 }}" min="2000" max="2099" required>
                    @error('fin')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn-side-save">Guardar</button>
            </form>
        </div>
    </div>

</div>

<div class="modal-overlay" id="modalOverlay" onclick="closeEdit()">
    <div class="modal-card" onclick="event.stopPropagation()">
        <div class="modal-header">
            <span>Editar temporada</span>
            <button class="modal-close" onclick="closeEdit()">✕</button>
        </div>
        <form method="POST" id="editForm">
            @csrf @method('PUT')
            <div class="side-field">
                <label>Año inicio</label>
                <input type="number" name="inicio" id="editInicio" class="side-input" min="2000" max="2099" required>
            </div>
            <div class="side-field">
                <label>Año fin</label>
                <input type="number" name="fin" id="editFin" class="side-input" min="2000" max="2099" required>
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
function openEdit(id, inicio, fin) {
    document.getElementById('editInicio').value = inicio;
    document.getElementById('editFin').value = fin;
    document.getElementById('editForm').action = '/admin/temporadas/' + id;
    document.getElementById('modalOverlay').classList.add('open');
}
function closeEdit() {
    document.getElementById('modalOverlay').classList.remove('open');
}
</script>
@endpush
