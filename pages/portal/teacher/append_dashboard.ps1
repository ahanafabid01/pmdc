$js = @"

/* ═══════════════════════════════════════════
   OVERVIEW GRID: CHARTS & TOP PERFORMERS
═══════════════════════════════════════════ */

const GRADE_BUCKETS = [
    { letter:'A+', minGP:5.00,          color:'#276749' },
    { letter:'A',  minGP:4.00, maxGP:4.99, color:'#38a169' },
    { letter:'A-', minGP:3.50, maxGP:3.99, color:'#3182ce' },
    { letter:'B',  minGP:3.00, maxGP:3.49, color:'#d69e2e' },
    { letter:'C',  minGP:2.00, maxGP:2.99, color:'#dd6b20' },
    { letter:'D',  minGP:1.00, maxGP:1.99, color:'#805ad5' },
    { letter:'F',  minGP:0.00, maxGP:0.99, color:'#e53e3e' },
];

function renderDistributionChart() {
    const allGPAs = [];
    allStudents.forEach(s => {
        EXAMS[s.year].forEach(exam => {
            if (s.examResults[exam]) {
                const gpa = calcGPA(s.examResults[exam].subjects);
                if (gpa !== null) allGPAs.push(gpa);
            }
        });
    });

    const counts = GRADE_BUCKETS.map(b => {
        if (b.letter === 'A+') return allGPAs.filter(g => g >= 5.00).length;
        return allGPAs.filter(g => g >= b.minGP && g <= b.maxGP).length;
    });
    const maxCount = Math.max(...counts, 1);

    const chartEl = document.getElementById('gradeBarChart');
    if (chartEl) {
        chartEl.innerHTML = GRADE_BUCKETS.map((b, i) => \`
            <div class="gbc-group">
                <div class="gbc-bar-wrap">
                    <div class="gbc-bar" style="height:\${Math.round(counts[i]/maxCount*100)}%;background:\${b.color};"
                         title="\${b.letter}: \${counts[i]} results"></div>
                </div>
                <div class="gbc-label">\${b.letter}</div>
                <div class="gbc-count">\${counts[i]}</div>
            </div>\`).join('');
    }
}

function getBestGPA(student) {
    let best = null;
    EXAMS[student.year].forEach(exam => {
        if (student.examResults[exam]) {
            const gpa = calcGPA(student.examResults[exam].subjects);
            if (best === null || gpa > best) best = gpa;
        }
    });
    return best;
}

function renderTopPerformers() {
    const top = [...allStudents]
        .map(s => ({ ...s, bestGPA: getBestGPA(s) }))
        .filter(s => s.bestGPA !== null)
        .sort((a, b) => b.bestGPA - a.bestGPA)
        .slice(0, 5);

    const symbols = ['🥇','🥈','🥉','4','5'];
    const classes  = ['gold','silver','bronze','other','other'];

    const tpEl = document.getElementById('topPerformersList');
    if (tpEl) {
        tpEl.innerHTML = top.length ? top.map((s, i) => \`
            <div class="tp-item">
                <div class="tp-rank \${classes[i]}">\${symbols[i]}</div>
                <div class="tp-avatar" style="background:\${s.color};">\${s.initials}</div>
                <div class="tp-info">
                    <div class="tp-name">\${s.name}</div>
                    <div class="tp-class">\${groupMeta[s.group].label} — \${yearMeta[s.year].label}</div>
                </div>
                <div class="tp-score">GPA \${s.bestGPA.toFixed(2)}</div>
            </div>\`).join('')
            : '<p class="empty-note">No data available.</p>';
    }
}

function renderNeedsAttention() {
    const atRisk = [...allStudents]
        .map(s => ({ ...s, bestGPA: getBestGPA(s) }))
        .filter(s => s.bestGPA !== null && s.bestGPA < 2.00)
        .sort((a, b) => a.bestGPA - b.bestGPA)
        .slice(0, 5);

    const attEl = document.getElementById('attentionList');
    if (attEl) {
        attEl.innerHTML = atRisk.length ? atRisk.map(s => {
            const g = gpaToLetter(s.bestGPA);
            return \`
                <div class="att-item">
                    <div class="att-avatar" style="background:\${s.color};">\${s.initials}</div>
                    <div class="att-info">
                        <div class="att-name">\${s.name}</div>
                        <div class="att-reason">\${groupMeta[s.group].label} — \${yearMeta[s.year].label}</div>
                    </div>
                    <div class="att-grade" style="color:\${g.color};">GPA \${s.bestGPA.toFixed(2)}</div>
                </div>\`;
        }).join('')
            : '<p class="empty-note">All students are on track! 🎉</p>';
    }
}

renderDistributionChart();
renderTopPerformers();
renderNeedsAttention();
"@

Add-Content -Path "c:\xampp\htdocs\pmdc\pages\portal\teacher\js\dashboard.js" -Value $js

$css = @"

/* ═══════════════════════════════════════════
   OVERVIEW GRID CSS (Moved from Grades)
═══════════════════════════════════════════ */
.grades-overview-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 20px;
    margin-bottom: 30px;
}
@media (max-width: 1200px) {
    .grades-overview-grid {
        grid-template-columns: 1fr 1fr;
    }
    .grades-chart-card {
        grid-column: 1 / -1;
    }
}
@media (max-width: 768px) {
    .grades-overview-grid {
        grid-template-columns: 1fr;
    }
}
.grades-chart-card .card-body {
    padding: 24px;
}
.chart-class-label {
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    background: #f1f5f9;
    padding: 4px 10px;
    border-radius: 20px;
}

.grade-bar-chart {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    height: 180px;
    padding-top: 10px;
    border-bottom: 2px solid #e2e8f0;
    margin-bottom: 16px;
}
.gbc-group {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}
.gbc-bar-wrap {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    align-items: center;
}
.gbc-bar {
    width: 60%;
    max-width: 40px;
    min-height: 2px;
    border-radius: 4px 4px 0 0;
    transition: all 0.3s ease;
    position: relative;
    cursor: pointer;
}
.gbc-bar:hover {
    filter: brightness(1.1);
}
.gbc-label {
    font-size: 13px;
    font-weight: 700;
    color: #1e293b;
}
.gbc-count {
    font-size: 12px;
    color: #64748b;
}

.grade-dist-legend {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
}
.legend-item {
    font-size: 12px;
    color: #475569;
    display: flex;
    align-items: center;
    gap: 4px;
}
.legend-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.tp-item, .att-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #f1f5f9;
}
.tp-item:last-child, .att-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.tp-rank {
    width: 24px;
    font-weight: 700;
    font-size: 14px;
    text-align: center;
}
.tp-rank.gold { color: #d69e2e; font-size: 18px; }
.tp-rank.silver { color: #a0aec0; font-size: 18px; }
.tp-rank.bronze { color: #b7791f; font-size: 18px; }
.tp-rank.other { color: #94a3b8; }
.tp-avatar, .att-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 13px;
    flex-shrink: 0;
}
.tp-info, .att-info {
    flex: 1;
    min-width: 0;
}
.tp-name, .att-name {
    font-weight: 600;
    color: #1e293b;
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.tp-class, .att-reason {
    font-size: 12px;
    color: #64748b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.tp-score, .att-grade {
    font-weight: 700;
    font-size: 13px;
    color: #16a34a;
    padding: 2px 8px;
    background: #f0fdf4;
    border-radius: 4px;
}
.att-grade {
    background: #fef2f2;
    color: #e53e3e;
}
.empty-note {
    font-size: 14px;
    color: #64748b;
    font-style: italic;
    padding: 10px 0;
}
"@

Add-Content -Path "c:\xampp\htdocs\pmdc\pages\portal\teacher\css\dashboard.css" -Value $css
