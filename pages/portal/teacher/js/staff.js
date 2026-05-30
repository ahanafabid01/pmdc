/**
 * staff.js — Teacher Portal: Staff Management
 * Shared localStorage store key with public teachers.php page
 * Phulpur Mohila Degree College
 */

'use strict';

/* ═══════════════════════════════════════════════════════════
   STORE
═══════════════════════════════════════════════════════════ */

const STORE_KEY = 'pmdc_staff';

function loadStore() {
    try {
        const raw = localStorage.getItem(STORE_KEY);
        if (raw) return JSON.parse(raw);
    } catch (_) {}
    return defaultStaff();
}

function saveStore(data) {
    localStorage.setItem(STORE_KEY, JSON.stringify(data));
}

function defaultStaff() {
    return [
        { id:'s-1',  name:'Dr. Halima Khatun',    designation:'Principal',             category:'teacher', isPrincipal:true,  subject:'Administration',       qualification:'PhD in Education (Dhaka University)',          email:'principal@pmdc.edu.bd', phone:'+880-1700-000010', photo:null },
        { id:'s-2',  name:'Ms. Afroza Begum',      designation:'Senior Lecturer',       category:'teacher', isPrincipal:false, subject:'Physics',               qualification:'M.Sc. Physics (Jahangirnagar University)',      email:'afroza@pmdc.edu.bd',    phone:'+880-1700-000011', photo:null },
        { id:'s-3',  name:'Mrs. Rashida Akter',    designation:'Lecturer',              category:'teacher', isPrincipal:false, subject:'Chemistry',             qualification:'M.Sc. Chemistry (Dhaka University)',            email:'rashida@pmdc.edu.bd',   phone:'+880-1700-000012', photo:null },
        { id:'s-4',  name:'Ms. Nasrin Sultana',    designation:'Lecturer',              category:'teacher', isPrincipal:false, subject:'Biology',               qualification:'M.Sc. Botany (Rajshahi University)',            email:'nasrin@pmdc.edu.bd',    phone:'+880-1700-000013', photo:null },
        { id:'s-5',  name:'Mrs. Fatema Begum',     designation:'Senior Lecturer',       category:'teacher', isPrincipal:false, subject:'Mathematics',           qualification:'M.Sc. Mathematics (Chittagong University)',     email:'fatema@pmdc.edu.bd',    phone:'+880-1700-000014', photo:null },
        { id:'s-6',  name:'Ms. Dilruba Islam',     designation:'Lecturer',              category:'teacher', isPrincipal:false, subject:'Accounting',            qualification:'M.Com. Accounting (National University)',        email:'dilruba@pmdc.edu.bd',   phone:'+880-1700-000015', photo:null },
        { id:'s-7',  name:'Mrs. Shaila Parvin',    designation:'Lecturer',              category:'teacher', isPrincipal:false, subject:'Economics',             qualification:'MA Economics (Dhaka University)',                email:'shaila@pmdc.edu.bd',    phone:'+880-1700-000016', photo:null },
        { id:'s-8',  name:'Ms. Roksana Begum',     designation:'Assistant Lecturer',    category:'teacher', isPrincipal:false, subject:'Civics',                qualification:'MA Political Science (Jahangirnagar University)',email:'roksana@pmdc.edu.bd',   phone:'+880-1700-000017', photo:null },
        { id:'s-9',  name:'Mrs. Morjina Khatun',   designation:'Lecturer',              category:'teacher', isPrincipal:false, subject:'Bangla',                qualification:'MA Bangla Literature (Dhaka University)',        email:'morjina@pmdc.edu.bd',   phone:'+880-1700-000018', photo:null },
        { id:'s-10', name:'Ms. Tania Akter',       designation:'Lecturer',              category:'teacher', isPrincipal:false, subject:'English',               qualification:'MA English (National University)',               email:'tania@pmdc.edu.bd',     phone:'+880-1700-000019', photo:null },
        { id:'s-11', name:'Mrs. Sonia Islam',      designation:'Assistant Lecturer',    category:'teacher', isPrincipal:false, subject:'ICT',                   qualification:'B.Sc. Computer Science (BUET)',                 email:'sonia@pmdc.edu.bd',     phone:'+880-1700-000020', photo:null },
        { id:'s-12', name:'Ms. Popy Begum',        designation:'Lecturer',              category:'teacher', isPrincipal:false, subject:'History',               qualification:'MA History (Rajshahi University)',               email:'popy@pmdc.edu.bd',      phone:'+880-1700-000021', photo:null },
        { id:'s-13', name:'Mr. Rafiqul Islam',     designation:'Office Superintendent', category:'admin',   isPrincipal:false, subject:'Administrative Office', qualification:'BBA (National University)',                      email:'rafiq@pmdc.edu.bd',     phone:'+880-1700-000030', photo:null },
        { id:'s-14', name:'Ms. Mitu Akter',        designation:'Accounts Officer',      category:'admin',   isPrincipal:false, subject:'Finance & Accounts',    qualification:'M.Com. (National University)',                   email:'mitu@pmdc.edu.bd',      phone:'+880-1700-000031', photo:null },
        { id:'s-15', name:'Mr. Karim Molla',       designation:'Office Assistant',      category:'admin',   isPrincipal:false, subject:'General Administration',qualification:'HSC (Board)',                                   email:'karim@pmdc.edu.bd',     phone:'+880-1700-000032', photo:null },
        { id:'s-16', name:'Ms. Asha Khatun',       designation:'Admission Officer',     category:'admin',   isPrincipal:false, subject:'Admissions Office',     qualification:'BA (National University)',                       email:'asha@pmdc.edu.bd',      phone:'+880-1700-000033', photo:null },
        { id:'s-17', name:'Mr. Jahangir Alam',     designation:'Library Assistant',     category:'support', isPrincipal:false, subject:'—',                     qualification:'—',                                             email:'—',                     phone:'+880-1700-000040', photo:null },
        { id:'s-18', name:'Ms. Rina Begum',        designation:'Lab Assistant',         category:'support', isPrincipal:false, subject:'—',                     qualification:'—',                                             email:'—',                     phone:'+880-1700-000041', photo:null },
        { id:'s-19', name:'Mr. Salam Sheikh',      designation:'Security Guard',        category:'support', isPrincipal:false, subject:'—',                     qualification:'—',                                             email:'—',                     phone:'+880-1700-000042', photo:null },
        { id:'s-20', name:'Ms. Mim Parvin',        designation:'Cleaning Staff',        category:'support', isPrincipal:false, subject:'—',                     qualification:'—',                                             email:'—',                     phone:'—',                photo:null },
    ];
}

