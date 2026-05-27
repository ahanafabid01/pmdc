/**
 * teacher-grades.js
 * Bangladesh HSC Result Management System
 *
 * ══════════════════════════════════════════════════════════
 * RULES (Bangladesh National Curriculum Board):
 *
 *  HSC 1st Year (Class XI) — 2 completely independent exams:
 *    1. Half-Yearly Exam  (অর্ধ-বার্ষিক পরীক্ষা)
 *    2. Year-Change Exam  (বার্ষান্তর পরীক্ষা)
 *
 *  HSC 2nd Year (Class XII) — 2 completely independent exams:
 *    1. Pre-Test Exam     (প্রি-টেস্ট পরীক্ষা)
 *    2. Test Exam         (টেস্ট পরীক্ষা)
 *
 *  Each exam is FULLY INDEPENDENT:
 *    - No combined total across exams
 *    - No cross-exam GPA
 *    - Each exam produces its own separate GPA
 *
 *  GPA per exam = Sum of all subject GPs ÷ number of subjects
 *  (Bangladesh Board standard grading scale)
 * ══════════════════════════════════════════════════════════
 */

'use strict';

/* ═══════════════════════════════════════════════════════════════
   CONSTANTS
═══════════════════════════════════════════════════════════════ */

const AVATAR_COLORS = [
    '#276749','#2c5282','#7b341e','#702459','#1a365d',
    '#0ea5e9','#f97316','#14b8a6','#ec4899','#6366f1'
];

/** HSC Groups × Classes */
const CLASS_MAP = {
    sci_xi:  { label: 'Science — HSC 1st Year',       year: 'xi'  },
    sci_xii: { label: 'Science — HSC 2nd Year',       year: 'xii' },
    com_xi:  { label: 'Business Studies — HSC 1st Year', year: 'xi'  },
    com_xii: { label: 'Business Studies — HSC 2nd Year', year: 'xii' },
    hum_xi:  { label: 'Humanities — HSC 1st Year',    year: 'xi'  },
    hum_xii: { label: 'Humanities — HSC 2nd Year',    year: 'xii' },
};

/**
 * Exams per HSC year — each is INDEPENDENT.
 * Class XI  → Half-Yearly, Year-Change
 * Class XII → Pre-Test,    Test Exam
 */
const EXAMS = {
    xi: [
        { key: 'halfyearly',  label: 'Half-Yearly Exam',  labelBn: 'অর্ধ-বার্ষিক পরীক্ষা' },
        { key: 'yearchange',  label: 'Year-Change Exam',  labelBn: 'বার্ষান্তর পরীক্ষা'   },
    ],
    xii: [
        { key: 'pretest',     label: 'Pre-Test Exam',     labelBn: 'প্রি-টেস্ট পরীক্ষা'   },
        { key: 'test',        label: 'Test Exam',         labelBn: 'টেস্ট পরীক্ষা'         },
    ],
};

/**
 * Subjects per group.
 * fullMarks: total marks available for this subject.
 * Each subject is graded independently.
 */
