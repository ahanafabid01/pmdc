/* ═══════════════════════════════════════════════════════════
   PMDC Admin — Teacher & Staff Management
   teacher.js
   Shared localStorage key: 'pmdc_staff'
   Data format:
     { id, name, designation, category, isPrincipal,
       subject, qualification, email, phone, photo(base64|null) }
═══════════════════════════════════════════════════════════ */

const STORE_KEY = 'pmdc_staff';
const PER_PAGE  = 15;

const AVATAR_COLORS = [
    '#1a3a5c','#276749','#7b341e','#702459','#1a365d',
    '#0f4c75','#b5451b','#1b4332','#4a1942','#2c3e7a'
];

/* ── Default data (same as public page) ──────────────────── */
function defaultStaff() {
    return [
        { id:'s-1',  name:'Rowshan Ara Begum',        designation:'Principal',                       category:'teacher', isPrincipal:true,  subject:'Administration',  qualification:'N/A', email:'N/A', phone:'01712-227983', photo:null },
        { id:'s-2',  name:'Md. Hafizur Rahman',        designation:'Assistant Professor',             category:'teacher', isPrincipal:false, subject:'Bangla',           qualification:'N/A', email:'N/A', phone:'01725-659229', photo:null },
        { id:'s-3',  name:'Md. Khorshedul Rahman',     designation:'Assistant Professor',             category:'teacher', isPrincipal:false, subject:'Physics',          qualification:'N/A', email:'N/A', phone:'01716-490999', photo:null },
        { id:'s-4',  name:'Md. Ali Akbar',             designation:'Assistant Professor',             category:'teacher', isPrincipal:false, subject:'History',          qualification:'N/A', email:'N/A', phone:'01721-930034', photo:null },
        { id:'s-5',  name:'Md. Hosen Ali',             designation:'Assistant Professor',             category:'teacher', isPrincipal:false, subject:'Mathematics',      qualification:'N/A', email:'N/A', phone:'01716-909681', photo:null },
        { id:'s-6',  name:'Md. Aminul Haq',            designation:'Assistant Professor',             category:'teacher', isPrincipal:false, subject:'Accounting',       qualification:'N/A', email:'N/A', phone:'01995-489780', photo:null },
        { id:'s-7',  name:'Lily Bilkis Rana',          designation:'Assistant Professor',             category:'teacher', isPrincipal:false, subject:'Botany',           qualification:'N/A', email:'N/A', phone:'01918-988038', photo:null },
        { id:'s-8',  name:'Shaheen Ara Begum',         designation:'Assistant Professor',             category:'teacher', isPrincipal:false, subject:'Economics',        qualification:'N/A', email:'N/A', phone:'01552-881886', photo:null },
        { id:'s-9',  name:'Md. Makbul Hosen',          designation:'Assistant Professor',             category:'teacher', isPrincipal:false, subject:'Chemistry',        qualification:'N/A', email:'N/A', phone:'01916-980300', photo:null },
        { id:'s-10', name:'Md. Shafayet Jamil',        designation:'Assistant Professor',             category:'teacher', isPrincipal:false, subject:'Social Work',      qualification:'N/A', email:'N/A', phone:'01912-509919', photo:null },
        { id:'s-11', name:'Md. Enamul Haq',            designation:'Assistant Professor',             category:'teacher', isPrincipal:false, subject:'Islamic Studies',  qualification:'N/A', email:'N/A', phone:'01984-880389', photo:null },
        { id:'s-12', name:'Shah Humayun Kabir',        designation:'Assistant Professor',             category:'teacher', isPrincipal:false, subject:'ICT',              qualification:'N/A', email:'N/A', phone:'01505-210622', photo:null },
        { id:'s-13', name:'Mostak Ahmed',              designation:'Assistant Professor',             category:'teacher', isPrincipal:false, subject:'Bangla',           qualification:'N/A', email:'N/A', phone:'01918-156038', photo:null },
        { id:'s-14', name:'Mohammad Alamgir',          designation:'Assistant Professor',             category:'teacher', isPrincipal:false, subject:'Philosophy',       qualification:'N/A', email:'N/A', phone:'01914-603985', photo:null },
        { id:'s-15', name:'Md. Saiful Islam',          designation:'Assistant Professor',             category:'teacher', isPrincipal:false, subject:'English',          qualification:'N/A', email:'N/A', phone:'01912-182229', photo:null },
        { id:'s-16', name:'Nadira Sultana',            designation:'Lecturer',                        category:'teacher', isPrincipal:false, subject:'Political Science',qualification:'N/A', email:'N/A', phone:'01936-985311', photo:null },
        { id:'s-17', name:'Kamrun Nahar',              designation:'Lecturer',                        category:'teacher', isPrincipal:false, subject:'History',          qualification:'N/A', email:'N/A', phone:'01919-635600', photo:null },
        { id:'s-18', name:'Shipra Sarkar',             designation:'Lecturer',                        category:'teacher', isPrincipal:false, subject:'Economics',        qualification:'N/A', email:'N/A', phone:'01932-000682', photo:null },
        { id:'s-19', name:'Mostafija Rusti',           designation:'Lecturer',                        category:'teacher', isPrincipal:false, subject:'Political Science',qualification:'N/A', email:'N/A', phone:'01916-816189', photo:null },
        { id:'s-20', name:'Mohammad Golam Kibriya',    designation:'Lecturer',                        category:'teacher', isPrincipal:false, subject:'Islamic Studies',  qualification:'N/A', email:'N/A', phone:'01920-098539', photo:null },
        { id:'s-21', name:'Akhtari Jahan',             designation:'Lecturer',                        category:'teacher', isPrincipal:false, subject:'Philosophy',       qualification:'N/A', email:'N/A', phone:'01932-868958', photo:null },
        { id:'s-22', name:'Mahmuda Sultana',           designation:'Lecturer',                        category:'teacher', isPrincipal:false, subject:'Social Work',      qualification:'N/A', email:'N/A', phone:'01911-699130', photo:null },
        { id:'s-23', name:'Mohammad Habibur Rahman',   designation:'Lecturer',                        category:'teacher', isPrincipal:false, subject:'Botany',           qualification:'N/A', email:'N/A', phone:'01952-353819', photo:null },
        { id:'s-24', name:'Al Amin Ahmed',             designation:'Lecturer',                        category:'teacher', isPrincipal:false, subject:'Botany',           qualification:'N/A', email:'N/A', phone:'01916-898525', photo:null },
        { id:'s-25', name:'Md. Aminul Islam',          designation:'Lecturer',                        category:'teacher', isPrincipal:false, subject:'Chemistry',        qualification:'N/A', email:'N/A', phone:'01923-560909', photo:null },
        { id:'s-26', name:'Majedul Islam Akand',       designation:'Lecturer',                        category:'teacher', isPrincipal:false, subject:'Zoology',          qualification:'N/A', email:'N/A', phone:'01990-318920', photo:null },
        { id:'s-27', name:'Abu Saeed',                 designation:'Lecturer',                        category:'teacher', isPrincipal:false, subject:'Zoology',          qualification:'N/A', email:'N/A', phone:'01959-369992', photo:null },
        { id:'s-28', name:'Md. Mahabbat Hosen',        designation:'Lecturer',                        category:'teacher', isPrincipal:false, subject:'Chemistry',        qualification:'N/A', email:'N/A', phone:'01951-028509', photo:null },
        { id:'s-29', name:'Md. Mostafizur Rahman',     designation:'Lecturer',                        category:'teacher', isPrincipal:false, subject:'Management',       qualification:'N/A', email:'N/A', phone:'01989-222110', photo:null },
        { id:'s-30', name:'Md. Anowar Hosen',          designation:'Lecturer',                        category:'teacher', isPrincipal:false, subject:'Marketing',        qualification:'N/A', email:'N/A', phone:'01984-262101', photo:null },
        { id:'s-31', name:'Mirja Ahad Hosen',          designation:'Demonstrator',                    category:'teacher', isPrincipal:false, subject:'Biology',          qualification:'N/A', email:'N/A', phone:'01918-262898', photo:null },
        { id:'s-32', name:'Md. Abul Hosen',            designation:'Demonstrator',                    category:'teacher', isPrincipal:false, subject:'Physics',          qualification:'N/A', email:'N/A', phone:'01916-889388', photo:null },
        { id:'s-33', name:'Afsana Khanam',             designation:'Co-Librarian',                    category:'teacher', isPrincipal:false, subject:'—',               qualification:'N/A', email:'N/A', phone:'01626-010160', photo:null },
        { id:'s-34', name:'Md. Abdul Aziz',            designation:'Computer Operator Demonstrator',  category:'teacher', isPrincipal:false, subject:'—',               qualification:'N/A', email:'N/A', phone:'01919-336600', photo:null },
        { id:'s-35', name:'Jobeda Khanam',             designation:'Accounts Assistant',              category:'admin',   isPrincipal:false, subject:'Accounts',         qualification:'N/A', email:'N/A', phone:'01918-820956', photo:null },
        { id:'s-36', name:'Md. Suraj Ali',             designation:'Accounts Assistant',              category:'admin',   isPrincipal:false, subject:'Accounts',         qualification:'N/A', email:'N/A', phone:'01918-980986', photo:null },
        { id:'s-37', name:'Md. Shafiqul Islam',        designation:'Computer Operator',               category:'admin',   isPrincipal:false, subject:'Computer Ops',     qualification:'N/A', email:'N/A', phone:'01988-986561', photo:null },
        { id:'s-38', name:'Md. Shariyar Hosen',        designation:'Lab Assistant',                   category:'admin',   isPrincipal:false, subject:'Laboratory',       qualification:'N/A', email:'N/A', phone:'01686-802261', photo:null },
        { id:'s-39', name:'Mahfuja Aktar',             designation:'Lab Assistant',                   category:'admin',   isPrincipal:false, subject:'Laboratory',       qualification:'N/A', email:'N/A', phone:'01983-606018', photo:null },
        { id:'s-40', name:'Rakib-ul-Hasan',            designation:'Lab Assistant',                   category:'admin',   isPrincipal:false, subject:'Laboratory',       qualification:'N/A', email:'N/A', phone:'01926-921292', photo:null },
        { id:'s-41', name:'Shirifa Akhtar',            designation:'Lab Assistant',                   category:'admin',   isPrincipal:false, subject:'Laboratory',       qualification:'N/A', email:'N/A', phone:'01926-921292', photo:null },
        { id:'s-42', name:'Md. Emdadul Haq',           designation:'Lab Assistant',                   category:'admin',   isPrincipal:false, subject:'Laboratory',       qualification:'N/A', email:'N/A', phone:'N/A',          photo:null },
        { id:'s-43', name:'Md. Abdul Hai',             designation:'Peon',                            category:'support', isPrincipal:false, subject:'—',               qualification:'N/A', email:'N/A', phone:'01981-508632', photo:null },
        { id:'s-44', name:'Aferoj Aktar',              designation:'Ayah',                            category:'support', isPrincipal:false, subject:'—',               qualification:'N/A', email:'N/A', phone:'01933-886190', photo:null },
        { id:'s-45', name:'Mocha. Rokeya Khatun',      designation:'Office Assistant',                category:'admin',   isPrincipal:false, subject:'Office Work',      qualification:'N/A', email:'N/A', phone:'N/A',          photo:null },
        { id:'s-46', name:'Md. Abu Hanif',             designation:'Peon',                            category:'support', isPrincipal:false, subject:'—',               qualification:'N/A', email:'N/A', phone:'01912-820880', photo:null },
        { id:'s-47', name:'Md. Abdul Jabbar',          designation:'Night Guard',                     category:'support', isPrincipal:false, subject:'—',               qualification:'N/A', email:'N/A', phone:'N/A',          photo:null },
        { id:'s-48', name:'Rokeya Khatun',             designation:'Cleaner',                         category:'support', isPrincipal:false, subject:'—',               qualification:'N/A', email:'N/A', phone:'01988-589853', photo:null },
        { id:'s-49', name:'Josna Begum',               designation:'Peon',                            category:'support', isPrincipal:false, subject:'—',               qualification:'N/A', email:'N/A', phone:'01968-909892', photo:null },
        { id:'s-50', name:'Rejwana Yasmin',            designation:'Peon',                            category:'support', isPrincipal:false, subject:'—',               qualification:'N/A', email:'N/A', phone:'01938-628090', photo:null },
        { id:'s-51', name:'Shalma Aktar',              designation:'Peon',                            category:'support', isPrincipal:false, subject:'—',               qualification:'N/A', email:'N/A', phone:'01866-295568', photo:null },
        { id:'s-52', name:'Rupali Akter',              designation:'Peon',                            category:'support', isPrincipal:false, subject:'—',               qualification:'N/A', email:'N/A', phone:'01862-266291', photo:null },
    ];
}

