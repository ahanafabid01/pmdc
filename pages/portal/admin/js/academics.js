/**
 * academics.js
 * Admin Portal — Academics Management (HSC Groups + Degree Programs)
 * Phulpur Mohila Degree College
 */

'use strict';

/* ═══════════════════════════════════════════════════════════
   API FETCHING
   ═══════════════════════════════════════════════════════════ */

const API = window.BASE_URL + `/pages/portal/admin/api/academics.php`;

let hscData = [];
let degData = [];

function loadData() {
    fetch(API + '?action=list')
        .then(r => r.json())
        .then(data => {
            if (data.ok) {
                hscData = data.hsc || [];
                degData = data.degree || [];
                renderAll();
            } else {
                showToast(data.error || 'Failed to load data', 'error');
            }
        })
        .catch(() => showToast('Network error loading data', 'error'));
}

let currentModalType = 'hsc'; // 'hsc' | 'degree'
let editingId        = null;
let pendingDeleteId  = null;
let pendingDeleteType = null;

/* ═══════════════════════════════════════════════════════════
   HELPERS
   ═══════════════════════════════════════════════════════════ */

function uid(prefix) {
    return prefix + '-' + Date.now() + '-' + Math.random().toString(36).slice(2, 6);
}

function esc(s) {
    return String(s)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;')
        .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function parseLines(str) {
    return str.split('\n').map(s => s.trim()).filter(Boolean);
}

function joinLines(arr) {
    return (arr || []).join('\n');
}

function showToast(msg, type = 'success') {
    const el = document.getElementById('acToast');
    el.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${msg}`;
    el.className = `tm-toast ${type} show`;
    setTimeout(() => el.classList.remove('show'), 3000);
}

function countBadge(count, cls) {
    if (count === 0) return `<span class="ac-count-badge none" style="width:30px;height:30px;border-radius:50%;padding:0;">—</span>`;
    return `<span class="ac-count-badge ${cls}" style="width:30px;height:30px;border-radius:50%;padding:0;">${count}</span>`;
}

/* ═══════════════════════════════════════════════════════════
   RENDER — HSC TABLE
   ═══════════════════════════════════════════════════════════ */


function renderHscTable() {
    const tbody = document.getElementById('hscTbody');
    const empty = document.getElementById('hscEmpty');
    const table = document.getElementById('hscTable');

    if (hscData.length === 0) {
        table.style.display = 'none';
        empty.style.display = 'flex';
        return;
    }

    table.style.display = '';
    empty.style.display = 'none';

    tbody.innerHTML = hscData.map((g, i) => {
        return `
        <tr style="vertical-align:top;">
            <td style="color:#94a3b8;font-size:.8rem;padding-top:22px;">${i + 1}</td>
            <td style="padding-top:20px;">
                <div class="ac-prog-cell">
                    <span class="ac-prog-dot" style="background:${esc(g.accent)};width:12px;height:12px;"></span>
                    <div>
                        <div class="ac-prog-name" style="font-size:1.05rem;">${esc(g.name)}</div>
                        <div style="font-size:.8rem;color:var(--muted);margin-top:2px;">${esc(g.bengali)}</div>
                    </div>
                </div>
            </td>
            <td style="padding-top:20px;">
                <span style="font-size:0.75rem;font-weight:600;color:#64748b;background:#f1f5f9;padding:5px 10px;border-radius:6px;border:1px solid #e2e8f0;white-space:nowrap;">${esc(g.optional_note || 'Choose any 3')}</span>
            </td>
            <td class="text-center" style="padding-top:22px;">${countBadge(g.compulsory?.length || 0, 'compulsory')}</td>
            <td class="text-center" style="padding-top:22px;">${countBadge(g.optional?.length || 0, 'optional')}</td>
            <td class="text-center" style="padding-top:22px;">${countBadge(g.fourth?.length || 0, 'fourth')}</td>
            <td style="padding-top:20px;">
                <div class="action-btns">
                    <button class="act-btn act-edit" data-type="hsc" data-id="${esc(g.id)}" data-action="edit" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                    <button class="act-btn act-delete" data-type="hsc" data-id="${esc(g.id)}" data-action="delete" title="Delete"><i class="fas fa-trash-alt"></i></button>
                </div>
            </td>
        </tr>
    `}).join('');
}

/* ═══════════════════════════════════════════════════════════
   RENDER — DEGREE TABLE
   ═══════════════════════════════════════════════════════════ */

function renderDegTable() {
    const tbody = document.getElementById('degTbody');
    const empty = document.getElementById('degEmpty');
    const table = document.getElementById('degTable');

    if (degData.length === 0) {
        table.style.display = 'none';
        empty.style.display = 'flex';
        return;
    }

    table.style.display = '';
    empty.style.display = 'none';

    tbody.innerHTML = degData.map((p, i) => `
        <tr>
            <td style="color:#94a3b8;font-size:.8rem;">${i + 1}</td>
            <td>
                <div class="ac-prog-cell">
                    <span class="ac-prog-dot" style="background:${esc(p.accent)};"></span>
                    <div>
                        <div class="ac-prog-name">${esc(p.name)}</div>
                    </div>
                </div>
            </td>
            <td class="ac-full-cell">${esc(p.full)}</td>
            <td style="font-size:.8rem;color:var(--muted);">${esc(p.bengali)}</td>
            <td class="text-center">${countBadge(p.compulsory?.length || 0, 'compulsory')}</td>
            <td class="text-center">${countBadge(p.optional?.length || 0, 'optional')}</td>
            <td>
                <div class="action-btns">
                    <button class="act-btn act-edit" data-type="degree" data-id="${esc(p.id)}" data-action="edit" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                    <button class="act-btn act-delete" data-type="degree" data-id="${esc(p.id)}" data-action="delete" title="Delete"><i class="fas fa-trash-alt"></i></button>
                </div>
            </td>
        </tr>
    `).join('');
}

function renderAll() {
    renderHscTable();
    renderDegTable();
}

/* ═══════════════════════════════════════════════════════════
   MODAL — OPEN / CLOSE
   ═══════════════════════════════════════════════════════════ */

function formatSubjectsWithCodes(subjects, codesObj) {
    if (!subjects) return '';
    return subjects.map(sub => {
        const key = sub.replace(/\s*\(.*?\)\s*/g, '').trim();
        const entry = codesObj ? codesObj[key] : null;
        if (entry) {
            if (entry.only) {
                return `${sub} - [${entry.only}]`;
            } else if (entry['1st'] && entry['2nd']) {
                return `${sub} - [${entry['1st']}, ${entry['2nd']}]`;
            }
        }
        return sub;
    }).join('\n');
}

function extractSubjectsAndCodes(linesRaw, codesObj) {
    const lines = linesRaw.split('\n').map(l => l.trim()).filter(l => l !== '');
    const cleanSubjects = [];
    
    for (let line of lines) {
        // Match: `Subject Name (Optional Bengali) - [101, 102]` or `... - [275]`
        const match = line.match(/(.*?)(?:\s*-\s*)?\[\s*([\d\s,]+)\s*\]\s*$/);
        
        if (match) {
            const subject = match[1].trim(); 
            cleanSubjects.push(subject);
            
            // Extract the English base key
            const key = subject.replace(/\s*\(.*?\)\s*/g, '').trim();
            
            // Parse codes
            const codesStr = match[2];
            const codesArr = codesStr.split(',').map(c => c.trim()).filter(c => c !== '');
            
            if (codesArr.length === 1) {
                codesObj[key] = { "only": parseInt(codesArr[0], 10) };
            } else if (codesArr.length >= 2) {
                codesObj[key] = { "1st": parseInt(codesArr[0], 10), "2nd": parseInt(codesArr[1], 10) };
            }
        } else {
            cleanSubjects.push(line);
        }
    }
    return cleanSubjects;
}

function openModal(type, id = null) {
    currentModalType = type;
    editingId        = id;

    const isHsc    = type === 'hsc';
    const isDegree = type === 'degree';

    // Show/hide degree-only fields
    document.getElementById('fFullWrap').style.display      = isDegree ? '' : 'none';
    document.getElementById('fFourthSection').style.display = isHsc    ? '' : 'none';
    document.getElementById('fConductorWrap').style.display = isDegree ? '' : 'none';

    clearErrors();

    const titleEl = document.getElementById('acModalTitle');

    if (id) {
        // Edit mode
        const data   = isHsc ? hscData : degData;
        const record = data.find(r => r.id === id);
        if (!record) return;

        titleEl.innerHTML = `<i class="fas fa-pencil-alt"></i> Edit ${isHsc ? 'HSC Group' : 'Degree Program'}`;

        document.getElementById('fName').value     = record.name;
        document.getElementById('fBengali').value  = record.bengali;
        document.getElementById('fColor').value    = record.accent;
        document.getElementById('fIcon').value     = record.icon;
        updateIconPreview(record.icon);
        
        document.getElementById('fCompulsory').value = formatSubjectsWithCodes(record.compulsory, record.subject_codes);
        document.getElementById('fOptional').value   = formatSubjectsWithCodes(record.optional, record.subject_codes);
        document.getElementById('fOptNote').value    = record.optional_note || '';

        if (isHsc) {
            document.getElementById('fFourth').value     = formatSubjectsWithCodes(record.fourth, record.subject_codes);
            document.getElementById('fFourthNote').value = record.fourth_note || '';
        }
        if (isDegree) {
            document.getElementById('fFull').value      = record.full;
            document.getElementById('fConductor').value = record.conductor || 'National University of Bangladesh';
        }
    } else {
        // Add mode
        titleEl.innerHTML = `<i class="fas fa-plus"></i> Add ${isHsc ? 'HSC Group' : 'Degree Program'}`;
        document.getElementById('acForm').reset();
        document.getElementById('fColor').value = isHsc ? '#2563eb' : '#7c3aed';
        document.getElementById('fIcon').value  = isHsc ? 'fas fa-book-open' : 'fas fa-university';
        document.getElementById('fConductor').value = 'National University of Bangladesh';
        updateIconPreview(document.getElementById('fIcon').value);
    }

    document.getElementById('acModalOverlay').classList.add('active');
    document.getElementById('fName').focus();
}

function closeModal() {
    document.getElementById('acModalOverlay').classList.remove('active');
    editingId = null;
}

function clearErrors() {
    ['errName', 'errFull', 'errBengali', 'errCompulsory'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.textContent = '';
    });
}

function updateIconPreview(cls) {
    const prev = document.getElementById('fIconPreview');
    prev.className = cls || 'fas fa-book';
}

/* ═══════════════════════════════════════════════════════════
   MODAL — VALIDATE & SAVE
   ═══════════════════════════════════════════════════════════ */

function validateForm() {
    let ok = true;
    const name      = document.getElementById('fName').value.trim();
    const bengali   = document.getElementById('fBengali').value.trim();
    const compLines = document.getElementById('fCompulsory').value.trim();

    if (!name) {
        document.getElementById('errName').textContent = 'Name is required.';
        ok = false;
    }
    if (!bengali) {
        document.getElementById('errBengali').textContent = 'Bengali name is required.';
        ok = false;
    }
    if (!compLines) {
        document.getElementById('errCompulsory').textContent = 'At least one compulsory subject is required.';
        ok = false;
    }

    if (currentModalType === 'degree') {
        const full = document.getElementById('fFull').value.trim();
        if (!full) {
            document.getElementById('errFull').textContent = 'Full name is required for degrees.';
            ok = false;
        }
    }
    
    return ok;
}

function saveProgram() {
    clearErrors();
    if (!validateForm()) return;

    const isHsc    = currentModalType === 'hsc';
    const isDegree = currentModalType === 'degree';

    let subjectCodesParsed = {};
    const compSubjects = extractSubjectsAndCodes(document.getElementById('fCompulsory').value, subjectCodesParsed);
    const optSubjects  = extractSubjectsAndCodes(document.getElementById('fOptional').value, subjectCodesParsed);
    
    let fourthSubjects = [];
    if (isHsc) {
        fourthSubjects = extractSubjectsAndCodes(document.getElementById('fFourth').value, subjectCodesParsed);
    }

    const record = {
        id:           editingId || uid(isHsc ? 'hsc' : 'deg'),
        name:         document.getElementById('fName').value.trim(),
        bengali:      document.getElementById('fBengali').value.trim(),
        accent:       document.getElementById('fColor').value,
        icon:         document.getElementById('fIcon').value.trim() || 'fas fa-book',
        compulsory:   compSubjects,
        optional:     optSubjects,
        optional_note:document.getElementById('fOptNote').value.trim(),
        subject_codes: subjectCodesParsed
    };

    if (isHsc) {
        record.fourth      = fourthSubjects;
        record.fourth_note = document.getElementById('fFourthNote').value.trim();
    }

    if (isDegree) {
        record.full      = document.getElementById('fFull').value.trim();
        record.conductor = document.getElementById('fConductor').value.trim() || 'National University of Bangladesh';
    }

    const btn = document.getElementById('acModalSave');
    const oldText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    btn.disabled = true;

    fetch(API + '?action=save', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ...record, type: isHsc ? 'hsc' : 'degree' })
    })
    .then(r => r.json())
    .then(res => {
        btn.innerHTML = oldText;
        btn.disabled = false;
        if (res.ok) {
            closeModal();
            showToast(editingId ? `"${record.name}" updated successfully.` : `"${record.name}" added successfully.`);
            loadData();
        } else {
            showToast(res.error || 'Failed to save', 'error');
        }
    })
    .catch(() => {
        btn.innerHTML = oldText;
        btn.disabled = false;
        showToast('Network error', 'error');
    });
}

/* ═══════════════════════════════════════════════════════════
   DELETE
   ═══════════════════════════════════════════════════════════ */

function openDeleteModal(type, id) {
    pendingDeleteId   = id;
    pendingDeleteType = type;

    const data   = type === 'hsc' ? hscData : degData;
    const record = data.find(r => r.id === id);
    document.getElementById('deleteProgName').textContent = record ? `"${record.name}"` : 'this program';
    document.getElementById('acDeleteOverlay').classList.add('active');
}

function closeDeleteModal() {
    pendingDeleteId   = null;
    pendingDeleteType = null;
    document.getElementById('acDeleteOverlay').classList.remove('active');
}

function confirmDelete() {
    if (!pendingDeleteId) return;
    const btn = document.getElementById('acDeleteConfirm');
    const oldText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
    btn.disabled = true;

    fetch(API + '?action=delete', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: pendingDeleteId, type: pendingDeleteType })
    })
    .then(r => r.json())
    .then(res => {
        btn.innerHTML = oldText;
        btn.disabled = false;
        if (res.ok) {
            closeDeleteModal();
            showToast('Program deleted successfully.', 'error');
            loadData();
        } else {
            showToast(res.error || 'Failed to delete', 'error');
        }
    })
    .catch(() => {
        btn.innerHTML = oldText;
        btn.disabled = false;
        showToast('Network error', 'error');
    });
}

/* ═══════════════════════════════════════════════════════════
   INIT & EVENT LISTENERS
   ═══════════════════════════════════════════════════════════ */

document.addEventListener('DOMContentLoaded', () => {
    loadData();

    // ── Add buttons ──
    document.getElementById('btnAddHsc').addEventListener('click', () => openModal('hsc'));
    document.getElementById('btnAddDeg').addEventListener('click', () => openModal('degree'));

    // ── Table delegated clicks (HSC + Degree) ──
    ['hscTbody', 'degTbody'].forEach(tbodyId => {
        document.getElementById(tbodyId).addEventListener('click', e => {
            const btn = e.target.closest('[data-action]');
            if (!btn) return;
            const { type, id, action } = btn.dataset;
            if (action === 'edit')   openModal(type, id);
            if (action === 'delete') openDeleteModal(type, id);
        });
    });

    // ── Modal: close ──
    document.getElementById('acModalClose').addEventListener('click', closeModal);
    document.getElementById('acModalCancel').addEventListener('click', closeModal);
    document.getElementById('acModalOverlay').addEventListener('click', e => {
        if (e.target === e.currentTarget) closeModal();
    });

    // ── Modal: save ──
    document.getElementById('acModalSave').addEventListener('click', saveProgram);

    // ── Delete modal ──
    document.getElementById('acDeleteClose').addEventListener('click', closeDeleteModal);
    document.getElementById('acDeleteCancel').addEventListener('click', closeDeleteModal);
    document.getElementById('acDeleteConfirm').addEventListener('click', confirmDelete);
    document.getElementById('acDeleteOverlay').addEventListener('click', e => {
        if (e.target === e.currentTarget) closeDeleteModal();
    });

    // ── Icon preview live update ──
    document.getElementById('fIcon').addEventListener('input', e => {
        updateIconPreview(e.target.value.trim());
    });

    // ── Color presets ──
    document.querySelectorAll('.ac-preset').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('fColor').value = this.dataset.color;
            document.querySelectorAll('.ac-preset').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // ── Keyboard close ──
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeModal();
            closeDeleteModal();
        }
    });
});