const SUBJECTS = {
    sci_xi: [
        { code:'101', name:'Bangla 1st Paper',        fullMarks: 100 },
        { code:'102', name:'Bangla 2nd Paper',        fullMarks: 100 },
        { code:'107', name:'English 1st Paper',       fullMarks: 100 },
        { code:'108', name:'English 2nd Paper',       fullMarks: 100 },
        { code:'174', name:'Physics 1st Paper',       fullMarks: 100 },
        { code:'176', name:'Chemistry 1st Paper',     fullMarks: 100 },
        { code:'178', name:'Biology 1st Paper',       fullMarks: 100 },
        { code:'265', name:'Higher Math 1st Paper',   fullMarks: 100 },
        { code:'275', name:'ICT',                     fullMarks: 100 },
    ],
    sci_xii: [
        { code:'101', name:'Bangla 1st Paper',        fullMarks: 100 },
        { code:'102', name:'Bangla 2nd Paper',        fullMarks: 100 },
        { code:'107', name:'English 1st Paper',       fullMarks: 100 },
        { code:'108', name:'English 2nd Paper',       fullMarks: 100 },
        { code:'175', name:'Physics 2nd Paper',       fullMarks: 100 },
        { code:'177', name:'Chemistry 2nd Paper',     fullMarks: 100 },
        { code:'179', name:'Biology 2nd Paper',       fullMarks: 100 },
        { code:'266', name:'Higher Math 2nd Paper',   fullMarks: 100 },
        { code:'275', name:'ICT',                     fullMarks: 100 },
    ],
    com_xi: [
        { code:'101', name:'Bangla 1st Paper',            fullMarks: 100 },
        { code:'102', name:'Bangla 2nd Paper',            fullMarks: 100 },
        { code:'107', name:'English 1st Paper',           fullMarks: 100 },
        { code:'108', name:'English 2nd Paper',           fullMarks: 100 },
        { code:'253', name:'Accounting 1st Paper',        fullMarks: 100 },
        { code:'277', name:'Business Organisation 1st',   fullMarks: 100 },
        { code:'292', name:'Finance & Banking 1st',       fullMarks: 100 },
        { code:'286', name:'Production Mgmt 1st Paper',   fullMarks: 100 },
        { code:'275', name:'ICT',                         fullMarks: 100 },
    ],
    com_xii: [
        { code:'101', name:'Bangla 1st Paper',            fullMarks: 100 },
        { code:'102', name:'Bangla 2nd Paper',            fullMarks: 100 },
        { code:'107', name:'English 1st Paper',           fullMarks: 100 },
        { code:'108', name:'English 2nd Paper',           fullMarks: 100 },
        { code:'254', name:'Accounting 2nd Paper',        fullMarks: 100 },
        { code:'278', name:'Business Organisation 2nd',   fullMarks: 100 },
        { code:'293', name:'Finance & Banking 2nd',       fullMarks: 100 },
        { code:'287', name:'Production Mgmt 2nd Paper',   fullMarks: 100 },
        { code:'275', name:'ICT',                         fullMarks: 100 },
    ],
    hum_xi: [
        { code:'101', name:'Bangla 1st Paper',            fullMarks: 100 },
        { code:'102', name:'Bangla 2nd Paper',            fullMarks: 100 },
        { code:'107', name:'English 1st Paper',           fullMarks: 100 },
        { code:'108', name:'English 2nd Paper',           fullMarks: 100 },
        { code:'269', name:'Civics & Gov. 1st Paper',     fullMarks: 100 },
        { code:'117', name:'Sociology 1st Paper',         fullMarks: 100 },
        { code:'109', name:'Economics 1st Paper',         fullMarks: 100 },
        { code:'304', name:'History 1st Paper',           fullMarks: 100 },
        { code:'275', name:'ICT',                         fullMarks: 100 },
    ],
    hum_xii: [
        { code:'101', name:'Bangla 1st Paper',            fullMarks: 100 },
        { code:'102', name:'Bangla 2nd Paper',            fullMarks: 100 },
        { code:'107', name:'English 1st Paper',           fullMarks: 100 },
        { code:'108', name:'English 2nd Paper',           fullMarks: 100 },
        { code:'270', name:'Civics & Gov. 2nd Paper',     fullMarks: 100 },
        { code:'118', name:'Sociology 2nd Paper',         fullMarks: 100 },
        { code:'110', name:'Economics 2nd Paper',         fullMarks: 100 },
        { code:'305', name:'History 2nd Paper',           fullMarks: 100 },
        { code:'275', name:'ICT',                         fullMarks: 100 },
    ],
};

/* ═══════════════════════════════════════════════════════════════
   GRADING — Bangladesh National Standard
═══════════════════════════════════════════════════════════════ */

/**
 * Convert a raw mark (0–fullMarks) to grade info.
 * Marks are normalised to /100 before applying the scale.
 */
function markToGrade(mark, fullMarks) {
    const pct = (mark / fullMarks) * 100;
    if (pct >= 80) return { letter:'A+', gp:5.00, color:'#276749', bg:'#f0fff4' };
    if (pct >= 70) return { letter:'A',  gp:4.00, color:'#234e52', bg:'#e6fffa' };
    if (pct >= 60) return { letter:'A-', gp:3.50, color:'#2c5282', bg:'#ebf8ff' };
    if (pct >= 50) return { letter:'B',  gp:3.00, color:'#2b6cb0', bg:'#bee3f8' };
    if (pct >= 40) return { letter:'C',  gp:2.00, color:'#744210', bg:'#fefcbf' };
    if (pct >= 33) return { letter:'D',  gp:1.00, color:'#7b341e', bg:'#feebc8' };
    return              { letter:'F',  gp:0.00, color:'#822727', bg:'#fff5f5' };
}

/**
 * Calculate GPA for one exam from an array of {mark, fullMarks} objects.
 * GPA = Σ GP ÷ n  (Bangladesh Board standard)
 * Returns null if any marks are missing.
 */
function calcExamGPA(subjectResults) {
    if (!subjectResults || subjectResults.some(r => r.mark === null)) return null;
    const totalGP = subjectResults.reduce((sum, r) => sum + markToGrade(r.mark, r.fullMarks).gp, 0);
    return Math.round((totalGP / subjectResults.length) * 100) / 100;
}

/** GPA number → overall letter grade */
function gpaToLetter(gpa) {
    if (gpa === null) return null;
    if (gpa >= 5.00) return { letter:'A+', color:'#276749', bg:'#f0fff4' };
    if (gpa >= 4.00) return { letter:'A',  color:'#234e52', bg:'#e6fffa' };
    if (gpa >= 3.50) return { letter:'A-', color:'#2c5282', bg:'#ebf8ff' };
    if (gpa >= 3.00) return { letter:'B',  color:'#2b6cb0', bg:'#bee3f8' };
    if (gpa >= 2.00) return { letter:'C',  color:'#744210', bg:'#fefcbf' };
    if (gpa >= 1.00) return { letter:'D',  color:'#7b341e', bg:'#feebc8' };
    return               { letter:'F',  color:'#822727', bg:'#fff5f5' };
}

