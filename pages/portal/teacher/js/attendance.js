/**
 * attendance.js — Teacher Attendance (Dynamic, DB-backed)
 * All data from API. No mock/localStorage fallbacks.
 */
'use strict';

const $ = id => document.getElementById(id);
const qs  = sel => document.querySelector(sel);
const qsa = sel => Array.from(document.querySelectorAll(sel));

/* ── Globals ─────────────────────────────────────────────── */
let CTX = null;        // teacher context from API
let allStudents = [];  // all students in teacher's programs

/* ── Helpers ─────────────────────────────────────────────── */
function localISO(date) {
    const d = date instanceof Date ? date : new Date(date);
    return new Date(d.getTime() - d.getTimezoneOffset()*60000).toISOString().slice(0,10);
}
const TODAY = localISO(new Date());

function fmtDate(iso) {
    return new Date(`${iso}T00:00:00`).toLocaleDateString('en-US',{month:'long',day:'numeric',year:'numeric'});
}

function esc(str) {
    return String(str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function showToast(msg, isErr = false) {
    const t = $('toast');
    $('toastMsg').textContent = msg;
    t.className = 'toast show' + (isErr ? ' error' : '');
    setTimeout(() => t.classList.remove('show'), 3200);
}

/* ── Sidebar ─────────────────────────────────────────────── */
(function() {
    const sidebar  = $('sidebar');
    const overlay  = $('sidebarOverlay');
    const open  = () => { sidebar.classList.add('open');    overlay?.classList.add('active'); };
    const close = () => { sidebar.classList.remove('open'); overlay?.classList.remove('active'); };
    $('menuToggle')?.addEventListener('click', open);
    $('closeSidebar')?.addEventListener('click', close);
    overlay?.addEventListener('click', close);
})();

/* ── Tabs ─────────────────────────────────────────────────── */
function openTab(name) {
    qsa('.att-tab').forEach(b => {
        const active = b.dataset.tab === name;
        b.classList.toggle('active', active);
        b.setAttribute('aria-selected', active ? 'true' : 'false');
    });
    qsa('.att-tab-panel').forEach(p => p.classList.toggle('active', p.id === `tab-${name}`));
}
qsa('.att-tab').forEach(b => b.addEventListener('click', () => openTab(b.dataset.tab)));

/* ── Set today ───────────────────────────────────────────── */
function setDateUI() {
    $('takeDateView').value    = fmtDate(TODAY);
    $('todayDateChip').textContent = `Today: ${fmtDate(TODAY)}`;
    $('historyDate').value     = TODAY;
    $('reportToDate').value    = TODAY;
    const from = new Date(); from.setDate(from.getDate()-30);
    $('reportFromDate').value  = localISO(from);
}

/* ── Populate dropdowns from real API context ────────────── */
function buildDropdowns(ctx) {
    const programs = ctx.programs || [];

    // Build group options (unique groups from assigned programs)
    const groupMap = {};
    programs.forEach(p => {
        // Map program to readable group label
        const label = p.name;
        const groupKey = p.id; // use program_id as group key in dropdowns
        groupMap[groupKey] = label;
    });

    const groups = Object.entries(groupMap);

    // Year dropdown — only show HSC years if HSC programs assigned; degree = 'year 1','year 2' etc
    const hasHSC = programs.some(p => p.type === 'hsc');
    const hasDegree = programs.some(p => p.type === 'degree');

    const yearOpts = [];
    if (hasHSC)    { yearOpts.push(['xi','HSC 1st Year'], ['xii','HSC 2nd Year']); }
    if (hasDegree) { yearOpts.push(['1','1st Year'], ['2','2nd Year'], ['3','3rd Year'], ['4','4th Year']); }

    ['takeYear','historyYear','reportYear'].forEach(id => {
        const sel = $(id);
        sel.innerHTML = '<option value="">Select Year</option>' +
            yearOpts.map(([v,l]) => `<option value="${v}">${l}</option>`).join('');
    });

    ['takeGroup','historyGroup','reportGroup'].forEach(id => {
        const sel = $(id);
        sel.innerHTML = '<option value="">Select Program</option>' +
            groups.map(([v,l]) => `<option value="${v}">${l}</option>`).join('');
    });
}

/* ── Section dropdown ────────────────────────────────────── */
function buildSectionDropdown(selEl, programId) {
    const sections = (CTX?.program_sections?.[programId] || []).sort();
    selEl.innerHTML = sections.length
        ? sections.map(s => `<option value="${s}">Section ${s}</option>`).join('')
        : '<option value="A">Section A</option>';
}

['takeGroup','historyGroup','reportGroup'].forEach(id => {
    $(id)?.addEventListener('change', function() {
        const targetId = id.replace('Group','Section');
        buildSectionDropdown($(targetId), this.value);
    });
});

/* ── TAKE ATTENDANCE ─────────────────────────────────────── */
const takeState = { students: [], statusMap: new Map(), selection: null, existingRecord: null, readOnly: false };

function getTakeSelection() {
    return {
        year:    $('takeYear').value,
        group:   $('takeGroup').value,
        section: $('takeSection').value,
        period:  parseInt($('takePeriod').value) || 1,
        date:    TODAY,
    };
}

function showTakeAlert(type, msg) {
    const el = $('takeAlert');
    el.className = `att-alert ${type}`;
    el.innerHTML = msg;
    el.style.display = 'block';
}
function hideTakeAlert() { $('takeAlert').style.display = 'none'; }
function showTakeSuccess(msg) { const e=$('takeSuccess'); e.textContent=msg; e.style.display='block'; }
function hideTakeSuccess() { $('takeSuccess').style.display = 'none'; }

function updateTakeSummary() {
    const total = takeState.students.length;
    const present = takeState.students.filter(s => (takeState.statusMap.get(s.id)||'present')==='present').length;
    $('takeSummaryBar').textContent = `Present: ${present} | Absent: ${total - present} | Total: ${total}`;
}

function renderTakeRows() {
    const tbody = $('takeStudentsTbody');
    const list  = takeState.students;
    const readOnly = takeState.readOnly;

    if (!list.length) {
        $('takeEmpty').style.display = 'block';
        $('takeStudentsTable').style.display = 'none';
        $('submitAttendanceBtn').style.display = 'flex';
        $('submitAttendanceBtn').disabled = true;
        tbody.innerHTML = '';
        return;
    }

    $('takeEmpty').style.display = 'none';
    $('takeStudentsTable').style.display = 'table';
    $('submitAttendanceBtn').disabled = readOnly;
    $('submitAttendanceBtn').style.display = readOnly ? 'none' : 'flex';

    tbody.innerHTML = list.map((st, idx) => {
        const status = takeState.statusMap.get(st.id) || 'present';
        return `<tr>
            <td data-label="#">${idx+1}</td>
            <td data-label="Roll"><code class="roll-chip">${esc(st.roll)}</code></td>
            <td data-label="Name"><span class="att-stu-name">${esc(st.name)}</span></td>
            <td data-label="Status">
                <div class="status-switch">
                    <button class="status-btn present ${status==='present'?'active':''}" data-student="${esc(st.id)}" data-status="present" ${readOnly?'disabled':''}>
                        <i class="fas fa-check"></i> Present
                    </button>
                    <button class="status-btn absent ${status==='absent'?'active':''}" data-student="${esc(st.id)}" data-status="absent" ${readOnly?'disabled':''}>
                        <i class="fas fa-times"></i> Absent
                    </button>
                </div>
            </td>
        </tr>`;
    }).join('');

    updateTakeSummary();
}

async function loadStudentsForTake() {
    hideTakeSuccess(); hideTakeAlert();
    const sel = getTakeSelection();

    if (!sel.year || !sel.group || !sel.section) {
        showToast('Please select year, program, and section.', true);
        return;
    }

    // Filter students from context
    const classStudents = allStudents
        .filter(s => {
            const sGroup = s.group?.toLowerCase();
            // Match by program_id key in program map
            const prog = CTX?.programs?.find(p => p.id === sel.group);
            if (!prog) return false;
            // Match by type
            if (prog.type === 'hsc') {
                return s.year === sel.year && s.section?.toUpperCase() === sel.section.toUpperCase();
            } else {
                return s.year === sel.year && s.section?.toUpperCase() === sel.section.toUpperCase();
            }
        })
        .sort((a,b) => a.roll.localeCompare(b.roll));

    if (!classStudents.length) {
        // Try broader match just by section & year
        const bySection = allStudents.filter(s =>
            s.year === sel.year && s.section?.toUpperCase() === sel.section.toUpperCase()
        ).sort((a,b) => a.roll.localeCompare(b.roll));

        takeState.students = bySection;
    } else {
        takeState.students = classStudents;
    }

    // Check for existing record
    let existingRecord = null;
    let readOnly = false;
    const statusMap = new Map();
    takeState.students.forEach(s => statusMap.set(s.id, 'present'));

    try {
        const res = await fetch(`api/attendance.php?action=list&date=${sel.date}&year=${sel.year}&group=${sel.group}&section=${sel.section}`);
        const data = await res.json();
        if (data.ok && data.records?.length) {
            const rec = data.records.find(r => r.period == sel.period);
            if (rec) {
                existingRecord = rec;
                rec.statuses.forEach(st => statusMap.set(st.student_id, st.status));
                showTakeAlert('att-alert-warning', `Attendance already submitted for Period ${sel.period}. You can edit and resubmit.`);
            }
        }
    } catch(e) { /* continue */ }

    takeState.selection = sel;
    takeState.statusMap = statusMap;
    takeState.existingRecord = existingRecord;
    takeState.readOnly = readOnly;

    const meta = `${sel.year === 'xi' ? 'HSC 1st Year' : sel.year === 'xii' ? 'HSC 2nd Year' : `Year ${sel.year}`} | ${CTX?.programs?.find(p=>p.id===sel.group)?.name||sel.group} | Section ${sel.section} | Period ${sel.period} | ${fmtDate(sel.date)}`;
    $('takeListMeta').textContent = meta;

    renderTakeRows();
    $('markAllPresentBtn').disabled = !takeState.students.length;
    $('markAllAbsentBtn').disabled  = !takeState.students.length;
    $('takeListCard').style.display = 'block';
}

$('loadStudentsBtn').addEventListener('click', loadStudentsForTake);
$('markAllPresentBtn').addEventListener('click', () => { takeState.students.forEach(s => takeState.statusMap.set(s.id,'present')); renderTakeRows(); });
$('markAllAbsentBtn').addEventListener('click',  () => { takeState.students.forEach(s => takeState.statusMap.set(s.id,'absent')); renderTakeRows(); });

$('takeStudentsTbody').addEventListener('click', e => {
    const btn = e.target.closest('.status-btn');
    if (!btn || takeState.readOnly) return;
    takeState.statusMap.set(btn.dataset.student, btn.dataset.status);
    renderTakeRows();
});

async function submitTakeAttendance() {
    const sel = takeState.selection;
    if (!sel || !takeState.students.length) return;

    const statuses = takeState.students.map(s => ({
        student_id: s.id,
        status: takeState.statusMap.get(s.id) === 'absent' ? 'absent' : 'present',
    }));

    $('confirmSubmitBtn').disabled = true;
    try {
        const res = await fetch('api/attendance.php?action=save', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                program_id: sel.group,
                group:      sel.group,
                year:       sel.year,
                section:    sel.section,
                period:     sel.period,
                date:       sel.date,
                statuses,
            })
        });
        const data = await res.json();
        if (data.ok) {
            showTakeSuccess(`Attendance submitted for Period ${sel.period} — ${fmtDate(sel.date)}`);
            showToast('Attendance saved to database!');
            $('takeListCard').style.display = 'none';
            $('takeYear').value = $('takeGroup').value = $('takePeriod').value = '';
        } else {
            showToast(data.msg || 'Failed to save.', true);
        }
    } catch(e) {
        showToast('Network error.', true);
    } finally {
        $('confirmSubmitBtn').disabled = false;
        closeConfirmModal();
    }
}

