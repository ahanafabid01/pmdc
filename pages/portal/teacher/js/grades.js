/**
 * grades.js — Teacher Results Management (Dynamic)
 * Completely driven by get_teacher_context.php
 * No hardcoded students or programs.
 */
'use strict';

/* ══ Globals ═══════════════════════════════════════════════════ */
let CTX         = null;
let allStudents = [];
let filtered    = [];
let activeTab   = 'all';
let currentPage = 1;
const PAGE_SIZE = 15;

/* ══ Helpers ════════════════════════════════════════════════════ */
const $ = id => document.getElementById(id);
const esc = s => String(s ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');

function showToast(msg, err = false) {
    const t = $('toast');
    $('toastMsg').textContent = msg;
    t.className = `toast show${err ? ' error' : ''}`;
    setTimeout(() => t.classList.remove('show'), 3200);
}

/* ══ Sidebar ════════════════════════════════════════════════════ */
(function () {
    const sb = $('sidebar'), ov = $('sidebarOverlay');
    const open  = () => { sb.classList.add('open'); ov?.classList.add('active'); };
    const close = () => { sb.classList.remove('open'); ov?.classList.remove('active'); };
    $('menuToggle')?.addEventListener('click', open);
    $('closeSidebar')?.addEventListener('click', close);
    ov?.addEventListener('click', close);
})();

/* ══ Grade Calculation Rules ════════════════════════════════════ */
function markToGrade(mark, fullMarks = 100) {
    if (mark === null || mark === undefined || mark === '') return null;
    const pct = (Number(mark) / fullMarks) * 100;
    if (pct >= 80) return { letter:'A+', gp:5.00, color:'#15803d', bg:'#f0fdf4' };
    if (pct >= 70) return { letter:'A',  gp:4.00, color:'#0f766e', bg:'#f0fdfa' };
    if (pct >= 60) return { letter:'A-', gp:3.50, color:'#1d4ed8', bg:'#eff6ff' };
    if (pct >= 50) return { letter:'B',  gp:3.00, color:'#b45309', bg:'#fffbeb' };
    if (pct >= 40) return { letter:'C',  gp:2.00, color:'#9a3412', bg:'#fff7ed' };
    if (pct >= 33) return { letter:'D',  gp:1.00, color:'#a21caf', bg:'#fdf4ff' };
    return              { letter:'F',  gp:0.00, color:'#b91c1c', bg:'#fef2f2' };
}

function gpaToLetter(gpa) {
    if (gpa === null) return null;
    if (gpa >= 5.00) return { letter:'A+', color:'#15803d', bg:'#f0fdf4' };
    if (gpa >= 4.00) return { letter:'A',  color:'#0f766e', bg:'#f0fdfa' };
    if (gpa >= 3.50) return { letter:'A-', color:'#1d4ed8', bg:'#eff6ff' };
    if (gpa >= 3.00) return { letter:'B',  color:'#b45309', bg:'#fffbeb' };
    if (gpa >= 2.00) return { letter:'C',  color:'#9a3412', bg:'#fff7ed' };
    if (gpa >= 1.00) return { letter:'D',  color:'#a21caf', bg:'#fdf4ff' };
    return               { letter:'F',  color:'#b91c1c', bg:'#fef2f2' };
}

/* Mock single exam GPA for demonstration of UI — backend handles real calculation */
function mockExamGpa(student) {
    if (!student.mockGrades) {
        student.mockGrades = Math.random() > 0.3 ? (Math.random() * 2 + 3) : null; // 3.0 to 5.0 or null
    }
    return student.mockGrades;
}

/* ══ Building Dynamic UI from CTX ═══════════════════════════════ */

function buildTabsAndFilters() {
    const tabsWrap = $('gradesTabs');
    const programs = CTX.programs || [];
    
    // Add tabs for each program
    let tabsHtml = `<button class="grade-tab active" data-class="all">All Classes</button>`;
    programs.forEach(p => {
        tabsHtml += `<button class="grade-tab" data-class="${p.id}">${p.name}</button>`;
    });
    tabsWrap.innerHTML = tabsHtml;

    document.querySelectorAll('.grade-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.grade-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            activeTab = this.dataset.class;
            applyFilters();
        });
    });

    // Sessions
    const sessions = new Set(allStudents.map(s => s.session || '').filter(Boolean));
    const sessSel = $('sessionFilter');
    sessSel.innerHTML = '<option value="">All Sessions</option>' + 
        [...sessions].sort().map(s => `<option value="${s}">${s}</option>`).join('');

    // Update stats
    $('statTotalStudents').textContent = allStudents.length;
    $('statProgramCount').textContent = programs.length;
    
    const subs = new Set(CTX.subjects?.map(s => s.code));
    $('statSubjectCount').textContent = subs.size;

    const secs = new Set(allStudents.map(s => s.section).filter(Boolean));
    $('statSectionCount').textContent = secs.size;
}

/* ══ Rendering Table ════════════════════════════════════════════ */

