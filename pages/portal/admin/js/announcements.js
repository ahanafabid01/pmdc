/**
 * announcements.js
 * Teacher Portal — Announcements Management
 * Phulpur Mohila Degree College
 */

'use strict';

/* ═══════════════════════════════════════════════════════════
   API FETCHING
═══════════════════════════════════════════════════════════ */

const API = window.BASE_URL + `/pages/portal/admin/api/announcements.php`;

function loadData() {
    fetch(API + '?action=list')
        .then(r => r.json())
        .then(res => {
            if (res.ok) {
                announcements = res.announcements || [];
                renderTable();
            } else {
                showToast(res.error || 'Failed to load data', 'error');
            }
        })
        .catch(() => showToast('Network error loading data', 'error'));
}

/* ═══════════════════════════════════════════════════════════
   STATE
═══════════════════════════════════════════════════════════ */

let announcements = [];
let editingId     = null;
let currentPage   = 1;
let pendingDeleteId = null;
let currentFile   = null;   // { name, size, dataUrl, type }

const PAGE_SIZE = 10;

/* ═══════════════════════════════════════════════════════════
   HELPERS
═══════════════════════════════════════════════════════════ */

function uid() {
    return 'ann-' + Date.now() + '-' + Math.random().toString(36).slice(2, 8);
}

function formatDate(iso) {
    if (!iso) return '—';
    const d = new Date(iso + 'T00:00:00');
    return d.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
}

function todayISO() {
    return new Date().toISOString().split('T')[0];
}

