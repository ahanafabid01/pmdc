/**
 * attendance.js — Teacher Attendance (Dynamic, DB-backed)
 * Dropdowns populated entirely from teacher context API.
 * No hardcoded groups, years, or sections.
 */
'use strict';

/* ══ Globals ═══════════════════════════════════════════════════ */
let CTX         = null;   // teacher context from API
let allStudents = [];     // all students in teacher's programs

/* ══ Helpers ════════════════════════════════════════════════════ */
function localISO(d) {
    const date = d instanceof Date ? d : new Date(d);
    return new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString().slice(0, 10);
}
const TODAY = localISO(new Date());

function fmtDate(iso) {
    return new Date(`${iso}T00:00:00`).toLocaleDateString('en-US', { weekday:'short', month:'long', day:'numeric', year:'numeric' });
}

function esc(s) {
    return String(s ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function showToast(msg, err = false) {
    const t = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = msg;
    t.className = `toast show${err ? ' error' : ''}`;
    setTimeout(() => t.classList.remove('show'), 3200);
}

const $ = id => document.getElementById(id);

/* ══ Sidebar ════════════════════════════════════════════════════ */
(function () {
    const sidebar = $('sidebar');
    const overlay = $('sidebarOverlay');
    const open  = () => { sidebar.classList.add('open');    overlay?.classList.add('active'); };
    const close = () => { sidebar.classList.remove('open'); overlay?.classList.remove('active'); };
    $('menuToggle')?.addEventListener('click', open);
    $('closeSidebar')?.addEventListener('click', close);
    overlay?.addEventListener('click', close);
})();

/* ══ Tabs ════════════════════════════════════════════════════════ */
function openTab(name) {
    document.querySelectorAll('.att-tab').forEach(b => {
        const active = b.dataset.tab === name;
        b.classList.toggle('active', active);
        b.setAttribute('aria-selected', String(active));
    });
    document.querySelectorAll('.att-tab-panel').forEach(p =>
        p.classList.toggle('active', p.id === `tab-${name}`)
    );
}
document.querySelectorAll('.att-tab').forEach(b =>
    b.addEventListener('click', () => openTab(b.dataset.tab))
);

/* ══ Date Chip ══════════════════════════════════════════════════ */
function setDateChip() {
    const el = $('todayDateChip');
    if (el) el.textContent = `Today: ${fmtDate(TODAY)}`;
    const dv = $('takeDateView');
    if (dv) dv.value = fmtDate(TODAY);
    const hd = $('historyDate');
    if (hd) hd.value = TODAY;
    const to = $('reportToDate');
    if (to) to.value = TODAY;
    const fr = $('reportFromDate');
    if (fr) {
        const d = new Date();
        d.setDate(d.getDate() - 30);
        fr.value = localISO(d);
    }
}

/* ══ Build program-scoped Year options ═════════════════════════ */
function yearOptions(programId) {
    const prog = CTX.programs.find(p => p.id === programId);
    if (!prog) return [{ val: '', label: 'Select Year' }];
    if (prog.type === 'hsc') {
        return [
            { val: '', label: 'Select Year' },
            { val: 'xi',  label: 'HSC 1st Year' },
            { val: 'xii', label: 'HSC 2nd Year' },
        ];
    }
    // Degree programs
    return [
        { val: '', label: 'Select Year' },
        { val: '1', label: '1st Year' },
        { val: '2', label: '2nd Year' },
        { val: '3', label: '3rd Year' },
        { val: '4', label: '4th Year' },
    ];
}

function fillYearSelect(sel, programId, withBlank = true) {
    const opts = yearOptions(programId);
    sel.innerHTML = opts
        .filter(o => withBlank || o.val)
        .map(o => `<option value="${o.val}">${o.label}</option>`)
        .join('');
}

/* ══ Build section options for program+year ════════════════════ */
function sectionsFor(programId, year) {
    if (!CTX || !year) return [];
    // Find sections from real student data
    const prog = CTX.programs.find(p => p.id === programId);
    if (!prog) return [];
    const secs = new Set();
    allStudents.forEach(s => {
        const sYear = s.year?.toLowerCase();
        const sGrp  = (s.group || '').toLowerCase();
        // Match by program type
        const matchProg = programMatchesStudent(prog, s);
        const matchYear = sYear === year?.toLowerCase();
        if (matchProg && matchYear && s.section) secs.add(s.section.toUpperCase());
    });
    // Fall back to context sections if empty
    const ctxSecs = CTX.program_sections?.[programId] || [];
    if (!secs.size) ctxSecs.forEach(s => secs.add(s.toUpperCase()));
    return [...secs].sort();
}

function programMatchesStudent(prog, student) {
    const g = (student.group || '').toLowerCase();
    const id = prog.id.toLowerCase();
    if (id.includes('science'))    return g === 'science';
    if (id.includes('humanities')) return g === 'humanities';
    if (id.includes('business') || id.includes('commerce')) return g === 'business' || g === 'commerce';
    if (id.includes('bmt'))  return g === 'bmt';
    if (id.includes('ba'))   return g === 'ba' || g === 'arts';
    if (id.includes('bsc'))  return g === 'bsc';
    if (id.includes('bss'))  return g === 'bss';
    return false;
}

function fillSectionSelect(sel, programId, year, withBlank = true) {
    const secs = sectionsFor(programId, year);
    if (withBlank) {
        sel.innerHTML = `<option value="">Select Section</option>` +
            secs.map(s => `<option value="${s}">Section ${s}</option>`).join('');
    } else {
        sel.innerHTML = secs.length
            ? secs.map(s => `<option value="${s}">Section ${s}</option>`).join('')
            : `<option value="A">Section A</option>`;
    }
}

/* ══ Populate all dropdowns from CTX ═══════════════════════════ */
function buildAllDropdowns() {
    const programs = CTX.programs || [];

    // Program selects
    ['takeProgram','historyProgram','reportProgram'].forEach(id => {
        const sel = $(id);
        const blank = id !== 'takeProgram' ? '<option value="">All Programs</option>' : '<option value="">Select Program</option>';
        sel.innerHTML = blank + programs.map(p =>
            `<option value="${p.id}">${p.name}</option>`
        ).join('');
    });

    // Wire program → year cascades
    $('takeProgram').addEventListener('change', function () {
        fillYearSelect($('takeYear'), this.value);
        $('takeSection').innerHTML = '<option value="">Select Section</option>';
    });
    $('takeYear').addEventListener('change', function () {
        fillSectionSelect($('takeSection'), $('takeProgram').value, this.value);
    });

    $('historyProgram').addEventListener('change', function () {
        fillYearSelect($('historyYear'), this.value, false);
        $('historySection').innerHTML = '<option value="">All Sections</option>';
    });
    $('historyYear').addEventListener('change', function () {
        const secs = sectionsFor($('historyProgram').value, this.value);
        $('historySection').innerHTML = '<option value="">All Sections</option>' +
            secs.map(s => `<option value="${s}">Section ${s}</option>`).join('');
    });

    $('reportProgram').addEventListener('change', function () {
        fillYearSelect($('reportYear'), this.value);
        $('reportSection').innerHTML = '<option value="">Select Section</option>';
    });
    $('reportYear').addEventListener('change', function () {
        fillSectionSelect($('reportSection'), $('reportProgram').value, this.value);
    });

    // Pre-select first program
    if (programs.length) {
        $('takeProgram').value = programs[0].id;
        fillYearSelect($('takeYear'), programs[0].id);
        fillYearSelect($('historyYear'), programs[0].id, false);
        fillYearSelect($('reportYear'), programs[0].id);
        $('historyProgram').value = programs[0].id;
        $('reportProgram').value  = programs[0].id;
    }
}

/* ══ Students filtered for a take selection ═══════════════════ */
function studentsForClass(programId, year, section) {
    const prog = CTX?.programs?.find(p => p.id === programId);
    if (!prog) return [];
    return allStudents.filter(s => {
        const matchProg = programMatchesStudent(prog, s);
        const matchYear = (s.year || '').toLowerCase() === (year || '').toLowerCase();
        const matchSec  = !section || (s.section || '').toUpperCase() === section.toUpperCase();
        return matchProg && matchYear && matchSec;
    }).sort((a, b) => String(a.roll).localeCompare(String(b.roll), undefined, { numeric: true }));
}

/* ══ TAKE ATTENDANCE state ══════════════════════════════════════ */
const takeState = {
    students: [],
    statusMap: new Map(),
    selection: null,
};

function renderTakeRows() {
    const tbody = $('takeStudentsTbody');
    const list  = takeState.students;

    $('takeEmpty').style.display         = list.length ? 'none' : 'flex';
    $('takeStudentsTable').style.display = list.length ? 'table' : 'none';
    $('submitAttendanceBtn').disabled    = !list.length;

    tbody.innerHTML = list.map((st, idx) => {
        const status = takeState.statusMap.get(String(st.id)) || 'present';
        return `<tr>
            <td data-label="#">${idx + 1}</td>
            <td data-label="Roll"><code class="roll-chip">${esc(st.roll)}</code></td>
            <td data-label="Name"><span class="att-stu-name">${esc(st.name)}</span></td>
            <td data-label="Status">
                <div class="status-switch">
                    <button class="status-btn present ${status === 'present' ? 'active' : ''}"
                        data-student="${esc(st.id)}" data-status="present">
                        <i class="fas fa-check"></i><span>Present</span>
                    </button>
                    <button class="status-btn absent ${status === 'absent' ? 'active' : ''}"
                        data-student="${esc(st.id)}" data-status="absent">
                        <i class="fas fa-times"></i><span>Absent</span>
                    </button>
                </div>
            </td>
        </tr>`;
    }).join('');

    updateSummary();
}

function updateSummary() {
    const total   = takeState.students.length;
    const present = takeState.students.filter(s =>
        (takeState.statusMap.get(String(s.id)) || 'present') === 'present'
    ).length;
    $('takeSummaryBar').textContent = `Present: ${present} | Absent: ${total - present} | Total: ${total}`;
}

async function loadStudentsForTake() {
    hideTakeAlerts();
    const progId  = $('takeProgram').value;
    const year    = $('takeYear').value;
    const section = $('takeSection').value;

    if (!progId || !year || !section) {
        showTakeAlert('att-alert-warning', 'Please select Program, Year, and Section.');
        return;
    }

    const students = studentsForClass(progId, year, section);
    takeState.students  = students;
    takeState.selection = { progId, year, section, date: TODAY };
    takeState.statusMap = new Map();
    students.forEach(s => takeState.statusMap.set(String(s.id), 'present'));

    // Try loading existing record
    try {
        const r = await fetch(window.BASE_URL + `/pages/portal/teacher/api/attendance.php?action=list&date=${TODAY}&year=${year}&group=${progId}&section=${section}`);
        const d = await r.json();
        if (d.ok && d.records?.length) {
            const rec = d.records[0];
            if (rec) {
                rec.statuses.forEach(st => takeState.statusMap.set(String(st.student_id), st.status));
                showTakeAlert('att-alert-warning',
                    `<i class="fas fa-info-circle"></i> Attendance already recorded. You can edit and resubmit.`);
            }
        }
    } catch (_) { /* ignore */ }

    const prog = CTX.programs.find(p => p.id === progId);
    const yearLabel = year === 'xi' ? 'HSC 1st Year' : year === 'xii' ? 'HSC 2nd Year' : `Year ${year}`;
    $('takeListMeta').innerHTML =
        `<strong>${prog?.name || progId}</strong> &nbsp;·&nbsp; ${yearLabel} &nbsp;·&nbsp; Section ${section} &nbsp;·&nbsp; ${fmtDate(TODAY)}`;

    renderTakeRows();
    $('markAllPresentBtn').disabled = !students.length;
    $('markAllAbsentBtn').disabled  = !students.length;
    $('takeListCard').style.display = 'block';
    $('takeListCard').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function hideTakeAlerts() {
    $('takeAlert').style.display   = 'none';
    $('takeSuccess').style.display = 'none';
}
function showTakeAlert(cls, msg) {
    const el = $('takeAlert');
    el.className = `att-alert ${cls}`;
    el.innerHTML = msg;
    el.style.display = 'block';
}

$('loadStudentsBtn').addEventListener('click', loadStudentsForTake);

$('markAllPresentBtn').addEventListener('click', () => {
    takeState.students.forEach(s => takeState.statusMap.set(String(s.id), 'present'));
    renderTakeRows();
});
$('markAllAbsentBtn').addEventListener('click', () => {
    takeState.students.forEach(s => takeState.statusMap.set(String(s.id), 'absent'));
    renderTakeRows();
});

$('takeStudentsTbody').addEventListener('click', e => {
    const btn = e.target.closest('.status-btn');
    if (!btn) return;
    takeState.statusMap.set(btn.dataset.student, btn.dataset.status);
    renderTakeRows();
});

/* ══ Submit Attendance ═════════════════════════════════════════ */
$('submitAttendanceBtn').addEventListener('click', () => {
    if (!takeState.students.length) return;
    const sel = takeState.selection;
    $('confirmText').textContent =
        `Submit attendance for ${fmtDate(sel.date)}? (${takeState.students.length} students)`;
    $('submitConfirmModal').classList.add('open');
});

['confirmCloseBtn','confirmCancelBtn'].forEach(id =>
    $(id)?.addEventListener('click', () => $('submitConfirmModal').classList.remove('open'))
);
$('submitConfirmModal').addEventListener('click', e => {
    if (e.target === $('submitConfirmModal')) $('submitConfirmModal').classList.remove('open');
});

$('confirmSubmitBtn').addEventListener('click', async () => {
    $('confirmSubmitBtn').disabled = true;
    const sel      = takeState.selection;
    const statuses = takeState.students.map(s => ({
        student_id: s.id,
        status: takeState.statusMap.get(String(s.id)) === 'absent' ? 'absent' : 'present',
    }));

    try {
        const res = await fetch(window.BASE_URL + `/pages/portal/teacher/api/attendance.php?action=save`, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify({
                program_id: sel.progId,
                group:      sel.progId,
                year:       sel.year,
                section:    sel.section,
                period:     1, // Defaulting to 1 as period field is removed
                date:       sel.date,
                statuses,
            }),
        });
        const data = await res.json();
        if (data.ok) {
            showToast('Attendance saved successfully!');
            $('takeSuccess').textContent =
                `✓ Attendance submitted on ${fmtDate(sel.date)}`;
            $('takeSuccess').style.display = 'block';
            $('takeListCard').style.display = 'none';
            // Reset selects
            $('takeSection').value = '';
        } else {
            showToast(data.msg || 'Failed to save.', true);
        }
    } catch (_) {
        showToast('Network error — please try again.', true);
    } finally {
        $('confirmSubmitBtn').disabled = false;
        $('submitConfirmModal').classList.remove('open');
    }
});

/* ══ HISTORY ════════════════════════════════════════════════════ */
async function searchHistory() {
    const program = $('historyProgram').value;
    const year    = $('historyYear').value;
    const section = $('historySection').value;
    const date    = $('historyDate').value || TODAY;
    const wrap    = $('historyResultsWrap');

    wrap.innerHTML = `<div class="att-loading-banner"><i class="fas fa-spinner fa-spin"></i><span>Loading records…</span></div>`;

    try {
        const res  = await fetch(window.BASE_URL + `/pages/portal/teacher/api/attendance.php?action=list&date=${date}&year=${year}&group=${program}&section=${section}`);
        const data = await res.json();

        if (!data.ok || !data.records?.length) {
            wrap.innerHTML = `<div class="card att-card"><div class="card-body att-pad"><div class="att-empty" style="display:flex;">
                <i class="fas fa-inbox"></i><p>No records found for ${fmtDate(date)}.</p>
                <span>Try a different date or class.</span></div></div></div>`;
            return;
        }

        const stuMap = {};
        allStudents.forEach(s => stuMap[String(s.id)] = s);

        wrap.innerHTML = data.records.map(rec => {
            const present = rec.statuses.filter(s => s.status === 'present').length;
            const absent  = rec.statuses.length - present;
            const prog    = CTX?.programs?.find(p => p.id === rec.program_id);
            const yr      = rec.year === 'xi' ? 'HSC 1st Year' : rec.year === 'xii' ? 'HSC 2nd Year' : `Year ${rec.year}`;
            return `<div class="history-card">
                <div class="history-head">
                    <div class="history-head-left">
                        <span class="hh-period">Period ${rec.period}</span>
                        <span>${prog?.name || rec.program_id} · ${yr} · Sec ${rec.section}</span>
                    </div>
                    <div class="history-head-right">
                        <span>${fmtDate(rec.att_date)}</span>
                    </div>
                </div>
                <div class="history-body">
                    <div class="table-responsive">
                        <table class="att-table">
                            <thead><tr><th>#</th><th>Roll</th><th>Name</th><th>Status</th></tr></thead>
                            <tbody>${rec.statuses.map((st, i) => {
                                const s = stuMap[String(st.student_id)];
                                return `<tr>
                                    <td>${i + 1}</td>
                                    <td><code class="roll-chip">${esc(s?.roll || st.student_id)}</code></td>
                                    <td><span class="att-stu-name">${esc(s?.name || '—')}</span></td>
                                    <td><span class="status-badge ${st.status}">${st.status === 'present' ? 'Present' : 'Absent'}</span></td>
                                </tr>`;
                            }).join('')}</tbody>
                        </table>
                    </div>
                </div>
                <div class="history-footer">
                    <span class="hf-present"><i class="fas fa-check"></i> ${present} Present</span>
                    <span class="hf-absent"><i class="fas fa-times"></i> ${absent} Absent</span>
                    <span class="hf-total">Total: ${rec.statuses.length}</span>
                </div>
            </div>`;
        }).join('');

    } catch (_) {
        wrap.innerHTML = `<div class="card att-card"><div class="card-body att-pad"><div class="att-empty" style="display:flex;">
            <i class="fas fa-exclamation-circle"></i><p>Failed to load records.</p></div></div></div>`;
    }
}
$('historySearchBtn').addEventListener('click', searchHistory);

/* ══ REPORT ════════════════════════════════════════════════════ */
function pctBadge(pct) {
    if (pct >= 90) return `<span class="pct-badge pct-green">${pct.toFixed(1)}%</span>`;
    if (pct >= 75) return `<span class="pct-badge pct-blue">${pct.toFixed(1)}%</span>`;
    if (pct >= 60) return `<span class="pct-badge pct-yellow">${pct.toFixed(1)}%</span>`;
    return `<span class="pct-badge pct-red">${pct.toFixed(1)}%</span>`;
}

async function generateReport() {
    const prog    = $('reportProgram').value;
    const year    = $('reportYear').value;
    const section = $('reportSection').value;
    const from    = $('reportFromDate').value;
    const to      = $('reportToDate').value;

    if (!prog || !year || !section || !from || !to) {
        showToast('Please complete all report filters.', true);
        return;
    }

    $('reportCard').style.display = 'block';
    $('reportTbody').innerHTML    =
        `<tr><td colspan="6" style="text-align:center;padding:28px;"><i class="fas fa-spinner fa-spin"></i></td></tr>`;

    try {
        const res  = await fetch(window.BASE_URL + `/pages/portal/teacher/api/attendance.php?action=report&year=${year}&group=${prog}&section=${section}&from=${from}&to=${to}`);
        const data = await res.json();

        $('sumTotalClasses').textContent = data.total_classes ?? 0;

        if (!data.ok || !data.rows?.length) {
            $('reportEmpty').style.display = 'flex';
            $('reportTbody').innerHTML     = '';
            ['sumAvgAttendance','sumMostAbsent','sumPerfectCount'].forEach(id =>
                $(id).textContent = id === 'sumAvgAttendance' ? '0%' : '—');
            return;
        }

        $('reportEmpty').style.display = 'none';
        const rows    = data.rows;
        const avg     = rows.reduce((a, r) => a + r.percent, 0) / rows.length;
        const top     = [...rows].sort((a, b) => b.absent - a.absent)[0];
        const perfect = rows.filter(r => r.absent === 0).length;

        $('sumAvgAttendance').textContent = avg.toFixed(1) + '%';
        $('sumMostAbsent').textContent    = top ? `${top.name} (${top.absent}×)` : '—';
        $('sumPerfectCount').textContent  = perfect;

        $('reportTbody').innerHTML = rows.map(r => `<tr>
            <td><code class="roll-chip">${esc(r.roll)}</code></td>
            <td><span class="att-stu-name">${esc(r.name)}</span></td>
            <td>${r.total_classes}</td>
            <td>${r.present}</td>
            <td>${r.absent}</td>
            <td>${pctBadge(r.percent)}</td>
        </tr>`).join('');

        $('reportSearchInput').oninput = function () {
            const q = this.value.toLowerCase();
            $('reportTbody').querySelectorAll('tr').forEach(tr =>
                tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none'
            );
        };

        $('reportCard').scrollIntoView({ behavior: 'smooth', block: 'start' });

    } catch (_) {
        $('reportTbody').innerHTML =
            `<tr><td colspan="6" style="text-align:center;color:#ef4444;padding:24px;">Failed to generate report.</td></tr>`;
    }
}
$('generateReportBtn').addEventListener('click', generateReport);
$('printReportBtn')?.addEventListener('click', () => window.print());

/* ══ INIT ═══════════════════════════════════════════════════════ */
async function loadTeacherContext() {
    try {
        const res  = await fetch(window.BASE_URL + `/pages/portal/api/get_teacher_context.php`);
        const data = await res.json();

        if (!data.ok) { window.location.href = '../portal-login.php'; return; }

        CTX         = data;
        allStudents = data.students || [];

        // Update sidebar
        document.querySelectorAll('.t-name').forEach(el => el.textContent = data.teacher_name);
        document.querySelectorAll('.t-role').forEach(el => {
            el.textContent = data.programs?.length
                ? data.programs.map(p => p.name).join(', ')
                : 'No programs assigned';
        });
        const av = $('sidebarAvatar');
        if (av) av.textContent = data.teacher_name.trim().split(/\s+/).map(w => w[0].toUpperCase()).slice(0,2).join('');
        const ha = $('headerAvatar');
        if (ha) {
            ha.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(data.teacher_name)}&background=2563eb&color=fff`;
            ha.alt = data.teacher_name;
        }

        // Show teacher context pill
        const pill = $('teacherContextPill');
        if (pill && data.programs?.length) {
            pill.innerHTML = data.programs.map(p =>
                `<span class="ctx-pill">${p.name}</span>`
            ).join('');
        }

        // Hide loading, show UI
        $('attLoadingBanner').style.display = 'none';

        if (!data.programs?.length) {
            $('attNoPrograms').style.display = 'flex';
            return;
        }

        $('attTabBar').style.display = 'flex';
        setDateChip();
        buildAllDropdowns();

    } catch (e) {
        console.error('Context load failed', e);
        $('attLoadingBanner').innerHTML =
            '<i class="fas fa-exclamation-circle"></i><span>Failed to load context. Please refresh.</span>';
    }
}

loadTeacherContext();
