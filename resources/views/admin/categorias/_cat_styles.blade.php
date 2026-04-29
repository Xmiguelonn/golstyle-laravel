<style>
    .cat-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .cat-layout { grid-template-columns: 1fr; }
    }

    /* TABLE */
    .cat-table-wrap {
        background: #161616;
        border: 1px solid #1f1f1f;
        border-radius: 12px;
        overflow: hidden;
    }

    .cat-table-header {
        padding: 14px 20px;
        background: #141414;
        border-bottom: 1px solid #1e1e1e;
        font-size: 0.75rem;
        color: #555;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .cat-table { width: 100%; border-collapse: collapse; }

    .cat-table thead th {
        padding: 11px 20px;
        font-size: 0.67rem;
        font-weight: 700;
        color: #444;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        background: #141414;
        border-bottom: 1px solid #1a1a1a;
        text-align: left;
    }

    .cat-table tbody td {
        padding: 13px 20px;
        font-size: 0.87rem;
        color: #aaa;
        border-bottom: 1px solid #1a1a1a;
        vertical-align: middle;
    }

    .cat-table tbody tr:last-child td { border-bottom: none; }
    .cat-table tbody tr:hover td { background: rgba(255,255,255,0.02); }

    .id-col   { color: #d4af37; font-weight: 600; font-size: 0.78rem; width: 60px; }
    .name-col { color: #ddd; font-weight: 500; }

    .count-badge {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 20px;
        background: rgba(212,175,55,0.08);
        border: 1px solid rgba(212,175,55,0.15);
        color: #b8941f;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .liga-tag {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 6px;
        background: rgba(255,255,255,0.04);
        border: 1px solid #222;
        color: #666;
        font-size: 0.78rem;
    }

    .row-actions { display: flex; gap: 6px; }

    .btn-row-edit, .btn-row-del {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px;
        border-radius: 7px; border: 1px solid #222;
        background: transparent; cursor: pointer;
        transition: all 0.2s; font-family: inherit;
        color: #666;
    }

    .btn-row-edit:hover { border-color: #d4af37; color: #d4af37; background: rgba(212,175,55,0.06); }
    .btn-row-del:hover  { border-color: #dc3545; color: #ff6b6b; background: rgba(220,53,69,0.06); }
    .btn-row-edit svg, .btn-row-del svg { width: 14px; height: 14px; }

    .empty-state {
        padding: 40px 20px;
        text-align: center;
        color: #3a3a3a;
        font-size: 0.85rem;
        font-style: italic;
    }

    /* SIDE PANEL */
    .side-card {
        background: #161616;
        border: 1px solid #1f1f1f;
        border-radius: 12px;
        border-top: 3px solid #d4af37;
        padding: 24px;
        position: relative;
    }

    .side-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(212,175,55,0.3), transparent);
    }

    .side-card-title {
        font-size: 0.72rem;
        font-weight: 700;
        color: #555;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid #1e1e1e;
    }

    .side-field { margin-bottom: 16px; display: flex; flex-direction: column; gap: 6px; }

    .side-field label {
        font-size: 0.7rem;
        font-weight: 600;
        color: #d4af37;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .side-input {
        padding: 10px 12px;
        background: #121212;
        border: 1px solid #272727;
        border-radius: 7px;
        color: #e0e0e0;
        font-size: 0.88rem;
        font-family: inherit;
        width: 100%;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .side-input:focus {
        outline: none;
        border-color: #d4af37;
        box-shadow: 0 0 0 3px rgba(212,175,55,0.1);
    }

    .side-input.is-invalid { border-color: #dc3545; }
    .side-input option { background: #1a1a1a; }

    .field-error { font-size: 0.75rem; color: #ff6b6b; }

    .btn-side-save {
        width: 100%;
        padding: 11px;
        background: linear-gradient(135deg, #d4af37, #b8941f);
        border: none;
        border-radius: 7px;
        color: #121212;
        font-size: 0.87rem;
        font-weight: 700;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.2s;
        margin-top: 4px;
        box-shadow: 0 4px 14px rgba(212,175,55,0.2);
    }

    .btn-side-save:hover {
        background: linear-gradient(135deg, #e8c84e, #d4af37);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(212,175,55,0.32);
    }

    .btn-side-cancel {
        flex: 1;
        padding: 10px;
        background: transparent;
        border: 1px solid #2a2a2a;
        border-radius: 7px;
        color: #666;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.2s;
    }

    .btn-side-cancel:hover { border-color: #444; color: #999; }

    /* MODAL */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.7);
        z-index: 200;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(2px);
    }

    .modal-overlay.open { display: flex; }

    .modal-card {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-top: 3px solid #d4af37;
        border-radius: 14px;
        width: 100%;
        max-width: 420px;
        margin: 20px;
        overflow: hidden;
        box-shadow: 0 24px 80px rgba(0,0,0,0.7);
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px;
        border-bottom: 1px solid #222;
        font-size: 0.88rem;
        font-weight: 600;
        color: #ccc;
    }

    .modal-close {
        background: none; border: none;
        color: #555; font-size: 1rem;
        cursor: pointer; padding: 4px 8px;
        border-radius: 4px; transition: color 0.2s;
        font-family: inherit;
    }

    .modal-close:hover { color: #ccc; }

    .modal-card .side-field { padding: 0 24px; }
    .modal-card .side-field:first-of-type { padding-top: 20px; }

    .modal-footer {
        display: flex;
        gap: 10px;
        padding: 16px 24px 20px;
    }

    .modal-footer .btn-side-save { flex: 2; width: auto; margin-top: 0; }
</style>