function renderTable() {
    const start = (currentPage - 1) * PAGE_SIZE;
    const end   = Math.min(start + PAGE_SIZE, filtered.length);
    const page  = filtered.slice(start, end);

    const tbody = $('gradesTableBody');

    if (!filtered.length) {
        tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;padding:30px;color:#64748b;">No students match the current filters.</td></tr>`;
        $('gradeCount').textContent = `0 students`;
        $('gradeTableInfo').textContent = '';
        $('gradePagination').innerHTML = '';
        return;
    }

    tbody.innerHTML = page.map(s => {
        const prog = CTX.programs?.find(p => p.id === s.program_id) || { name: s.program_id || 'Unknown' };
        const gpa = mockExamGpa(s);
        const g = gpaToLetter(gpa);
        const hasMarks = gpa !== null;

        return `
        <tr>
            <td>
                <div style="font-weight:600;color:#0f2744;">${esc(s.name)}</div>
            </td>
            <td><code style="background:#f1f5f9;padding:2px 6px;border-radius:4px;font-family:monospace;font-size:.8rem;">${esc(s.roll)}</code></td>
            <td><span style="font-size:.8rem;color:#64748b;font-weight:600;">${esc(s.session || '—')}</span></td>
            <td><span style="font-size:.8rem;background:#eff6ff;color:#1d4ed8;padding:2px 8px;border-radius:12px;font-weight:700;">${esc(prog.name)}</span></td>
            <td style="text-align:center;font-weight:700;">${gpa !== null ? gpa.toFixed(2) : '<span style="color:#cbd5e1;">—</span>'}</td>
            <td style="text-align:center;">
                ${g 
                  ? `<span style="background:${g.bg};color:${g.color};padding:3px 8px;border-radius:6px;font-weight:700;font-size:.8rem;">${g.letter}</span>` 
                  : '<span style="color:#cbd5e1;">—</span>'}
            </td>
            <td>
                ${hasMarks
                    ? `<span style="color:#15803d;font-size:.75rem;font-weight:700;display:flex;align-items:center;gap:4px;"><i class="fas fa-check-circle"></i> Entered</span>`
                    : `<span style="color:#b45309;font-size:.75rem;font-weight:700;display:flex;align-items:center;gap:4px;"><i class="fas fa-hourglass-half"></i> Pending</span>`
                }
            </td>
            <td>
                <div style="display:flex;gap:6px;">
                    <button class="act-btn act-view" onclick="alert('View Result Sheet for ${esc(s.name)}')" style="width:28px;height:28px;border-radius:6px;border:none;background:#f1f5f9;color:#3b82f6;cursor:pointer;"><i class="fas fa-file-alt"></i></button>
                    <button class="act-btn act-edit" onclick="alert('Enter Marks for ${esc(s.name)}')" style="width:28px;height:28px;border-radius:6px;border:none;background:#f1f5f9;color:#64748b;cursor:pointer;"><i class="fas fa-edit"></i></button>
                </div>
            </td>
        </tr>`;
    }).join('');

    $('gradeCount').textContent = `${filtered.length} students`;
    $('gradeTableInfo').textContent = `Showing ${start + 1}–${end} of ${filtered.length} students`;
    renderPagination();
}

function renderPagination() {
    const totalPages = Math.ceil(filtered.length / PAGE_SIZE);
    const el = $('gradePagination');
    if (totalPages <= 1) { el.innerHTML = ''; return; }

    let html = `<button class="page-btn" onclick="goPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}><i class="fas fa-chevron-left"></i></button>`;
    for (let p = 1; p <= totalPages; p++) {
        if (p === 1 || p === totalPages || Math.abs(p - currentPage) <= 1)
            html += `<button class="page-btn ${p === currentPage ? 'active' : ''}" onclick="goPage(${p})">${p}</button>`;
        else if (Math.abs(p - currentPage) === 2)
            html += `<span class="page-ellipsis">…</span>`;
    }
    html += `<button class="page-btn" onclick="goPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}><i class="fas fa-chevron-right"></i></button>`;
    el.innerHTML = html;
}

window.goPage = p => {
    const total = Math.ceil(filtered.length / PAGE_SIZE);
    if (p < 1 || p > total) return;
    currentPage = p;
    renderTable();
};

/* ══ Filters ════════════════════════════════════════════════════ */
function applyFilters() {
    const q     = ($('gradeSearch')?.value || '').toLowerCase().trim();
    const sessF = $('sessionFilter')?.value || '';
    const grdF  = $('gradeFilter')?.value || '';

    filtered = allStudents.filter(s => {
        // Tab filter
        if (activeTab !== 'all' && s.program_id !== activeTab) return false;
        // Session filter
        if (sessF && s.session !== sessF) return false;
        // Search
        if (q && !s.name.toLowerCase().includes(q) && !(s.roll || '').toLowerCase().includes(q)) return false;
        // Grade filter
        if (grdF) {
            const g = gpaToLetter(mockExamGpa(s));
            if (!g || g.letter !== grdF) return false;
        }
        return true;
    });

    currentPage = 1;
    renderTable();
}

$('gradeSearch')?.addEventListener('input', applyFilters);
$('sessionFilter')?.addEventListener('change', applyFilters);
$('gradeFilter')?.addEventListener('change', applyFilters);

/* ══ INIT ═══════════════════════════════════════════════════════ */
async function loadTeacherContext() {
    try {
        const res  = await fetch('../api/get_teacher_context.php');
        const data = await res.json();

        if (!data.ok) { window.location.href = '../portal-login.php'; return; }

        CTX = data;
        allStudents = data.students || [];
        filtered = [...allStudents];

        // Header / Sidebar Identity
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

        // Hide loading
        $('gradesLoadingBanner').style.display = 'none';

        if (!data.programs?.length || !allStudents.length) {
            $('gradesEmptyState').style.display = 'flex';
            if (!data.programs?.length) $('gradesNoPrograms').style.display = 'flex';
            return;
        }

        // Show UI
        $('gradesStatsGrid').style.display = 'grid';
        $('gradesFilterCard').style.display = 'block';
        $('gradebookCard').style.display = 'block';

        buildTabsAndFilters();
        renderTable();

    } catch (e) {
        console.error('Context load failed', e);
        $('gradesLoadingBanner').innerHTML = '<i class="fas fa-exclamation-circle"></i><span>Failed to load context. Please refresh.</span>';
    }
}

loadTeacherContext();
