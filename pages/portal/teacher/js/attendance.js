/**
 * attendance.js
 * Teacher attendance management (Take / History / Report)
 */

'use strict';

/* -----------------------------------------
   Shared constants
----------------------------------------- */
const CURRENT_TEACHER = {
    id: 'teacher-afroza',
    name: 'Ms. Afroza Begum',
};

const STORAGE_KEYS = {
    students: 'pmdc_teacher_students_v1',
    attendance: 'pmdc_teacher_attendance_records_v1',
};

const YEAR_LABELS = {
    xi: 'HSC 1st Year',
    xii: 'HSC 2nd Year',
};

const GROUP_LABELS = {
    science: 'Science',
    commerce: 'Business',
    humanities: 'Humanities',
};

const DEFAULT_SECTIONS = ['A', 'B', 'C', 'D'];

/* -----------------------------------------
   DOM helpers
----------------------------------------- */
const $ = id => document.getElementById(id);
const qs = sel => document.querySelector(sel);
const qsa = sel => Array.from(document.querySelectorAll(sel));

function localISO(date) {
    const d = date instanceof Date ? date : new Date(date);
    const offsetMs = d.getTimezoneOffset() * 60000;
    return new Date(d.getTime() - offsetMs).toISOString().slice(0, 10);
}

function formatHumanDate(iso) {
    const dt = new Date(`${iso}T00:00:00`);
    return dt.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
}

function formatTime(iso) {
    return new Date(iso).toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: '2-digit',
    });
}

function esc(str) {
    return String(str ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function groupLabel(key) {
    return GROUP_LABELS[key] || 'Unknown';
}

function yearLabel(key) {
    return YEAR_LABELS[key] || 'Unknown';
}

function periodLabel(period) {
    return `Period ${period}`;
}

function attendanceKey(selection) {
    return `${selection.date}|${selection.year}|${selection.group}|${selection.section}|${selection.period}`;
}

/* -----------------------------------------
   Sidebar mobile
----------------------------------------- */
(function initSidebar() {
    const sidebar = $('sidebar');
    const overlay = $('sidebarOverlay');
    const openBtn = $('menuToggle');
    const closeBtn = $('closeSidebar');

    if (!sidebar) return;

    function openSidebar() {
        sidebar.classList.add('open');
        overlay?.classList.add('active');
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay?.classList.remove('active');
    }

    openBtn?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);

    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) closeSidebar();
    });
}());

/* -----------------------------------------
   Data sources
----------------------------------------- */
function fallbackStudents() {
    const firstNames = [
        'Fatema', 'Rashida', 'Nusrat', 'Morjina', 'Shirin', 'Taslima', 'Sultana', 'Afroza',
        'Monika', 'Roksana', 'Dilruba', 'Nasrin', 'Mithila', 'Shaila', 'Farida', 'Rina',
        'Tania', 'Jannat', 'Sonia', 'Rima', 'Popy', 'Mitu', 'Sharmin', 'Sadia',
    ];
    const lastNames = [
        'Begum', 'Akter', 'Khanam', 'Islam', 'Khatun', 'Parvin', 'Siddiqua', 'Rashid',
        'Sultana', 'Banu', 'Hossain', 'Rahman', 'Molla', 'Sarker', 'Sheikh', 'Mondol',
    ];
    const years = ['xi', 'xii'];
    const groups = ['science', 'commerce', 'humanities'];
    const sections = ['A', 'B', 'C', 'D'];

    return Array.from({ length: 160 }, (_, i) => {
        const year = years[i % years.length];
        const group = groups[i % groups.length];
        const section = sections[i % sections.length];
        const yrTag = year === 'xii' ? 'XII' : 'XI';
        return {
            id: `stu-${String(i + 1).padStart(3, '0')}`,
            roll: `PMDC-${yrTag}-${String(i + 1).padStart(3, '0')}`,
            name: `${firstNames[i % firstNames.length]} ${lastNames[i % lastNames.length]}`,
            year,
            group,
            section,
        };
    });
}

