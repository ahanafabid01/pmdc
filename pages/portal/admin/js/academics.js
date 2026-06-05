/**
 * academics.js
 * Admin Portal — Academics Management (HSC Groups + Degree Programs)
 * Phulpur Mohila Degree College
 */

'use strict';

/* ═══════════════════════════════════════════════════════════
   STORE (localStorage-backed)
   ═══════════════════════════════════════════════════════════ */

const HSC_KEY = 'pmdc_hsc_groups';
const DEG_KEY = 'pmdc_deg_programs';

function loadStore(key, defaults) {
    try {
        const raw = localStorage.getItem(key);
        return raw ? JSON.parse(raw) : defaults;
    } catch (_) { return defaults; }
}

function saveStore(key, data) {
    localStorage.setItem(key, JSON.stringify(data));
}

/* ─── Default data (from hsc-program.php + degree-program.php) ─── */

const defaultHsc = [
    {
        id: 'hsc-science',
        name: 'Science', bengali: 'বিজ্ঞান শাখা',
        icon: 'fas fa-flask', accent: '#2563eb',
        compulsory: ['Bangla (বাংলা)', 'English', 'ICT (তথ্য ও যোগাযোগ প্রযুক্তি)'],
        optional: ['Physics (পদার্থ বিজ্ঞান)', 'Chemistry (রসায়ন)', 'Biology (জীব বিজ্ঞান)'],
        optional_note: 'Choose any 3',
        fourth: ['Higher Mathematics (উচ্চতর গণিত)', 'Biology (জীব বিজ্ঞান)'],
        fourth_note: 'Choose any 1 (optional)',
    },
    {
        id: 'hsc-humanities',
        name: 'Humanities', bengali: 'মানবিক শাখা',
        icon: 'fas fa-landmark', accent: '#7c3aed',
        compulsory: ['Bangla (বাংলা)', 'English', 'ICT (তথ্য ও যোগাযোগ প্রযুক্তি)'],
        optional: [
            'Civics & Good Governance (পৌরনীতি ও সুশাসন)', 'Economics (অর্থনীতি)',
            'Logic (যুক্তিবিদ্যা)', 'Social Work (সমাজকর্ম)',
            'History (ইতিহাস)', 'Geography (ভূগোল)',
        ],
        optional_note: 'Choose any 3',
        fourth: [
            'Civics (পৌরনীতি)', 'Economics (অর্থনীতি)', 'Logic (যুক্তিবিদ্যা)',
            'Social Work (সমাজকর্ম)', 'History (ইতিহাস)', 'Islamic Studies (ইসলাম শিক্ষা)',
        ],
        fourth_note: 'Choose any 1 (optional)',
    },
    {
        id: 'hsc-business',
        name: 'Business Studies', bengali: 'ব্যবসায় শিক্ষা শাখা',
        icon: 'fas fa-chart-line', accent: '#059669',
        compulsory: ['Bangla (বাংলা)', 'English', 'ICT (তথ্য ও যোগাযোগ প্রযুক্তি)'],
        optional: [
            'Accounting (হিসাব বিজ্ঞান)',
            'Business Policy & Practice (ব্যবসায়নীতি ও প্রয়োগ)',
            'Marketing (মার্কেটিং)',
        ],
        optional_note: 'Choose any 3',
        fourth: ['Economics (অর্থনীতি)', 'Geography (ভূগোল)'],
        fourth_note: 'Choose any 1 (optional)',
    },
];