/* ── API helpers ─────────────────────────────────── */
async function loadStaff() {
    try {
        const res = await fetch('api/staff.php?action=list');
        const data = await res.json();
        if (data.ok) {
            allStaff = data.staff;
            renderStats();
            applyFilter();
        } else {
            showToast('Failed to load staff', 'error');
        }
    } catch (e) {
        showToast('Network error loading staff', 'error');
    }
}

/* ── Helpers ─────────────────────────────────────────────── */
function initials(name) {
    return name.split(' ').slice(0, 2).map(w => w[0]).join('').toUpperCase();
}
function avatarColor(name) {
    let h = 0;
    for (let i = 0; i < name.length; i++) h = (h * 31 + name.charCodeAt(i)) & 0xffffffff;
    return AVATAR_COLORS[Math.abs(h) % AVATAR_COLORS.length];
}
function catLabel(cat) {
    return { teacher: 'Teacher', admin: 'Admin', support: 'Support' }[cat] || cat;
}
function catClass(cat) {
    return { teacher: 'cat-teacher', admin: 'cat-admin', support: 'cat-support' }[cat] || '';
}

/* ── State ───────────────────────────────────────────────── */
let allStaff      = [];
let filtered      = [];
let currentPage   = 1;
let currentCat    = 'all';
let currentSearch = '';
let editingId     = null;
let deleteId      = null;
let photoData     = null;   // base64

