/**
 * dashboard.js — Teacher Portal Dashboard
 * Fully dynamic — all data from the teacher context API
 */
'use strict';

/* ── Set today's date immediately (no API wait) ──────────── */
(function() {
    const now = new Date();
    const dateStr = now.toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
    const el = document.getElementById('todayDateBanner');
    if (el) el.textContent = dateStr;
})();

/* ── Sidebar ─────────────────────────────────────────────── */
const sidebar  = document.getElementById('sidebar');
const menuBtn  = document.getElementById('menuToggle');
const closeBtn = document.getElementById('closeSidebar');
menuBtn?.addEventListener('click',  () => sidebar.classList.add('open'));
closeBtn?.addEventListener('click', () => sidebar.classList.remove('open'));
document.addEventListener('click', e => {
    if (sidebar.classList.contains('open') &&
        !sidebar.contains(e.target) && e.target !== menuBtn) {
        sidebar.classList.remove('open');
    }
});

/* ── GPA helpers ─────────────────────────────────────────── */
function gpaToLetter(gpa) {
    if (gpa >= 5.0) return { letter:'A+', color:'#15803d', bg:'#f0fdf4' };
    if (gpa >= 4.0) return { letter:'A',  color:'#0e7490', bg:'#ecfeff' };
    if (gpa >= 3.5) return { letter:'A-', color:'#1d4ed8', bg:'#eff6ff' };
    if (gpa >= 3.0) return { letter:'B',  color:'#1e40af', bg:'#dbeafe' };
    if (gpa >= 2.0) return { letter:'C',  color:'#92400e', bg:'#fffbeb' };
    if (gpa >= 1.0) return { letter:'D',  color:'#7b341e', bg:'#fef3c7' };
    return               { letter:'F',  color:'#b91c1c', bg:'#fef2f2' };
}

const AVATAR_COLORS = [
    '#276749','#2c5282','#7b341e','#702459','#1a365d',
    '#0ea5e9','#f97316','#14b8a6','#ec4899','#6366f1'
];

function avatarColor(name) {
    let h = 0;
    for (let i = 0; i < name.length; i++) h = (h * 31 + name.charCodeAt(i)) & 0xffffffff;
    return AVATAR_COLORS[Math.abs(h) % AVATAR_COLORS.length];
}

function initials(name) {
    return name.trim().split(/\s+/).map(w => w[0].toUpperCase()).slice(0,2).join('');
}

/* ── Empty state helper ──────────────────────────────────── */
function emptyState(icon, title, sub) {
    return `<div class="empty-state">
        <i class="fas ${icon}"></i>
        <div class="es-title">${title}</div>
        ${sub ? `<div class="es-sub">${sub}</div>` : ''}
    </div>`;
}

/* ── Stat counters ───────────────────────────────────────── */
function animateCount(el, target) {
    if (!el) return;
    const duration = 700;
    const start = Date.now();
    (function tick() {
        const progress = Math.min((Date.now() - start) / duration, 1);
        el.textContent = Math.round(progress * target);
        if (progress < 1) requestAnimationFrame(tick);
    })();
}

/* ── Render programs ───────────────────────────────────── */
function renderPrograms(programs) {
    const el = document.getElementById('programsList');
    if (!el) return;
    if (!programs.length) {
        el.innerHTML = emptyState('fa-folder-open', 'No Programs Assigned', 'Contact admin to assign classes.');
        return;
    }
    el.innerHTML = programs.map(p => {
        const color = p.accent_color || (p.type==='hsc' ? '#2563eb' : '#7c3aed');
        return `<div class="program-item">
            <div class="pi-icon" style="background:${color}18;">
                <i class="fas fa-book-open" style="color:${color};"></i>
            </div>
            <div style="flex:1;min-width:0;">
                <div class="pi-name">${p.name}</div>
                <span class="pi-badge ${p.type}">${p.type.toUpperCase()}</span>
            </div>
        </div>`;
    }).join('');
}

/* ── Render subjects ───────────────────────────────────── */
const SI_COLORS = [
    {bg:'#dbeafe',color:'#1e40af'},{bg:'#ede9fe',color:'#5b21b6'},
    {bg:'#dcfce7',color:'#166534'},{bg:'#fef3c7',color:'#92400e'},
    {bg:'#fee2e2',color:'#991b1b'},{bg:'#fce7f3',color:'#9d174d'},
];
function renderSubjects(subjects) {
    const el = document.getElementById('subjectsList');
    if (!el) return;
    if (!subjects.length) {
        el.innerHTML = emptyState('fa-book', 'No Subjects Assigned', '');
        return;
    }
    el.innerHTML = subjects.map((s, i) => {
        const c = SI_COLORS[i % SI_COLORS.length];
        return `<div class="subject-item">
            <div class="si-num" style="background:${c.bg};color:${c.color};">${i+1}</div>
            <div class="si-name">${s}</div>
        </div>`;
    }).join('');
}

/* ── Render group distribution ──────────────────────────── */
const GROUP_COLORS = {
    science:'#3b82f6', humanities:'#8b5cf6', commerce:'#10b981',
    business:'#f59e0b', ba:'#ec4899', bmt:'#f97316', bsc:'#0ea5e9', bss:'#14b8a6'
};
function renderGroupDistribution(students) {
    const el = document.getElementById('groupDistChart');
    if (!el) return;
    const groups = {};
    students.forEach(s => { const g = (s.group||'unknown').toLowerCase(); groups[g]=(groups[g]||0)+1; });
    const total = students.length;
    if (!total) {
        el.innerHTML = emptyState('fa-users', 'No Students Enrolled', 'Students will appear once registered.');
        return;
    }
    el.innerHTML = Object.entries(groups).map(([g, count]) => {
        const pct = Math.round((count/total)*100);
        const color = GROUP_COLORS[g] || '#64748b';
        return `<div class="dist-item">
            <div class="dist-label-row">
                <span class="dl-name">${g}</span>
                <span class="dl-count">${count} (${pct}%)</span>
            </div>
            <div class="dist-bar-bg">
                <div class="dist-bar-fill" style="width:${pct}%;background:${color};"></div>
            </div>
        </div>`;
    }).join('');
}