function normalizeStudent(raw, i) {
    const year = raw.year === 'xii' ? 'xii' : 'xi';
    const group = ['science', 'commerce', 'humanities'].includes(raw.group) ? raw.group : 'science';
    const section = (raw.section || 'A').toString().toUpperCase();
    const safeSection = DEFAULT_SECTIONS.includes(section) ? section : 'A';

    return {
        id: String(raw.id || `stu-${i + 1}`),
        roll: String(raw.roll || `PMDC-${year === 'xii' ? 'XII' : 'XI'}-${String(i + 1).padStart(3, '0')}`),
        name: String(raw.name || 'Unnamed Student'),
        year,
        group,
        section: safeSection,
    };
}

function loadStudents() {
    try {
        const raw = localStorage.getItem(STORAGE_KEYS.students);
        if (!raw) return fallbackStudents();
        const parsed = JSON.parse(raw);
        if (!Array.isArray(parsed) || !parsed.length) return fallbackStudents();
        return parsed.map((s, i) => normalizeStudent(s, i));
    } catch (_err) {
        return fallbackStudents();
    }
}

function loadAttendanceRecords() {
    try {
        const raw = localStorage.getItem(STORAGE_KEYS.attendance);
        const parsed = raw ? JSON.parse(raw) : [];
        if (!Array.isArray(parsed)) return [];
        return parsed.map(r => ({
            id: String(r.id || `att-${Date.now()}`),
            key: String(r.key || ''),
            date: String(r.date || ''),
            year: r.year === 'xii' ? 'xii' : 'xi',
            group: ['science', 'commerce', 'humanities'].includes(r.group) ? r.group : 'science',
            section: DEFAULT_SECTIONS.includes(String(r.section || '').toUpperCase()) ? String(r.section).toUpperCase() : 'A',
            period: Number(r.period || 1),
            teacherId: String(r.teacherId || ''),
            teacherName: String(r.teacherName || 'Unknown Teacher'),
            submittedAt: String(r.submittedAt || new Date().toISOString()),
            updatedAt: String(r.updatedAt || r.submittedAt || new Date().toISOString()),
            statuses: Array.isArray(r.statuses) ? r.statuses.map(st => ({
                studentId: String(st.studentId || ''),
                status: st.status === 'absent' ? 'absent' : 'present',
            })) : [],
        }));
    } catch (_err) {
        return [];
    }
}

function saveAttendanceRecords(records) {
    localStorage.setItem(STORAGE_KEYS.attendance, JSON.stringify(records));
}

/* -----------------------------------------
   State
----------------------------------------- */
const TODAY_ISO = localISO(new Date());

const state = {
    students: loadStudents(),
    records: loadAttendanceRecords(),
    take: {
        selection: null,
        loadedStudents: [],
        statusMap: new Map(),
        existingRecord: null,
        readOnly: false,
    },
    history: {
        records: [],
        editingRecordId: null,
        statusMap: new Map(),
    },
    report: {
        allRows: [],
        context: null,
    },
};

/* -----------------------------------------
   UI setup
----------------------------------------- */
function setTodayUI() {
    $('takeDateView').value = formatHumanDate(TODAY_ISO);
    $('todayDateChip').textContent = `Today: ${formatHumanDate(TODAY_ISO)}`;
    $('historyDate').value = TODAY_ISO;
    $('reportToDate').value = TODAY_ISO;

    const from = new Date();
    from.setDate(from.getDate() - 30);
    $('reportFromDate').value = localISO(from);
}

function fillSectionSelect(selectEl, year, group, selected = '') {
    if (!selectEl) return;
    const options = year && group ? DEFAULT_SECTIONS : [];
    selectEl.innerHTML = '';

    if (!options.length) {
        selectEl.innerHTML = '<option value="">Select Section</option>';
        return;
    }

    options.forEach(sec => {
        const opt = document.createElement('option');
        opt.value = sec;
        opt.textContent = `Section ${sec}`;
        if (sec === selected) opt.selected = true;
        selectEl.appendChild(opt);
    });
}