/* ── DOM refs ────────────────────────────────────────────── */
const tbody         = document.getElementById('staffTableBody');
const tmSearch      = document.getElementById('tmSearch');
const tmRowCount    = document.getElementById('tmRowCount');
const tmPagination  = document.getElementById('tmPagination');

/* Stats */
const statTotalVal   = document.getElementById('statTotalVal');
const statTeacherVal = document.getElementById('statTeacherVal');
const statAdminVal   = document.getElementById('statAdminVal');
const statSupportVal = document.getElementById('statSupportVal');

/* Modal */
const modalOverlay  = document.getElementById('tmModalOverlay');
const modalTitle    = document.getElementById('modalTitle');
const photoPreview  = document.getElementById('photoPreview');
const fId           = document.getElementById('fId');
const fName         = document.getElementById('fName');
const fDesignation  = document.getElementById('fDesignation');
const fCategory     = document.getElementById('fCategory');
const fSubject      = document.getElementById('fSubject');
const fQualification= document.getElementById('fQualification');
const fPhone        = document.getElementById('fPhone');
const fEmail        = document.getElementById('fEmail');
const fIsPrincipal  = document.getElementById('fIsPrincipal');
const fPhoto        = document.getElementById('fPhoto');

/* Delete modal */
const deleteOverlay    = document.getElementById('tmDeleteOverlay');
const deleteTargetName = document.getElementById('deleteTargetName');

