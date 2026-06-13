/**
 * students.js
 * Phulpur Mohila Degree College — Student Management
 * Supports HSC (Class XI/XII) and Degree (1st/2nd/3rd Year) programs
 * with groups, optional subjects, and 4th subjects loaded from the database.
 */

'use strict';

/* ═══════════════════════════════════════════════════
   CONSTANTS
═══════════════════════════════════════════════════ */

const AVATAR_COLORS = [
    '#276749','#2c5282','#7b341e','#702459','#1a365d',
    '#0ea5e9','#f97316','#14b8a6','#ec4899','#6366f1'
];

// Year options by program type
const YEAR_OPTIONS = {
    hsc: [
        { value: 'xi',  label: 'Class XI — HSC 1st Year (একাদশ শ্রেণি)' },
        { value: 'xii', label: 'Class XII — HSC 2nd Year (দ্বাদশ শ্রেণি)' },
    ],
    degree: [
        { value: '1st', label: '1st Year (প্রথম বর্ষ)' },
        { value: '2nd', label: '2nd Year (দ্বিতীয় বর্ষ)' },
        { value: '3rd', label: '3rd Year (তৃতীয় বর্ষ)' },
    ],
};

// Year display labels
const YEAR_LABELS = {
    xi:  { label:'HSC 1st Year', labelBn:'একাদশ শ্রেণি', cls:'' },
    xii: { label:'HSC 2nd Year', labelBn:'দ্বাদশ শ্রেণি', cls:'xii' },
    '1st': { label:'Degree 1st Year', labelBn:'প্রথম বর্ষ', cls:'' },
    '2nd': { label:'Degree 2nd Year', labelBn:'দ্বিতীয় বর্ষ', cls:'' },
    '3rd': { label:'Degree 3rd Year', labelBn:'তৃতীয় বর্ষ', cls:'' },
};

// Group display labels
const GROUP_LABELS = {
    science:    { label:'বিজ্ঞান (Science)',           cls:'group-sci', icon:'fa-flask'       },
    commerce:   { label:'ব্যবসায় শিক্ষা (Business)',  cls:'group-com', icon:'fa-briefcase'   },
    humanities: { label:'মানবিক (Humanities)',         cls:'group-hum', icon:'fa-book'        },
    ba:         { label:'BA (Arts)',                   cls:'group-hum', icon:'fa-palette'     },
    bmt:        { label:'BMT (Business)',              cls:'group-com', icon:'fa-chart-line'  },
    bsc:        { label:'BSc (Science)',               cls:'group-sci', icon:'fa-atom'        },
    bss:        { label:'BSS (Social Science)',        cls:'group-hum', icon:'fa-globe'       },
};

// allPrograms populated by loadPrograms()
let allPrograms = []; // [{id, name, type, optionalSubjects:[], fourthSubjects:[], optionalNote}]

const API_URL = window.BASE_URL + `/pages/portal/admin/api-students.php`;

let allStudents    = [];
let filtered       = [];
let currentPage    = 1;
const PAGE_SIZE    = 15;
let viewMode       = 'table';
let deleteTargetId = null;

/* ── Load academic programs from DB ─────────────────────────── */
async function loadPrograms() {
    try {
        const res  = await fetch(API_URL + '?action=programs');
        const data = await res.json();
        if (data.success) {
            allPrograms = data.programs;
        }
    } catch(e) {
        console.error('Failed to load programs', e);
    }
}

/* ── Fetch students ──────────────────────────────────────────── */
async function fetchStudents() {
    $('tableInfo').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading students from database...';
    try {
        const res = await fetch(API_URL);
        const json = await res.json();
        if (json.success) {
            allStudents = json.data;
            applyFilters();
        } else {
            console.error(json.error);
            $('tableInfo').textContent = 'Failed to load students.';
        }
    } catch (e) {
        console.error(e);
        $('tableInfo').textContent = 'Error connecting to database.';
    }
}

/* ═══════════════════════════════════════════════════
   DOM HELPERS
═══════════════════════════════════════════════════ */

const $ = id => document.getElementById(id);

function fmt(val, fallback = '—') { return (val && val.trim && val.trim()) ? val : fallback; }

function getGroupLabel(group) {
    return GROUP_LABELS[group]?.label || group || '—';
}
function getGroupCls(group) {
    return GROUP_LABELS[group]?.cls || 'group-hum';
}
function getGroupIcon(group) {
    return GROUP_LABELS[group]?.icon || 'fa-graduation-cap';
}
function getYearLabel(year) {
    return YEAR_LABELS[year]?.label || year || '—';
}

function showToast(msg) {
    const tm = $('toastMsg');
    const t  = $('toast');
    if (tm && t) {
        tm.textContent = msg;
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 3000);
    }
}

/* ── Strip Bengali parenthetical from subject name ── */
function stripBn(s) { return s.replace(/\s*\(.*?\)\s*/g, '').trim(); }