function initSectionDropdowns() {
    const takeYear = $('takeYear');
    const takeGroup = $('takeGroup');
    const takeSection = $('takeSection');
    const historyYear = $('historyYear');
    const historyGroup = $('historyGroup');
    const historySection = $('historySection');
    const reportYear = $('reportYear');
    const reportGroup = $('reportGroup');
    const reportSection = $('reportSection');

    fillSectionSelect(takeSection, '', '');
    fillSectionSelect(historySection, historyYear.value, historyGroup.value, 'A');
    fillSectionSelect(reportSection, reportYear.value, reportGroup.value, 'A');

    takeYear.addEventListener('change', () => {
        fillSectionSelect(takeSection, takeYear.value, takeGroup.value);
    });
    takeGroup.addEventListener('change', () => {
        fillSectionSelect(takeSection, takeYear.value, takeGroup.value);
    });

    historyYear.addEventListener('change', () => {
        fillSectionSelect(historySection, historyYear.value, historyGroup.value, historySection.value || 'A');
    });
    historyGroup.addEventListener('change', () => {
        fillSectionSelect(historySection, historyYear.value, historyGroup.value, historySection.value || 'A');
    });

    reportYear.addEventListener('change', () => {
        fillSectionSelect(reportSection, reportYear.value, reportGroup.value, reportSection.value || 'A');
    });
    reportGroup.addEventListener('change', () => {
        fillSectionSelect(reportSection, reportYear.value, reportGroup.value, reportSection.value || 'A');
    });
}

/* -----------------------------------------
   Tabs
----------------------------------------- */
function openTab(name) {
    qsa('.att-tab').forEach(btn => {
        const active = btn.dataset.tab === name;
        btn.classList.toggle('active', active);
        btn.setAttribute('aria-selected', active ? 'true' : 'false');
    });
    qsa('.att-tab-panel').forEach(panel => {
        panel.classList.toggle('active', panel.id === `tab-${name}`);
    });
}

qsa('.att-tab').forEach(btn => {
    btn.addEventListener('click', () => openTab(btn.dataset.tab));
});

/* -----------------------------------------
   Banner helpers
----------------------------------------- */
function showTakeAlert(type, msg) {
    const el = $('takeAlert');
    el.className = `att-alert ${type}`;
    el.innerHTML = msg;
    el.style.display = 'block';
}

function hideTakeAlert() {
    $('takeAlert').style.display = 'none';
}

function showTakeSuccess(msg) {
    const el = $('takeSuccess');
    el.textContent = msg;
    el.style.display = 'block';
}

function hideTakeSuccess() {
    $('takeSuccess').style.display = 'none';
}

/* -----------------------------------------
   Take attendance
----------------------------------------- */
function getTakeSelection() {
    return {
        year: $('takeYear').value,
        group: $('takeGroup').value,
        section: $('takeSection').value,
        period: $('takePeriod').value,
        date: TODAY_ISO,
    };
}

function updateTakeSummary() {
    const total = state.take.loadedStudents.length;
    let present = 0;

    state.take.loadedStudents.forEach(st => {
        if ((state.take.statusMap.get(st.id) || 'present') === 'present') present += 1;
    });

    const absent = total - present;
    $('takeSummaryBar').textContent = `Present: ${present} | Absent: ${absent} | Total: ${total}`;
}

