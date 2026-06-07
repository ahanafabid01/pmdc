/**
 * registration-admin.js
 * Admin portal — Registration management (HSC + Degree).
 * Reads FORM_TYPE from <body data-reg-type="hsc|degree">
 */

'use strict';

const REG_TYPE = document.body.dataset.regType || 'hsc';

const API_SETTINGS = window.BASE_URL + `/pages/portal/admin/api/registration-settings.php`;
const API_SUBMIT   = 'api/registration-submit.php';

const ITEMS_PER_PAGE = 10;

/* ════════════════════════════════════════════════════════════
   STATE
   ════════════════════════════════════════════════════════════ */
let allApplications  = [];   // full dataset
let filteredApps     = [];   // after filter/search
let currentPage      = 1;
let settings         = {};
let viewingApp       = null; // application in detail modal
let pendingRejectId  = null;

/* ════════════════════════════════════════════════════════════
   DEMO DATA (shown when API/DB not available)
   ════════════════════════════════════════════════════════════ */
function demoData() {
    const type = REG_TYPE;
    const prefix = type === 'hsc' ? 'HSC' : 'DEG';
    const session = '2025–2026';
    const statuses = ['pending','pending','approved','rejected','pending'];
    const methods  = ['bKash','Nagad','bKash','Rocket','Nagad'];
    const groups   = type === 'hsc'
        ? ['Science','Humanities','Business Studies','Science','Humanities']
        : ['BA','BSS','BSc','BMT','BA'];

    return Array.from({ length: 5 }, (_, i) => ({
        ref_number:    `PMDC-${prefix}-2025-0000${i + 1}`,
        session,
        program_type:  type,
        status:        statuses[i],
        payment_method: methods[i],
        transaction_id: `TXN${Math.random().toString(36).slice(2,10).toUpperCase()}`,
        amount_paid:   200,
        payment_date:  '2025-06-01',
        submitted_at:  `2025-06-0${i + 1} 10:${10 + i}:00`,
        photo_path:    null,
        certificate_path: null,
        birth_cert_path:  null,
        rejection_reason: statuses[i] === 'rejected' ? 'Incomplete documents submitted.' : '',
        admin_note: '',
        personal_data: {
            full_name_en: ['Fatema Khatun','Sonia Akter','Riya Begum','Nasrin Sultana','Mim Akter'][i],
            full_name_bn: ['ফাতেমা খাতুন','সোনিয়া আক্তার','রিয়া বেগম','নাসরিন সুলতানা','মিম আক্তার'][i],
            dob:          '2007-0' + (i+1) + '-15',
            religion:     'Islam',
            father_name:  'Mohammad Abul Hossain',
            mother_name:  'Fatema Begum',
            guardian_phone: '0171234567' + i,
            present_address: 'Phulpur, Mymensingh',
        },
        academic_data: type === 'hsc'
            ? { ssc_roll: `10000${i}`, ssc_board: 'Mymensingh', ssc_year: '2025', ssc_gpa: (3.5 + i * 0.3).toFixed(2), ssc_group: groups[i], desired_group: groups[i] }
            : { hsc_roll: `20000${i}`, hsc_board: 'Mymensingh', hsc_year: '2025', hsc_gpa: (3.5 + i * 0.3).toFixed(2), hsc_group: 'Science', desired_program: groups[i] },
    }));
}

/* ════════════════════════════════════════════════════════════
   LOAD SETTINGS
   ════════════════════════════════════════════════════════════ */
async function loadSettings() {
    try {
        const res  = await fetch(API_SETTINGS);
        const data = await res.json();
        settings = data[REG_TYPE] || {};
    } catch (_) {
        settings = { status: 'closed', session: '2025–2026', fee: 200, bkash: '', nagad: '', rocket: '' };
    }
    applySettings();
}