const defaultDeg = [
    {
        id: 'deg-ba',
        name: 'BA', full: 'Bachelor of Arts', bengali: 'কলা বিভাগ',
        icon: 'fas fa-book', accent: '#7c3aed',
        conductor: 'National University of Bangladesh',
        compulsory: [
            'Bangla (বাংলা)',
            "History of Bangladesh's Liberation (বাংলাদেশের অভ্যুদয়ের ইতিহাস)",
            'English',
        ],
        optional: ['History (ইতিহাস)', 'Philosophy (দর্শন)', 'Political Science (রাষ্ট্রবিজ্ঞান)', 'Islamic Studies (ইসলাম শিক্ষা)'],
        optional_note: 'Choose optional subjects as per curriculum',
    },
    {
        id: 'deg-bss',
        name: 'BSS', full: 'Bachelor of Social Science', bengali: 'সমাজবিজ্ঞান বিভাগ',
        icon: 'fas fa-users', accent: '#2563eb',
        conductor: 'National University of Bangladesh',
        compulsory: [
            'Bangla (বাংলা)',
            "History of Bangladesh's Liberation (বাংলাদেশের অভ্যুদয়ের ইতিহাস)",
            'English',
        ],
        optional: [
            'History (ইতিহাস)', 'Philosophy (দর্শন)', 'Political Science (রাষ্ট্রবিজ্ঞান)',
            'Islamic Studies (ইসলাম শিক্ষা)', 'Economics (অর্থনীতি)', 'Social Welfare (সমাজকল্যাণ)',
        ],
        optional_note: 'Choose optional subjects as per curriculum',
    },
    {
        id: 'deg-bsc',
        name: 'BSc', full: 'Bachelor of Science', bengali: 'বিজ্ঞান বিভাগ',
        icon: 'fas fa-flask', accent: '#059669',
        conductor: 'National University of Bangladesh',
        compulsory: [
            'Bangla (বাংলা)',
            "History of Bangladesh's Liberation (বাংলাদেশের অভ্যুদয়ের ইতিহাস)",
            'English',
        ],
        optional: ['Botany (উদ্ভিদ বিজ্ঞান)', 'Zoology (প্রাণি বিজ্ঞান)', 'Chemistry (রসায়ন)'],
        optional_note: 'Choose optional subjects as per curriculum',
    },
    {
        id: 'deg-bmt',
        name: 'BMT', full: 'Business Management & Technology', bengali: 'ব্যবসায় ব্যবস্থাপনা এবং টেকনোলজি',
        icon: 'fas fa-briefcase', accent: '#d97706',
        conductor: 'National University of Bangladesh',
        compulsory: [
            'Bangla (বাংলা)', 'English',
            'Business Mathematics & Statistics (ব্যবসায়িক গণিত ও পরিসংখ্যান)',
            'Marketing (মার্কেটিং)', 'Business Organization (ব্যবসায় সংগঠন)',
            'Accounting (হিসাব বিজ্ঞান)', 'Economics (অর্থনীতি)',
            'Computer Office Application (কম্পিউটার অফিস অ্যাপ্লিকেশন)',
            'Digital Technology & Business-1 (ডিজিটাল টেকনোলজি এন্ড বিজনেস-১)',
        ],
        optional: [],
        optional_note: 'All subjects are compulsory in this program',
    },
];

/* ═══════════════════════════════════════════════════════════
   STATE
   ═══════════════════════════════════════════════════════════ */

let hscData = loadStore(HSC_KEY, defaultHsc);
let degData = loadStore(DEG_KEY, defaultDeg);

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
    if (count === 0) return `<span class="ac-count-badge none">—</span>`;
    return `<span class="ac-count-badge ${cls}">${count}</span>`;
}

/* ═══════════════════════════════════════════════════════════
   RENDER — STATS
   ═══════════════════════════════════════════════════════════ */