function renderTakeRows() {
    const tbody = $('takeStudentsTbody');
    const list = state.take.loadedStudents;
    const readOnly = state.take.readOnly;

    if (!list.length) {
        $('takeEmpty').style.display = 'block';
        tbody.innerHTML = '';
        $('takeStudentsTable').style.display = 'none';
        $('submitAttendanceBtn').style.display = 'flex';
        $('submitAttendanceBtn').disabled = true;
        return;
    }

    $('takeEmpty').style.display = 'none';
    $('takeStudentsTable').style.display = 'table';
    $('submitAttendanceBtn').disabled = readOnly;
    $('submitAttendanceBtn').style.display = readOnly ? 'none' : 'flex';

    tbody.innerHTML = list.map((st, idx) => {
        const status = state.take.statusMap.get(st.id) || 'present';
        return `
        <tr>
            <td data-label="#">${idx + 1}</td>
            <td data-label="Roll"><code class="roll-chip">${esc(st.roll)}</code></td>
            <td data-label="Student Name"><span class="att-stu-name">${esc(st.name)}</span></td>
            <td data-label="Status">
                <div class="status-switch">
                    <button class="status-btn present ${status === 'present' ? 'active' : ''}"
                            data-student="${esc(st.id)}"
                            data-status="present"
                            ${readOnly ? 'disabled' : ''}>
                        <i class="fas fa-check"></i> Present
                    </button>
                    <button class="status-btn absent ${status === 'absent' ? 'active' : ''}"
                            data-student="${esc(st.id)}"
                            data-status="absent"
                            ${readOnly ? 'disabled' : ''}>
                        <i class="fas fa-times"></i> Absent
                    </button>
                </div>
            </td>
        </tr>`;
    }).join('');

    updateTakeSummary();
}

function renderTakeHeaderMeta() {
    const s = state.take.selection;
    if (!s) return;
    $('takeListMeta').textContent =
        `${yearLabel(s.year)} | ${groupLabel(s.group)} | Section ${s.section} | ${periodLabel(s.period)} | ${formatHumanDate(s.date)}`;
}

function setTakeActionDisabled(disabled) {
    $('markAllPresentBtn').disabled = disabled;
    $('markAllAbsentBtn').disabled = disabled;
}

function loadStudentsForTake() {
    hideTakeSuccess();
    hideTakeAlert();

    const selection = getTakeSelection();
    if (!selection.year || !selection.group || !selection.section || !selection.period) {
        showToast('Please select year, group, section, and period.');
        return;
    }

    const classStudents = state.students
        .filter(s => s.year === selection.year && s.group === selection.group && s.section === selection.section)
        .sort((a, b) => a.roll.localeCompare(b.roll));

    const key = attendanceKey(selection);
    const existing = state.records.find(r => r.key === key) || null;
    const statusMap = new Map();

    classStudents.forEach(st => statusMap.set(st.id, 'present'));

    let readOnly = false;
    if (existing) {
        const existingMap = new Map(existing.statuses.map(s => [s.studentId, s.status]));
        classStudents.forEach(st => {
            statusMap.set(st.id, existingMap.get(st.id) || 'present');
        });

        if (existing.teacherId === CURRENT_TEACHER.id) {
            showTakeAlert(
                'att-alert-warning',
                'Attendance already submitted for this period.<br>You can edit it since you submitted it.'
            );
        } else {
            readOnly = true;
            showTakeAlert(
                'att-alert-danger',
                'Attendance for this period was already submitted by another teacher.<br>You cannot edit it.'
            );
        }
    }

    state.take.selection = selection;
    state.take.loadedStudents = classStudents;
    state.take.statusMap = statusMap;
    state.take.existingRecord = existing;
    state.take.readOnly = readOnly;

    renderTakeHeaderMeta();
    renderTakeRows();
    setTakeActionDisabled(readOnly || !classStudents.length);
    $('takeListCard').style.display = 'block';
}

function setAllTakeStatuses(status) {
    if (state.take.readOnly) return;
    state.take.loadedStudents.forEach(st => state.take.statusMap.set(st.id, status));
    renderTakeRows();
}

$('loadStudentsBtn').addEventListener('click', loadStudentsForTake);
$('markAllPresentBtn').addEventListener('click', () => setAllTakeStatuses('present'));
$('markAllAbsentBtn').addEventListener('click', () => setAllTakeStatuses('absent'));

$('takeStudentsTbody').addEventListener('click', e => {
    const btn = e.target.closest('.status-btn');
    if (!btn || state.take.readOnly) return;
    const sid = btn.dataset.student;
    const status = btn.dataset.status;
    if (!sid || !status) return;
    state.take.statusMap.set(sid, status);
    renderTakeRows();
});