function applySettings() {
    const toggle   = document.getElementById('statusToggle');
    const toggleLbl= document.getElementById('toggleLbl');
    const session  = document.getElementById('settingsSession');
    const fee      = document.getElementById('settingsFee');
    const openDate = document.getElementById('settingsOpenDate');
    const closeDate= document.getElementById('settingsCloseDate');
    const bkash    = document.getElementById('settingsBkash');
    const nagad    = document.getElementById('settingsNagad');
    const rocket   = document.getElementById('settingsRocket');

    const isOpen = (settings.status || 'closed') === 'open';
    if (toggle) toggle.checked = isOpen;
    if (toggleLbl) {
        toggleLbl.textContent = isOpen ? 'OPEN' : 'CLOSED';
        toggleLbl.className   = 'ra-toggle-lbl ' + (isOpen ? 'open' : 'closed');
    }
    if (session) session.value = settings.session || '';
    if (fee)     fee.value     = settings.fee     || 200;
    if (openDate) openDate.value = settings.open_date || '';
    if (closeDate) closeDate.value= settings.close_date || '';
    if (bkash)   bkash.value   = settings.bkash   || '';
    if (nagad)   nagad.value   = settings.nagad   || '';
    if (rocket)  rocket.value  = settings.rocket  || '';
}