/* ═══════════════════════════════════════════════════════════════
   DATA GENERATION (mock — replace with real backend calls)
═══════════════════════════════════════════════════════════════ */

function rnd(min, max) { return Math.floor(Math.random() * (max - min + 1)) + min; }

function generateStudents() {
    const firstNames = [
        'Fatema','Rashida','Nusrat','Morjina','Shirin','Taslima','Sultana','Afroza',
        'Monika','Roksana','Dilruba','Nasrin','Mithila','Shaila','Farida','Rina',
        'Tania','Jannat','Sonia','Rima','Popy','Mitu','Sharmin','Sadia','Lima',
        'Rahela','Rumana','Sumi','Asha','Mukti','Eti','Borna','Ritu','Meghla','Ovi',
        'Shimu','Mim','Boishakhi','Puja','Chanda',
    ];
    const lastNames = [
        'Begum','Akter','Khanam','Islam','Khatun','Parvin','Siddiqua','Rashid',
        'Sultana','Banu','Hossain','Rahman','Molla','Sarker','Sheikh','Mondol',
        'Biswas','Paul','Roy','Das',
    ];

    const classKeys = Object.keys(CLASS_MAP);

    return Array.from({ length: 120 }, (_, i) => {
        const fn       = firstNames[i % firstNames.length];
        const ln       = lastNames[i % lastNames.length];
        const clsKey   = classKeys[i % classKeys.length];
        const clsInfo  = CLASS_MAP[clsKey];
        const year     = clsInfo.year;           // 'xi' or 'xii'
        const yearTag  = year === 'xii' ? 'XII' : 'XI';
        const subjects = SUBJECTS[clsKey];

        /**
         * examResults: { [examKey]: Array<{mark,fullMarks}> | null }
         * null = student has not appeared / marks not entered yet
         *
         * Each exam is INDEPENDENT — stored separately, never combined.
         */
        const examResults = {};
        EXAMS[year].forEach((exam, ei) => {
            const hasMarks = (i + ei) % 4 !== 0;   // ~75% have marks entered
            examResults[exam.key] = hasMarks
                ? subjects.map(sub => ({
                    mark:      rnd(33, sub.fullMarks),
                    fullMarks: sub.fullMarks,
                }))
                : null;
        });

        const sessions = ['2022–2023','2023–2024','2024–2025','2025–2026'];

        return {
            id:          `PMDC-${yearTag}-${String(i + 1).padStart(3, '0')}`,
            name:        `${fn} ${ln}`,
            initials:    `${fn[0]}${ln[0]}`,
            classKey:    clsKey,
            classInfo:   clsInfo,
            year,
            session:     sessions[i % sessions.length],
            subjects,
            examResults, // ← per-exam, independent
            color:       AVATAR_COLORS[i % AVATAR_COLORS.length],
        };

    });
}

/* ═══════════════════════════════════════════════════════════════
   STATE
═══════════════════════════════════════════════════════════════ */

let allStudents     = generateStudents();
let filtered        = [...allStudents];
let activeClassKey  = 'all';
let currentPage     = 1;
const PAGE_SIZE     = 15;

/* ═══════════════════════════════════════════════════════════════
   DOM HELPERS
═══════════════════════════════════════════════════════════════ */

const $ = id => document.getElementById(id);

function gpaPill(gpa) {
    if (gpa === null) {
        return `<span class="gpa-pill gpa-pending">—<small>Pending</small></span>`;
    }
    const g = gpaToLetter(gpa);
    return `<span class="gpa-pill" style="background:${g.bg};color:${g.color};border-color:${g.color}40;">
                ${g.letter}<small>${gpa.toFixed(2)}</small>
            </span>`;
}

/* ═══════════════════════════════════════════════════════════════
   EXAM FILTER — updates automatically when class tab changes
═══════════════════════════════════════════════════════════════ */

function rebuildExamFilter(classKey) {
    const sel = $('examFilter');
    sel.innerHTML = '<option value="">All Exams</option>';

    let examsToList = [];
    if (classKey === 'all') {
        examsToList = [...EXAMS.xi, ...EXAMS.xii];
    } else {
        const year = CLASS_MAP[classKey]?.year || 'xi';
        examsToList = EXAMS[year];
    }

    examsToList.forEach(e => {
        const opt = document.createElement('option');
        opt.value       = e.key;
        opt.textContent = `${e.label} (${e.labelBn})`;
        sel.appendChild(opt);
    });
    sel.value = '';
}

/* ═══════════════════════════════════════════════════════════════
   BUILD TABLE HEADER — correct exam columns per selected class
═══════════════════════════════════════════════════════════════ */