function resetTakeFormAfterSubmit() {
    $('takeYear').value = '';
    $('takeGroup').value = '';
    $('takePeriod').value = '';
    fillSectionSelect($('takeSection'), '', '');
    $('takeListCard').style.display = 'none';
    hideTakeAlert();

    state.take.selection = null;
    state.take.loadedStudents = [];
    state.take.statusMap = new Map();
    state.take.existingRecord = null;
    state.take.readOnly = false;
}

function submitTakeAttendance() {
    const selection = state.take.selection;
    if (!selection || state.take.readOnly || !state.take.loadedStudents.length) return;

    const nowISO = new Date().toISOString();
    const statuses = state.take.loadedStudents.map(st => ({
        studentId: st.id,
        status: state.take.statusMap.get(st.id) === 'absent' ? 'absent' : 'present',
    }));

    if (state.take.existingRecord && state.take.existingRecord.teacherId === CURRENT_TEACHER.id) {
        state.take.existingRecord.statuses = statuses;
        state.take.existingRecord.updatedAt = nowISO;
    } else {
        state.records.push({
            id: `att-${Date.now()}`,
            key: attendanceKey(selection),
            date: selection.date,
            year: selection.year,
            group: selection.group,
            section: selection.section,
            period: Number(selection.period),
            teacherId: CURRENT_TEACHER.id,
            teacherName: CURRENT_TEACHER.name,
            submittedAt: nowISO,
            updatedAt: nowISO,
            statuses,
        });
    }

    saveAttendanceRecords(state.records);

    showTakeSuccess(
        `Attendance submitted successfully for ${periodLabel(selection.period)} - ${groupLabel(selection.group)} Section ${selection.section} | ${formatHumanDate(selection.date)}`
    );
    showToast('Attendance saved successfully.');
    resetTakeFormAfterSubmit();
}

/* -----------------------------------------
   Confirm modal
----------------------------------------- */
function openConfirmModal() {
    const selection = state.take.selection;
    if (!selection || state.take.readOnly || !state.take.loadedStudents.length) return;

    $('confirmText').textContent =
        `Submit attendance for ${periodLabel(selection.period)} - ${groupLabel(selection.group)}, Section ${selection.section}, ${yearLabel(selection.year)}? This will be recorded. You can edit it later if needed.`;
    $('submitConfirmModal').classList.add('open');
}

function closeConfirmModal() {
    $('submitConfirmModal').classList.remove('open');
}

$('submitAttendanceBtn').addEventListener('click', openConfirmModal);
$('confirmCloseBtn').addEventListener('click', closeConfirmModal);
$('confirmCancelBtn').addEventListener('click', closeConfirmModal);
$('confirmSubmitBtn').addEventListener('click', () => {
    closeConfirmModal();
    submitTakeAttendance();
});

$('submitConfirmModal').addEventListener('click', e => {
    if (e.target === $('submitConfirmModal')) closeConfirmModal();
});

/* -----------------------------------------
   History
----------------------------------------- */
function getRecordStatusMap(record) {
    return new Map((record.statuses || []).map(st => [st.studentId, st.status]));
}

function getClassStudents(year, group, section) {
    return state.students
        .filter(s => s.year === year && s.group === group && s.section === section)
        .sort((a, b) => a.roll.localeCompare(b.roll));
}

function historyFooterCount(students, statusMap) {
    const total = students.length;
    const present = students.reduce((acc, s) => acc + ((statusMap.get(s.id) || 'present') === 'present' ? 1 : 0), 0);
    const absent = total - present;
    return `Present: ${present} | Absent: ${absent} | Total: ${total}`;
}