/* ── Render sections ─────────────────────────────────────── */
function renderSections(students) {
    const el = document.getElementById('sectionsBreakdown');
    if (!el) return;
    const map = {};
    students.forEach(s => {
        const yr = s.year === 'xii' ? '2nd Year' : s.year === 'xi' ? '1st Year' : `Year ${s.year}`;
        const key = `${s.group} · ${yr} · Sec ${s.section}`;
        map[key] = (map[key]||0)+1;
    });
    if (!Object.keys(map).length) {
        el.innerHTML = emptyState('fa-layer-group', 'No Sections Yet', '');
        return;
    }
    el.innerHTML = Object.entries(map).map(([label, count]) =>
        `<div class="section-row">
            <span class="sr-label">${label}</span>
            <span class="sr-count">${count}</span>
        </div>`
    ).join('');
}

/* ── Render recent students ─────────────────────────────── */
function renderRecentStudents(students) {
    const el = document.getElementById('recentStudentsList');
    if (!el) return;
    if (!students.length) {
        el.innerHTML = emptyState('fa-user-graduate', 'No Students Yet', 'Students will appear once enrolled.');
        return;
    }
    el.innerHTML = students.slice(0, 10).map(s => {
        const color = avatarColor(s.name);
        const ini   = initials(s.name);
        const yr = s.year === 'xii' ? '2nd Yr' : s.year === 'xi' ? '1st Yr' : `Yr ${s.year}`;
        return `<div class="student-row">
            <div class="stu-avatar" style="background:${color};">${ini}</div>
            <div class="stu-info">
                <div class="stu-name">${s.name}</div>
                <div class="stu-meta">${s.group} · ${yr} · Sec ${s.section||'A'}</div>
            </div>
            <code class="stu-roll">${s.roll}</code>
        </div>`;
    }).join('');
}

/* ── Sidebar: show teacher info ──────────────────────────── */
function populateSidebar(ctx) {
    // Update all teacher name placeholders
    document.querySelectorAll('.t-name').forEach(el => el.textContent = ctx.teacher_name);

    // Update role / programs
    document.querySelectorAll('.t-role').forEach(el => {
        el.textContent = ctx.programs.length
            ? ctx.programs.map(p => p.name).join(', ')
            : 'No programs assigned';
    });

    // Update sidebar avatar initials
    const avatarEl = document.getElementById('sidebarAvatar');
    if (avatarEl && ctx.teacher_name) {
        avatarEl.textContent = ctx.teacher_name.trim().split(/\s+/).map(w => w[0].toUpperCase()).slice(0,2).join('');
    }

    // Update header avatar image with real name
    const headerAvatar = document.getElementById('headerAvatar');
    if (headerAvatar && ctx.teacher_name) {
        const encoded = encodeURIComponent(ctx.teacher_name);
        headerAvatar.src = `https://ui-avatars.com/api/?name=${encoded}&background=2563eb&color=fff`;
        headerAvatar.alt = ctx.teacher_name;
    }
}

/* ── Main init ────────────────────────────────────────────── */
async function loadTeacherContext() {
    try {
        const res  = await fetch(window.BASE_URL + `/pages/portal/api/get_teacher_context.php`);
        const data = await res.json();

        if (!data.ok) {
            window.location.href = '../portal-login.php';
            return;
        }

        const students = data.students || [];
        const programs = data.programs || [];
        const subjects = data.subjects || [];

        /* Stats */
        animateCount(document.getElementById('statStudents'),  students.length);
        animateCount(document.getElementById('statSubjects'),  subjects.length);
        animateCount(document.getElementById('statPrograms'),  programs.length);

        const sections = new Set(students.map(s => `${s.group}|${s.year}|${s.section}`));
        animateCount(document.getElementById('statSections'), sections.size);

        /* Sidebar */
        populateSidebar(data);

        /* Banner chips */
        const bannerCount = document.getElementById('bannerStudentCount');
        if (bannerCount) bannerCount.textContent = `${students.length} Student${students.length !== 1 ? 's' : ''}`;

        const sessEl = document.getElementById('currentSession');
        if (sessEl) {
            const sess = [...new Set(students.map(s => s.session).filter(Boolean))];
            sessEl.textContent = sess.length ? sess[0] : new Date().getFullYear() + '–' + (new Date().getFullYear() + 1);
        }

        /* Render panels */
        renderPrograms(programs, subjects);
        renderSubjects(subjects);
        renderGroupDistribution(students);
        renderSections(students);
        renderRecentStudents(students);

    } catch(e) {
        console.error('Failed to load teacher context:', e);
        ['statStudents','statSubjects','statPrograms','statSections'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = '0';
        });
        // Show empty states
        ['programsList','subjectsList','groupDistChart','sectionsBreakdown','recentStudentsList'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.innerHTML = emptyState('fa-exclamation-circle', 'Could not load data', 'Please refresh the page.');
        });
    }
}

loadTeacherContext();
