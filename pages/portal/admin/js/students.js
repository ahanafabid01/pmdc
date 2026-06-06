/**
 * teacher-students.js
 * Bangladesh HSC Student Management System
 * Phulpur Mohila Degree College
 */

'use strict';

/* ═══════════════════════════════════════════════════
   DATA STRUCTURES
═══════════════════════════════════════════════════ */

const AVATAR_COLORS = [
    '#276749','#2c5282','#7b341e','#702459','#1a365d',
    '#0ea5e9','#f97316','#14b8a6','#ec4899','#6366f1'
];

const GROUP_LABELS = {
    science:    { label:'বিজ্ঞান (Science)',              cls:'group-sci', icon:'fa-flask'    },
    commerce:   { label:'ব্যবসায় শিক্ষা (Business)',     cls:'group-com', icon:'fa-briefcase' },
    humanities: { label:'মানবিক (Humanities)',            cls:'group-hum', icon:'fa-book'      },
};

const YEAR_LABELS = {
    xi:  { label:'HSC 1st Year', labelBn:'একাদশ শ্রেণি', cls:'' },
    xii: { label:'HSC 2nd Year', labelBn:'দ্বাদশ শ্রেণি', cls:'xii' },
};

const OPTIONAL_SUBJECTS = {
    science: [
        { value: 'higher_math', label: 'Higher Math' },
        { value: 'biology', label: 'Biology' },
        { value: 'agriculture', label: 'Agriculture' },
    ],
    commerce: [
        { value: 'production_management', label: 'Production Management' },
        { value: 'finance', label: 'Finance & Banking' },
    ],
    humanities: [
        { value: 'history', label: 'History' },
        { value: 'islamic_history', label: 'Islamic History' },
        { value: 'geography', label: 'Geography' },
    ],
};


const API_URL = 'api-students.php';

let allStudents     = [];
let filtered        = [];
let currentPage     = 1;
const PAGE_SIZE     = 15;
let viewMode        = 'table';
let deleteTargetId  = null;

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

function getOptionalSubjectLabel(group, value) {
    const subject = (OPTIONAL_SUBJECTS[group] || []).find(item => item.value === value);
    return subject ? subject.label : '—';
}

function showToast(msg) {
    const tm = $('toastMsg');
    const t = $('toast');
    if (tm && t) {
        tm.textContent = msg;
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 3000);
    }
}

function populateOptionalSubject(group, selected = '') {
    const select = $('optionalSubject');
    if (!select) return;

    const options = OPTIONAL_SUBJECTS[group] || [];
    if (!options.length) {
        select.innerHTML = '<option value="">Select academic group first</option>';
        select.disabled = true;
        return;
    }

    select.disabled = false;
    select.innerHTML = options.map(opt =>
        `<option value="${opt.value}" ${opt.value === selected ? 'selected' : ''}>${opt.label}</option>`
    ).join('');

    if (selected && !options.some(opt => opt.value === selected)) {
        select.value = options[0].value;
    }
}

/* ═══════════════════════════════════════════════════
   RENDER TABLE
═══════════════════════════════════════════════════ */

function renderTable() {
    const start = (currentPage - 1) * PAGE_SIZE;
    const end   = Math.min(start + PAGE_SIZE, filtered.length);
    const page  = filtered.slice(start, end);
    const grp   = GROUP_LABELS;
    const yr    = YEAR_LABELS;

    $('studentsTableBody').innerHTML = page.map(s => `
        <tr data-id="${s.id}">
            <td><input type="checkbox" class="check-row" data-id="${s.id}"></td>
            <td><code class="roll-code">${s.roll}</code></td>
            <td>
                <div class="stu-cell">
                    <span class="stu-name">${s.name}</span>
                </div>
            </td>
            <td><span class="session-tag">${s.session}</span></td>
            <td>
                <span class="group-badge ${grp[s.group].cls}">
                    <i class="fas ${grp[s.group].icon}"></i> ${s.group === 'science' ? 'Science' : s.group === 'commerce' ? 'Business' : 'Humanities'}
                </span>
            </td>
            <td><span class="year-tag ${yr[s.year].cls}">${yr[s.year].label}</span></td>
            <td><span class="section-tag">Sec ${s.section}</span></td>
            <td><span class="phone-text">${s.phone}</span></td>
            <td>
                <div class="row-actions-cell">
                    <button class="row-act-btn ra-view"   onclick="viewStudent('${s.id}')"   title="View Profile"><i class="fas fa-eye"></i></button>
                    <button class="row-act-btn ra-edit"   onclick="editStudent('${s.id}')"   title="Edit"><i class="fas fa-edit"></i></button>
                    <button class="row-act-btn ra-delete" onclick="confirmDelete('${s.id}')" title="Delete"><i class="fas fa-trash"></i></button>
                </div>
            </td>
        </tr>`).join('');


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
    const grp   = GROUP_LABELS;
    const yr    = YEAR_LABELS;

    $('gridView').innerHTML = page.map(s => `
        <div class="sgc" onclick="viewStudent('${s.id}')">
            <div class="sgc-top">
                <div class="sgc-avatar" style="background:${s.color};">${s.initials}</div>
                <div>
                    <div class="sgc-name">${s.name}</div>
                    <div class="sgc-roll">${s.roll}</div>
                </div>
            </div>
            <div class="sgc-row"><span class="sgc-key">Group</span>
                <span class="group-badge ${grp[s.group].cls}" style="padding:2px 7px;font-size:.75rem;">
                    ${s.group === 'science' ? 'Science' : s.group === 'commerce' ? 'Business' : 'Humanities'}
                </span>
            </div>
            <div class="sgc-row"><span class="sgc-key">Year</span><span class="year-tag ${yr[s.year].cls}" style="font-size:.74rem;">${yr[s.year].label}</span></div>
            <div class="sgc-row"><span class="sgc-key">Section</span><span>${s.section}</span></div>
            <div class="sgc-row"><span class="sgc-key">Phone</span><span class="phone-text">${s.phone}</span></div>
            <div class="sgc-btns" onclick="event.stopPropagation()">
                <button class="sgc-btn sgc-view" onclick="viewStudent('${s.id}')"><i class="fas fa-eye"></i> View</button>
                <button class="sgc-btn sgc-edit" onclick="editStudent('${s.id}')"><i class="fas fa-edit"></i> Edit</button>
                <button class="sgc-btn sgc-del"  onclick="confirmDelete('${s.id}')"><i class="fas fa-trash"></i></button>
            </div>
        </div>`).join('');

    renderPagination();
}