function renderHistoryRecords() {
    const wrap = $('historyResultsWrap');
    const rows = state.history.records;

    if (!rows.length) {
        wrap.innerHTML = `
            <div class="card att-card">
                <div class="card-body att-pad">
                    <div class="att-empty">
                        <i class="fas fa-inbox"></i>
                        <p>No attendance records found for the selected filters</p>
                    </div>
                </div>
            </div>`;
        return;
    }

    wrap.innerHTML = rows.map(record => {
        const students = getClassStudents(record.year, record.group, record.section);
        const recordMap = getRecordStatusMap(record);
        const isOwner = record.teacherId === CURRENT_TEACHER.id;
        const isEditing = state.history.editingRecordId === record.id;
        const activeMap = isEditing ? state.history.statusMap : recordMap;
        const footerText = historyFooterCount(students, activeMap);

        return `
        <div class="history-card" data-record-id="${esc(record.id)}">
            <div class="history-head">
                <div class="history-head-left">
                    ${periodLabel(record.period)} | ${groupLabel(record.group)} - Section ${record.section} | ${yearLabel(record.year)}
                </div>
                <div class="history-head-right">
                    <span>${formatHumanDate(record.date)}</span>
                    <span>Submitted by: ${esc(record.teacherName)}</span>
                    <span>Time: ${formatTime(record.submittedAt)}</span>
                    ${isOwner && !isEditing ? `
                        <button class="history-edit-btn" data-action="edit" data-record-id="${esc(record.id)}">
                            <i class="fas fa-pen"></i> Edit
                        </button>` : ''}
                </div>
            </div>
            <div class="history-body">
                <div class="table-responsive">
                    <table class="att-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Roll</th>
                                <th>Student Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${students.map((st, idx) => {
                                const status = activeMap.get(st.id) || 'present';
                                return `
                                <tr>
                                    <td data-label="#">${idx + 1}</td>
                                    <td data-label="Roll"><code class="roll-chip">${esc(st.roll)}</code></td>
                                    <td data-label="Student Name"><span class="att-stu-name">${esc(st.name)}</span></td>
                                    <td data-label="Status">
                                        ${isEditing ? `
                                            <div class="status-switch">
                                                <button class="status-btn present history-status-btn ${status === 'present' ? 'active' : ''}"
                                                        data-action="his-status"
                                                        data-record-id="${esc(record.id)}"
                                                        data-student-id="${esc(st.id)}"
                                                        data-status="present">
                                                    <i class="fas fa-check"></i> Present
                                                </button>
                                                <button class="status-btn absent history-status-btn ${status === 'absent' ? 'active' : ''}"
                                                        data-action="his-status"
                                                        data-record-id="${esc(record.id)}"
                                                        data-student-id="${esc(st.id)}"
                                                        data-status="absent">
                                                    <i class="fas fa-times"></i> Absent
                                                </button>
                                            </div>`
                                            : `<span class="status-badge ${status}">${status === 'present' ? 'Present' : 'Absent'}</span>`
                                        }
                                    </td>
                                </tr>`;
                            }).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="history-footer">${footerText}</div>
            ${isEditing ? `
                <div class="history-edit-actions">
                    <button class="btn-his-cancel" data-action="cancel-edit">Cancel</button>
                    <button class="btn-his-save" data-action="save-edit" data-record-id="${esc(record.id)}">Save Changes</button>
                </div>` : ''}
        </div>`;
    }).join('');
}

function searchHistory() {
    const year = $('historyYear').value;
    const group = $('historyGroup').value;
    const section = $('historySection').value;
    const date = $('historyDate').value || TODAY_ISO;

    state.history.editingRecordId = null;
    state.history.statusMap = new Map();

    state.history.records = state.records
        .filter(r => r.year === year && r.group === group && r.section === section && r.date === date)
        .sort((a, b) => Number(a.period) - Number(b.period));

    renderHistoryRecords();
}

$('historySearchBtn').addEventListener('click', searchHistory);