function renderStats() {
    document.getElementById('statHsc').textContent = hscData.length;
    document.getElementById('statDeg').textContent = degData.length;

    const totalSubj = [...hscData, ...degData].reduce((sum, p) => {
        return sum + (p.compulsory?.length || 0) + (p.optional?.length || 0) + (p.fourth?.length || 0);
    }, 0);
    document.getElementById('statSubjects').textContent = totalSubj;
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

    tbody.innerHTML = hscData.map((g, i) => `
        <tr>
            <td style="color:#94a3b8;font-size:.8rem;">${i + 1}</td>
            <td>
                <div class="ac-prog-cell">
                    <span class="ac-prog-dot" style="background:${esc(g.accent)};"></span>
                    <div>
                        <div class="ac-prog-name">${esc(g.name)}</div>
                        <div class="ac-prog-bn">${esc(g.bengali)}</div>
                    </div>
                </div>
            </td>
            <td style="font-size:.8rem;color:var(--muted);">${esc(g.bengali)}</td>
            <td class="text-center">${countBadge(g.compulsory?.length || 0, 'compulsory')}</td>
            <td class="text-center">${countBadge(g.optional?.length || 0, 'optional')}</td>
            <td class="text-center">${countBadge(g.fourth?.length || 0, 'fourth')}</td>
            <td>
                <div class="action-btns">
                    <button class="act-btn act-edit" data-type="hsc" data-id="${esc(g.id)}" data-action="edit" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                    <button class="act-btn act-delete" data-type="hsc" data-id="${esc(g.id)}" data-action="delete" title="Delete"><i class="fas fa-trash-alt"></i></button>
                </div>
            </td>
        </tr>
    `).join('');
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
                        <div class="ac-prog-bn">${esc(p.bengali)}</div>
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
    renderStats();
    renderHscTable();
    renderDegTable();
}

/* ═══════════════════════════════════════════════════════════
   MODAL — OPEN / CLOSE
   ═══════════════════════════════════════════════════════════ */

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
        document.getElementById('fCompulsory').value = joinLines(record.compulsory);
        document.getElementById('fOptional').value   = joinLines(record.optional);
        document.getElementById('fOptNote').value    = record.optional_note || '';

        if (isHsc) {
            document.getElementById('fFourth').value     = joinLines(record.fourth);
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
            document.getElementById('errFull').textContent = 'Full name is required.';
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

    const record = {
        id:           editingId || uid(isHsc ? 'hsc' : 'deg'),
        name:         document.getElementById('fName').value.trim(),
        bengali:      document.getElementById('fBengali').value.trim(),
        accent:       document.getElementById('fColor').value,
        icon:         document.getElementById('fIcon').value.trim() || 'fas fa-book',
        compulsory:   parseLines(document.getElementById('fCompulsory').value),
        optional:     parseLines(document.getElementById('fOptional').value),
        optional_note:document.getElementById('fOptNote').value.trim(),
    };

    if (isHsc) {
        record.fourth      = parseLines(document.getElementById('fFourth').value);
        record.fourth_note = document.getElementById('fFourthNote').value.trim();
    }

    if (isDegree) {
        record.full      = document.getElementById('fFull').value.trim();
        record.conductor = document.getElementById('fConductor').value.trim() || 'National University of Bangladesh';
    }

    if (isHsc) {
        if (editingId) {
            const idx = hscData.findIndex(r => r.id === editingId);
            if (idx !== -1) hscData[idx] = record;
        } else {
            hscData.push(record);
        }
        saveStore(HSC_KEY, hscData);
    } else {
        if (editingId) {
            const idx = degData.findIndex(r => r.id === editingId);
            if (idx !== -1) degData[idx] = record;
        } else {
            degData.push(record);
        }
        saveStore(DEG_KEY, degData);
    }

    renderAll();
    closeModal();
    showToast(editingId ? `"${record.name}" updated successfully.` : `"${record.name}" added successfully.`);
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

    if (pendingDeleteType === 'hsc') {
        const name = hscData.find(r => r.id === pendingDeleteId)?.name;
        hscData = hscData.filter(r => r.id !== pendingDeleteId);
        saveStore(HSC_KEY, hscData);
        showToast(`HSC group "${name}" deleted.`, 'error');
    } else {
        const name = degData.find(r => r.id === pendingDeleteId)?.name;
        degData = degData.filter(r => r.id !== pendingDeleteId);
        saveStore(DEG_KEY, degData);
        showToast(`Degree program "${name}" deleted.`, 'error');
    }

    renderAll();
    closeDeleteModal();
}

/* ═══════════════════════════════════════════════════════════
   INIT & EVENT LISTENERS
   ═══════════════════════════════════════════════════════════ */

document.addEventListener('DOMContentLoaded', () => {
    renderAll();

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