function showToast(msg, type = 'success') {
    const el = document.getElementById('annToast');
    el.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${msg}`;
    el.className = `tm-toast ${type} show`;
    setTimeout(() => el.classList.remove('show'), 3000);
}

/* ═══════════════════════════════════════════════════════════
   RENDER
═══════════════════════════════════════════════════════════ */

function getActiveFilter() {
    const active = document.querySelector('#annFilterTabs .tm-tab.active');
    return active ? active.dataset.filter : 'all';
}

function getFiltered() {
    const q = document.getElementById('annSearch').value.trim().toLowerCase();
    const f = getActiveFilter();
    return announcements
        .filter(a => {
            const matchQ = !q || a.title.toLowerCase().includes(q);
            const matchF = f === 'all' || a.status === f;
            return matchQ && matchF;
        })
        .sort((a, b) => new Date(b.date) - new Date(a.date));
}

function updateStats() {
    document.getElementById('statTotal').textContent     = announcements.length;
    document.getElementById('statPublished').textContent = announcements.filter(a => a.status === 'published').length;
    document.getElementById('statDrafts').textContent    = announcements.filter(a => a.status === 'draft').length;
}

function renderTable() {
    updateStats();
    const filtered = getFiltered();
    const total    = filtered.length;
    const pages    = Math.max(1, Math.ceil(total / PAGE_SIZE));
    if (currentPage > pages) currentPage = pages;

    const start = (currentPage - 1) * PAGE_SIZE;
    const slice = filtered.slice(start, start + PAGE_SIZE);

    const tbody  = document.getElementById('annTbody');
    const empty  = document.getElementById('annEmpty');
    const table  = document.getElementById('annTable');
    const pgn    = document.getElementById('annPagination');

    if (total === 0) {
        table.style.display = 'none';
        empty.style.display = 'flex';
        pgn.style.display   = 'none';
        return;
    }

    table.style.display = '';
    empty.style.display = 'none';
    pgn.style.display   = '';

    tbody.innerHTML = slice.map((a, i) => {
        const num    = start + i + 1;
        const isPublished = a.status === 'published';
        const attCell = a.attachment
            ? `<i class="fas fa-paperclip att-icon" title="${a.attachment.name}"></i>`
            : `<span class="att-none">—</span>`;
        const statusBadge = isPublished
            ? `<span class="status-badge sb-published"><i class="fas fa-circle" style="font-size:.45rem;"></i> Published</span>`
            : `<span class="status-badge sb-draft"><i class="fas fa-circle" style="font-size:.45rem;"></i> Draft</span>`;
        const toggleBtn = isPublished
            ? `<button class="act-btn act-toggle-pub" data-id="${a.id}" data-action="toggle" title="Unpublish (set to draft)"><i class="fas fa-eye"></i></button>`
            : `<button class="act-btn act-toggle-draft" data-id="${a.id}" data-action="toggle" title="Publish"><i class="fas fa-eye-slash"></i></button>`;

        return `
        <tr>
            <td style="color:#94a3b8;font-size:.8rem;">${num}</td>
            <td><div class="ann-title-cell" title="${escHtml(a.title)}">${escHtml(a.title)}</div></td>
            <td class="ann-date-cell">${formatDate(a.date)}</td>
            <td>${attCell}</td>
            <td>${statusBadge}</td>
            <td>
                <div class="action-btns">
                    <button class="act-btn act-edit"   data-id="${a.id}" data-action="edit"   title="Edit"><i class="fas fa-pencil-alt"></i></button>
                    ${toggleBtn}
                    <button class="act-btn act-delete" data-id="${a.id}" data-action="delete" title="Delete"><i class="fas fa-trash-alt"></i></button>
                </div>
            </td>
        </tr>`;
    }).join('');

    renderPagination(total, pages);
}

function escHtml(s) {
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function renderPagination(total, pages) {
    const info = document.getElementById('apInfo');
    const btns = document.getElementById('apBtns');

    const start = (currentPage - 1) * PAGE_SIZE + 1;
    const end   = Math.min(currentPage * PAGE_SIZE, total);
    info.textContent = `Showing ${start}–${end} of ${total}`;

    let html = `<button class="ap-btn" data-pg="prev" ${currentPage === 1 ? 'disabled' : ''}><i class="fas fa-chevron-left"></i></button>`;
    for (let p = 1; p <= pages; p++) {
        if (pages > 7 && p > 2 && p < pages - 1 && Math.abs(p - currentPage) > 1) {
            if (p === 3 || p === pages - 2) html += `<button class="ap-btn" disabled>…</button>`;
            continue;
        }
        html += `<button class="ap-btn${p === currentPage ? ' active' : ''}" data-pg="${p}">${p}</button>`;
    }
    html += `<button class="ap-btn" data-pg="next" ${currentPage === pages ? 'disabled' : ''}><i class="fas fa-chevron-right"></i></button>`;
    btns.innerHTML = html;
}

/* ═══════════════════════════════════════════════════════════
   MODAL — CREATE / EDIT
═══════════════════════════════════════════════════════════ */

function openModal(id = null) {
    editingId  = id;
    currentFile = null;
    const overlay = document.getElementById('annModalOverlay');
    const title   = document.getElementById('modalTitle');

    clearErrors();
    document.getElementById('filePreview').style.display = 'none';
    document.getElementById('fileDrop').style.display    = '';
    document.getElementById('fFile').value               = '';

    if (id) {
        const a = announcements.find(x => x.id === id || String(x.id) === String(id));
        title.textContent              = 'Edit Announcement';
        document.getElementById('fTitle').value   = a.title;
        document.getElementById('fCategory').value = a.category || 'notice';
        document.getElementById('fBadgeLabel').value = a.badge_label || '';
        document.getElementById('fBadgeClass').value = a.badge_class || '';
        document.getElementById('fMessage').value = a.message;
        document.getElementById('fDate').value    = a.date;
        document.querySelector(`input[name="fStatus"][value="${a.status}"]`).checked = true;
        if (a.attachment) {
            currentFile = a.attachment;
            showFilePreview(a.attachment);
        }
    } else {
        title.textContent              = 'New Announcement';
        document.getElementById('fTitle').value   = '';
        document.getElementById('fCategory').value = 'notice';
        document.getElementById('fBadgeLabel').value = '';
        document.getElementById('fBadgeClass').value = '';
        document.getElementById('fMessage').value = '';
        document.getElementById('fDate').value    = todayISO();
        document.querySelector('input[name="fStatus"][value="published"]').checked = true;
    }

    overlay.classList.add('active');
    document.getElementById('fTitle').focus();
}

function closeModal() {
    document.getElementById('annModalOverlay').classList.remove('active');
    editingId   = null;
    currentFile = null;
}

function clearErrors() {
    ['errTitle','errMessage','errDate','errFile'].forEach(id => {
        document.getElementById(id).textContent = '';
    });
}

function validateForm() {
    let ok = true;
    const title   = document.getElementById('fTitle').value.trim();
    const message = document.getElementById('fMessage').value.trim();
    const date    = document.getElementById('fDate').value;
    if (!title)   { document.getElementById('errTitle').textContent   = 'Title is required.';   ok = false; }
    if (!message) { document.getElementById('errMessage').textContent = 'Message is required.'; ok = false; }
    if (!date)    { document.getElementById('errDate').textContent    = 'Date is required.';    ok = false; }
    return ok;
}

function saveAnnouncement(forcedStatus = null) {
    clearErrors();
    if (!validateForm()) return;

    const publish = document.getElementById('btnPublish');
    const draft   = document.getElementById('btnSaveDraft');
    publish.disabled = true; draft.disabled = true;
    publish.classList.add('loading');

    const status = forcedStatus || document.querySelector('input[name="fStatus"]:checked').value;
    const catSelect = document.getElementById('fCategory');
    const ann = {
        id:         editingId,
        title:      document.getElementById('fTitle').value.trim(),
        category:   catSelect.value,
        category_label: catSelect.options[catSelect.selectedIndex].text,
        badge_label: document.getElementById('fBadgeLabel').value.trim(),
        badge_class: document.getElementById('fBadgeClass').value,
        message:    document.getElementById('fMessage').value.trim(),
        date:       document.getElementById('fDate').value,
        status:     status,
        attachment: currentFile,
    };

    fetch(API + '?action=save', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(ann)
    })
    .then(r => r.json())
    .then(res => {
        publish.disabled = false; draft.disabled = false;
        publish.classList.remove('loading');
        if (res.ok) {
            closeModal();
            showToast(`Announcement saved successfully.`, 'success');
            loadData();
        } else {
            showToast(res.error || 'Failed to save', 'error');
        }
    })
    .catch(() => {
        publish.disabled = false; draft.disabled = false;
        publish.classList.remove('loading');
        showToast('Network error', 'error');
    });
}

/* ═══════════════════════════════════════════════════════════
   FILE HANDLING
═══════════════════════════════════════════════════════════ */

const MAX_MB = 5;

function handleFile(file) {
    if (!file) return;
    const allowedTypes = ['image/jpeg','image/png','application/pdf',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    const errEl = document.getElementById('errFile');
    errEl.textContent = '';

    if (!allowedTypes.includes(file.type) && !file.name.match(/\.(jpg|jpeg|png|pdf|docx)$/i)) {
        errEl.textContent = 'Only .jpg, .png, .pdf, and .docx files are allowed.';
        return;
    }
    if (file.size > MAX_MB * 1024 * 1024) {
        errEl.textContent = `File is too large. Maximum size is ${MAX_MB} MB.`;
        return;
    }

    const reader = new FileReader();
    reader.onload = e => {
        currentFile = {
            name:    file.name,
            size:    file.size,
            type:    file.type,
            dataUrl: e.target.result,
        };
        showFilePreview(currentFile);
    };
    reader.readAsDataURL(file);
}

function showFilePreview(file) {
    const drop    = document.getElementById('fileDrop');
    const preview = document.getElementById('filePreview');
    const isImage = file.type && file.type.startsWith('image/');
    const sizeFmt = file.size > 1024 * 1024
        ? (file.size / 1024 / 1024).toFixed(1) + ' MB'
        : Math.round(file.size / 1024) + ' KB';

    const mediaEl = isImage && file.dataUrl
        ? `<img class="fp-thumb" src="${file.dataUrl}" alt="preview">`
        : `<div class="fp-icon"><i class="fas fa-file-alt"></i></div>`;

    preview.innerHTML = `
        ${mediaEl}
        <div class="fp-info">
            <div class="fp-name">${escHtml(file.name)}</div>
            <div class="fp-size">${sizeFmt}</div>
        </div>
        <button class="fp-remove" id="fpRemove" title="Remove file"><i class="fas fa-times"></i></button>`;
    preview.style.display = 'flex';
    drop.style.display    = 'none';

    document.getElementById('fpRemove').addEventListener('click', () => {
        currentFile = null;
        preview.style.display = 'none';
        drop.style.display    = '';
        document.getElementById('fFile').value = '';
    });
}

/* ═══════════════════════════════════════════════════════════
   DELETE
═══════════════════════════════════════════════════════════ */

function openDeleteModal(id) {
    pendingDeleteId = id;
    document.getElementById('deleteOverlay').classList.add('active');
}

function closeDeleteModal() {
    pendingDeleteId = null;
    document.getElementById('deleteOverlay').classList.remove('active');
}

function confirmDelete() {
    if (!pendingDeleteId) return;
    const btn = document.getElementById('deleteConfirmBtn');
    const oldHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
    btn.disabled = true;

    fetch(API + '?action=delete', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: pendingDeleteId })
    }).then(r => r.json()).then(res => {
        btn.innerHTML = oldHtml;
        btn.disabled = false;
        if (res.ok) {
            closeDeleteModal();
            showToast('Announcement deleted.', 'error');
            loadData();
        } else {
            showToast(res.error || 'Failed to delete', 'error');
        }
    }).catch(() => {
        btn.innerHTML = oldHtml;
        btn.disabled = false;
        showToast('Network error', 'error');
    });
}

/* ═══════════════════════════════════════════════════════════
   TOGGLE PUBLISH / DRAFT
═══════════════════════════════════════════════════════════ */

function toggleStatus(id) {
    const ann = announcements.find(a => String(a.id) === String(id));
    if (!ann) return;
    const newStatus = ann.status === 'published' ? 'draft' : 'published';
    
    fetch(API + '?action=toggle', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id, status: newStatus })
    }).then(r => r.json()).then(res => {
        if (res.ok) {
            showToast(newStatus === 'published' ? 'Announcement published.' : 'Announcement set to draft.', 'success');
            loadData();
        } else {
            showToast(res.error || 'Failed to toggle status', 'error');
        }
    }).catch(() => showToast('Network error', 'error'));
}

/* ═══════════════════════════════════════════════════════════
   SIDEBAR / MENU (mobile) — matches existing portal JS
═══════════════════════════════════════════════════════════ */

function initSidebar() {
    const toggle  = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const close   = document.getElementById('closeSidebar');

    const open = () => { sidebar.classList.add('open'); overlay.classList.add('active'); };
    const shut = () => { sidebar.classList.remove('open'); overlay.classList.remove('active'); };

    toggle?.addEventListener('click', open);
    close?.addEventListener('click', shut);
    overlay?.addEventListener('click', shut);
}

/* ═══════════════════════════════════════════════════════════
   EVENT LISTENERS
═══════════════════════════════════════════════════════════ */

document.addEventListener('DOMContentLoaded', () => {
    initSidebar();
    loadData();

    // ── New Announcement button ──
    document.getElementById('btnNewAnn').addEventListener('click', () => openModal());

    // ── Table delegated clicks ──
    document.getElementById('annTbody').addEventListener('click', e => {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;
        const id     = btn.dataset.id;
        const action = btn.dataset.action;
        if (action === 'edit')   openModal(id);
        if (action === 'toggle') toggleStatus(id);
        if (action === 'delete') openDeleteModal(id);
    });

    // ── Pagination ──
    document.getElementById('apBtns').addEventListener('click', e => {
        const btn = e.target.closest('.ap-btn');
        if (!btn || btn.disabled) return;
        const pg = btn.dataset.pg;
        if (pg === 'prev') currentPage--;
        else if (pg === 'next') currentPage++;
        else currentPage = parseInt(pg, 10);
        renderTable();
    });

    // ── Search ──
    document.getElementById('annSearch').addEventListener('input', () => { currentPage = 1; renderTable(); });

    // ── Filter tabs ──
    document.getElementById('annFilterTabs').addEventListener('click', e => {
        const tab = e.target.closest('.tm-tab');
        if (!tab) return;
        document.querySelectorAll('#annFilterTabs .tm-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        currentPage = 1;
        renderTable();
    });

    // ── Modal close buttons ──
    document.getElementById('modalClose').addEventListener('click', closeModal);
    document.getElementById('modalCancel').addEventListener('click', closeModal);
    document.getElementById('annModalOverlay').addEventListener('click', e => {
        if (e.target === e.currentTarget) closeModal();
    });

    // ── Save/Publish buttons ──
    document.getElementById('btnSaveDraft').addEventListener('click', () => saveAnnouncement('draft'));
    document.getElementById('btnPublish').addEventListener('click',   () => saveAnnouncement('published'));

    // ── Delete modal ──
    document.getElementById('deleteClose').addEventListener('click', closeDeleteModal);
    document.getElementById('deleteCancelBtn').addEventListener('click', closeDeleteModal);
    document.getElementById('deleteConfirmBtn').addEventListener('click', confirmDelete);
    document.getElementById('deleteOverlay').addEventListener('click', e => {
        if (e.target === e.currentTarget) closeDeleteModal();
    });

    // ── File input ──
    document.getElementById('fFile').addEventListener('change', e => {
        if (e.target.files[0]) handleFile(e.target.files[0]);
    });

    // ── Drag & drop ──
    const drop = document.getElementById('fileDrop');
    drop.addEventListener('dragover',  e => { e.preventDefault(); drop.classList.add('dragover'); });
    drop.addEventListener('dragleave', () => drop.classList.remove('dragover'));
    drop.addEventListener('drop', e => {
        e.preventDefault();
        drop.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file) handleFile(file);
    });

    // ── Keyboard close ──
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeModal();
            closeDeleteModal();
        }
    });
});