/* Toast */
const toast = document.getElementById('tmToast');

/* ── Toast ───────────────────────────────────────────────── */
let toastTimer;
function showToast(msg, type = 'success') {
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-times-circle';
    toast.innerHTML = `<i class="fas ${icon}"></i> ${msg}`;
    toast.className = `tm-toast show ${type}`;
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove('show'), 3000);
}

/* ── Render stats ─────────────────────────────────────────── */
function renderStats() {
    const teachers = allStaff.filter(s => s.category === 'teacher').length;
    const admins   = allStaff.filter(s => s.category === 'admin').length;
    const support  = allStaff.filter(s => s.category === 'support').length;
    statTotalVal.textContent   = allStaff.length;
    statTeacherVal.textContent = teachers;
    statAdminVal.textContent   = admins;
    statSupportVal.textContent = support;
}

/* ── Filter & paginate ────────────────────────────────────── */
function applyFilter() {
    const q = currentSearch.toLowerCase();
    filtered = allStaff.filter(s => {
        const catOk = currentCat === 'all' || s.category === currentCat;
        const qOk   = !q || s.name.toLowerCase().includes(q)
                         || s.designation.toLowerCase().includes(q)
                         || (s.subject || '').toLowerCase().includes(q);
        return catOk && qOk;
    });
    currentPage = 1;
    renderTable();
}