/* ═══════════════════════════════════════════════════
   STATS
═══════════════════════════════════════════════════ */

function updateStats() {
    $('statTotal').textContent = allStudents.length;
    $('statSci').textContent   = allStudents.filter(s => s.group === 'science').length;
    $('statCom').textContent   = allStudents.filter(s => s.group === 'commerce').length;
    $('statHum').textContent   = allStudents.filter(s => s.group === 'humanities').length;
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
    const q       = ($('studentSearch')?.value || '').toLowerCase().trim();
    const year    = $('yearFilter')?.value    || '';
    const group   = $('groupFilter')?.value   || '';
    const section = $('sectionFilter')?.value || '';
    const session = $('sessionFilter')?.value || '';
    const sort    = $('sortFilter')?.value    || 'name';

    filtered = allStudents.filter(s => {
        if (q && !s.name.toLowerCase().includes(q) && !s.roll.toLowerCase().includes(q) && !s.regno.includes(q)) return false;
        if (year    && s.year    !== year)    return false;
        if (group   && s.group   !== group)   return false;
        if (section && s.section !== section) return false;
        if (session && s.session !== session) return false;
        return true;
    });


    switch (sort) {
        case 'name':   filtered.sort((a, b) => a.name.localeCompare(b.name)); break;
        case 'roll':   filtered.sort((a, b) => a.roll.localeCompare(b.roll)); break;
        case 'recent': filtered.sort((a, b) => b.addedDate.localeCompare(a.addedDate)); break;
    }

    currentPage = 1;
    viewMode === 'table' ? renderTable() : renderGrid();
}

    [$('studentSearch'), $('globalSearch')].forEach(el => el?.addEventListener('input', applyFilters));
    [$('yearFilter'), $('groupFilter'), $('sectionFilter'), $('sessionFilter'), $('sortFilter')].forEach(el => el?.addEventListener('change', applyFilters));


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

    const grp = GROUP_LABELS[s.group];
    const yr  = YEAR_LABELS[s.year];

    $('modalTitle').innerHTML = `<i class="fas fa-user"></i> Student Profile`;
    $('studentModalBody').innerHTML = `
        <div class="detail-header">
            ${s.photoUrl
                ? `<img src="${s.photoUrl}" style="width:64px;height:80px;border-radius:8px;object-fit:cover;flex-shrink:0;">`
                : `<div class="detail-avatar" style="background:${s.color};">${s.initials}</div>`}
            <div>
                <h3 class="detail-name">${s.name}</h3>
                <p class="detail-sub">${s.roll} &nbsp;·&nbsp; Reg: ${s.regno}</p>
                <div class="detail-tags">
                    <span class="group-badge ${grp.cls}"><i class="fas ${grp.icon}"></i> ${grp.label}</span>
                    <span class="year-tag ${yr.cls}">${yr.label} (${yr.labelBn})</span>
                    <span class="section-tag">Section ${s.section}</span>
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
                ${dRow('Session', s.session)}
                ${dRow('Institution', s.institution)}
                ${dRow('Year', yr.label)}
                ${dRow('Group (বিভাগ)', grp.label)}
                ${dRow('Optional Subject', getOptionalSubjectLabel(s.group, s.optionalSubject))}
                ${dRow('Section', `Section ${s.section}`)}
                ${dRow('Roll No.', s.roll)}
                ${dRow('Registration No.', s.regno)}
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

$('group')?.addEventListener('change', function() {
    populateOptionalSubject(this.value, '');
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
    populateOptionalSubject('', '');

    // Reset photo
    $('photoPreview').innerHTML = `<i class="fas fa-user-circle"></i><span>No photo uploaded</span>`;

    // Switch to Academic tab
    document.querySelectorAll('.ftab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.form-section').forEach(s => s.classList.remove('active'));
    document.querySelector('.ftab[data-section="academic"]').classList.add('active');
    $('section-academic').classList.add('active');

    // Populate if editing
    if (s) {
        $('fname').value         = s.name;
        $('roll').value          = s.roll;
        $('regno').value         = s.regno;
        $('hscYear').value       = s.year;
        $('group').value         = s.group;
        populateOptionalSubject(s.group, s.optionalSubject || OPTIONAL_SUBJECTS[s.group]?.[0]?.value || '');
        $('section').value       = s.section;
        $('session').value       = s.session;
        $('institution').value   = s.institution;

        $('dob').value           = s.dob;
        $('gender').value        = s.gender;
        $('religion').value      = s.religion;
        $('bloodGroup').value    = s.bloodGroup;
        $('nid').value           = s.nid;
        $('birthCert').value     = s.birthCert;

        $('phone').value         = s.phone;
        $('email').value         = s.email;
        $('presentAddr').value   = s.presentAddr;
        $('permanentAddr').value = s.permanentAddr;

        $('fatherName').value    = s.fatherName;
        $('fatherNid').value     = s.fatherNid;
        $('fatherPhone').value   = s.fatherPhone;
        $('fatherOcc').value     = s.fatherOcc;
        $('motherName').value    = s.motherName;
        $('motherNid').value     = s.motherNid;
        $('motherPhone').value   = s.motherPhone;
        $('motherOcc').value     = s.motherOcc;
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
    ['err-fname','err-roll','err-hscYear','err-group','err-phone',
     'err-nid','err-fatherNid','err-fatherPhone','err-motherNid',
     'err-motherPhone','err-guardianPhone'].forEach(id => setErr(id, ''));
}

function validateForm() {
    clearErrors();
    let ok = true;

    const name    = $('fname').value.trim();
    const roll    = $('roll').value.trim();
    const hscYear = $('hscYear').value;
    const group   = $('group').value;
    const phone   = $('phone').value.trim();
    const nid     = $('nid').value.trim();
    const fNid    = $('fatherNid').value.trim();
    const fPhone  = $('fatherPhone').value.trim();
    const mNid    = $('motherNid').value.trim();
    const mPhone  = $('motherPhone').value.trim();
    const gPhone  = $('guardianPhone').value.trim();

    if (!name)     { setErr('err-fname',    'Full name is required');              ok = false; }
    if (!roll)     { setErr('err-roll',     'Roll number is required');            ok = false; }
    if (!hscYear)  { setErr('err-hscYear',  'Please select HSC year');            ok = false; }
    if (!group)    { setErr('err-group',    'Please select academic group');       ok = false; }

    // Check roll uniqueness (skip own record when editing)
    const editId = $('editStudentId').value;
    if (roll && allStudents.some(s => s.roll === roll && s.id !== editId)) {
        setErr('err-roll', 'Roll number already exists — must be unique'); ok = false;
    }

    if (phone && !isBDPhone(phone))   { setErr('err-phone',       'Invalid BD phone (01XXXXXXXXX)');  ok = false; }
    if (nid && !isNID(nid))           { setErr('err-nid',         'NID must be 10 or 17 digits');     ok = false; }
    if (fNid  && !isNID(fNid))        { setErr('err-fatherNid',   'NID must be 10 or 17 digits');     ok = false; }
    if (fPhone && !isBDPhone(fPhone)) { setErr('err-fatherPhone', 'Invalid BD phone (01XXXXXXXXX)');  ok = false; }
    if (mNid  && !isNID(mNid))        { setErr('err-motherNid',   'NID must be 10 or 17 digits');     ok = false; }
    if (mPhone && !isBDPhone(mPhone)) { setErr('err-motherPhone', 'Invalid BD phone (01XXXXXXXXX)');  ok = false; }
    if (gPhone && !isBDPhone(gPhone)) { setErr('err-guardianPhone','Invalid BD phone (01XXXXXXXXX)'); ok = false; }

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
    const fn     = $('fname').value.trim().split(' ');

    const studentData = {
        name:         $('fname').value.trim(),
        initials:     ($('fname').value.trim().split(' ').map(w => w[0]).join('').slice(0,2)).toUpperCase(),
        roll:         $('roll').value.trim(),
        regno:        $('regno').value.trim(),
        year:         $('hscYear').value,
        group:        $('group').value,
        optionalSubject: $('optionalSubject').value || OPTIONAL_SUBJECTS[$('group').value]?.[0]?.value || '',
        section:      $('section').value || 'A',
        session:      $('session').value.trim() || '2024–2025',
        institution:  $('institution').value.trim(),

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

// Initial fetch from DB
fetchStudents();