/* ── Confirm modal ───────────────────────────────────────── */
function openConfirmModal() {
    const sel = takeState.selection;
    if (!sel || !takeState.students.length) return;
    $('confirmText').textContent = `Submit attendance for Period ${sel.period} — ${fmtDate(sel.date)}?`;
    $('submitConfirmModal').classList.add('open');
}
function closeConfirmModal() { $('submitConfirmModal').classList.remove('open'); }

$('submitAttendanceBtn').addEventListener('click', openConfirmModal);
$('confirmCloseBtn').addEventListener('click', closeConfirmModal);
$('confirmCancelBtn').addEventListener('click', closeConfirmModal);
$('confirmSubmitBtn').addEventListener('click', submitTakeAttendance);
$('submitConfirmModal').addEventListener('click', e => { if (e.target===$('submitConfirmModal')) closeConfirmModal(); });

/* ── HISTORY ─────────────────────────────────────────────── */
async function searchHistory() {
    const year    = $('historyYear').value;
    const group   = $('historyGroup').value;
    const section = $('historySection').value;
    const date    = $('historyDate').value || TODAY;
    const wrap    = $('historyResultsWrap');

    wrap.innerHTML = '<div style="text-align:center;padding:30px;color:#94a3b8;"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';

    try {
        const res = await fetch(`api/attendance.php?action=list&date=${date}&year=${year}&group=${group}&section=${section}`);
        const data = await res.json();

        if (!data.ok || !data.records?.length) {
            wrap.innerHTML = `<div class="card att-card"><div class="card-body att-pad"><div class="att-empty"><i class="fas fa-inbox"></i><p>No attendance records found.</p></div></div></div>`;
            return;
        }

        const stuMap = {};
        allStudents.forEach(s => stuMap[s.id] = s);

        wrap.innerHTML = data.records.map(rec => {
            const footerPresent = rec.statuses.filter(s => s.status==='present').length;
            const footerTotal   = rec.statuses.length;
            return `<div class="history-card">
                <div class="history-head">
                    <div class="history-head-left">Period ${rec.period} | ${rec.academic_group} — Section ${rec.section} | ${rec.year === 'xi' ? 'HSC 1st Year' : 'HSC 2nd Year'}</div>
                    <div class="history-head-right">
                        <span>${fmtDate(rec.att_date)}</span>
                        <span>By: ${esc(rec.teacher_name)}</span>
                    </div>
                </div>
                <div class="history-body">
                    <div class="table-responsive">
                        <table class="att-table">
                            <thead><tr><th>#</th><th>Roll</th><th>Student Name</th><th>Status</th></tr></thead>
                            <tbody>
                                ${rec.statuses.map((st, idx) => {
                                    const s = stuMap[st.student_id];
                                    return `<tr>
                                        <td>${idx+1}</td>
                                        <td><code class="roll-chip">${esc(s?.roll||st.student_id)}</code></td>
                                        <td><span class="att-stu-name">${esc(s?.name||'Unknown')}</span></td>
                                        <td><span class="status-badge ${st.status}">${st.status==='present'?'Present':'Absent'}</span></td>
                                    </tr>`;
                                }).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="history-footer">Present: ${footerPresent} | Absent: ${footerTotal-footerPresent} | Total: ${footerTotal}</div>
            </div>`;
        }).join('');

    } catch(e) {
        wrap.innerHTML = `<div class="card att-card"><div class="card-body att-pad"><div class="att-empty"><i class="fas fa-exclamation-circle"></i><p>Failed to load records.</p></div></div></div>`;
    }
}
$('historySearchBtn').addEventListener('click', searchHistory);

