/**
 * announcements.js
 * Teacher Portal — Announcements Management
 * Phulpur Mohila Degree College
 */

'use strict';

/* ═══════════════════════════════════════════════════════════
   STORE (localStorage-backed)
═══════════════════════════════════════════════════════════ */

const STORE_KEY = 'pmdc_announcements';

function loadStore() {
    try {
        const raw = localStorage.getItem(STORE_KEY);
        return raw ? JSON.parse(raw) : defaultData();
    } catch (_) { return defaultData(); }
}

function saveStore(data) {
    localStorage.setItem(STORE_KEY, JSON.stringify(data));
}

function defaultData() {
    const today = new Date();
    const fmt   = d => d.toISOString().split('T')[0];
    const ago   = (days) => { const d = new Date(today); d.setDate(d.getDate() - days); return fmt(d); };

    return [
        {
            id:         'ann-1',
            title:      'Admission Open for Session 2026–27',
            message:    'Applications are now being accepted for HSC 1st Year (একাদশ শ্রেণি) across Science, Commerce, and Humanities groups. Eligible SSC/Dakhil pass students may apply before the deadline.',
            date:       ago(1),
            status:     'published',
            attachment: null,
            createdAt:  ago(1),
        },
        {
            id:         'ann-2',
            title:      'HSC Test Examination 2026 — Schedule Released',
            message:    'The pre-board test examination (টেস্ট পরীক্ষা) timetable for HSC 2nd Year (দ্বাদশ শ্রেণি) students has been published. Students must collect their admit cards from the college office.',
            date:       ago(3),
            status:     'published',
            attachment: null,
            createdAt:  ago(3),
        },
        {
            id:         'ann-3',
            title:      'সাংস্কৃতিক অনুষ্ঠান — Annual Cultural Programme 2026',
            message:    'The annual cultural programme will take place in the college auditorium. All students are encouraged to participate and showcase their talent.',
            date:       ago(4),
            status:     'published',
            attachment: null,
            createdAt:  ago(4),
        },
        {
            id:         'ann-4',
            title:      'Parents Meeting — Draft Notice',
            message:    'A parents meeting is being planned for Class XI and XII guardians. Date and time to be confirmed. This is currently a draft.',
            date:       ago(5),
            status:     'draft',
            attachment: null,
            createdAt:  ago(5),
        },
        {
            id:         'ann-5',
            title:      'Scholarship Applications 2026 — Now Open',
            message:    'Merit-based and need-based scholarships are available for eligible students. Application deadline: 28th February 2026. Submit applications through the college office.',
            date:       ago(7),
            status:     'published',
            attachment: null,
            createdAt:  ago(7),
        },
        {
            id:         'ann-6',
            title:      'Guest Lecture — Women Empowerment & Leadership',
            message:    'A special guest lecture on women\'s empowerment and educational leadership will be held at the college premises. All HSC students are welcome to attend.',
            date:       ago(13),
            status:     'published',
            attachment: null,
            createdAt:  ago(13),
        },
        {
            id:         'ann-7',
            title:      'HSC Board Exam Results 2025 — Draft Summary',
            message:    'Draft summary of HSC Annual Exam 2025 results. Awaiting final verification before publishing.',
            date:       ago(18),
            status:     'draft',
            attachment: null,
            createdAt:  ago(18),
        },
        {
            id:         'ann-8',
            title:      'College Closed — National Holiday Notice',
            message:    'The college will remain closed on the upcoming national holiday. Regular classes will resume the following working day.',
            date:       ago(20),
            status:     'published',
            attachment: null,
            createdAt:  ago(20),
        },
        {
            id:         'ann-9',
            title:      'New ICT Lab Equipment Installed',
            message:    'The college has installed new computers and projectors in the ICT lab. Students can now use the upgraded facility during scheduled lab hours.',
            date:       ago(25),
            status:     'published',
            attachment: null,
            createdAt:  ago(25),
        },
        {
            id:         'ann-10',
            title:      'Year-Change Exam Results — Draft',
            message:    'Results for the Year-Change exam (বার্ষান্তর পরীক্ষা) for Class XI students are being compiled. Will be published once verified.',
            date:       ago(28),
            status:     'draft',
            attachment: null,
            createdAt:  ago(28),
        },
        {
            id:         'ann-11',
            title:      'Sports Day 2026 — Registration Open',
            message:    'Annual Sports Day (বার্ষিক ক্রীড়া দিবস) is scheduled for March 2026. Students wishing to participate should register at the office.',
            date:       ago(32),
            status:     'published',
            attachment: null,
            createdAt:  ago(32),
        },
        {
            id:         'ann-12',
            title:      'Anti-Drug Awareness Campaign',
            message:    'A special awareness programme on the dangers of drug abuse will be held in collaboration with local health authorities. Attendance is compulsory for all students.',
            date:       ago(40),
            status:     'published',
            attachment: null,
            createdAt:  ago(40),
        },
    ];
}

/* ═══════════════════════════════════════════════════════════
   STATE
═══════════════════════════════════════════════════════════ */

let announcements = loadStore();
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
        const a = announcements.find(x => x.id === id);
        title.textContent              = 'Edit Announcement';
        document.getElementById('fTitle').value   = a.title;
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

    setTimeout(() => {
        const status = forcedStatus || document.querySelector('input[name="fStatus"]:checked').value;
        const ann = {
            id:         editingId || uid(),
            title:      document.getElementById('fTitle').value.trim(),
            message:    document.getElementById('fMessage').value.trim(),
            date:       document.getElementById('fDate').value,
            status,
            attachment: currentFile,
            createdAt:  editingId
                ? (announcements.find(x => x.id === editingId)?.createdAt || todayISO())
                : todayISO(),
        };

        if (editingId) {
            const idx = announcements.findIndex(x => x.id === editingId);
            if (idx !== -1) announcements[idx] = ann;
        } else {
            announcements.unshift(ann);
        }

        saveStore(announcements);
        renderTable();
        closeModal();

        publish.disabled = false; draft.disabled = false;
        publish.classList.remove('loading');

        showToast(
            editingId
                ? `Announcement ${status === 'published' ? 'updated & published' : 'saved as draft'}.`
                : `Announcement ${status === 'published' ? 'published' : 'saved as draft'} successfully.`
            , 'success'
        );
    }, 700);
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
    announcements = announcements.filter(a => a.id !== pendingDeleteId);
    saveStore(announcements);
    renderTable();
    closeDeleteModal();
    showToast('Announcement deleted.', 'error');
}

/* ═══════════════════════════════════════════════════════════
   TOGGLE PUBLISH / DRAFT
═══════════════════════════════════════════════════════════ */

function toggleStatus(id) {
    const ann = announcements.find(a => a.id === id);
    if (!ann) return;
    ann.status = ann.status === 'published' ? 'draft' : 'published';
    saveStore(announcements);
    renderTable();
    showToast(
        ann.status === 'published' ? 'Announcement published.' : 'Announcement set to draft.',
        ann.status === 'published' ? 'fas fa-globe' : 'fas fa-file-alt'
    );
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
    renderTable();

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
