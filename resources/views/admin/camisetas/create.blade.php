@extends('layouts.admin')

@section('title', 'Nueva camiseta')

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

    .form-card {
        background: #161616;
        border: 1px solid #1f1f1f;
        border-radius: 12px;
        border-top: 3px solid #d4af37;
        overflow: hidden;
        max-width: 780px;
        position: relative;
    }

    .form-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(212,175,55,0.35), transparent);
    }

    .form-body { padding: 36px 40px; }

    .form-section-title {
        font-size: 0.72rem;
        font-weight: 700;
        color: #555;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #1e1e1e;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 28px;
    }

    .form-group { display: flex; flex-direction: column; gap: 7px; }
    .form-group.full { grid-column: 1 / -1; }

    .form-group label {
        font-size: 0.72rem;
        font-weight: 600;
        color: #d4af37;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-control {
        padding: 11px 14px;
        background: #121212;
        border: 1px solid #272727;
        border-radius: 8px;
        color: #e0e0e0;
        font-size: 0.9rem;
        font-family: inherit;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:hover { border-color: #333; }

    .form-control:focus {
        outline: none;
        border-color: #d4af37;
        background: #141414;
        box-shadow: 0 0 0 3px rgba(212,175,55,0.1);
    }

    .form-control.is-invalid { border-color: #dc3545 !important; }

    .invalid-feedback {
        font-size: 0.77rem;
        color: #ff6b6b;
        margin-top: 2px;
    }

    select.form-control option { background: #1a1a1a; }

    .hint {
        font-size: 0.75rem;
        color: #444;
    }

    /* IMAGE UPLOAD */
    .upload-area {
        border: 2px dashed #252525;
        border-radius: 10px;
        padding: 28px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
        position: relative;
        background: #111;
    }

    .upload-area:hover {
        border-color: #d4af37;
        background: rgba(212,175,55,0.03);
    }

    .upload-area input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .upload-area svg {
        width: 32px; height: 32px;
        color: #333;
        margin: 0 auto 10px;
        display: block;
        transition: color 0.2s;
    }

    .upload-area:hover svg { color: #d4af37; }

    .upload-label {
        font-size: 0.85rem;
        color: #555;
    }

    .upload-label span {
        color: #d4af37;
        font-weight: 600;
    }

    #preview-wrap { margin-top: 16px; display: none; }
    #preview-img  { max-height: 140px; border-radius: 8px; border: 1px solid #252525; }

    /* FORM FOOTER */
    .form-footer {
        padding: 22px 40px;
        border-top: 1px solid #1e1e1e;
        display: flex;
        gap: 12px;
        align-items: center;
        background: #141414;
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

    .btn-cancel:hover {
        border-color: #444;
        color: #999;
    }

    @media (max-width: 640px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-body  { padding: 24px; }
        .form-footer { padding: 18px 24px; }
    }
</style>
@endpush

@section('content')

<div class="content-header">
    <h2>Nueva camiseta</h2>
    <p>Añadir producto al catálogo</p>
</div>

<a href="{{ route('admin.camisetas.index') }}" class="back-link">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Volver al listado
</a>

<div class="form-card">
    <form method="POST" action="{{ route('admin.camisetas.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-body">

            {{-- Info básica --}}
            <div class="form-section-title">Información básica</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre') }}" placeholder="Ej: Camiseta local 2024" required>
                    @error('nombre')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="color">Color *</label>
                    <input type="text" id="color" name="color" class="form-control @error('color') is-invalid @enderror"
                           value="{{ old('color') }}" placeholder="Ej: Blanco / Azul" required>
                    @error('color')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="precio">Precio (€) *</label>
                    <input type="number" id="precio" name="precio" class="form-control @error('precio') is-invalid @enderror"
                           value="{{ old('precio') }}" placeholder="0.00" step="0.01" min="0" required>
                    @error('precio')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="cod_tem">Temporada *</label>
                    <select id="cod_tem" name="cod_tem" class="form-control @error('cod_tem') is-invalid @enderror" required>
                        <option value="">— Seleccionar —</option>
                        @foreach($temporadas as $t)
                            <option value="{{ $t->cod_tem }}" {{ old('cod_tem') == $t->cod_tem ? 'selected' : '' }}>
                                {{ $t->inicio }}/{{ $t->fin }}
                            </option>
                        @endforeach
                    </select>
                    @error('cod_tem')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Categoría --}}
            <div class="form-section-title">Categoría</div>
            <div class="form-grid" style="margin-bottom: 32px;">
                <div class="form-group">
                    <label for="cod_equi">Equipo</label>
                    <select id="cod_equi" name="cod_equi" class="form-control @error('cod_equi') is-invalid @enderror">
                        <option value="">— Ninguno —</option>
                        @foreach($equipos as $e)
                            <option value="{{ $e->cod_equi }}" {{ old('cod_equi') == $e->cod_equi ? 'selected' : '' }}>
                                {{ $e->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <span class="hint">Dejar en blanco si es de selección</span>
                    @error('cod_equi')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="cod_sel">Selección</label>
                    <select id="cod_sel" name="cod_sel" class="form-control @error('cod_sel') is-invalid @enderror">
                        <option value="">— Ninguna —</option>
                        @foreach($selecciones as $s)
                            <option value="{{ $s->cod_sel }}" {{ old('cod_sel') == $s->cod_sel ? 'selected' : '' }}>
                                {{ $s->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <span class="hint">Dejar en blanco si es de equipo</span>
                    @error('cod_sel')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Imagen --}}
            <div class="form-section-title">Imagen principal</div>
            <div class="form-group full">
                <div class="upload-area" id="uploadArea">
                    <input type="file" name="imagen_principal" id="imagen_principal" accept="image/*">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                    <p class="upload-label">Arrastra aquí o <span>haz clic</span> para seleccionar</p>
                    <p style="font-size:0.75rem;color:#444;margin-top:4px;">JPG, PNG, WEBP — máx. 4 MB</p>
                </div>
                <div id="preview-wrap">
                    <img id="preview-img" src="" alt="Vista previa">
                </div>
                @error('imagen_principal')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

        </div>{{-- /form-body --}}

        <div class="form-footer">
            <button type="submit" class="btn-save">Guardar camiseta</button>
            <a href="{{ route('admin.camisetas.index') }}" class="btn-cancel">Cancelar</a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('imagen_principal').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('preview-img').src = e.target.result;
        document.getElementById('preview-wrap').style.display = 'block';
    };
    reader.readAsDataURL(file);
});
</script>
@endpush