/* ── Populate the Year dropdown based on program type ── */
function populateYears(type, selectedYear = '') {
    const sel  = $('hscYear');
    const opts = YEAR_OPTIONS[type] || [];
    if (!opts.length) {
        sel.innerHTML = '<option value="">-- Select Program First --</option>';
        return;
    }
    sel.innerHTML = '<option value="">-- Select Year --</option>' +
        opts.map(o => `<option value="${o.value}" ${o.value === selectedYear ? 'selected' : ''}>${o.label}</option>`).join('');
}

/* ── Populate the Group dropdown based on program type ── */
function populateGroups(type, selectedGroup = '') {
    const sel      = $('group');
    const programs = allPrograms.filter(p => p.type === type);
    if (!programs.length) {
        sel.innerHTML = '<option value="">-- No Programs Found --</option>';
        return;
    }
    sel.innerHTML = '<option value="">-- Select Group --</option>' +
        programs.map(p => `<option value="${p.id}" ${p.id === selectedGroup ? 'selected' : ''}>${p.name}</option>`).join('');
}

/* ── Populate optional subjects as checkboxes (max 3) ── */
function populateOptionals(programId, selectedOpts = []) {
    const container = $('optionalSubjectGroup');
    if (!container) return;
    const prog = allPrograms.find(p => p.id === programId);
    if (!prog || !prog.optionalSubjects.length) {
        container.innerHTML = '<span class="chk-placeholder">No elective subjects for this group</span>';
        return;
    }
    // Normalise selectedOpts to array
    if (typeof selectedOpts === 'string') {
        selectedOpts = selectedOpts ? selectedOpts.split(',').map(s => s.trim()) : [];
    }
    const maxChoices = 3;
    container.innerHTML = prog.optionalSubjects.map((s, i) => {
        const clean   = stripBn(s);
        const checked = selectedOpts.includes(clean);
        return `
        <label class="chk-subject-item" id="chk-wrap-opt-${i}">
            <input type="checkbox" class="opt-subject-chk" value="${clean}"
                   ${checked ? 'checked' : ''}
                   onchange="enforceOptMax(${maxChoices})">
            <span class="chk-subject-name">${s}</span>
        </label>`;
    }).join('');
    enforceOptMax(maxChoices);
}

/* ── Enforce max-3 checkbox selections ── */
window.enforceOptMax = function(max) {
    const boxes = document.querySelectorAll('.opt-subject-chk');
    const checkedCount = [...boxes].filter(b => b.checked).length;
    boxes.forEach(b => {
        if (!b.checked) b.disabled = checkedCount >= max;
    });
    const errEl = $('err-optionalSubject');
    if (errEl) errEl.textContent = checkedCount > max ? `Max ${max} subjects allowed` : '';
};

/* ── Get selected optional subjects as comma-separated string ── */
function getCheckedOptionals() {
    return [...document.querySelectorAll('.opt-subject-chk:checked')].map(b => b.value).join(',');
}

/* ── Populate 4th subjects — HSC only ── */
function populateFourthSubjects(programId, selectedFourth = '') {
    const wrapEl = $('fourthSubjectWrap');
    const sel    = $('fourthSubject');
    const prog   = allPrograms.find(p => p.id === programId);

    // Only show for HSC programs that have fourth_subjects configured
    if (!prog || prog.type !== 'hsc' || !prog.fourthSubjects.length) {
        wrapEl.style.display = 'none';
        sel.innerHTML = '<option value="">-- None --</option>';
        return;
    }
    wrapEl.style.display = '';
    sel.innerHTML = '<option value="">-- None (Optional) --</option>' +
        prog.fourthSubjects.map(s => {
            const clean = stripBn(s);
            return `<option value="${clean}" ${clean === selectedFourth ? 'selected' : ''}>${s}</option>`;
        }).join('');
}


/* ═══════════════════════════════════════════════════
   RENDER TABLE
═══════════════════════════════════════════════════ */

