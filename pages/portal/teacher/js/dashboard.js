/**
 * dashboard.js — Teacher Portal Dashboard
 * Phulpur Mohila Degree College
 */

'use strict';

/* ═══════════════════════════════════════════
   SIDEBAR TOGGLE (mobile)
═══════════════════════════════════════════ */
const sidebar  = document.getElementById('sidebar');
const menuBtn  = document.getElementById('menuToggle');
const closeBtn = document.getElementById('closeSidebar');

menuBtn?.addEventListener('click',  () => sidebar.classList.add('open'));
closeBtn?.addEventListener('click', () => sidebar.classList.remove('open'));
document.addEventListener('click', e => {
    if (sidebar.classList.contains('open') &&
        !sidebar.contains(e.target) &&
        e.target !== menuBtn) {
        sidebar.classList.remove('open');
    }
});

/* ═══════════════════════════════════════════
   MOCK DATA — mirrors students.js & grades.js
═══════════════════════════════════════════ */
const AVATAR_COLORS = [
    '#276749','#2c5282','#7b341e','#702459','#1a365d',
    '#0ea5e9','#f97316','#14b8a6','#ec4899','#6366f1'
];

const firstNames = [
    'Fatema','Rashida','Nusrat','Morjina','Shirin','Taslima','Sultana','Afroza',
    'Monika','Roksana','Dilruba','Nasrin','Mithila','Shaila','Farida','Rina',
    'Tania','Jannat','Sonia','Rima',
];
const lastNames = [
    'Begum','Akter','Khanam','Islam','Khatun','Parvin','Siddiqua','Rashid',
    'Sultana','Banu','Hossain','Rahman','Molla','Sarker','Sheikh','Mondol',
];

const groups   = ['science','commerce','humanities'];
const years    = ['xi','xii'];
const sections = ['A','B','C'];
const SESSIONS = ['2022–2023','2023–2024','2024–2025','2025–2026'];

const groupMeta = {
    science:    { label:'Science',    cls:'gc-sci' },
    commerce:   { label:'Business',   cls:'gc-com' },
    humanities: { label:'Humanities', cls:'gc-hum' },
};
const yearMeta = {
    xi:  { label:'1st Year', cls:'' },
    xii: { label:'2nd Year', cls:'xii' },
};
const EXAMS = {
    xi:  ['Half-Yearly Exam','Year-Change Exam'],
    xii: ['Pre-Test Exam','Test Exam'],
};

function rnd(min, max) { return Math.floor(Math.random() * (max - min + 1)) + min; }

function gpaToLetter(gpa) {
    if (gpa >= 5.0) return { letter:'A+', color:'#15803d', bg:'#f0fdf4' };
    if (gpa >= 4.0) return { letter:'A',  color:'#0e7490', bg:'#ecfeff' };
    if (gpa >= 3.5) return { letter:'A-', color:'#1d4ed8', bg:'#eff6ff' };
    if (gpa >= 3.0) return { letter:'B',  color:'#1e40af', bg:'#dbeafe' };
    if (gpa >= 2.0) return { letter:'C',  color:'#92400e', bg:'#fffbeb' };
    if (gpa >= 1.0) return { letter:'D',  color:'#7b341e', bg:'#fef3c7' };
    return               { letter:'F',  color:'#b91c1c', bg:'#fef2f2' };
}

function markToGP(mark) {
    if (mark >= 80) return 5.00;
    if (mark >= 70) return 4.00;
    if (mark >= 60) return 3.50;
    if (mark >= 50) return 3.00;
    if (mark >= 40) return 2.00;
    if (mark >= 33) return 1.00;
    return 0.00;
}

function calcGPA(subjects) {
    if (!subjects || !subjects.length) return null;
    const total = subjects.reduce((s, m) => s + markToGP(m), 0);
    return Math.round((total / subjects.length) * 100) / 100;
}

// Generate 120 students (consistent with students.js / grades.js)
const allStudents = Array.from({ length: 120 }, (_, i) => {
    const fn    = firstNames[i % firstNames.length];
    const ln    = lastNames[i % lastNames.length];
    const year  = years[i % 2];
    const group = groups[i % 3];
    const yrTag = year === 'xii' ? 'XII' : 'XI';
    const roll  = `PMDC-${yrTag}-${String(i + 1).padStart(3, '0')}`;
    const sess  = SESSIONS[i % SESSIONS.length];

    const examResults = {};
    EXAMS[year].forEach((exam, ei) => {
        const hasMarks = (i + ei) % 4 !== 0;
        examResults[exam] = hasMarks
            ? { subjects: Array.from({ length: 9 }, () => rnd(33, 100)) }
            : null;
    });

    return {
        id:         `stu-${i + 1}`,
        name:       `${fn} ${ln}`,
        initials:   `${fn[0]}${ln[0]}`,
        roll, year, group, session: sess,
        section:    sections[i % 3],
        color:      AVATAR_COLORS[i % AVATAR_COLORS.length],
        examResults,
        addedAt:    Date.now() - (i * 43200000),
    };
});