/* ── Render table ─────────────────────────────────────────── */
function renderTable() {
    const total  = filtered.length;
    const pages  = Math.ceil(total / PER_PAGE) || 1;
    const start  = (currentPage - 1) * PER_PAGE;
    const slice  = filtered.slice(start, start + PER_PAGE);

    tmRowCount.textContent = `Showing ${slice.length} of ${total} staff member${total !== 1 ? 's' : ''}`;

    if (!slice.length) {
        tbody.innerHTML = `<tr class="tm-empty-row"><td colspan="7">
            <i class="fas fa-users-slash"></i>
            <p>No staff members found.</p>
        </td></tr>`;
        renderPagination(pages);
        return;
    }

    tbody.innerHTML = slice.map((s, i) => {
        const idx    = start + i + 1;
        const avatar = s.photo
            ? `<img src="../../../${s.photo}" alt="${s.name}" class="tm-staff-avatar">`
            : `<div class="tm-staff-avatar-initials" style="background:${avatarColor(s.name)}">${initials(s.name)}</div>`;

        const prinTag = s.isPrincipal
            ? `<span class="principal-star"><i class="fas fa-star"></i> Principal</span>`
            : '';

        return `<tr>
            <td style="color:var(--text-light);font-size:.75rem;font-weight:600;">${idx}</td>
            <td>
                <div class="tm-staff-cell">
                    ${avatar}
                    <div>
                        <div class="tm-staff-name">${escHtml(s.name)}${prinTag}</div>
                        <div class="tm-staff-qual">${escHtml(s.qualification || '—')}</div>
                    </div>
                </div>
            </td>
            <td>${escHtml(s.designation)}</td>
            <td><span class="cat-badge ${catClass(s.category)}">${catLabel(s.category)}</span></td>
            <td>${escHtml(s.subject || '—')}</td>
            <td style="font-family:'Inter',sans-serif;font-size:.82rem;">${escHtml(s.phone || '—')}</td>
            <td>
                <div class="tm-row-actions">
                    <button class="btn-edit" onclick="openEdit('${s.id}')" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn-del"  onclick="openDelete('${s.id}')" title="Delete"><i class="fas fa-trash-alt"></i></button>
                </div>
            </td>
        </tr>`;
    }).join('');

    renderPagination(pages);
}