$('historyResultsWrap').addEventListener('click', e => {
    const target = e.target.closest('button');
    if (!target) return;

    const action = target.dataset.action;

    if (action === 'edit') {
        const recordId = target.dataset.recordId;
        const record = state.records.find(r => r.id === recordId);
        if (!record || record.teacherId !== CURRENT_TEACHER.id) return;

        state.history.editingRecordId = recordId;
        state.history.statusMap = getRecordStatusMap(record);
        renderHistoryRecords();
        return;
    }

    if (action === 'his-status') {
        const recordId = target.dataset.recordId;
        if (state.history.editingRecordId !== recordId) return;
        const sid = target.dataset.studentId;
        const status = target.dataset.status === 'absent' ? 'absent' : 'present';
        state.history.statusMap.set(sid, status);
        renderHistoryRecords();
        return;
    }

    if (action === 'cancel-edit') {
        state.history.editingRecordId = null;
        state.history.statusMap = new Map();
        renderHistoryRecords();
        return;
    }

    if (action === 'save-edit') {
        const recordId = target.dataset.recordId;
        const record = state.records.find(r => r.id === recordId);
        if (!record || record.teacherId !== CURRENT_TEACHER.id) return;

        const students = getClassStudents(record.year, record.group, record.section);
        record.statuses = students.map(st => ({
            studentId: st.id,
            status: state.history.statusMap.get(st.id) === 'absent' ? 'absent' : 'present',
        }));
        record.updatedAt = new Date().toISOString();
        saveAttendanceRecords(state.records);

        state.history.editingRecordId = null;
        state.history.statusMap = new Map();
        showToast('Attendance history updated.');
        searchHistory();
    }
});

/* -----------------------------------------
   Report
----------------------------------------- */
function attendancePctClass(pct) {
    if (pct >= 90) return 'pct-green';
    if (pct >= 75) return 'pct-blue';
    if (pct >= 60) return 'pct-yellow';
    return 'pct-red';
}

function renderReportRows(rows) {
    const tbody = $('reportTbody');
    tbody.innerHTML = rows.map(row => `
        <tr>
            <td data-label="Roll"><code class="roll-chip">${esc(row.roll)}</code></td>
            <td data-label="Student Name"><span class="att-stu-name">${esc(row.name)}</span></td>
            <td data-label="Total Classes">${row.totalClasses}</td>
            <td data-label="Present">${row.present}</td>
            <td data-label="Absent">${row.absent}</td>
            <td data-label="Attendance %"><span class="pct-badge ${attendancePctClass(row.percent)}">${row.percent.toFixed(2)}%</span></td>
        </tr>
    `).join('');
}

function renderReportSummary(rows, totalClasses) {
    const avg = rows.length ? rows.reduce((sum, r) => sum + r.percent, 0) / rows.length : 0;
    const mostAbsent = [...rows].sort((a, b) => b.absent - a.absent || a.name.localeCompare(b.name))[0];
    const perfect = rows.filter(r => r.totalClasses > 0 && r.absent === 0).length;

    $('sumTotalClasses').textContent = totalClasses;
    $('sumAvgAttendance').textContent = `${avg.toFixed(2)}%`;
    $('sumMostAbsent').textContent = mostAbsent ? `${mostAbsent.name} (${mostAbsent.absent})` : 'None';
    $('sumPerfectCount').textContent = perfect;
}

function applyReportSearch() {
    const q = $('reportSearchInput').value.toLowerCase().trim();
    const rows = !q
        ? state.report.allRows
        : state.report.allRows.filter(r =>
            r.name.toLowerCase().includes(q) || r.roll.toLowerCase().includes(q));
    renderReportRows(rows);
}