/* ═══════════════════════════════════════════
   STATS COMPUTATION
═══════════════════════════════════════════ */
const totalStudents = allStudents.length;
let resultsEntered = 0, resultsPending = 0;

allStudents.forEach(s => {
    EXAMS[s.year].forEach(exam => {
        if (s.examResults[exam]) resultsEntered++;
        else                     resultsPending++;
    });
});

// Group counts
const groupCounts = { science: 0, commerce: 0, humanities: 0 };
allStudents.forEach(s => groupCounts[s.group]++);

// Year counts
const yearCounts = { xi: 0, xii: 0 };
allStudents.forEach(s => yearCounts[s.year]++);

// Session counts
const sessionCounts = {};
SESSIONS.forEach(sess => sessionCounts[sess] = 0);
allStudents.forEach(s => { if (sessionCounts[s.session] !== undefined) sessionCounts[s.session]++; });

const uniqueSessions  = Object.keys(sessionCounts).filter(k => sessionCounts[k] > 0).sort();
const latestSession   = uniqueSessions[uniqueSessions.length - 1] || '—';

/* ═══════════════════════════════════════════
   POPULATE STAT CARDS
═══════════════════════════════════════════ */
const $ = id => document.getElementById(id);

$('statTotalStudents').textContent  = totalStudents;
$('statResultsEntered').textContent = resultsEntered;
$('statPending').textContent        = `${resultsPending} pending`;
$('bannerStudentCount').textContent = `${totalStudents} Students`;
$('bannerActiveSession').textContent= `Session ${latestSession}`;

$('statActiveSessions').textContent = uniqueSessions.length;
$('statLatestSession').textContent  = `Latest: ${latestSession}`;

$('statYearBreakdown').textContent  = yearCounts.xi;
$('statYearBreakdown2').textContent = `${yearCounts.xii} in 2nd Year`;

/* ═══════════════════════════════════════════
   GROUP BREAKDOWN MINI CARDS
═══════════════════════════════════════════ */
$('bdSci').textContent = groupCounts.science;
$('bdCom').textContent = groupCounts.commerce;
$('bdHum').textContent = groupCounts.humanities;

// Session breakdown mini cards
const sessCardIds = ['bdSess1','bdSess2','bdSess3','bdSess4'];
uniqueSessions.forEach((sess, i) => {
    const card = $(sessCardIds[i]);
    if (!card) return;
    card.innerHTML = `
        <div class="breakdown-title"><i class="fas fa-calendar" style="color:#2563eb;"></i> ${sess}</div>
        <div class="breakdown-val">${sessionCounts[sess]}</div>
        <div class="breakdown-sub">students</div>
    `;
});

/* ═══════════════════════════════════════════
   RECENT STUDENTS TABLE (last 8 added)
   Columns: Roll No | Name | Session | Year | Group
═══════════════════════════════════════════ */
const recentStudents = [...allStudents]
    .sort((a, b) => b.addedAt - a.addedAt)
    .slice(0, 8);

$('recentStudentsTbody').innerHTML = recentStudents.map(s => `
    <tr>
        <td><code class="roll-chip">${s.roll}</code></td>
        <td><span class="stu-nm">${s.name}</span></td>
        <td><span class="sess-chip">${s.session}</span></td>
        <td><span class="year-chip ${yearMeta[s.year].cls}">${yearMeta[s.year].label}</span></td>
        <td><span class="group-chip ${groupMeta[s.group].cls}">${groupMeta[s.group].label}</span></td>
    </tr>`).join('');

/* ═══════════════════════════════════════════
   RECENT RESULTS TABLE (first 8 with marks)
   Columns: Roll No | Name | Session | Exam | GPA | Grade
═══════════════════════════════════════════ */
const recentResults = [];
allStudents.forEach(s => {
    EXAMS[s.year].forEach(exam => {
        if (s.examResults[exam]) {
            const gpa = calcGPA(s.examResults[exam].subjects);
            recentResults.push({ s, exam, gpa });
        }
    });
});

const displayResults = recentResults.slice(0, 8);

$('recentResultsTbody').innerHTML = displayResults.map(({ s, exam, gpa }) => {
    const g = gpaToLetter(gpa);
    return `
    <tr>
        <td><code class="roll-chip">${s.roll}</code></td>
        <td><span class="stu-nm">${s.name}</span></td>
        <td><span class="sess-chip">${s.session}</span></td>
        <td><span class="exam-label">${exam}</span></td>
        <td><span class="gpa-num">${gpa.toFixed(2)}</span></td>
        <td><span class="grade-badge" style="background:${g.bg};color:${g.color};">${g.letter}</span></td>
    </tr>`;
}).join('');