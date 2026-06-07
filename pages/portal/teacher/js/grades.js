/**
 * grades.js — Teacher Results Management
 * Connects to get_teacher_context.php & api/grades.php
 */
'use strict';

/* ══ Globals ═══════════════════════════════════════════════════ */
let CTX = null;
let allStudents = [];
let currentStudents = [];
let isPublished = false;

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

/* ══ Building Dynamic UI from CTX ═══════════════════════════════ */
function buildFilters() {
    // Populate Exams
    const exams = CTX.exams || [];
    $('takeExam').innerHTML = '<option value="">Select Exam</option>' + 
        exams.map(e => `<option value="${e.id}">${e.name} (${e.year})</option>`).join('');

    // Populate Programs
    const programs = CTX.programs || [];
    $('takeProgram').innerHTML = '<option value="">Select Program</option>' + 
        programs.map(p => `<option value="${p.id}">${p.name}</option>`).join('');

    // Cascade Program -> Subject
    $('takeProgram').addEventListener('change', function() {
        const pid = this.value;
        const subjects = CTX.program_subjects?.[pid] || [];
        $('takeSubject').innerHTML = '<option value="">Select Subject</option>' + 
            subjects.map(s => `<option value="${s}">${s}</option>`).join('');
    });

    if (programs.length) {
        $('takeProgram').value = programs[0].id;
        $('takeProgram').dispatchEvent(new Event('change'));
    }

    $('statTotalStudents').textContent = allStudents.length;
    $('statProgramCount').textContent = programs.length;
    $('statSubjectCount').textContent = CTX.subjects.length;
    
    let sections = new Set();
    Object.values(CTX.program_sections || {}).forEach(arr => arr.forEach(s => sections.add(s)));
    $('statSectionCount').textContent = sections.size;
}

function programMatchesStudent(progId, student) {
    const PROGRAM_GROUP_MAP = {
        'hsc-science':    ['science'],
        'hsc-humanities': ['humanities'],
        'hsc-business':   ['business', 'commerce', 'business studies'],
        'deg-ba':         ['ba', 'arts', 'ba'],
        'deg-bmt':        ['bmt', 'business management', 'bmt'],
        'deg-bsc':        ['bsc', 'science'],
        'deg-bss':        ['bss', 'social science']
    };
    const groups = PROGRAM_GROUP_MAP[progId] || [];
    const sg = (student.group || '').toLowerCase();
    return groups.some(g => sg === g);
}