function buildTableHeader() {
    const thead = document.querySelector('#gradesTable thead tr');

    // Which exams to show as columns?
    let examCols = [];
    if (activeClassKey === 'all') {
        examCols = null;
    } else {
        const year = CLASS_MAP[activeClassKey].year;
        examCols   = EXAMS[year];
    }

    // Each exam (or the summary) gets TWO columns: GPA (number) + Grade (letter)
    const examHeaders = examCols
        ? examCols.map(e => `
            <th class="exam-col-header">
                ${e.label}<br>
                <small style="font-weight:400;font-size:.7rem;color:#a0aec0;">GPA</small>
            </th>
            <th class="exam-col-header">
                ${e.label}<br>
                <small style="font-weight:400;font-size:.7rem;color:#a0aec0;">Grade</small>
            </th>`).join('')
        : `<th class="exam-col-header">GPA</th>
           <th class="exam-col-header">Grade</th>`;

    thead.innerHTML = `
        <th>Student</th>
        <th>Roll No</th>
        <th>Session</th>
        <th>Group / Class</th>
        ${examHeaders}
        <th>Status</th>
        <th>Actions</th>
    `;
}


/* ═══════════════════════════════════════════════════════════════
   RENDER TABLE
═══════════════════════════════════════════════════════════════ */

function renderTable() {
    buildTableHeader();

    const start = (currentPage - 1) * PAGE_SIZE;
    const end   = Math.min(start + PAGE_SIZE, filtered.length);
    const page  = filtered.slice(start, end);

    $('gradesTableBody').innerHTML = page.map(student => {
        // Build GPA + Grade cells (two TDs per exam or summary)
        let examCells = '';

        if (activeClassKey === 'all') {
            // Summary: best GPA across all exams
            const allGPAs = Object.values(student.examResults)
                .filter(r => r !== null)
                .map(r => calcExamGPA(r))
                .filter(g => g !== null);
            const bestGPA = allGPAs.length ? Math.max(...allGPAs) : null;
            const g = bestGPA !== null ? gpaToLetter(bestGPA) : null;
            examCells = [
                `<td class="exam-gpa-cell gpa-num-cell">${bestGPA !== null
                    ? `<span class="gpa-number">${bestGPA.toFixed(2)}</span>`
                    : `<span class="gpa-pending-dash">—</span>`}</td>`,
                `<td class="exam-gpa-cell gpa-letter-cell">${g
                    ? `<span class="grade-letter-badge" style="background:${g.bg};color:${g.color};">${g.letter}</span>`
                    : `<span class="gpa-pending-dash">—</span>`}</td>`,
            ].join('');
        } else {
            const year  = CLASS_MAP[activeClassKey].year;
            const exams = EXAMS[year];
            examCells = exams.map(exam => {
                const results = student.examResults[exam.key] ?? null;
                const gpa     = calcExamGPA(results);
                const g       = gpa !== null ? gpaToLetter(gpa) : null;
                return [
                    `<td class="exam-gpa-cell gpa-num-cell">${gpa !== null
                        ? `<span class="gpa-number">${gpa.toFixed(2)}</span>`
                        : `<span class="gpa-pending-dash">—</span>`}</td>`,
                    `<td class="exam-gpa-cell gpa-letter-cell">${g
                        ? `<span class="grade-letter-badge" style="background:${g.bg};color:${g.color};">${g.letter}</span>`
                        : `<span class="gpa-pending-dash">—</span>`}</td>`,
                ].join('');
            }).join('');
        }

        // Status: published if any exam has marks
        const hasAnyMarks = Object.values(student.examResults).some(r => r !== null);

        return `
            <tr data-id="${student.id}">
                <td>
                    <div class="student-cell">
                        <span class="student-name">${student.name}</span>
                    </div>
                </td>
                <td><code class="roll-code">${student.id}</code></td>
                <td><span class="session-tag">${student.session}</span></td>
                <td><span class="class-badge">${student.classInfo.label}</span></td>
                ${examCells}
                <td>${hasAnyMarks
                    ? `<span class="status-pill status-published"><i class="fas fa-check-circle"></i> Entered</span>`
                    : `<span class="status-pill status-pending"><i class="fas fa-hourglass-half"></i> Pending</span>`
                }</td>
                <td>
                    <div class="row-actions">
                        <button class="act-btn act-view"  onclick="showResultSheet('${student.id}')"   title="View Result Sheet"><i class="fas fa-file-alt"></i></button>
                        <button class="act-btn act-edit"  onclick="openEnterMarks('${student.id}')"    title="Enter / Edit Marks"><i class="fas fa-edit"></i></button>
                    </div>
                </td>
            </tr>`;

    }).join('');

    $('gradeTableInfo').textContent  = `Showing ${start + 1}–${end} of ${filtered.length} students`;
    $('gradeCount').textContent      = `${filtered.length} students`;
    renderPagination();
}