async function saveSettings() {
    const payload = {
        [REG_TYPE]: {
            status:     document.getElementById('statusToggle')?.checked ? 'open' : 'closed',
            session:    document.getElementById('settingsSession')?.value.trim(),
            fee:        parseFloat(document.getElementById('settingsFee')?.value || 200),
            open_date:  document.getElementById('settingsOpenDate')?.value || '',
            close_date: document.getElementById('settingsCloseDate')?.value || '',
            bkash:      document.getElementById('settingsBkash')?.value.trim(),
            nagad:      document.getElementById('settingsNagad')?.value.trim(),
            rocket:     document.getElementById('settingsRocket')?.value.trim(),
        }
    };

    const saveBtn = document.getElementById('btnSaveSettings');
    if (saveBtn) { saveBtn.disabled = true; saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving…'; }

    try {
        const res  = await fetch(API_SETTINGS, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
        const data = await res.json();
        showToast(data.success ? 'Settings saved successfully!' : (data.message || 'Error saving settings.'), data.success ? 'success' : 'error');
        if (data.success) { settings = payload[REG_TYPE]; applySettings(); }
    } catch (_) {
        showToast('Could not reach the server. Settings not saved.', 'error');
    } finally {
        if (saveBtn) { saveBtn.disabled = false; saveBtn.innerHTML = '<i class="fas fa-save"></i> Save Settings'; }
    }
}

/* ════════════════════════════════════════════════════════════
   LOAD APPLICATIONS
   ════════════════════════════════════════════════════════════ */
async function loadApplications() {
    try {
        const session = settings.session || '';
        const res     = await fetch(window.BASE_URL + `/pages/portal/admin/api/registration-admin.php?type=${REG_TYPE}&session=${encodeURIComponent(session)}`);
        if (!res.ok) throw new Error('API unavailable');
        const data    = await res.json();
        allApplications = data.applications || [];
    } catch (_) {
        allApplications = demoData();
    }
    applyFilters();
    updateStats();
}

/* ════════════════════════════════════════════════════════════
   FILTERS
   ════════════════════════════════════════════════════════════ */
function applyFilters() {
    const q      = (document.getElementById('searchInput')?.value || '').toLowerCase().trim();
    const status = document.getElementById('filterStatus')?.value || 'all';
    const group  = document.getElementById('filterGroup')?.value  || 'all';
    const pm     = document.getElementById('filterPayment')?.value || 'all';

    filteredApps = allApplications.filter(app => {
        const name   = (app.personal_data?.full_name_en || '').toLowerCase();
        const ref    = (app.ref_number || '').toLowerCase();
        const txn    = (app.transaction_id || '').toLowerCase();
        const matchQ = !q || name.includes(q) || ref.includes(q) || txn.includes(q);
        const matchS = status === 'all' || app.status === status;
        const grp    = REG_TYPE === 'hsc' ? app.academic_data?.desired_group : app.academic_data?.desired_program;
        const matchG = group === 'all' || grp === group;
        const matchP = pm === 'all'  || app.payment_method === pm;
        return matchQ && matchS && matchG && matchP;
    });

    currentPage = 1;
    renderTable();
}

/* ════════════════════════════════════════════════════════════
   RENDER TABLE
   ════════════════════════════════════════════════════════════ */
function renderTable() {
    const tbody  = document.getElementById('appTbody');
    const empty  = document.getElementById('appEmpty');
    const table  = document.getElementById('appTable');
    const pag    = document.getElementById('appPagination');

    if (filteredApps.length === 0) {
        if (table) table.style.display = 'none';
        if (empty) empty.style.display = 'flex';
        if (pag)   pag.style.display   = 'none';
        return;
    }

    if (table) table.style.display = '';
    if (empty) empty.style.display = 'none';
    if (pag)   pag.style.display   = '';

    const start = (currentPage - 1) * ITEMS_PER_PAGE;
    const page  = filteredApps.slice(start, start + ITEMS_PER_PAGE);

    const groupField = REG_TYPE === 'hsc' ? 'desired_group' : 'desired_program';

    tbody.innerHTML = page.map(app => {
        const name   = esc(app.personal_data?.full_name_en || '—');
        const group  = esc(app.academic_data?.[groupField]  || '—');
        const gpa    = esc((REG_TYPE === 'hsc' ? app.academic_data?.ssc_gpa : app.academic_data?.hsc_gpa) || '—');
        const date   = formatDate(app.submitted_at);
        const status = app.status || 'pending';

        return `<tr>
            <td style="font-size:.78rem;color:#94a3b8;">${esc(app.ref_number)}</td>
            <td><div style="font-weight:700;font-size:.875rem;color:var(--text);">${name}</div></td>
            <td><span style="font-size:.82rem;font-weight:600;color:var(--muted);">${group}</span></td>
            <td style="text-align:center;font-weight:700;font-size:.85rem;">${gpa}</td>
            <td><span style="font-size:.8rem;">${esc(app.payment_method || '—')}</span></td>
            <td><code style="font-size:.76rem;color:var(--muted);">${esc(app.transaction_id || '—')}</code></td>
            <td style="font-size:.78rem;color:var(--muted);white-space:nowrap;">${date}</td>
            <td><span class="ra-badge ${status}">
                <i class="fas fa-${status === 'approved' ? 'check' : status === 'rejected' ? 'times' : 'clock'}"></i>
                ${ucfirst(status)}
            </span></td>
            <td>
                <div class="ra-action-btns">
                    <button class="ra-btn ra-btn-view"    data-id="${esc(app.ref_number)}" data-action="view"    title="View"><i class="fas fa-eye"></i></button>
                    <button class="ra-btn ra-btn-approve" data-id="${esc(app.ref_number)}" data-action="approve" title="Approve"><i class="fas fa-check"></i></button>
                    <button class="ra-btn ra-btn-reject"  data-id="${esc(app.ref_number)}" data-action="reject"  title="Reject"><i class="fas fa-times"></i></button>
                </div>
            </td>
        </tr>`;
    }).join('');

    renderPagination();
}

function renderPagination() {
    const total = Math.ceil(filteredApps.length / ITEMS_PER_PAGE);
    const info  = document.getElementById('pagInfo');
    const btns  = document.getElementById('pagBtns');
    if (!info || !btns) return;

    const start = (currentPage - 1) * ITEMS_PER_PAGE + 1;
    const end   = Math.min(currentPage * ITEMS_PER_PAGE, filteredApps.length);
    info.textContent = `Showing ${start}–${end} of ${filteredApps.length}`;

    let html = `<button class="ra-page-btn" data-page="prev" ${currentPage === 1 ? 'disabled' : ''}><i class="fas fa-chevron-left"></i></button>`;
    for (let p = 1; p <= total; p++) {
        if (total > 7 && Math.abs(p - currentPage) > 2 && p !== 1 && p !== total) {
            if (p === currentPage - 3 || p === currentPage + 3) html += `<span style="padding:0 4px;color:var(--muted);">…</span>`;
            continue;
        }
        html += `<button class="ra-page-btn${p === currentPage ? ' active' : ''}" data-page="${p}">${p}</button>`;
    }
    html += `<button class="ra-page-btn" data-page="next" ${currentPage === total ? 'disabled' : ''}><i class="fas fa-chevron-right"></i></button>`;
    btns.innerHTML = html;
}

/* ════════════════════════════════════════════════════════════
   STATS
   ════════════════════════════════════════════════════════════ */
function updateStats() {
    const total    = allApplications.length;
    const pending  = allApplications.filter(a => a.status === 'pending').length;
    const approved = allApplications.filter(a => a.status === 'approved').length;
    const rejected = allApplications.filter(a => a.status === 'rejected').length;
    document.getElementById('statTotal')?.   textContent != null && (document.getElementById('statTotal').textContent    = total);
    document.getElementById('statPending')?.  textContent != null && (document.getElementById('statPending').textContent  = pending);
    document.getElementById('statApproved')?.textContent != null && (document.getElementById('statApproved').textContent = approved);
    document.getElementById('statRejected')?.textContent != null && (document.getElementById('statRejected').textContent = rejected);
    setStatText('statTotal',    total);
    setStatText('statPending',  pending);
    setStatText('statApproved', approved);
    setStatText('statRejected', rejected);
}

function setStatText(id, val) {
    const el = document.getElementById(id);
    if (el) el.textContent = val;
}

/* ════════════════════════════════════════════════════════════
   DETAIL MODAL
   ════════════════════════════════════════════════════════════ */
function openDetail(refNum) {
    viewingApp = allApplications.find(a => a.ref_number === refNum) || null;
    if (!viewingApp) return;

    const app = viewingApp;
    const pd  = app.personal_data || {};
    const ad  = app.academic_data  || {};

    // Populate header
    document.getElementById('detailRef').textContent = app.ref_number;
    const badge = document.getElementById('detailStatus');
    badge.className = `ra-badge ${app.status}`;
    badge.innerHTML = `<i class="fas fa-${app.status === 'approved' ? 'check' : app.status === 'rejected' ? 'times' : 'clock'}"></i> ${ucfirst(app.status)}`;
    document.getElementById('detailDate').textContent = formatDate(app.submitted_at);

    // Personal info
    setDetailField('dName',    pd.full_name_en);
    setDetailField('dNameBn',  pd.full_name_bn);
    setDetailField('dDob',     pd.dob);
    setDetailField('dReligion', pd.religion);
    setDetailField('dBlood',   pd.blood_group);
    setDetailField('dNid',     pd.nid_number || '—');
    setDetailField('dBirth',   pd.birth_cert_num || '—');
    setDetailField('dFather',  pd.father_name);
    setDetailField('dMother',  pd.mother_name);
    setDetailField('dPhone',   pd.guardian_phone);
    setDetailField('dStudentPhone', pd.student_phone || '—');
    setDetailField('dEmail',   pd.email || '—');
    setDetailField('dFatherNid', pd.father_nid || '—');
    setDetailField('dFatherOcc', pd.father_occupation || '—');
    setDetailField('dMotherNid', pd.mother_nid || '—');
    setDetailField('dMotherOcc', pd.mother_occupation || '—');
    setDetailField('dPresentAddress', pd.present_address || '—');
    setDetailField('dPermanentAddress', pd.permanent_address || '—');

    // Academic info
    if (REG_TYPE === 'hsc') {
        setDetailField('dAcadRoll',  ad.ssc_roll);
        setDetailField('dAcadReg',   ad.ssc_reg);
        setDetailField('dAcadBoard', ad.ssc_board);
        setDetailField('dAcadYear',  ad.ssc_year);
        setDetailField('dAcadGPA',   ad.ssc_gpa);
        setDetailField('dAcadPrevGroup', ad.ssc_group);
        setDetailField('dAcadDesiredGroup', ad.desired_group);
        
        let optText = '—';
        if (ad.optional_subjects && Array.isArray(ad.optional_subjects)) {
            optText = ad.optional_subjects.join(', ');
        }
        setDetailField('dAcadOptSubjects', optText);
        setDetailField('dAcadFourthSubject', ad.fourth_subject || '—');
        
        setDetailField('dAcadInst',  ad.prev_institution);
    } else {
        setDetailField('dAcadRoll',  ad.hsc_roll);
        setDetailField('dAcadReg',   ad.hsc_reg);
        setDetailField('dAcadBoard', ad.hsc_board);
        setDetailField('dAcadYear',  ad.hsc_year);
        setDetailField('dAcadGPA',   ad.hsc_gpa);
        setDetailField('dAcadPrevGroup', ad.hsc_group);
        setDetailField('dAcadDesiredGroup', ad.desired_program);
        setDetailField('dAcadInst',  ad.prev_institution);
    }

    // Payment
    setDetailField('dPayMethod', app.payment_method);
    setDetailField('dPayTxn',    app.transaction_id);
    setDetailField('dPayAmount', '৳' + app.amount_paid);
    setDetailField('dPayDate',   app.payment_date);

    // Documents
    renderDocThumb('docPhoto', app.photo_path,       'photo');
    renderDocThumb('docCert',  app.certificate_path, 'certificate');
    renderDocThumb('docBirth', app.birth_cert_path,  'birth cert');

    // Admin note
    const noteTA = document.getElementById('adminNoteTA');
    if (noteTA) noteTA.value = app.admin_note || '';

    // Reject reason
    const rejectDiv = document.getElementById('rejectionReasonWrap');
    if (rejectDiv) {
        if (app.status === 'rejected' && app.rejection_reason) {
            rejectDiv.style.display = '';
            setDetailField('rejectionReasonText', app.rejection_reason);
        } else {
            rejectDiv.style.display = 'none';
        }
    }

    // Show/hide approve+reject buttons based on status
    const approveBtn = document.getElementById('detailApproveBtn');
    const rejectBtn  = document.getElementById('detailRejectBtn');
    if (approveBtn) approveBtn.style.display = app.status !== 'approved' ? '' : 'none';
    if (rejectBtn)  rejectBtn.style.display  = app.status !== 'rejected' ? '' : 'none';

    document.getElementById('detailOverlay').classList.add('active');
}

function setDetailField(id, val) {
    const el = document.getElementById(id);
    if (el) el.textContent = val || '—';
}

function renderDocThumb(id, path, label) {
    const wrap = document.getElementById(id);
    if (!wrap) return;
    if (path) {
        const isImg = /\.(jpg|jpeg|png)$/i.test(path);
        // Path is relative to pages/portal/admin, so 3 levels up: ../../../ + path (e.g. uploads/...)
        wrap.innerHTML = isImg
            ? `<img class="ra-doc-img" src="../../../${path}" alt="${label}" onclick="window.open(this.src,'_blank')" style="object-fit:cover;width:100%;height:120px;border-radius:10px;border:1px solid #cbd5e1;cursor:pointer;">`
            : `<div class="ra-doc-none" title="Click to view PDF" style="cursor:pointer;flex-direction:column;background:#fff1f2;border-color:#fecdd3;" onclick="window.open('../../../${path}','_blank')">
                 <i class="fas fa-file-pdf" style="color:#e11d48;font-size:2.5rem;margin-bottom:8px;"></i>
                 <div style="font-size:.75rem;font-weight:700;color:#e11d48;">VIEW PDF</div>
               </div>`;
    } else {
        wrap.innerHTML = `<div class="ra-doc-none" style="flex-direction:column;"><i class="fas fa-image" style="color:#cbd5e1;font-size:2rem;margin-bottom:8px;"></i><div style="font-size:.7rem;color:#94a3b8;">Not uploaded</div></div>`;
    }
}

function closeDetail() {
    document.getElementById('detailOverlay').classList.remove('active');
    viewingApp = null;
}

/* ════════════════════════════════════════════════════════════
   STATUS CHANGES
   ════════════════════════════════════════════════════════════ */
async function changeStatus(refNum, status, reason = '') {
    try {
        const res  = await fetch(window.BASE_URL + `/pages/portal/admin/api/registration-admin.php`, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify({ ref_number: refNum, status, rejection_reason: reason }),
        });
        const data = await res.json();
        if (data.success) {
            const app = allApplications.find(a => a.ref_number === refNum);
            if (app) { app.status = status; app.rejection_reason = reason; }
            showToast(`Application ${status}.`, status === 'approved' ? 'success' : 'error');
        }
    } catch (_) {
        // Demo: update locally
        const app = allApplications.find(a => a.ref_number === refNum);
        if (app) { app.status = status; app.rejection_reason = reason; }
        showToast(`Application marked as ${status}. (Demo mode)`, 'success');
    }

    applyFilters();
    updateStats();
    if (viewingApp?.ref_number === refNum) {
        closeDetail();
    }
}

function approveApp(refNum) {
    Swal.fire({
        title: 'Approve Application?',
        text: `Are you sure you want to approve application ${refNum}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#64748b',
        confirmButtonText: '<i class="fas fa-check"></i> Yes, Approve',
        showLoaderOnConfirm: true,
        preConfirm: async () => {
            await changeStatus(refNum, 'approved');
        },
        allowOutsideClick: () => !Swal.isLoading()
    });
}

function openRejectModal(refNum) {
    Swal.fire({
        title: 'Reject Application',
        text: 'Please provide a reason for rejection (optional):',
        input: 'textarea',
        inputPlaceholder: 'e.g. Incomplete documents, unclear photo...',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: '<i class="fas fa-times"></i> Reject',
        showLoaderOnConfirm: true,
        preConfirm: async (reason) => {
            await changeStatus(refNum, 'rejected', reason);
        },
        allowOutsideClick: () => !Swal.isLoading()
    });
}

function closeRejectModal() {
    // No longer needed with SweetAlert2
}

function confirmReject() {
    // No longer needed with SweetAlert2
}

/* ════════════════════════════════════════════════════════════
   EXPORT CSV
   ════════════════════════════════════════════════════════════ */
function exportCSV() {
    const groupField = REG_TYPE === 'hsc' ? 'desired_group' : 'desired_program';
    const gpaField   = REG_TYPE === 'hsc' ? 'ssc_gpa'       : 'hsc_gpa';

    const header = ['Ref No.','Name','Group/Program','GPA','Payment','Transaction ID','Submitted','Status'];
    const rows   = filteredApps.map(a => [
        a.ref_number,
        a.personal_data?.full_name_en || '',
        a.academic_data?.[groupField]  || '',
        a.academic_data?.[gpaField]    || '',
        a.payment_method || '',
        a.transaction_id  || '',
        a.submitted_at    || '',
        a.status          || '',
    ]);

    const csv     = [header, ...rows].map(r => r.map(c => `"${String(c).replace(/"/g, '""')}"`).join(',')).join('\n');
    const blob    = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
    const url     = URL.createObjectURL(blob);
    const a       = document.createElement('a');
    a.href        = url;
    a.download    = `PMDC_${REG_TYPE.toUpperCase()}_Registrations.csv`;
    a.click();
    URL.revokeObjectURL(url);
    showToast('CSV exported successfully!');
}

/* ════════════════════════════════════════════════════════════
   ADMIN NOTE
   ════════════════════════════════════════════════════════════ */
async function saveNote() {
    if (!viewingApp) return;
    const note = document.getElementById('adminNoteTA')?.value || '';
    try {
        await fetch(window.BASE_URL + `/pages/portal/admin/api/registration-admin.php`, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify({ ref_number: viewingApp.ref_number, admin_note: note }),
        });
    } catch (_) {}
    viewingApp.admin_note = note;
    showToast('Note saved.');
}

