@extends('layouts.admin')
@section('title', 'Mensaje de contacto')

@push('styles')
<style>
    .back-link {
        display: inline-flex; align-items: center; gap: 6px;
        color: #666; font-size: 0.82rem; text-decoration: none;
        margin-bottom: 28px; transition: color 0.2s;
    }
    .back-link:hover { color: #d4af37; }
    .back-link svg { width: 14px; height: 14px; }

    .msg-detail-card {
        background: #161616; border: 1px solid #1f1f1f;
        border-radius: 12px; border-top: 3px solid #d4af37;
        overflow: hidden; max-width: 700px; position: relative;
    }

    .msg-detail-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(212,175,55,0.3), transparent);
    }

    .msg-meta {
        padding: 24px 28px 20px;
        border-bottom: 1px solid #1e1e1e;
        display: grid; grid-template-columns: 1fr 1fr; gap: 16px;
    }

    .meta-item { display: flex; flex-direction: column; gap: 4px; }
    .meta-label { font-size: 0.68rem; font-weight: 700; color: #555; text-transform: uppercase; letter-spacing: 1.5px; }
    .meta-value { font-size: 0.9rem; color: #ddd; font-weight: 500; }

    .msg-subject {
        padding: 20px 28px 0;
        font-size: 1.1rem; font-weight: 700; color: #e8e8e8; letter-spacing: 0.2px;
    }

    .msg-body-text {
        padding: 16px 28px 28px;
        font-size: 0.9rem; color: #aaa; line-height: 1.7;
        white-space: pre-wrap; word-break: break-word;
    }

    .msg-footer {
        padding: 18px 28px;
        border-top: 1px solid #1e1e1e;
        background: #141414;
        display: flex; gap: 12px;
    }

    .btn-delete {
        padding: 10px 22px; background: transparent; border: 1px solid #3a1515;
        border-radius: 8px; color: #aa3333; font-size: 0.85rem; font-weight: 600;
        cursor: pointer; font-family: inherit; transition: all 0.2s;
        display: inline-flex; align-items: center; gap: 6px;
    }

    .btn-delete:hover { border-color: #dc3545; color: #ff6b6b; background: rgba(220,53,69,0.06); }
    .btn-delete svg { width: 14px; height: 14px; }

    .btn-back {
        padding: 10px 22px; background: transparent; border: 1px solid #2a2a2a;
        border-radius: 8px; color: #666; font-size: 0.85rem; font-weight: 600;
        text-decoration: none; transition: all 0.2s;
    }

    .btn-back:hover { border-color: #444; color: #999; }

    .pedido-ref {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 12px; border-radius: 6px;
        background: rgba(212,175,55,0.08); border: 1px solid rgba(212,175,55,0.15);
        color: #d4af37; font-size: 0.8rem; font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="content-header">
    <h2>Mensaje de contacto</h2>
    <p>Recibido el {{ $contacto->created_at->format('d/m/Y \a \l\a\s H:i') }}</p>
</div>

<a href="{{ route('admin.contactos.index') }}" class="back-link">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Volver a mensajes
</a>

<div class="msg-detail-card">
    <div class="msg-meta">
        <div class="meta-item">
            <span class="meta-label">Remitente</span>
            <span class="meta-value">{{ $contacto->correo }}</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Fecha</span>
            <span class="meta-value">{{ $contacto->created_at->format('d/m/Y H:i') }}</span>
        </div>
        @if($contacto->id_pedido)
        <div class="meta-item">
            <span class="meta-label">Pedido relacionado</span>
            <div style="margin-top:4px">
                <a href="{{ route('admin.pedidos.show', $contacto->id_pedido) }}" class="pedido-ref">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
                    #{{ $contacto->id_pedido }}
                </a>
            </div>
        </div>
        @endif
    </div>

    <div class="msg-subject">{{ $contacto->asunto }}</div>
    <div class="msg-body-text">{{ $contacto->mensaje }}</div>

    <div class="msg-footer">
        <a href="{{ route('admin.contactos.index') }}" class="btn-back">← Volver</a>
        <form method="POST" action="{{ route('admin.contactos.destroy', $contacto->id) }}"
              onsubmit="return confirm('¿Eliminar este mensaje? No se puede recuperar.')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-delete">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                Eliminar mensaje
            </button>
        </form>
    </div>
</div>
@endsection
