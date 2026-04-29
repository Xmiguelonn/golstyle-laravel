@extends('layouts.admin')
@section('title', 'Mensajes')

@push('styles')
<style>
    .msg-list { display: flex; flex-direction: column; gap: 10px; }

    .msg-card {
        background: #161616; border: 1px solid #1f1f1f; border-radius: 10px;
        padding: 18px 22px; display: flex; align-items: center; gap: 18px;
        transition: border-color 0.2s; text-decoration: none;
        border-left: 3px solid #1f1f1f;
    }

    .msg-card:hover { border-color: #2a2a2a; border-left-color: #d4af37; }

    .msg-icon {
        width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
        background: rgba(212,175,55,0.07); border: 1px solid rgba(212,175,55,0.12);
        display: flex; align-items: center; justify-content: center; color: #d4af37;
    }

    .msg-icon svg { width: 18px; height: 18px; }

    .msg-body { flex: 1; min-width: 0; }

    .msg-top { display: flex; align-items: baseline; gap: 10px; margin-bottom: 4px; }
    .msg-asunto { font-size: 0.9rem; font-weight: 600; color: #ddd; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .msg-date   { font-size: 0.75rem; color: #444; white-space: nowrap; flex-shrink: 0; }

    .msg-from { font-size: 0.78rem; color: #555; margin-bottom: 4px; }
    .msg-preview { font-size: 0.82rem; color: #444; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    .msg-actions { display: flex; gap: 8px; flex-shrink: 0; }

    .btn-ver {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 7px 14px; border-radius: 6px; border: 1px solid #2a2a2a;
        background: transparent; color: #777; font-size: 0.78rem; font-weight: 600;
        text-decoration: none; transition: all 0.2s;
    }

    .btn-ver:hover { border-color: #d4af37; color: #d4af37; background: rgba(212,175,55,0.05); }
    .btn-ver svg { width: 13px; height: 13px; }

    .btn-del {
        display: inline-flex; align-items: center; justify-content: center;
        width: 34px; height: 34px; border-radius: 6px; border: 1px solid #2a2a2a;
        background: transparent; color: #666; cursor: pointer; transition: all 0.2s; font-family: inherit;
    }

    .btn-del:hover { border-color: #dc3545; color: #ff6b6b; background: rgba(220,53,69,0.06); }
    .btn-del svg { width: 14px; height: 14px; }

    .empty-state { padding: 60px 24px; text-align: center; color: #3a3a3a; font-size: 0.9rem; font-style: italic; }

    .pagination-wrap {
        margin-top: 20px; display: flex; justify-content: flex-end; gap: 6px;
    }

    .page-link {
        padding: 6px 12px; border: 1px solid #252525; border-radius: 6px;
        color: #888; font-size: 0.82rem; text-decoration: none; transition: all 0.2s;
    }

    .page-link:hover, .page-link.active { border-color: #d4af37; color: #d4af37; background: rgba(212,175,55,0.06); }
</style>
@endpush

@section('content')
<div class="content-header">
    <h2>Mensajes de contacto</h2>
    <p>{{ $contactos->total() }} mensaje(s) recibido(s)</p>
</div>

@if($contactos->isEmpty())
    <p class="empty-state">No hay mensajes todavía.</p>
@else
    <div class="msg-list">
        @foreach($contactos as $c)
        <div class="msg-card">
            <div class="msg-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
            <div class="msg-body">
                <div class="msg-top">
                    <span class="msg-asunto">{{ $c->asunto }}</span>
                    <span class="msg-date">{{ $c->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="msg-from">De: {{ $c->correo }}{{ $c->id_pedido ? ' · Pedido #' . $c->id_pedido : '' }}</div>
                <div class="msg-preview">{{ Str::limit($c->mensaje, 100) }}</div>
            </div>
            <div class="msg-actions">
                <a href="{{ route('admin.contactos.show', $c->id) }}" class="btn-ver">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    Leer
                </a>
                <form method="POST" action="{{ route('admin.contactos.destroy', $c->id) }}"
                      onsubmit="return confirm('¿Eliminar este mensaje?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-del" title="Eliminar">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    @if($contactos->hasPages())
    <div class="pagination-wrap">
        @if($contactos->onFirstPage())
            <span class="page-link" style="opacity:0.3">← Anterior</span>
        @else
            <a href="{{ $contactos->previousPageUrl() }}" class="page-link">← Anterior</a>
        @endif
        @foreach($contactos->getUrlRange(1, $contactos->lastPage()) as $page => $url)
            <a href="{{ $url }}" class="page-link {{ $page == $contactos->currentPage() ? 'active' : '' }}">{{ $page }}</a>
        @endforeach
        @if($contactos->hasMorePages())
            <a href="{{ $contactos->nextPageUrl() }}" class="page-link">Siguiente →</a>
        @else
            <span class="page-link" style="opacity:0.3">Siguiente →</span>
        @endif
    </div>
    @endif
@endif
@endsection