function renderTable() {
    const start = (currentPage - 1) * PAGE_SIZE;
    const end   = Math.min(start + PAGE_SIZE, filtered.length);
    const page  = filtered.slice(start, end);

    $('studentsTableBody').innerHTML = page.map(s => {
        const grpCls   = getGroupCls(s.group || s.programId);
        const grpIcon  = getGroupIcon(s.group || s.programId);
        const grpLabel = getGroupLabel(s.group || s.programId);
        const yrLabel  = getYearLabel(s.year);
        return `
        <tr data-id="${s.id}">
            <td><input type="checkbox" class="check-row" data-id="${s.id}"></td>
            <td><code class="roll-code">${s.roll}</code></td>
            <td>
                <div class="stu-cell">
                    <span class="stu-name">${s.name}</span>
                    ${s.programType === 'degree' ? '<span style="font-size:.7rem;background:#ede9fe;color:#5b21b6;border-radius:4px;padding:1px 5px;margin-left:4px;">Degree</span>' : ''}
                </div>
            </td>
            <td><span class="session-tag">${s.session || '—'}</span></td>
            <td><span class="group-badge ${grpCls}"><i class="fas ${grpIcon}"></i> ${grpLabel.split('(')[0].trim()}</span></td>
            <td><span class="year-tag">${yrLabel}</span></td>
            <td><span class="section-tag">Sec ${s.section || '—'}</span></td>
            <td><span class="phone-text">${s.phone || '—'}</span></td>
            <td>
                <div class="row-actions-cell">
                    <button class="row-act-btn ra-view"   onclick="viewStudent('${s.id}')"   title="View Profile"><i class="fas fa-eye"></i></button>
                    <button class="row-act-btn ra-edit"   onclick="editStudent('${s.id}')"   title="Edit"><i class="fas fa-edit"></i></button>
                    <button class="row-act-btn ra-delete" onclick="confirmDelete('${s.id}')" title="Delete"><i class="fas fa-trash"></i></button>
                </div>
            </td>
        </tr>`;
    }).join('');

    document.querySelectorAll('.check-row').forEach(cb => cb.addEventListener('change', handleCheck));
    $('tableInfo').textContent = `Showing ${start+1}–${end} of ${filtered.length} students`;
    renderPagination();
    updateStats();
}


/* ═══════════════════════════════════════════════════
   RENDER GRID
═══════════════════════════════════════════════════ */

function renderGrid() {
    const start = (currentPage - 1) * PAGE_SIZE;
    const page  = filtered.slice(start, Math.min(start + PAGE_SIZE, filtered.length));

    $('gridView').innerHTML = page.map(s => {
        const grpCls   = getGroupCls(s.group || s.programId);
        const grpLabel = getGroupLabel(s.group || s.programId);
        const yrLabel  = getYearLabel(s.year);
        return `
        <div class="sgc" onclick="viewStudent('${s.id}')">
            <div class="sgc-top">
                <div class="sgc-avatar" style="background:${s.color};">${s.initials}</div>
                <div>
                    <div class="sgc-name">${s.name}</div>
                    <div class="sgc-roll">${s.roll}</div>
                </div>
            </div>
            <div class="sgc-row"><span class="sgc-key">Group</span>
                <span class="group-badge ${grpCls}" style="padding:2px 7px;font-size:.75rem;">${grpLabel.split('(')[0].trim()}</span>
            </div>
            <div class="sgc-row"><span class="sgc-key">Year</span><span class="year-tag" style="font-size:.74rem;">${yrLabel}</span></div>
            <div class="sgc-row"><span class="sgc-key">Section</span><span>${s.section || '—'}</span></div>
            <div class="sgc-row"><span class="sgc-key">Phone</span><span class="phone-text">${s.phone || '—'}</span></div>
            <div class="sgc-btns" onclick="event.stopPropagation()">
                <button class="sgc-btn sgc-view" onclick="viewStudent('${s.id}')"><i class="fas fa-eye"></i> View</button>
                <button class="sgc-btn sgc-edit" onclick="editStudent('${s.id}')"><i class="fas fa-edit"></i> Edit</button>
                <button class="sgc-btn sgc-del"  onclick="confirmDelete('${s.id}')"><i class="fas fa-trash"></i></button>
            </div>
        </div>`;
    }).join('');

    renderPagination();
}

/* ═══════════════════════════════════════════════════
   STATS
═══════════════════════════════════════════════════ */

function updateStats() {
    $('statTotal').textContent = allStudents.length;
    $('statSci').textContent   = allStudents.filter(s => s.group === 'science' || s.group === 'bsc').length;
    $('statCom').textContent   = allStudents.filter(s => s.group === 'commerce' || s.group === 'bmt').length;
    $('statHum').textContent   = allStudents.filter(s => s.group === 'humanities' || s.group === 'ba' || s.group === 'bss').length;
    const degEl = $('statDeg');
    if (degEl) degEl.textContent = allStudents.filter(s => (s.programType || 'hsc') === 'degree').length;
}

/* ═══════════════════════════════════════════════════
   PAGINATION
═══════════════════════════════════════════════════ */

function renderPagination() {
    const totalPages = Math.ceil(filtered.length / PAGE_SIZE);
    const el = $('pagination');
    if (totalPages <= 1) { el.innerHTML = ''; return; }

    let html = `<button class="page-btn" onclick="goPage(${currentPage-1})" ${currentPage===1?'disabled':''}><i class="fas fa-chevron-left"></i></button>`;
    for (let p = 1; p <= totalPages; p++) {
        if (p===1||p===totalPages||Math.abs(p-currentPage)<=1)
            html += `<button class="page-btn ${p===currentPage?'active':''}" onclick="goPage(${p})">${p}</button>`;
        else if (Math.abs(p-currentPage)===2)
            html += `<span class="page-ellipsis">…</span>`;
    }
    html += `<button class="page-btn" onclick="goPage(${currentPage+1})" ${currentPage===totalPages?'disabled':''}><i class="fas fa-chevron-right"></i></button>`;
    el.innerHTML = html;
}

