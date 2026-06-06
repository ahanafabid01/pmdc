/**
 * dashboard.js — Teacher Portal Dashboard
 * Fully dynamic — all data from the teacher context API
 */
'use strict';

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
    return `<div style="text-align:center;padding:40px 20px;color:#94a3b8;">
        <i class="fas ${icon}" style="font-size:2rem;margin-bottom:12px;display:block;"></i>
        <div style="font-weight:700;font-size:.95rem;color:#64748b;margin-bottom:4px;">${title}</div>
        <div style="font-size:.8rem;">${sub}</div>
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

/* ── Render programs ─────────────────────────────────────── */
function renderPrograms(programs, subjects) {
    const el = document.getElementById('programsList');
    if (!el) return;

    if (!programs.length) {
        el.innerHTML = emptyState('fa-folder-open', 'No Programs Assigned', 'Contact admin to assign classes.');
        return;
    }

    el.innerHTML = programs.map(p => {
        const color = p.accent_color || '#2563eb';
        const typeBadge = p.type === 'hsc'
            ? '<span style="background:#dbeafe;color:#1e40af;padding:2px 8px;border-radius:20px;font-size:.7rem;font-weight:700;">HSC</span>'
            : '<span style="background:#f3e8ff;color:#6b21a8;padding:2px 8px;border-radius:20px;font-size:.7rem;font-weight:700;">DEGREE</span>';
        return `<div class="program-item" style="display:flex;align-items:center;gap:12px;padding:14px 0;border-bottom:1px solid var(--border);">
            <div style="width:42px;height:42px;border-radius:10px;background:${color}20;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-book-open" style="color:${color};font-size:1rem;"></i>
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-weight:700;font-size:.88rem;color:var(--text);margin-bottom:3px;">${p.name}</div>
                <div style="display:flex;gap:6px;align-items:center;">${typeBadge}</div>
            </div>
        </div>`;
    }).join('');
}

/* ── Render subjects ─────────────────────────────────────── */
function renderSubjects(subjects) {
    const el = document.getElementById('subjectsList');
    if (!el) return;

    if (!subjects.length) {
        el.innerHTML = emptyState('fa-book', 'No Subjects Assigned', '');
        return;
    }

    el.innerHTML = subjects.map((s, i) => {
        const colors = ['#dbeafe','#f3e8ff','#dcfce7','#fef3c7','#fee2e2'];
        const textColors = ['#1e40af','#6b21a8','#166534','#92400e','#991b1b'];
        return `<div style="display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid var(--border);">
            <div style="width:32px;height:32px;border-radius:8px;background:${colors[i%5]};display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.75rem;color:${textColors[i%5]};flex-shrink:0;">${i+1}</div>
            <div style="font-size:.875rem;color:var(--text);font-weight:600;">${s}</div>
        </div>`;
    }).join('');
}

/* ── Render student group distribution ───────────────────── */
function renderGroupDistribution(students) {
    const el = document.getElementById('groupDistChart');
    if (!el) return;

    const groups = {};
    students.forEach(s => {
        const g = s.group || 'unknown';
        groups[g] = (groups[g] || 0) + 1;
    });

    const total = students.length;
    if (!total) {
        el.innerHTML = emptyState('fa-users', 'No Students Enrolled', 'Students will appear once registered.');
        return;
    }

    const colors = { science:'#3b82f6', humanities:'#8b5cf6', commerce:'#10b981', business:'#f59e0b', ba:'#ec4899', bmt:'#f97316', bsc:'#0ea5e9', bss:'#14b8a6' };
    el.innerHTML = Object.entries(groups).map(([g, count]) => {
        const pct = Math.round((count/total)*100);
        const color = colors[g.toLowerCase()] || '#64748b';
        return `<div style="margin-bottom:14px;">
            <div style="display:flex;justify-content:space-between;font-size:.8rem;margin-bottom:5px;">
                <span style="font-weight:700;text-transform:capitalize;">${g}</span>
                <span style="color:var(--muted);">${count} students (${pct}%)</span>
            </div>
            <div style="height:7px;background:#f1f5f9;border-radius:10px;overflow:hidden;">
                <div style="height:100%;width:${pct}%;background:${color};border-radius:10px;transition:width .6s ease;"></div>
            </div>
        </div>`;
    }).join('');
}

/* ── Render sections breakdown ───────────────────────────── */
function renderSections(students) {
    const el = document.getElementById('sectionsBreakdown');
    if (!el) return;

    const map = {};
    students.forEach(s => {
        const key = `${s.group} | ${s.year === 'xii' ? '2nd Year' : '1st Year'} | Sec ${s.section}`;
        map[key] = (map[key] || 0) + 1;
    });

    if (!Object.keys(map).length) {
        el.innerHTML = emptyState('fa-layer-group', 'No Sections Yet', '');
        return;
    }

    el.innerHTML = Object.entries(map).map(([label, count]) =>
        `<div style="display:flex;justify-content:space-between;align-items:center;padding:9px 14px;background:var(--bg);border-radius:8px;margin-bottom:8px;font-size:.835rem;">
            <span style="font-weight:600;color:var(--text);text-transform:capitalize;">${label}</span>
            <span style="font-weight:800;color:var(--blue);">${count}</span>
        </div>`
    ).join('');
}

/* ── Render recent students ──────────────────────────────── */
function renderRecentStudents(students) {
    const el = document.getElementById('recentStudentsList');
    if (!el) return;

    if (!students.length) {
        el.innerHTML = emptyState('fa-user-graduate', 'No Students Yet', 'Students will appear once enrolled.');
        return;
    }

    const shown = students.slice(0, 8);
    el.innerHTML = shown.map(s => {
        const color = avatarColor(s.name);
        const ini   = initials(s.name);
        return `<div style="display:flex;align-items:center;gap:12px;padding:12px 0;border-bottom:1px solid var(--border);">
            <div style="width:38px;height:38px;border-radius:50%;background:${color};display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.8rem;color:#fff;flex-shrink:0;">${ini}</div>
            <div style="flex:1;min-width:0;">
                <div style="font-weight:700;font-size:.855rem;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${s.name}</div>
                <div style="font-size:.74rem;color:var(--muted);">Roll: ${s.roll} · ${s.group} · ${s.year === 'xii' ? '2nd Year' : '1st Year'}</div>
            </div>
        </div>`;
    }).join('');
}

/* ── Sidebar: show teacher info ──────────────────────────── */
function populateSidebar(ctx) {
    const nameEl = document.querySelector('.t-name');
    if (nameEl) nameEl.textContent = ctx.teacher_name;

    const roleEl = document.querySelector('.t-role');
    if (roleEl) roleEl.textContent = ctx.programs.length
        ? ctx.programs.map(p => p.name).join(', ')
        : 'No programs assigned';
}

/* ── Main init ────────────────────────────────────────────── */
async function loadTeacherContext() {
    try {
        const res  = await fetch('../api/get_teacher_context.php');
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

        // Unique sections
        const sections = new Set(students.map(s => `${s.group}|${s.year}|${s.section}`));
        animateCount(document.getElementById('statSections'), sections.size);

        /* Sidebar */
        populateSidebar(data);

        /* Sections */
        const el1 = document.getElementById('statStudentsEl');
        if (el1) el1.textContent = students.length;

        /* Render panels */
        renderPrograms(programs, subjects);
        renderSubjects(subjects);
        renderGroupDistribution(students);
        renderSections(students);
        renderRecentStudents(students);

        // Session label
        const sessEl = document.getElementById('currentSession');
        if (sessEl && students.length) {
            const sessions = [...new Set(students.map(s => s.session).filter(Boolean))];
            sessEl.textContent = sessions.join(', ') || '—';
        }

    } catch(e) {
        console.error('Failed to load teacher context:', e);
        // Show error state on main stats
        ['statStudents','statSubjects','statPrograms','statSections'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = '—';
        });
    }
}

loadTeacherContext();