/* ══ Load Students & Render Table ═══════════════════════════════ */
$('loadStudentsBtn').addEventListener('click', async () => {
    const examId = $('takeExam').value;
    const progId = $('takeProgram').value;
    const subject = $('takeSubject').value;

    if (!examId || !progId || !subject) {
        showToast("Please select Exam, Program, and Subject.", true);
        return;
    }

    // Filter students by program
    const students = allStudents.filter(s => programMatchesStudent(progId, s));
    if (!students.length) {
        showToast("No students found for this program.", true);
        return;
    }

    $('loadStudentsBtn').disabled = true;
    $('loadStudentsBtn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';

    try {
        // Fetch existing marks
        const res = await fetch(`api/grades.php?action=list&exam_id=${examId}&program_id=${progId}&subject_name=${encodeURIComponent(subject)}`);
        const data = await res.json();
        
        if (data.ok) {
            isPublished = data.is_published;
            const markMap = {};
            (data.records || []).forEach(r => markMap[r.student_id] = r.mark);

            currentStudents = students.map(s => ({
                ...s,
                mark: markMap[s.id] ?? ''
            })).sort((a,b) => String(a.roll).localeCompare(String(b.roll), undefined, {numeric: true}));

            renderGradebook();
            
            // Show gradebook
            $('gradebookCard').style.display = 'block';
            $('gradebookCard').scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            showToast(data.msg || "Failed to load marks.", true);
        }
    } catch (e) {
        console.error(e);
        showToast("Network error while loading marks.", true);
    } finally {
        $('loadStudentsBtn').disabled = false;
        $('loadStudentsBtn').innerHTML = '<i class="fas fa-users"></i> Load Students';
    }
});

function renderGradebook() {
    const tbody = $('gradesTableBody');
    const fullMarks = Number($('takeMaxMarks').value) || 100;
    
    // Inject Save Draft button if not there
    let actionsWrap = document.querySelector('.gradebook-header-actions');
    actionsWrap.innerHTML = `
        <button class="btn-att-primary" id="saveDraftBtn" style="width:auto; margin-top:0; padding:8px 12px; margin-right:8px; background: #475569;">
            <i class="fas fa-save"></i> Save Draft
        </button>
        <button class="btn-publish" id="publishBtn2" ${isPublished ? 'disabled' : ''}>
            <i class="fas fa-paper-plane"></i> ${isPublished ? 'Published' : 'Publish'}
        </button>
    `;

    // Bind listeners immediately
    $('saveDraftBtn').addEventListener('click', () => submitMarks('save'));
    $('publishBtn2').addEventListener('click', attemptPublish);

    // Top page publish btn
    $('publishBtn').style.display = isPublished ? 'none' : 'inline-flex';
    $('publishBtn').onclick = attemptPublish;

    let html = '';
    currentStudents.forEach((st, i) => {
        const gradeInfo = markToGrade(st.mark, fullMarks);
        const gpHtml = gradeInfo ? `<span style="font-weight:700;color:${gradeInfo.color}">${gradeInfo.gp.toFixed(2)}</span>` : '-';
        const lgHtml = gradeInfo ? `<span class="badge" style="background:${gradeInfo.bg};color:${gradeInfo.color}">${gradeInfo.letter}</span>` : '-';
        
        html += `
            <tr>
                <td>${i+1}</td>
                <td>
                    <div style="font-weight:600; color:#1e293b;">${esc(st.name)}</div>
                    <div style="font-size:0.75rem; color:#64748b;">Sec ${esc(st.section?.toUpperCase() || 'A')}</div>
                </td>
                <td><code class="roll-chip">${esc(st.roll)}</code></td>
                <td>
                    <input type="number" class="mark-input" data-id="${st.id}" value="${st.mark !== null ? st.mark : ''}" 
                           min="0" max="${fullMarks}" ${isPublished ? 'disabled' : ''} 
                           style="width: 70px; padding: 6px; border: 1px solid #cbd5e1; border-radius: 6px; text-align: center;">
                </td>
                <td id="gp_${st.id}">${gpHtml}</td>
                <td id="lg_${st.id}">${lgHtml}</td>
            </tr>
        `;
    });

    tbody.innerHTML = html;
    $('gradeCount').textContent = `${currentStudents.length} students`;
    $('gradeTableInfo').textContent = isPublished ? "Marks are published and locked." : "Draft mode - don't forget to save!";

    // Live update GPA
    document.querySelectorAll('.mark-input').forEach(inp => {
        inp.addEventListener('input', function() {
            const sid = this.dataset.id;
            const mark = this.value;
            const s = currentStudents.find(x => String(x.id) === sid);
            if (s) s.mark = mark;

            const gi = markToGrade(mark, fullMarks);
            $(`gp_${sid}`).innerHTML = gi ? `<span style="font-weight:700;color:${gi.color}">${gi.gp.toFixed(2)}</span>` : '-';
            $(`lg_${sid}`).innerHTML = gi ? `<span class="badge" style="background:${gi.bg};color:${gi.color}">${gi.letter}</span>` : '-';
        });
    });
}

function attemptPublish() {
    if (isPublished) return;
    const subject = $('takeSubject').value;
    if (!subject) return;
    $('publishClassName').textContent = subject;
    $('publishModal').classList.add('active');
}

$('confirmPublish').addEventListener('click', () => {
    $('publishModal').classList.remove('active');
    submitMarks('publish');
});

$('closePublishModal').addEventListener('click', () => $('publishModal').classList.remove('active'));
$('cancelPublish').addEventListener('click', () => $('publishModal').classList.remove('active'));

async function submitMarks(actionType) {
    if (isPublished) return;

    const examId = $('takeExam').value;
    const progId = $('takeProgram').value;
    const subject = $('takeSubject').value;

    const marksPayload = currentStudents.map(s => ({
        student_id: s.id,
        mark: s.mark
    }));

    const btn = (actionType === 'publish') ? $('publishBtn2') : $('saveDraftBtn');
    const oldText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    btn.disabled = true;

    try {
        const res = await fetch('api/grades.php?action=' + actionType, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                exam_id: examId,
                program_id: progId,
                subject_name: subject,
                marks: marksPayload
            })
        });
        const data = await res.json();
        
        if (data.ok) {
            showToast(data.msg);
            if (actionType === 'publish') {
                isPublished = true;
                renderGradebook(); // Will disable all inputs
            }
        } else {
            showToast(data.msg, true);
        }
    } catch (e) {
        console.error(e);
        showToast("Network Error", true);
    } finally {
        if (!isPublished) {
            btn.disabled = false;
            btn.innerHTML = oldText;
        }
    }
}

/* ══ INIT ═══════════════════════════════════════════════════════ */
async function loadTeacherContext() {
    try {
        const res  = await fetch('../api/get_teacher_context.php');
        const data = await res.json();
        if (data.ok) {
            CTX = data;
            allStudents = data.students || [];

            // Update header
            document.querySelectorAll('.t-name').forEach(el => el.textContent = data.teacher_name);
            document.querySelectorAll('.t-role').forEach(el => el.textContent = 'Teacher (' + (data.assignments.length ? 'Assigned' : 'No subjects') + ')');
            const initials = data.teacher_name.substring(0, 2).toUpperCase();
            $('sidebarAvatar').textContent = initials;
            $('headerAvatar').src = `https://ui-avatars.com/api/?name=${encodeURIComponent(data.teacher_name)}&background=2563eb&color=fff`;

            if (data.programs && data.programs.length > 0) {
                $('gradesFilterCard').style.display = 'block';
                $('gradesStatsGrid').style.display  = 'grid';
                buildFilters();
            } else {
                $('gradesNoPrograms').style.display = 'flex';
            }
        } else {
            throw new Error(data.msg);
        }
    } catch (e) {
        console.error('Context load failed', e);
        $('gradesLoadingBanner').innerHTML = '<i class="fas fa-exclamation-circle"></i><span>Failed to load context. Please refresh.</span>';
    } finally {
        const banner = $('gradesLoadingBanner');
        if (CTX && CTX.ok) banner.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', loadTeacherContext);