window.goPage = p => {
    const total = Math.ceil(filtered.length / PAGE_SIZE);
    if (p < 1 || p > total) return;
    currentPage = p;
    viewMode === 'table' ? renderTable() : renderGrid();
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

/* ═══════════════════════════════════════════════════
   FILTERS
═══════════════════════════════════════════════════ */

function applyFilters() {
    const q           = ($('studentSearch')?.value || '').toLowerCase().trim();
    const progType    = $('programTypeFilter')?.value || '';
    const year        = $('yearFilter')?.value    || '';
    const group       = $('groupFilter')?.value   || '';
    const section     = $('sectionFilter')?.value || '';
    const session     = $('sessionFilter')?.value || '';
    const sort        = $('sortFilter')?.value    || 'name';

    filtered = allStudents.filter(s => {
        if (q       && !s.name.toLowerCase().includes(q) && !s.roll.toLowerCase().includes(q) && !(s.regno||'').includes(q)) return false;
        if (progType && (s.programType || 'hsc') !== progType)   return false;
        if (year    && s.year    !== year)    return false;
        if (group   && (s.group||s.programId)  !== group)  return false;
        if (section && s.section !== section) return false;
        if (session && s.session !== session) return false;
        return true;
    });

    switch (sort) {
        case 'name':   filtered.sort((a, b) => a.name.localeCompare(b.name)); break;
        case 'roll':   filtered.sort((a, b) => (a.roll||'').localeCompare(b.roll||'')); break;
        case 'recent': filtered.sort((a, b) => (b.addedDate||'').localeCompare(a.addedDate||'')); break;
    }

    currentPage = 1;
    viewMode === 'table' ? renderTable() : renderGrid();
}

[$('studentSearch'), $('globalSearch')].forEach(el => el?.addEventListener('input', applyFilters));
[$('programTypeFilter'), $('yearFilter'), $('groupFilter'), $('sectionFilter'), $('sessionFilter'), $('sortFilter')].forEach(el => el?.addEventListener('change', applyFilters));


/* ═══════════════════════════════════════════════════
   VIEW TOGGLE
═══════════════════════════════════════════════════ */

$('tableViewBtn').addEventListener('click', function() {
    viewMode = 'table';
    this.classList.add('active');
    $('gridViewBtn').classList.remove('active');
    $('tableView').style.display = '';
    $('gridView').style.display  = 'none';
    renderTable();
});

$('gridViewBtn').addEventListener('click', function() {
    viewMode = 'grid';
    this.classList.add('active');
    $('tableViewBtn').classList.remove('active');
    $('tableView').style.display = 'none';
    $('gridView').style.display  = '';
    renderGrid();
});

/* ═══════════════════════════════════════════════════
   COLUMN SORT
═══════════════════════════════════════════════════ */

document.querySelectorAll('.sortable').forEach(th => {
    th.addEventListener('click', function() {
        const col = this.dataset.col;
        const asc = !this.classList.contains('sorted-asc');
        document.querySelectorAll('.sortable').forEach(t => t.classList.remove('sorted-asc','sorted-desc'));
        this.classList.add(asc ? 'sorted-asc' : 'sorted-desc');
        filtered.sort((a, b) => {
            const va = a[col], vb = b[col];
            if (typeof va === 'string') return asc ? va.localeCompare(vb) : vb.localeCompare(va);
            return asc ? va - vb : vb - va;
        });
        currentPage = 1;
        renderTable();
    });
});

/* ═══════════════════════════════════════════════════
   CHECKBOX / BULK
═══════════════════════════════════════════════════ */

$('selectAll').addEventListener('change', function() {
    document.querySelectorAll('.check-row').forEach(cb => cb.checked = this.checked);
    updateBulkBar();
});

function handleCheck() { updateBulkBar(); }

function updateBulkBar() {
    const n = document.querySelectorAll('.check-row:checked').length;
    $('bulkActions').style.display  = n > 0 ? 'flex' : 'none';
    $('selectedCount').textContent  = `${n} selected`;
    const all     = document.querySelectorAll('.check-row');
    const checked = document.querySelectorAll('.check-row:checked');
    $('selectAll').indeterminate = checked.length > 0 && checked.length < all.length;
    $('selectAll').checked       = all.length > 0 && checked.length === all.length;
}

/* ═══════════════════════════════════════════════════
   VIEW STUDENT — Detail Modal (Page 1)
═══════════════════════════════════════════════════ */

window.viewStudent = function(id) {
    const s = allStudents.find(x => x.id === id);
    if (!s) return;

    const grpLabel = getGroupLabel(s.group || s.programId);
    const grpCls   = getGroupCls(s.group || s.programId);
    const grpIcon  = getGroupIcon(s.group || s.programId);
    const yrLabel  = getYearLabel(s.year);
    const yrLabelBn = YEAR_LABELS[s.year]?.labelBn || '';
    const progLabel = s.programType === 'degree' ? 'Degree (ডিগ্রি)' : 'HSC (উচ্চ মাধ্যমিক)';

    $('modalTitle').innerHTML = `<i class="fas fa-user"></i> Student Profile`;
    $('studentModalBody').innerHTML = `
        <div class="detail-header">
            ${s.photoUrl
                ? `<img src="${s.photoUrl}" style="width:64px;height:80px;border-radius:8px;object-fit:cover;flex-shrink:0;">`
                : `<div class="detail-avatar" style="background:${s.color};">${s.initials}</div>`}
            <div>
                <h3 class="detail-name">${s.name}</h3>
                <p class="detail-sub">${s.roll} &nbsp;·&nbsp; Reg: ${s.regno || '—'}</p>
                <div class="detail-tags">
                    <span class="group-badge ${grpCls}"><i class="fas ${grpIcon}"></i> ${grpLabel}</span>
                    <span class="year-tag">${yrLabel}${yrLabelBn ? ' (' + yrLabelBn + ')' : ''}</span>
                    ${s.section ? `<span class="section-tag">Section ${s.section}</span>` : ''}
                    <span style="font-size:.75rem;background:${s.programType==='degree'?'#ede9fe':'#dbeafe'};color:${s.programType==='degree'?'#5b21b6':'#1e40af'};border-radius:5px;padding:2px 8px;font-weight:600;">${progLabel}</span>
                </div>
            </div>
            <div style="margin-left:auto;display:flex;gap:8px;flex-shrink:0;">
                <button class="row-act-btn ra-edit" onclick="editStudent('${s.id}')" style="width:auto;padding:0 14px;" title="Edit">
                    <i class="fas fa-edit"></i> Edit
                </button>
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-section">
                <h4><i class="fas fa-graduation-cap"></i> Academic</h4>
                ${dRow('Program', progLabel)}
                ${dRow('Year / Class', yrLabel)}
                ${dRow('Group / Stream', grpLabel)}
                ${dRow('Optional Subjects', s.optionalSubject
                    ? s.optionalSubject.split(',').map(o => `<span style="display:inline-block;background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;border-radius:5px;padding:1px 8px;margin:2px 3px 2px 0;font-size:.82rem;">${o.trim()}</span>`).join('')
                    : '—')}
                ${s.fourthSubject ? dRow('4th (Bonus) Subject', s.fourthSubject) : ''}
                ${dRow('Section', s.section ? `Section ${s.section}` : '—')}
                ${dRow('Session', s.session)}
                ${dRow('Roll No.', s.roll)}
                ${dRow('Registration No.', s.regno || '—')}
                ${dRow('Institution', s.institution)}
            </div>
            <div class="detail-section">
                <h4><i class="fas fa-id-card"></i> Personal</h4>
                ${dRow('Date of Birth', s.dob || '—')}
                ${dRow('Gender', s.gender ? s.gender.charAt(0).toUpperCase() + s.gender.slice(1) : '—')}
                ${dRow('Religion', s.religion || '—')}
                ${dRow('Blood Group', s.bloodGroup || '—')}
                ${dRow('NID Number', fmt(s.nid))}
                ${dRow('Birth Certificate', fmt(s.birthCert))}
            </div>
            <div class="detail-section">
                <h4><i class="fas fa-phone"></i> Contact</h4>
                ${dRow('Phone', s.phone)}
                ${dRow('Email', fmt(s.email))}
                ${dRow('Present Address', s.presentAddr || '—')}
                ${dRow('Permanent Address', s.permanentAddr || '—')}
            </div>
            <div class="detail-section">
                <h4><i class="fas fa-users"></i> Parents / Guardian</h4>
                ${dRow("Father's Name", fmt(s.fatherName))}
                ${dRow("Father's Phone", fmt(s.fatherPhone))}
                ${dRow("Father's Occupation", fmt(s.fatherOcc))}
                ${dRow("Mother's Name", fmt(s.motherName))}
                ${dRow("Mother's Phone", fmt(s.motherPhone))}
                ${dRow("Mother's Occupation", fmt(s.motherOcc))}
                ${s.guardianName ? dRow('Guardian', `${s.guardianName} (${s.guardianRel || 'Guardian'})`) : ''}
                ${s.guardianPhone ? dRow("Guardian's Phone", s.guardianPhone) : ''}
            </div>
        </div>
    `;

    $('studentModal').classList.add('open');
};

function dRow(key, val) {
    return `<div class="detail-row"><span class="detail-key">${key}</span><span class="detail-val">${val || '—'}</span></div>`;
}

$('closeStudentModal').addEventListener('click', () => $('studentModal').classList.remove('open'));
$('studentModal').addEventListener('click', e => { if (e.target === $('studentModal')) $('studentModal').classList.remove('open'); });

/* ═══════════════════════════════════════════════════
   FORM SECTION TABS
═══════════════════════════════════════════════════ */

document.querySelectorAll('.ftab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.ftab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.form-section').forEach(s => s.classList.remove('active'));
        this.classList.add('active');
        $(`section-${this.dataset.section}`)?.classList.add('active');
    });
});