function renderPagination() {
    const totalPages = Math.ceil(filtered.length / PAGE_SIZE);
    const el         = $('gradePagination');
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

/* ═══════════════════════════════════════════════════════════════
   FILTERS & TABS
═══════════════════════════════════════════════════════════════ */

function applyFilters() {
    const q          = ($('gradeSearch')?.value || '').toLowerCase().trim();
    const gradeF     = $('gradeFilter')?.value  || '';
    const examF      = $('examFilter')?.value   || '';
    const sessionF   = $('sessionFilter')?.value || '';

    filtered = allStudents.filter(s => {
        // Class filter
        if (activeClassKey !== 'all' && s.classKey !== activeClassKey) return false;

        // Session filter
        if (sessionF && s.session !== sessionF) return false;

        // Search
        if (q && !s.name.toLowerCase().includes(q) && !s.id.toLowerCase().includes(q)) return false;

        // Grade filter — applies to the selected exam if one is chosen
        if (gradeF) {
            let gpas = [];
            if (examF && s.examResults[examF]) {
                const gpa = calcExamGPA(s.examResults[examF]);
                if (gpa !== null) gpas = [gpa];
            } else {
                gpas = Object.values(s.examResults)
                    .filter(r => r !== null)
                    .map(r => calcExamGPA(r))
                    .filter(g => g !== null);
            }
            if (!gpas.length) return false;
            const matched = gpas.some(gpa => gpaToLetter(gpa)?.letter === gradeF);
            if (!matched) return false;
        }

        return true;
    });

    currentPage = 1;
    renderTable();
    renderDistributionChart(filtered);
    renderTopPerformers(filtered);
    renderNeedsAttention(filtered);
}


document.querySelectorAll('.grade-tab').forEach(tab => {
    tab.addEventListener('click', function () {
        document.querySelectorAll('.grade-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        activeClassKey = this.dataset.class;
        $('chartClassLabel').textContent = activeClassKey === 'all'
            ? 'All Groups'
            : CLASS_MAP[activeClassKey]?.label || activeClassKey;
        rebuildExamFilter(activeClassKey);
        applyFilters();
    });
});

$('gradeSearch')?.addEventListener('input', applyFilters);
$('gradeFilter')?.addEventListener('change', applyFilters);
$('examFilter')?.addEventListener('change', applyFilters);
$('sessionFilter')?.addEventListener('change', applyFilters);


/* ═══════════════════════════════════════════════════════════════
   GRADE DISTRIBUTION CHART
═══════════════════════════════════════════════════════════════ */

const GRADE_BUCKETS = [
    { letter:'A+', minGP:5.00,          color:'#276749' },
    { letter:'A',  minGP:4.00, maxGP:4.99, color:'#38a169' },
    { letter:'A-', minGP:3.50, maxGP:3.99, color:'#3182ce' },
    { letter:'B',  minGP:3.00, maxGP:3.49, color:'#d69e2e' },
    { letter:'C',  minGP:2.00, maxGP:2.99, color:'#dd6b20' },
    { letter:'D',  minGP:1.00, maxGP:1.99, color:'#805ad5' },
    { letter:'F',  minGP:0.00, maxGP:0.99, color:'#e53e3e' },
];

function renderDistributionChart(data) {
    // Collect all individual exam GPAs (each exam counted separately)
    const allGPAs = [];
    data.forEach(s => {
        Object.values(s.examResults).forEach(results => {
            if (results !== null) {
                const gpa = calcExamGPA(results);
                if (gpa !== null) allGPAs.push(gpa);
            }
        });
    });

    const counts   = GRADE_BUCKETS.map(b => {
        if (b.letter === 'A+') return allGPAs.filter(g => g >= 5.00).length;
        return allGPAs.filter(g => g >= b.minGP && g <= b.maxGP).length;
    });
    const maxCount = Math.max(...counts, 1);

    $('gradeBarChart').innerHTML = GRADE_BUCKETS.map((b, i) => `
        <div class="gbc-group">
            <div class="gbc-bar-wrap">
                <div class="gbc-bar" style="height:${Math.round(counts[i]/maxCount*100)}%;background:${b.color};"
                     title="${b.letter}: ${counts[i]} results"></div>
            </div>
            <div class="gbc-label">${b.letter}</div>
            <div class="gbc-count">${counts[i]}</div>
        </div>`).join('');
}

/* ═══════════════════════════════════════════════════════════════
   TOP PERFORMERS & NEEDS ATTENTION
═══════════════════════════════════════════════════════════════ */

function getBestGPA(student) {
    const gpas = Object.values(student.examResults)
        .filter(r => r !== null)
        .map(r => calcExamGPA(r))
        .filter(g => g !== null);
    return gpas.length ? Math.max(...gpas) : null;
}

function renderTopPerformers(data) {
    const top = [...data]
        .map(s => ({ ...s, bestGPA: getBestGPA(s) }))
        .filter(s => s.bestGPA !== null)
        .sort((a, b) => b.bestGPA - a.bestGPA)
        .slice(0, 5);

    const symbols = ['🥇','🥈','🥉','4','5'];
    const classes  = ['gold','silver','bronze','other','other'];

    $('topPerformersList').innerHTML = top.length ? top.map((s, i) => `
        <div class="tp-item">
            <div class="tp-rank ${classes[i]}">${symbols[i]}</div>
            <div class="tp-avatar" style="background:${s.color};">${s.initials}</div>
            <div class="tp-info">
                <div class="tp-name">${s.name}</div>
                <div class="tp-class">${s.classInfo.label}</div>
            </div>
            <div class="tp-score">GPA ${s.bestGPA.toFixed(2)}</div>
        </div>`).join('')
        : '<p class="empty-note">No data available.</p>';
}

function renderNeedsAttention(data) {
    const atRisk = [...data]
        .map(s => ({ ...s, bestGPA: getBestGPA(s) }))
        .filter(s => s.bestGPA !== null && s.bestGPA < 2.00)
        .sort((a, b) => a.bestGPA - b.bestGPA)
        .slice(0, 5);

    $('attentionList').innerHTML = atRisk.length ? atRisk.map(s => {
        const g = gpaToLetter(s.bestGPA);
        return `
            <div class="att-item">
                <div class="att-avatar">${s.initials}</div>
                <div class="att-info">
                    <div class="att-name">${s.name}</div>
                    <div class="att-reason">${s.classInfo.label}</div>
                </div>
                <div class="att-grade" style="color:${g.color};">GPA ${s.bestGPA.toFixed(2)}</div>
            </div>`;
    }).join('')
        : '<p class="empty-note">All students are on track! 🎉</p>';
}

/* ═══════════════════════════════════════════════════════════════
   PAGE 3 — RESULT SHEET (per exam, independent)
═══════════════════════════════════════════════════════════════ */

window.showResultSheet = function (studentId) {
    const student = allStudents.find(s => s.id === studentId);
    if (!student) return;

    const year  = student.year;
    const exams = EXAMS[year];

    // Build result sheet for each exam independently
    let sheetsHtml = '';
    exams.forEach(exam => {
        const results = student.examResults[exam.key];
        const gpa     = calcExamGPA(results);
        const overall = gpaToLetter(gpa);

        sheetsHtml += `
            <div class="result-sheet-block">
                <div class="rs-exam-header">
                    <div class="rs-exam-title">
                        <i class="fas fa-file-alt"></i>
                        <div>
                            <strong>${exam.label}</strong>
                            <span class="rs-exam-bn">${exam.labelBn}</span>
                        </div>
                    </div>
                    ${gpa !== null
                        ? `<div class="rs-gpa-badge" style="background:${overall.bg};color:${overall.color};border-color:${overall.color}60;">
                               GPA: <strong>${gpa.toFixed(2)}</strong> &nbsp;(${overall.letter})
                           </div>`
                        : `<div class="rs-gpa-badge rs-gpa-pending">Marks Not Entered</div>`
                    }
                </div>

                ${results !== null ? `
                <table class="rs-table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Code</th>
                            <th>Full Marks</th>
                            <th>Marks Obtained</th>
                            <th>Grade</th>
                            <th>Grade Point</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${student.subjects.map((sub, i) => {
                            const r = results[i];
                            const g = markToGrade(r.mark, r.fullMarks);
                            return `
                                <tr>
                                    <td>${sub.name}</td>
                                    <td><code>${sub.code}</code></td>
                                    <td>${sub.fullMarks}</td>
                                    <td><strong style="color:${g.color};">${r.mark}</strong></td>
                                    <td><span class="grade-letter" style="color:${g.color};">${g.letter}</span></td>
                                    <td>${g.gp.toFixed(2)}</td>
                                </tr>`;
                        }).join('')}
                    </tbody>
                    <tfoot>
                        <tr class="rs-gpa-row">
                            <td colspan="5" style="text-align:right;font-weight:700;">GPA (this exam):</td>
                            <td style="font-weight:800;font-size:1.1rem;color:${overall.color};">
                                ${gpa.toFixed(2)} &nbsp;<span style="font-size:.85rem;">(${overall.letter})</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <p class="rs-note"><i class="fas fa-info-circle"></i> This result is for <strong>${exam.label}</strong> only. Each exam GPA is independent — there is no combined total.</p>
                ` : `<div class="rs-empty"><i class="fas fa-hourglass-half"></i> Marks not yet entered for this exam.</div>`}
            </div>`;
    });

    openModal(`
        <div class="modal-student-header">
            <div class="ms-avatar" style="background:${student.color};">${student.initials}</div>
            <div>
                <h3>${student.name}</h3>
                <p>${student.id} &nbsp;·&nbsp; ${student.classInfo.label}</p>
            </div>
        </div>
        <div class="exam-overview-grid">
            ${exams.map(exam => {
                const gpa = calcExamGPA(student.examResults[exam.key]);
                const g   = gpaToLetter(gpa);
                return `
                    <div class="overview-exam-card ${gpa === null ? 'pending' : ''}" style="${gpa ? `border-left:4px solid ${g.color};` : ''}">
                        <div class="oec-label">${exam.label}</div>
                        <div class="oec-bn">${exam.labelBn}</div>
                        <div class="oec-gpa" style="color:${gpa ? g.color : '#a0aec0'};">
                            ${gpa !== null ? `GPA <strong>${gpa.toFixed(2)}</strong> (${g.letter})` : '—'}
                        </div>
                    </div>`;
            }).join('')}
        </div>
        <hr style="margin:16px 0;border-color:#e2e8f0;">
        ${sheetsHtml}
    `, `Result Sheet — ${student.name}`);
};

/* ═══════════════════════════════════════════════════════════════
   PAGE 2 — ENTER MARKS (per exam, independent)
═══════════════════════════════════════════════════════════════ */

window.openEnterMarks = function (studentId) {
    const student = allStudents.find(s => s.id === studentId);
    if (!student) return;

    const year  = student.year;
    const exams = EXAMS[year];

    // Exam selector tabs
    const examTabsHtml = exams.map((exam, idx) => `
        <button type="button"
                class="exam-entry-tab ${idx === 0 ? 'active' : ''}"
                onclick="switchEntryTab('${exam.key}', this)">
            ${exam.label}
        </button>`).join('');

    // Marks entry panels — one per exam (independent)
    const panelsHtml = exams.map(exam => {
        const existing = student.examResults[exam.key];
        return `
            <div class="entry-panel" id="panel-${exam.key}" style="${exam === exams[0] ? '' : 'display:none;'}">
                <p class="entry-exam-info"><i class="fas fa-info-circle"></i>
                    Enter marks for <strong>${exam.label}</strong> (${exam.labelBn}) independently.
                    This has no relation to any other exam's result.
                </p>
                <table class="entry-table">
                    <thead>
                        <tr><th>Subject</th><th>Code</th><th>Full Marks</th><th>Marks Obtained</th><th>Grade</th><th>GP</th></tr>
                    </thead>
                    <tbody>
                        ${student.subjects.map((sub, i) => {
                            const prev = existing ? existing[i].mark : '';
                            return `
                                <tr>
                                    <td>${sub.name}</td>
                                    <td><code>${sub.code}</code></td>
                                    <td>${sub.fullMarks}</td>
                                    <td>
                                        <input type="number" min="0" max="${sub.fullMarks}"
                                               class="mark-input"
                                               data-exam="${exam.key}" data-idx="${i}"
                                               data-full="${sub.fullMarks}"
                                               value="${prev}"
                                               placeholder="0–${sub.fullMarks}"
                                               oninput="liveGrade(this, '${exam.key}')">
                                    </td>
                                    <td class="live-grade" id="lg-${exam.key}-${i}">—</td>
                                    <td class="live-gp"    id="lgp-${exam.key}-${i}">—</td>
                                </tr>`;
                        }).join('')}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" style="text-align:right;font-weight:700;">Calculated GPA:</td>
                            <td><strong id="live-gpa-${exam.key}" style="font-size:1rem;">—</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>`;
    }).join('');

    openModal(`
        <div class="modal-student-header">
            <div class="ms-avatar" style="background:${student.color};">${student.initials}</div>
            <div>
                <h3>${student.name}</h3>
                <p>${student.id} &nbsp;·&nbsp; ${student.classInfo.label}</p>
            </div>
        </div>
        <div class="exam-entry-tabs">${examTabsHtml}</div>
        ${panelsHtml}
        <div class="modal-form-actions">
            <button class="btn-cancel-modal" onclick="closeModal()">Cancel</button>
            <button class="btn-save-modal"   onclick="saveMarks('${studentId}')">
                <i class="fas fa-save"></i> Save Marks
            </button>
        </div>
    `, `Enter Marks — ${student.name}`);

    // Initialise live preview for any pre-filled values
    exams.forEach(exam => {
        student.subjects.forEach((sub, i) => {
            const inp = document.querySelector(`[data-exam="${exam.key}"][data-idx="${i}"]`);
            if (inp && inp.value) liveGrade(inp, exam.key);
        });
        recalcExamGPA(exam.key, student.subjects.length);
    });
};

/** Switches between exam tabs in the Enter Marks modal */
window.switchEntryTab = function (examKey, btn) {
    document.querySelectorAll('.exam-entry-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.entry-panel').forEach(p => p.style.display = 'none');
    const panel = document.getElementById(`panel-${examKey}`);
    if (panel) panel.style.display = '';
};

/** Live grade preview as teacher types */
window.liveGrade = function (input, examKey) {
    const idx  = parseInt(input.dataset.idx);
    const full = parseInt(input.dataset.full);
    const mark = parseInt(input.value);

    const lgEl  = document.getElementById(`lg-${examKey}-${idx}`);
    const lgpEl = document.getElementById(`lgp-${examKey}-${idx}`);

    if (isNaN(mark) || input.value === '') {
        if (lgEl)  lgEl.textContent  = '—';
        if (lgpEl) lgpEl.textContent = '—';
    } else {
        const g = markToGrade(Math.min(mark, full), full);
        if (lgEl)  { lgEl.textContent  = g.letter; lgEl.style.color  = g.color; }
        if (lgpEl) { lgpEl.textContent = g.gp.toFixed(2); lgpEl.style.color = g.color; }
    }

    // Total subject count for this exam
    const allInputs = document.querySelectorAll(`[data-exam="${examKey}"]`);
    recalcExamGPA(examKey, allInputs.length);
};

function recalcExamGPA(examKey, subjectCount) {
    const inputs   = Array.from(document.querySelectorAll(`[data-exam="${examKey}"]`));
    const marks    = inputs.map(inp => ({
        mark:      parseInt(inp.value),
        fullMarks: parseInt(inp.dataset.full),
    }));
    const allFilled = marks.every(m => !isNaN(m.mark));
    const gpaEl     = document.getElementById(`live-gpa-${examKey}`);
    if (!gpaEl) return;

    if (!allFilled) {
        gpaEl.textContent = '—';
        gpaEl.style.color = '';
        return;
    }
    const gpa = calcExamGPA(marks);
    if (gpa !== null) {
        const g = gpaToLetter(gpa);
        gpaEl.textContent = `${gpa.toFixed(2)} (${g.letter})`;
        gpaEl.style.color = g.color;
    }
}

/** Save all exam marks for this student */
window.saveMarks = function (studentId) {
    const student = allStudents.find(s => s.id === studentId);
    if (!student) return;

    const year  = student.year;
    const exams = EXAMS[year];

    exams.forEach(exam => {
        const inputs = Array.from(document.querySelectorAll(`[data-exam="${exam.key}"]`));
        const marks  = inputs.map(inp => ({
            mark:      parseInt(inp.value) || 0,
            fullMarks: parseInt(inp.dataset.full),
        }));
        // Only save if at least one mark was entered
        if (marks.some(m => m.mark > 0)) {
            student.examResults[exam.key] = marks;
        }
    });

    closeModal();
    applyFilters();
    showToast(`Marks saved for ${student.name}! নম্বর সংরক্ষিত হয়েছে।`);
};

/* ═══════════════════════════════════════════════════════════════
   GENERIC MODAL
═══════════════════════════════════════════════════════════════ */

function openModal(bodyHtml, title = '') {
    $('modalTitle').textContent = title;
    $('modalContent').innerHTML  = bodyHtml;
    $('gradeModal').classList.add('open');
}

window.closeModal = function () {
    $('gradeModal').classList.remove('open');
};

$('gradeModal')?.addEventListener('click', e => {
    if (e.target === $('gradeModal')) closeModal();
});
$('closeGradeModal')?.addEventListener('click', closeModal);

/* ═══════════════════════════════════════════════════════════════
   PUBLISH
═══════════════════════════════════════════════════════════════ */

$('publishBtn')?.addEventListener('click', () => {
    const label = activeClassKey === 'all' ? 'All Groups' : CLASS_MAP[activeClassKey]?.label || '';
    $('publishClassName').textContent = label;
    $('publishModal').classList.add('open');
});

['closePublishModal','cancelPublish'].forEach(id => {
    $(id)?.addEventListener('click', () => $('publishModal').classList.remove('open'));
});

$('publishModal')?.addEventListener('click', function (e) {
    if (e.target === this) this.classList.remove('open');
});

$('confirmPublish')?.addEventListener('click', () => {
    $('publishModal').classList.remove('open');
    showToast('ফলাফল প্রকাশিত হয়েছে! Results published successfully. 🎉');
});

/* ═══════════════════════════════════════════════════════════════
   EXPORT
═══════════════════════════════════════════════════════════════ */

$('exportGradesBtn')?.addEventListener('click', () => {
    const rows = [['Roll No','Name','Group / Class','Exam','GPA','Grade']];
    filtered.forEach(s => {
        const year  = s.year;
        const exams = EXAMS[year];
        exams.forEach(exam => {
            const gpa     = calcExamGPA(s.examResults[exam.key]);
            const overall = gpaToLetter(gpa);
            rows.push([
                s.id, `"${s.name}"`, s.classInfo.label,
                exam.label,
                gpa !== null ? gpa.toFixed(2) : 'Pending',
                overall ? overall.letter : '—',
            ]);
        });
    });
    const csv  = rows.map(r => r.join(',')).join('\n');
    const blob = new Blob([csv], { type:'text/csv' });
    const a    = document.createElement('a');
    a.href     = URL.createObjectURL(blob);
    a.download = 'pmdc-hsc-results.csv';
    a.click();
});

/* ═══════════════════════════════════════════════════════════════
   TOAST
═══════════════════════════════════════════════════════════════ */

function showToast(msg) {
    $('toastMsg').textContent = msg;
    $('toast').classList.add('show');
    setTimeout(() => $('toast').classList.remove('show'), 3500);
}

/* ═══════════════════════════════════════════════════════════════
   SPARKLINES
═══════════════════════════════════════════════════════════════ */

function renderSparklines() {
    [
        { id:'spark1', h:[30,45,35,55,48,62,70], c:'#3182ce' },
        { id:'spark2', h:[20,28,22,35,30,40,50], c:'#38a169' },
        { id:'spark3', h:[60,50,55,45,40,35,28], c:'#d69e2e' },
        { id:'spark4', h:[18,22,20,15,12,10,8],  c:'#e53e3e' },
    ].forEach(({ id, h, c }) => {
        const el = $(id);
        if (el) el.innerHTML = h.map(v => `<div class="spark-bar" style="height:${v}px;background:${c};"></div>`).join('');
    });
}

/* ═══════════════════════════════════════════════════════════════
   INIT
═══════════════════════════════════════════════════════════════ */

rebuildExamFilter('all');
renderSparklines();
renderDistributionChart(allStudents);
renderTopPerformers(allStudents);
renderNeedsAttention(allStudents);
renderTable();