/* ═══════════════════════════════════════════════════════════
   HELPERS
═══════════════════════════════════════════════════════════ */

function uid() {
    return 's-' + Date.now() + '-' + Math.random().toString(36).slice(2, 7);
}

function esc(s) {
    return String(s || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

const AVATAR_COLORS = [
    '#1a3a5c','#276749','#7b341e','#702459','#1a365d',
    '#0f4c75','#b5451b','#1b4332','#4a1942','#2c3e7a'
];

function initials(name) {
    return (name || '?').split(' ').slice(0,2).map(w => w[0] || '').join('').toUpperCase() || '?';
}
function avatarBg(name) {
    let h = 0;
    for (const c of (name || '')) h = ((h << 5) - h) + c.charCodeAt(0);
    return AVATAR_COLORS[Math.abs(h) % AVATAR_COLORS.length];
}
function photoOrInitials(member, size = 38, cls = 'tbl') {
    if (member.photo) {
        return `<img src="${member.photo}" alt="${esc(member.name)}" class="${cls}-photo">`;
    }
    return `<div class="${cls}-initials" style="background:${avatarBg(member.name)};">${initials(member.name)}</div>`;
}

function catPill(cat) {
    const map = { teacher:'cp-teacher', admin:'cp-admin', support:'cp-support' };
    const labels = { teacher:'Teacher', admin:'Admin', support:'Support' };
    return `<span class="cat-pill ${map[cat] || ''}">${labels[cat] || cat}</span>`;
}

function showToast(msg, icon = 'fas fa-check-circle') {
    const t = document.getElementById('toast');
    t.querySelector('i').className = icon;
    document.getElementById('toastMsg').textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2800);
}

/* ═══════════════════════════════════════════════════════════
   RENDER
═══════════════════════════════════════════════════════════ */

let staff = loadStore();
let pendingDeleteId = null;
let currentPhotoDataUrl = null;

function getFiltered() {
    const q   = (document.getElementById('smSearch').value || '').trim().toLowerCase();
    const cat = document.getElementById('smFilter').value;
    return staff.filter(s => {
        const matchQ = !q || s.name.toLowerCase().includes(q) || s.designation.toLowerCase().includes(q);
        const matchC = cat === 'all' || s.category === cat;
        return matchQ && matchC;
    });
}

function updateStats() {
    document.getElementById('stTotal').textContent    = staff.length;
    document.getElementById('stTeachers').textContent = staff.filter(s => s.category === 'teacher').length;
    document.getElementById('stAdmin').textContent    = staff.filter(s => s.category === 'admin').length;
    document.getElementById('stSupport').textContent  = staff.filter(s => s.category === 'support').length;
}

function renderTable() {
    updateStats();
    const list  = getFiltered();
    const tbody = document.getElementById('smTbody');
    const empty = document.getElementById('smEmpty');
    const table = document.getElementById('smTable');

    if (list.length === 0) {
        tbody.innerHTML = '';
        table.style.display = 'none';
        empty.style.display = 'flex';
        return;
    }
    table.style.display = '';
    empty.style.display = 'none';

    tbody.innerHTML = list.map(s => `
        <tr>
            <td>${photoOrInitials(s, 38, 'tbl')}</td>
            <td>
                <div class="tbl-name">${esc(s.name)}${s.isPrincipal ? `<span class="principal-badge"><i class="fas fa-star"></i> Principal</span>` : ''}</div>
            </td>
            <td style="color:var(--muted);font-size:.82rem;">${esc(s.designation)}</td>
            <td>${catPill(s.category)}</td>
            <td style="color:var(--muted);font-size:.82rem;">${esc(s.subject || '—')}</td>
            <td style="font-size:.8rem;">${s.email && s.email !== '—' ? `<a href="mailto:${esc(s.email)}" style="color:var(--blue);">${esc(s.email)}</a>` : '<span style="color:#cbd5e1;">—</span>'}</td>
            <td style="font-size:.8rem;white-space:nowrap;">${esc(s.phone || '—')}</td>
            <td>
                <div class="sm-action-btns">
                    <button class="sm-act-btn sab-edit" data-id="${esc(s.id)}" data-action="edit" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                    <button class="sm-act-btn sab-delete" data-id="${esc(s.id)}" data-action="delete" title="Delete"><i class="fas fa-trash-alt"></i></button>
                </div>
            </td>
        </tr>`).join('');
}

/* ═══════════════════════════════════════════════════════════
   MODAL — ADD / EDIT
═══════════════════════════════════════════════════════════ */

function openModal(id = null) {
    currentPhotoDataUrl = null;
    clearErrors();

    const overlay = document.getElementById('smModalOverlay');
    const title   = document.getElementById('smModalTitle');
    document.getElementById('smEditId').value = id || '';
    document.getElementById('smPhotoRemove').style.display = 'none';

    if (id) {
        const s = staff.find(x => x.id === id);
        title.innerHTML = '<i class="fas fa-pencil-alt"></i> Edit Staff Member';
        document.getElementById('smName').value        = s.name;
        document.getElementById('smDesig').value       = s.designation;
        document.getElementById('smCategory').value    = s.category;
        document.getElementById('smSubject').value     = s.subject || '';
        document.getElementById('smQual').value        = s.qualification || '';
        document.getElementById('smEmail').value       = s.email === '—' ? '' : (s.email || '');
        document.getElementById('smPhone').value       = s.phone === '—' ? '' : (s.phone || '');
        document.getElementById('smIsPrincipal').checked = !!s.isPrincipal;
        currentPhotoDataUrl = s.photo || null;
        updatePhotoPreview(s.photo, s.name);
        if (s.photo) document.getElementById('smPhotoRemove').style.display = '';
    } else {
        title.innerHTML = '<i class="fas fa-id-badge"></i> Add Staff Member';
        document.getElementById('smName').value        = '';
        document.getElementById('smDesig').value       = '';
        document.getElementById('smCategory').value    = '';
        document.getElementById('smSubject').value     = '';
        document.getElementById('smQual').value        = '';
        document.getElementById('smEmail').value       = '';
        document.getElementById('smPhone').value       = '';
        document.getElementById('smIsPrincipal').checked = false;
        updatePhotoPreview(null, '');
    }

    overlay.classList.add('open');
    document.getElementById('smName').focus();

    /* Live preview initials as name is typed */
    document.getElementById('smName').oninput = () => {
        if (!currentPhotoDataUrl) {
            updatePhotoPreview(null, document.getElementById('smName').value);
        }
    };
}

function closeModal() {
    document.getElementById('smModalOverlay').classList.remove('open');
    document.getElementById('smPhotoInput').value = '';
}

function updatePhotoPreview(photoDataUrl, name) {
    const preview = document.getElementById('smPhotoPreview');
    if (photoDataUrl) {
        preview.innerHTML = `<img src="${photoDataUrl}" alt="preview">`;
    } else {
        const ini = initials(name) || '?';
        const bg  = name ? avatarBg(name) : '#1a3a5c';
        preview.innerHTML = `<div class="spp-initials" id="sppInitials" style="background:${bg};">${ini}</div>`;
    }
}

function clearErrors() {
    ['errSmName','errSmDesig','errSmCat'].forEach(id => { document.getElementById(id).textContent = ''; });
}

function validateForm() {
    let ok = true;
    if (!document.getElementById('smName').value.trim())  { document.getElementById('errSmName').textContent  = 'Name is required.';        ok = false; }
    if (!document.getElementById('smDesig').value.trim()) { document.getElementById('errSmDesig').textContent = 'Designation is required.';  ok = false; }
    if (!document.getElementById('smCategory').value)     { document.getElementById('errSmCat').textContent   = 'Category is required.';     ok = false; }
    return ok;
}

function saveStaff() {
    clearErrors();
    if (!validateForm()) return;

    const btn = document.getElementById('smSaveBtn');
    btn.disabled = true;
    btn.querySelector('.btn-text').style.display = 'none';
    btn.querySelector('.btn-spin').style.display = '';

    setTimeout(() => {
        const id   = document.getElementById('smEditId').value;
        const name = document.getElementById('smName').value.trim();
        const cat  = document.getElementById('smCategory').value;

        /* If marking as principal, unmark any existing principal in same category */
        const isPrincipal = document.getElementById('smIsPrincipal').checked;
        if (isPrincipal) {
            staff.forEach(s => { if (s.category === cat && s.id !== id) s.isPrincipal = false; });
        }

        const emailVal = document.getElementById('smEmail').value.trim();
        const phoneVal = document.getElementById('smPhone').value.trim();

        const member = {
            id:           id || uid(),
            name,
            designation:  document.getElementById('smDesig').value.trim(),
            category:     cat,
            subject:      document.getElementById('smSubject').value.trim() || '—',
            qualification:document.getElementById('smQual').value.trim()    || '—',
            email:        emailVal || '—',
            phone:        phoneVal || '—',
            isPrincipal,
            photo:        currentPhotoDataUrl || null,
        };

        if (id) {
            const idx = staff.findIndex(s => s.id === id);
            if (idx !== -1) staff[idx] = member;
        } else {
            staff.unshift(member);
        }

        saveStore(staff);
        renderTable();
        closeModal();

        btn.disabled = false;
        btn.querySelector('.btn-text').style.display = '';
        btn.querySelector('.btn-spin').style.display = 'none';

        showToast(id ? `${name} updated successfully.` : `${name} added to staff list.`);
    }, 600);
}

/* ═══════════════════════════════════════════════════════════
   DELETE
═══════════════════════════════════════════════════════════ */

function openDelete(id) {
    pendingDeleteId = id;
    const s = staff.find(x => x.id === id);
    document.getElementById('deleteStaffName').textContent = s ? s.name : 'this staff member';
    document.getElementById('smDeleteOverlay').classList.add('open');
}
function closeDelete() {
    pendingDeleteId = null;
    document.getElementById('smDeleteOverlay').classList.remove('open');
}
function confirmDelete() {
    if (!pendingDeleteId) return;
    const s = staff.find(x => x.id === pendingDeleteId);
    staff = staff.filter(x => x.id !== pendingDeleteId);
    saveStore(staff);
    renderTable();
    closeDelete();
    showToast(`${s ? s.name : 'Staff member'} removed.`, 'fas fa-trash-alt');
}

/* ═══════════════════════════════════════════════════════════
   PHOTO HANDLING
═══════════════════════════════════════════════════════════ */

function handlePhotoFile(file) {
    if (!file) return;
    if (!file.type.startsWith('image/')) { showToast('Only image files are allowed.', 'fas fa-exclamation-circle'); return; }
    if (file.size > 2 * 1024 * 1024)    { showToast('Image must be under 2 MB.',      'fas fa-exclamation-circle'); return; }
    const reader = new FileReader();
    reader.onload = e => {
        currentPhotoDataUrl = e.target.result;
        updatePhotoPreview(currentPhotoDataUrl, document.getElementById('smName').value);
        document.getElementById('smPhotoRemove').style.display = '';
    };
    reader.readAsDataURL(file);
}

/* ═══════════════════════════════════════════════════════════
   EVENT LISTENERS
═══════════════════════════════════════════════════════════ */

document.addEventListener('DOMContentLoaded', () => {
    renderTable();

    /* Add Staff button */
    document.getElementById('btnAddStaff').addEventListener('click', () => openModal());

    /* Table delegated clicks */
    document.getElementById('smTbody').addEventListener('click', e => {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;
        const id     = btn.dataset.id;
        const action = btn.dataset.action;
        if (action === 'edit')   openModal(id);
        if (action === 'delete') openDelete(id);
    });

    /* Search & filter */
    document.getElementById('smSearch').addEventListener('input', renderTable);
    document.getElementById('smFilter').addEventListener('change', renderTable);

    /* Modal close */
    document.getElementById('smModalClose').addEventListener('click', closeModal);
    document.getElementById('smModalCancel').addEventListener('click', closeModal);
    document.getElementById('smModalOverlay').addEventListener('click', e => {
        if (e.target === document.getElementById('smModalOverlay')) closeModal();
    });

    /* Save */
    document.getElementById('smSaveBtn').addEventListener('click', saveStaff);

    /* Delete modal */
    document.getElementById('smDeleteClose').addEventListener('click', closeDelete);
    document.getElementById('smDeleteCancel').addEventListener('click', closeDelete);
    document.getElementById('smDeleteConfirm').addEventListener('click', confirmDelete);
    document.getElementById('smDeleteOverlay').addEventListener('click', e => {
        if (e.target === document.getElementById('smDeleteOverlay')) closeDelete();
    });

    /* Photo upload */
    document.getElementById('smPhotoInput').addEventListener('change', e => {
        if (e.target.files[0]) handlePhotoFile(e.target.files[0]);
    });
    document.getElementById('smPhotoRemove').addEventListener('click', () => {
        currentPhotoDataUrl = null;
        document.getElementById('smPhotoInput').value = '';
        document.getElementById('smPhotoRemove').style.display = 'none';
        updatePhotoPreview(null, document.getElementById('smName').value);
    });

    /* Escape key */
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') { closeModal(); closeDelete(); }
    });
});