/* ═══════════════════════════════════════════════════
   ADD STUDENT
═══════════════════════════════════════════════════ */

$('addStudentBtn').addEventListener('click', () => openStudentForm(null));

/* ── Program Type → Year + Group cascade ── */
$('programType')?.addEventListener('change', function() {
    const type = this.value;
    populateYears(type);
    populateGroups(type);
    // Reset optional checkboxes
    const optGrp = $('optionalSubjectGroup');
    if (optGrp) optGrp.innerHTML = '<span class="chk-placeholder">Select Group / Program first</span>';
    populateFourthSubjects('');
});

/* ── Group selection → Optional + 4th subjects ── */
$('group')?.addEventListener('change', function() {
    const programId = this.value;
    populateOptionals(programId, []);
    populateFourthSubjects(programId);
});

function openStudentForm(studentId) {
    const isEdit = studentId !== null;
    const s      = isEdit ? allStudents.find(x => x.id === studentId) : null;

    $('addEditTitle').innerHTML = isEdit
        ? `<i class="fas fa-user-edit"></i> Edit Student`
        : `<i class="fas fa-user-plus"></i> Add New Student`;

    $('editStudentId').value = studentId || '';

    // Reset form
    $('studentForm').reset();
    clearErrors();
    $('hscYear').innerHTML     = '<option value="">-- Select Program First --</option>';
    $('group').innerHTML       = '<option value="">-- Select Program First --</option>';
    const optGrp = $('optionalSubjectGroup');
    if (optGrp) optGrp.innerHTML = '<span class="chk-placeholder">Select Group / Program first</span>';
    populateFourthSubjects('');

    // Reset photo
    $('photoPreview').innerHTML = `<i class="fas fa-user-circle"></i><span>No photo uploaded</span>`;

    // Switch to Academic tab
    document.querySelectorAll('.ftab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.form-section').forEach(s => s.classList.remove('active'));
    document.querySelector('.ftab[data-section="academic"]').classList.add('active');
    $('section-academic').classList.add('active');

    // Populate if editing
    if (s) {
        $('fname').value       = s.name;
        $('roll').value        = s.roll;
        $('regno').value       = s.regno;

        // Restore program type, then cascade
        const pType = s.programType || 'hsc';
        $('programType').value = pType;
        populateYears(pType, s.year);
        populateGroups(pType, s.programId || s.group);
        populateOptionals(s.programId || s.group, s.optionalSubject || '');
        populateFourthSubjects(s.programId || s.group, s.fourthSubject);

        $('section').value     = s.section;
        $('session').value     = s.session;
        $('institution').value = s.institution;

        $('dob').value         = s.dob;
        $('gender').value      = s.gender;
        $('religion').value    = s.religion;
        $('bloodGroup').value  = s.bloodGroup;
        $('nid').value         = s.nid;
        $('birthCert').value   = s.birthCert;

        $('phone').value         = s.phone;
        $('email').value         = s.email;
        $('presentAddr').value   = s.presentAddr;
        $('permanentAddr').value = s.permanentAddr;

        $('fatherName').value  = s.fatherName;
        $('fatherNid').value   = s.fatherNid;
        $('fatherPhone').value = s.fatherPhone;
        $('fatherOcc').value   = s.fatherOcc;
        $('motherName').value  = s.motherName;
        $('motherNid').value   = s.motherNid;
        $('motherPhone').value = s.motherPhone;
        $('motherOcc').value   = s.motherOcc;
        $('guardianName').value  = s.guardianName;
        $('guardianPhone').value = s.guardianPhone;
        $('guardianRel').value   = s.guardianRel;

        if (s.photoUrl) {
            $('photoPreview').innerHTML = `<img src="${s.photoUrl}" alt="Photo">`;
        }
    }

    $('addEditModal').classList.add('open');
}