function renderPagination(pages) {
    if (pages <= 1) { tmPagination.innerHTML = ''; return; }
    let html = '';
    if (currentPage > 1)   html += `<button class="tm-page-btn" onclick="goPage(${currentPage - 1})"><i class="fas fa-chevron-left"></i></button>`;
    for (let p = 1; p <= pages; p++) {
        if (p === 1 || p === pages || Math.abs(p - currentPage) <= 1) {
            html += `<button class="tm-page-btn ${p === currentPage ? 'active' : ''}" onclick="goPage(${p})">${p}</button>`;
        } else if (Math.abs(p - currentPage) === 2) {
            html += `<button class="tm-page-btn" disabled style="cursor:default;opacity:.4;">…</button>`;
        }
    }
    if (currentPage < pages) html += `<button class="tm-page-btn" onclick="goPage(${currentPage + 1})"><i class="fas fa-chevron-right"></i></button>`;
    tmPagination.innerHTML = html;
}

function goPage(p) {
    currentPage = p;
    renderTable();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function escHtml(str) {
    const d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
}

/* ── Modal: open Add ──────────────────────────────────────── */
function openAdd() {
    editingId = null;
    photoData = null;
    clearForm();
    modalTitle.innerHTML = '<i class="fas fa-user-plus"></i> Add Staff Member';
    modalOverlay.classList.add('active');
    document.body.style.overflow = 'hidden';
    fName.focus();
}

/* ── Modal: open Edit ─────────────────────────────────────── */
function openEdit(id) {
    const s = allStaff.find(x => x.id === id);
    if (!s) return;
    editingId = id;
    photoData = s.photo || null;

    fId.value           = s.id;
    fName.value         = s.name;
    fDesignation.value  = s.designation;
    fCategory.value     = s.category;
    fSubject.value      = s.subject || '';
    fQualification.value= s.qualification || '';
    fPhone.value        = s.phone || '';
    fEmail.value        = s.email || '';
    fIsPrincipal.checked= !!s.isPrincipal;

    photoPreview.innerHTML = s.photo
        ? `<img src="../../../${s.photo}" alt="Photo" style="width:100%;height:100%;object-fit:cover;border-radius:12px;">`
        : `<i class="fas fa-user"></i>`;

    modalTitle.innerHTML = '<i class="fas fa-pencil-alt"></i> Edit Staff Member';
    modalOverlay.classList.add('active');
    document.body.style.overflow = 'hidden';
    fName.focus();
}

function clearForm() {
    [fId, fName, fDesignation, fSubject, fQualification, fPhone, fEmail].forEach(el => el.value = '');
    fCategory.value = '';
    fIsPrincipal.checked = false;
    photoPreview.innerHTML = '<i class="fas fa-user"></i>';
    [fName, fDesignation, fCategory].forEach(el => el.classList.remove('error'));
}

function closeModal() {
    modalOverlay.classList.remove('active');
    document.body.style.overflow = '';
}

/* ── Save ─────────────────────────────────────────────────── */
async function saveStaffMember() {
    // Validate
    let valid = true;
    [fName, fDesignation, fCategory].forEach(el => {
        el.classList.remove('error');
        if (!el.value.trim()) { el.classList.add('error'); valid = false; }
    });
    if (!valid) { showToast('Please fill in all required fields.', 'error'); return; }

    const formData = new FormData();
    if (editingId) formData.append('id', editingId);
    formData.append('name', fName.value.trim());
    formData.append('designation', fDesignation.value.trim());
    formData.append('category', fCategory.value);
    formData.append('isPrincipal', fIsPrincipal.checked);
    formData.append('subject', fSubject.value.trim());
    formData.append('qualification', fQualification.value.trim());
    formData.append('email', fEmail.value.trim());
    formData.append('phone', fPhone.value.trim());
    
    if (fPhoto.files[0]) {
        formData.append('photo', fPhoto.files[0]);
    }

    try {
        const btn = document.getElementById('btnSave');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        btn.disabled = true;

        const res = await fetch('api/staff.php?action=save', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();
        
        btn.innerHTML = originalText;
        btn.disabled = false;

        if (data.ok) {
            showToast(editingId ? 'Staff member updated successfully.' : 'Staff member added successfully.');
            closeModal();
            loadStaff();
        } else {
            showToast(data.msg || 'Failed to save staff member', 'error');
        }
    } catch (e) {
        showToast('Network error', 'error');
        document.getElementById('btnSave').disabled = false;
    }
}

/* ── Delete ───────────────────────────────────────────────── */
function openDelete(id) {
    const s = allStaff.find(x => x.id === id);
    if (!s) return;
    deleteId = id;
    deleteTargetName.textContent = s.name;
    deleteOverlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeDelete() {
    deleteOverlay.classList.remove('active');
    document.body.style.overflow = '';
    deleteId = null;
}
async function confirmDelete() {
    const s = allStaff.find(x => x.id === deleteId);
    try {
        const res = await fetch('api/staff.php?action=delete', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${deleteId}`
        });
        const data = await res.json();
        if (data.ok) {
            showToast(`${s?.name || 'Staff member'} deleted.`, 'error');
            closeDelete();
            loadStaff();
        } else {
            showToast(data.msg || 'Failed to delete staff member', 'error');
        }
    } catch(e) {
        showToast('Network error', 'error');
    }
}

/* ── Export CSV ───────────────────────────────────────────── */
function exportCSV() {
    const headers = ['ID','Name','Designation','Category','Subject','Qualification','Phone','Email','Principal'];
    const rows = allStaff.map(s => [
        s.id, s.name, s.designation, s.category,
        s.subject, s.qualification, s.phone, s.email,
        s.isPrincipal ? 'Yes' : 'No'
    ].map(v => `"${String(v).replace(/"/g, '""')}"`));

    const csv = [headers.join(','), ...rows.map(r => r.join(','))].join('\n');
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const a    = document.createElement('a');
    a.href     = URL.createObjectURL(blob);
    a.download = 'pmdc_staff.csv';
    a.click();
    URL.revokeObjectURL(a.href);
    showToast('CSV exported successfully.');
}

/* ── Photo upload ─────────────────────────────────────────── */
fPhoto.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    if (file.size > 2 * 1024 * 1024) { showToast('Photo must be under 2MB.', 'error'); return; }
    const reader = new FileReader();
    reader.onload = e => {
        photoData = e.target.result;
        photoPreview.innerHTML = `<img src="${photoData}" alt="Preview" style="width:100%;height:100%;object-fit:cover;border-radius:12px;">`;
    };
    reader.readAsDataURL(file);
});

document.getElementById('btnClearPhoto').addEventListener('click', () => {
    photoData = null;
    fPhoto.value = '';
    photoPreview.innerHTML = '<i class="fas fa-user"></i>';
});

/* ── Event bindings ───────────────────────────────────────── */
document.getElementById('btnAddStaff').addEventListener('click', openAdd);
document.getElementById('btnSave').addEventListener('click', saveStaffMember);
document.getElementById('btnCancel').addEventListener('click', closeModal);
document.getElementById('tmModalClose').addEventListener('click', closeModal);
document.getElementById('btnExport').addEventListener('click', exportCSV);
document.getElementById('btnDeleteConfirm').addEventListener('click', confirmDelete);
document.getElementById('btnDeleteCancel').addEventListener('click', closeDelete);
document.getElementById('tmDeleteClose').addEventListener('click', closeDelete);

// Close modal on overlay click
modalOverlay.addEventListener('click', e => { if (e.target === modalOverlay) closeModal(); });
deleteOverlay.addEventListener('click', e => { if (e.target === deleteOverlay) closeDelete(); });

// Escape key
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeModal(); closeDelete(); }
});

// Search
tmSearch.addEventListener('input', e => {
    currentSearch = e.target.value;
    applyFilter();
});

// Filter tabs
document.querySelectorAll('.tm-tab').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.tm-tab').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        currentCat = this.dataset.cat;
        applyFilter();
    });
});

/* ── Init ─────────────────────────────────────────────────── */
(function init() {
    loadStaff();
})();