/* ════════════════════════════════════════════════════════════
   HELPERS
   ════════════════════════════════════════════════════════════ */
function esc(s)       { return String(s ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
function ucfirst(s)   { return s ? s.charAt(0).toUpperCase() + s.slice(1) : s; }
function formatDate(d){ if (!d) return '—'; try { return new Date(d).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit' }); } catch { return d; } }

function showToast(msg, type = 'success') {
    const el = document.getElementById('raToast');
    el.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${msg}`;
    el.className = `tm-toast ${type} show`;
    setTimeout(() => el.classList.remove('show'), 3000);
}

/* ════════════════════════════════════════════════════════════
   INIT
   ════════════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', async () => {
    await loadSettings();
    await loadApplications();

    // ── Settings ──
    document.getElementById('statusToggle')?.addEventListener('change', function () {
        const lbl = document.getElementById('toggleLbl');
        if (lbl) { lbl.textContent = this.checked ? 'OPEN' : 'CLOSED'; lbl.className = 'ra-toggle-lbl ' + (this.checked ? 'open' : 'closed'); }
    });
    document.getElementById('btnSaveSettings')?.addEventListener('click', saveSettings);

    // ── Filters ──
    ['searchInput','filterStatus','filterGroup','filterPayment'].forEach(id => {
        document.getElementById(id)?.addEventListener('input',  applyFilters);
        document.getElementById(id)?.addEventListener('change', applyFilters);
    });

    // ── Table actions (delegated) ──
    document.getElementById('appTbody')?.addEventListener('click', e => {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;
        const { id, action } = btn.dataset;
        if (action === 'view')    openDetail(id);
        if (action === 'approve') approveApp(id);
        if (action === 'reject')  openRejectModal(id);
    });

    // ── Pagination (delegated) ──
    document.getElementById('pagBtns')?.addEventListener('click', e => {
        const btn = e.target.closest('[data-page]');
        if (!btn || btn.disabled) return;
        const p = btn.dataset.page;
        const total = Math.ceil(filteredApps.length / ITEMS_PER_PAGE);
        if (p === 'prev') currentPage = Math.max(1, currentPage - 1);
        else if (p === 'next') currentPage = Math.min(total, currentPage + 1);
        else currentPage = parseInt(p);
        renderTable();
    });

    // ── Detail modal ──
    document.getElementById('detailClose')?.addEventListener('click', closeDetail);
    document.getElementById('detailOverlay')?.addEventListener('click', e => { if (e.target === e.currentTarget) closeDetail(); });
    document.getElementById('detailApproveBtn')?.addEventListener('click', () => { if (viewingApp) approveApp(viewingApp.ref_number); });
    document.getElementById('detailRejectBtn')?.addEventListener('click', () => { if (viewingApp) openRejectModal(viewingApp.ref_number); });
    document.getElementById('btnSaveNote')?.addEventListener('click', saveNote);

    // ── Reject modal ──
    document.getElementById('rejectClose')?.addEventListener('click', closeRejectModal);
    document.getElementById('rejectCancel')?.addEventListener('click', closeRejectModal);
    document.getElementById('rejectConfirm')?.addEventListener('click', confirmReject);
    document.getElementById('rejectOverlay')?.addEventListener('click', e => { if (e.target === e.currentTarget) closeRejectModal(); });

    // ── Export ──
    document.getElementById('btnExport')?.addEventListener('click', exportCSV);

    // ── Print ──
    document.getElementById('detailPrint')?.addEventListener('click', () => window.print());

    // ── Keyboard ──
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') { closeDetail(); closeRejectModal(); }
    });
});