window.editStudent = function(id) { openStudentForm(id); };

[$('closeAddEdit'), $('cancelForm')].forEach(el => {
    el.addEventListener('click', () => $('addEditModal').classList.remove('open'));
});

$('addEditModal').addEventListener('click', e => {
    if (e.target === $('addEditModal')) $('addEditModal').classList.remove('open');
});

/* ─── Same Address checkbox ─── */
$('sameAddress').addEventListener('change', function() {
    if (this.checked) $('permanentAddr').value = $('presentAddr').value;
});

/* ─── Photo preview ─── */
$('photoInput').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        $('photoPreview').innerHTML = `<img src="${e.target.result}" alt="Photo">`;
    };
    reader.readAsDataURL(file);
});

/* ═══════════════════════════════════════════════════
   VALIDATION
═══════════════════════════════════════════════════ */

function isBDPhone(v) { return /^01[3-9]\d{8}$/.test(v.trim()); }
function isNID(v)     { return /^\d{10}$|^\d{17}$/.test(v.trim()); }

function setErr(id, msg) { const el = $(id); if (el) el.textContent = msg; }
function clearErrors() {
    ['err-fname','err-roll','err-programType','err-hscYear','err-group','err-phone',
     'err-nid','err-fatherNid','err-fatherPhone','err-motherNid',
     'err-motherPhone','err-guardianPhone'].forEach(id => setErr(id, ''));
}