/* ── REPORT ──────────────────────────────────────────────── */
function pctClass(pct) {
    if (pct >= 90) return 'pct-green';
    if (pct >= 75) return 'pct-blue';
    if (pct >= 60) return 'pct-yellow';
    return 'pct-red';
}

async function generateReport() {
    const year    = $('reportYear').value;
    const group   = $('reportGroup').value;
    const section = $('reportSection').value;
    const from    = $('reportFromDate').value;
    const to      = $('reportToDate').value;

    if (!year || !group || !section || !from || !to) {
        showToast('Please fill all report filters.', true);
        return;
    }

    $('reportCard').style.display = 'block';
    $('reportTbody').innerHTML = '<tr><td colspan="6" style="text-align:center;padding:30px;"><i class="fas fa-spinner fa-spin"></i></td></tr>';

    try {
        const res = await fetch(`api/attendance.php?action=report&year=${year}&group=${group}&section=${section}&from=${from}&to=${to}`);
        const data = await res.json();

        $('sumTotalClasses').textContent = data.total_classes || 0;

        if (!data.ok || !data.rows?.length) {
            $('reportEmpty').style.display = 'block';
            $('reportTbody').innerHTML = '';
            $('sumAvgAttendance').textContent = '0%';
            $('sumMostAbsent').textContent    = 'None';
            $('sumPerfectCount').textContent  = '0';
            return;
        }

        $('reportEmpty').style.display = 'none';
        const rows = data.rows;
        const avg  = rows.reduce((s,r)=>s+r.percent,0)/rows.length;
        const top  = [...rows].sort((a,b)=>b.absent-a.absent)[0];
        const perfect = rows.filter(r=>r.absent===0).length;

        $('sumAvgAttendance').textContent = avg.toFixed(1)+'%';
        $('sumMostAbsent').textContent    = top ? `${top.name} (${top.absent} absences)` : 'None';
        $('sumPerfectCount').textContent  = perfect;

        $('reportTbody').innerHTML = rows.map(r => `<tr>
            <td><code class="roll-chip">${esc(r.roll)}</code></td>
            <td><span class="att-stu-name">${esc(r.name)}</span></td>
            <td>${r.total_classes}</td>
            <td>${r.present}</td>
            <td>${r.absent}</td>
            <td><span class="pct-badge ${pctClass(r.percent)}">${r.percent.toFixed(1)}%</span></td>
        </tr>`).join('');

        // Search
        $('reportSearchInput').oninput = function() {
            const q = this.value.toLowerCase();
            $('reportTbody').querySelectorAll('tr').forEach(tr => {
                tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        };

    } catch(e) {
        $('reportTbody').innerHTML = `<tr><td colspan="6" style="text-align:center;color:#ef4444;">Failed to generate report.</td></tr>`;
    }
}
$('generateReportBtn').addEventListener('click', generateReport);

/* ── INIT ────────────────────────────────────────────────── */
async function loadTeacherContext() {
    try {
        const res = await fetch('../api/get_teacher_context.php');
        const data = await res.json();

        if (!data.ok) { window.location.href = '../portal-login.php'; return; }

        CTX = data;
        allStudents = data.students || [];

        // Update sidebar teacher name
        const nameEl = qs('.t-name');
        if (nameEl) nameEl.textContent = data.teacher_name;
        const roleEl = qs('.t-role');
        if (roleEl && data.programs?.length) roleEl.textContent = data.programs.map(p=>p.name).join(', ');

        setDateUI();
        buildDropdowns(data);

        // Initialize sections for first program
        if (data.programs?.length) {
            buildSectionDropdown($('takeSection'),    data.programs[0].id);
            buildSectionDropdown($('historySection'), data.programs[0].id);
            buildSectionDropdown($('reportSection'),  data.programs[0].id);
        }

    } catch(e) {
        console.error('Context load failed', e);
        setDateUI();
    }
}

loadTeacherContext();