function generateReport() {
    const year = $('reportYear').value;
    const group = $('reportGroup').value;
    const section = $('reportSection').value;
    const fromDate = $('reportFromDate').value;
    const toDate = $('reportToDate').value;

    if (!year || !group || !section || !fromDate || !toDate) {
        showToast('Please complete all report filters.');
        return;
    }
    if (fromDate > toDate) {
        showToast('From date cannot be after To date.');
        return;
    }

    const records = state.records
        .filter(r =>
            r.year === year &&
            r.group === group &&
            r.section === section &&
            r.date >= fromDate &&
            r.date <= toDate
        )
        .sort((a, b) => (a.date === b.date ? Number(a.period) - Number(b.period) : a.date.localeCompare(b.date)));

    $('reportCard').style.display = 'block';
    $('reportSearchInput').value = '';

    if (!records.length) {
        state.report.allRows = [];
        $('reportTbody').innerHTML = '';
        $('reportEmpty').style.display = 'block';
        renderReportSummary([], 0);
        return;
    }

    const students = getClassStudents(year, group, section);
    const totalClasses = records.length;

    const rows = students.map(st => {
        let present = 0;
        records.forEach(rec => {
            const status = (rec.statuses.find(s => s.studentId === st.id) || {}).status || 'absent';
            if (status === 'present') present += 1;
        });
        const absent = totalClasses - present;
        const percent = totalClasses ? (present / totalClasses) * 100 : 0;
        return {
            id: st.id,
            roll: st.roll,
            name: st.name,
            totalClasses,
            present,
            absent,
            percent,
        };
    }).sort((a, b) => a.percent - b.percent || a.name.localeCompare(b.name));

    state.report.allRows = rows;
    state.report.context = { year, group, section, fromDate, toDate };

    $('reportEmpty').style.display = rows.length ? 'none' : 'block';
    renderReportRows(rows);
    renderReportSummary(rows, totalClasses);

    $('reportPrintHeader').innerHTML = `
        <h2 style="font-size:18px;margin-bottom:4px;">PMDC Attendance Report</h2>
        <div style="font-size:13px;">
            ${yearLabel(year)} | ${groupLabel(group)} | Section ${section} | ${formatHumanDate(fromDate)} - ${formatHumanDate(toDate)}
        </div>
    `;
}

$('generateReportBtn').addEventListener('click', generateReport);
$('reportSearchInput').addEventListener('input', applyReportSearch);

$('printReportBtn').addEventListener('click', () => {
    if (!$('reportCard').style.display || $('reportCard').style.display === 'none') {
        showToast('Generate a report first.');
        return;
    }
    window.print();
});

$('exportPdfBtn').addEventListener('click', () => {
    if (!$('reportCard').style.display || $('reportCard').style.display === 'none') {
        showToast('Generate a report first.');
        return;
    }
    showToast('Use "Save as PDF" in the print dialog.');
    window.print();
});

/* -----------------------------------------
   Toast
----------------------------------------- */
function showToast(msg) {
    $('toastMsg').textContent = msg;
    $('toast').classList.add('show');
    setTimeout(() => $('toast').classList.remove('show'), 2800);
}

/* -----------------------------------------
   Auth & Context Initialization
----------------------------------------- */
async function loadTeacherContext() {
    try {
        const res = await fetch('../api/get_teacher_context.php');
        const data = await res.json();
        
        if (!data.ok) {
            window.location.href = '../portal-login.php';
            return;
        }

        // Update teacher name in current state
        CURRENT_TEACHER.name = data.teacher_name;

        const allowedClasses = data.classes || [];
        const allowedGroups = new Set();
        const allowedYears = new Set();
        
        allowedClasses.forEach(c => {
            const name = c.name.toLowerCase();
            if (name.includes('science')) allowedGroups.add('science');
            if (name.includes('business') || name.includes('commerce')) allowedGroups.add('commerce');
            if (name.includes('humanities')) allowedGroups.add('humanities');
            
            if (name.includes('1st') || name.includes('xi')) allowedYears.add('xi');
            if (name.includes('2nd') || name.includes('xii')) allowedYears.add('xii');
        });

        if (allowedGroups.size > 0 || allowedYears.size > 0) {
            const filteredStudents = state.students.filter(s => 
                (allowedGroups.size === 0 || allowedGroups.has(s.group)) && 
                (allowedYears.size === 0 || allowedYears.has(s.year))
            );
            state.students = filteredStudents;
        } else if (data.assignments && data.assignments.length === 0) {
            state.students = [];
        }

        setTodayUI();
        initSectionDropdowns();
        openTab('take');
    } catch (e) {
        console.error('Failed to load teacher context', e);
        setTodayUI();
        initSectionDropdowns();
        openTab('take');
    }
}

/* -----------------------------------------
   Init
----------------------------------------- */
loadTeacherContext();