function validateForm() {
    clearErrors();
    let ok = true;

    const name       = $('fname').value.trim();
    const roll       = $('roll').value.trim();
    const programType = $('programType').value;
    const hscYear    = $('hscYear').value;
    const group      = $('group').value;
    const phone      = $('phone').value.trim();
    const nid        = $('nid').value.trim();
    const fNid       = $('fatherNid').value.trim();
    const fPhone     = $('fatherPhone').value.trim();
    const mNid       = $('motherNid').value.trim();
    const mPhone     = $('motherPhone').value.trim();
    const gPhone     = $('guardianPhone').value.trim();

    if (!name)        { setErr('err-fname',       'Full name is required');          ok = false; }
    if (!roll)        { setErr('err-roll',         'Roll number is required');        ok = false; }
    if (!programType) { setErr('err-programType',  'Please select a program');        ok = false; }
    if (!hscYear)     { setErr('err-hscYear',      'Please select a year/class');     ok = false; }
    if (!group)       { setErr('err-group',        'Please select a group/program');  ok = false; }

    // Check roll uniqueness (skip own record when editing)
    const editId = $('editStudentId').value;
    if (roll && allStudents.some(s => s.roll === roll && s.id !== editId)) {
        setErr('err-roll', 'Roll number already exists — must be unique'); ok = false;
    }

    if (phone  && !isBDPhone(phone))  { setErr('err-phone',        'Invalid BD phone (01XXXXXXXXX)');  ok = false; }
    if (nid    && !isNID(nid))        { setErr('err-nid',           'NID must be 10 or 17 digits');     ok = false; }
    if (fNid   && !isNID(fNid))       { setErr('err-fatherNid',    'NID must be 10 or 17 digits');     ok = false; }
    if (fPhone && !isBDPhone(fPhone)) { setErr('err-fatherPhone',  'Invalid BD phone (01XXXXXXXXX)');  ok = false; }
    if (mNid   && !isNID(mNid))       { setErr('err-motherNid',    'NID must be 10 or 17 digits');     ok = false; }
    if (mPhone && !isBDPhone(mPhone)) { setErr('err-motherPhone',  'Invalid BD phone (01XXXXXXXXX)');  ok = false; }
    if (gPhone && !isBDPhone(gPhone)) { setErr('err-guardianPhone','Invalid BD phone (01XXXXXXXXX)');  ok = false; }

    return ok;
}

/* ═══════════════════════════════════════════════════
   SAVE STUDENT
═══════════════════════════════════════════════════ */

$('studentForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    if (!validateForm()) {
        const firstErr = document.querySelector('.err:not(:empty)');
        if (firstErr) {
            const section = firstErr.closest('.form-section');
            if (section) {
                const sectionId = section.id.replace('section-','');
                document.querySelectorAll('.ftab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.form-section').forEach(s => s.classList.remove('active'));
                document.querySelector(`.ftab[data-section="${sectionId}"]`)?.classList.add('active');
                section.classList.add('active');
            }
        }
        return;
    }

    const editId = $('editStudentId').value;
    const programType = $('programType').value || 'hsc';
    const programId   = $('group').value; // program id (e.g. 'hsc-science', 'deg-ba')

    // Derive academic_group from programId for backwards compatibility
    const groupMap = {
        'hsc-science': 'science', 'hsc-business': 'commerce', 'hsc-humanities': 'humanities',
        'deg-ba': 'ba', 'deg-bmt': 'bmt', 'deg-bsc': 'bsc', 'deg-bss': 'bss'
    };
    const academicGroup = groupMap[programId] || programId;

    const studentData = {
        name:            $('fname').value.trim(),
        initials:        ($('fname').value.trim().split(' ').map(w => w[0]).join('').slice(0,2)).toUpperCase(),
        roll:            $('roll').value.trim(),
        regno:           $('regno').value.trim(),
        year:            $('hscYear').value,
        group:           academicGroup,
        programType:     programType,
        programId:       programId,
        optionalSubject: getCheckedOptionals(),
        fourthSubject:   $('fourthSubject')?.value || '',
        section:         $('section').value || 'A',
        session:         $('session').value.trim() || new Date().getFullYear() + '–' + (new Date().getFullYear()+1),
        institution:     $('institution').value.trim(),

        dob:          $('dob').value,
        gender:       $('gender').value,
        religion:     $('religion').value,
        bloodGroup:   $('bloodGroup').value,
        nid:          $('nid').value.trim(),
        birthCert:    $('birthCert').value.trim(),

        phone:        $('phone').value.trim(),
        email:        $('email').value.trim(),
        presentAddr:  $('presentAddr').value.trim(),
        permanentAddr:$('permanentAddr').value.trim(),

        fatherName:   $('fatherName').value.trim(),
        fatherNid:    $('fatherNid').value.trim(),
        fatherPhone:  $('fatherPhone').value.trim(),
        fatherOcc:    $('fatherOcc').value.trim(),
        motherName:   $('motherName').value.trim(),
        motherNid:    $('motherNid').value.trim(),
        motherPhone:  $('motherPhone').value.trim(),
        motherOcc:    $('motherOcc').value.trim(),
        guardianName: $('guardianName').value.trim(),
        guardianPhone:$('guardianPhone').value.trim(),
        guardianRel:  $('guardianRel').value.trim(),
        photoUrl:     null,
    };

    const method = editId ? 'PUT' : 'POST';
    if (editId) {
        studentData.id = editId;
    } else {
        studentData.id = `stu-${Date.now()}`;
        studentData.color = AVATAR_COLORS[allStudents.length % AVATAR_COLORS.length];
        studentData.addedDate = new Date().toISOString().split('T')[0];
    }

    const submitBtn = this.querySelector('.btn-save-form');
    const originalText = submitBtn ? submitBtn.innerHTML : '';
    if (submitBtn) {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        submitBtn.disabled = true;
    }

    try {
        const res = await fetch(API_URL, {
            method: method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(studentData)
        });
        const json = await res.json();
        
        if (json.success) {
            showToast(`Student "${studentData.name}" saved to database!`);
            $('addEditModal').classList.remove('open');
            fetchStudents(); // Reload from DB
        } else {
            alert('Database Error: ' + json.error);
        }
    } catch (err) {
        alert('Network error connecting to database.');
    } finally {
        if (submitBtn) {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }
});

/* ═══════════════════════════════════════════════════
   DELETE STUDENT
═══════════════════════════════════════════════════ */

window.confirmDelete = function(id) {
    const s = allStudents.find(x => x.id === id);
    if (!s) return;
    deleteTargetId = id;
    $('deleteStudentName').textContent = s.name;
    $('deleteModal').classList.add('open');
};

$('confirmDelete').addEventListener('click', async () => {
    if (!deleteTargetId) return;
    
    const delBtn = $('confirmDelete');
    const originalText = delBtn.innerHTML;
    delBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
    delBtn.disabled = true;

    try {
        const res = await fetch(API_URL, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: deleteTargetId })
        });
        const json = await res.json();
        
        if (json.success) {
            showToast('Student deleted from database.');
            $('deleteModal').classList.remove('open');
            deleteTargetId = null;
            fetchStudents(); // Reload from DB
        } else {
            alert('Database Error: ' + json.error);
        }
    } catch (err) {
        alert('Network error while deleting.');
    } finally {
        delBtn.innerHTML = originalText;
        delBtn.disabled = false;
    }

});

[$('closeDeleteModal'), $('cancelDelete')].forEach(el => {
    el.addEventListener('click', () => $('deleteModal').classList.remove('open'));
});

$('deleteModal').addEventListener('click', e => {
    if (e.target === $('deleteModal')) $('deleteModal').classList.remove('open');
});

/* ═══════════════════════════════════════════════════
   EXPORT CSV
═══════════════════════════════════════════════════ */

$('exportBtn').addEventListener('click', () => {
    const headers = ['Roll No','Name','Year','Group','Optional Subject','Section','Phone','Email','Father','Mother','Date Added'];
    const rows    = filtered.map(s => [
        s.roll, `"${s.name}"`, YEAR_LABELS[s.year].label,
        GROUP_LABELS[s.group].label.split('(')[0].trim(),
        getOptionalSubjectLabel(s.group, s.optionalSubject),
        `Section ${s.section}`, s.phone, s.email,
        `"${s.fatherName}"`, `"${s.motherName}"`, s.addedDate,
    ].join(','));
    const csv  = [headers.join(','), ...rows].join('\n');
    const blob = new Blob(['\uFEFF' + csv], { type:'text/csv;charset=utf-8;' }); // BOM for Excel Bangla support
    const a    = document.createElement('a');
    a.href     = URL.createObjectURL(blob);
    a.download = 'pmdc-students.csv';
    a.click();
});

/* ═══════════════════════════════════════════════════
   TOAST
═══════════════════════════════════════════════════ */

function showToast(msg) {
    $('toastMsg').textContent = msg;
    $('toast').classList.add('show');
    setTimeout(() => $('toast').classList.remove('show'), 3500);
}

/* ═══════════════════════════════════════════════════
   INIT
═══════════════════════════════════════════════════ */

// Load programs first, then fetch students
loadPrograms().then(() => fetchStudents());
