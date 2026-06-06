<?php
$page       = 'hsc-program';
$page_group = 'academic';
$page_title = 'HSC Program | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';

// Load dynamic data from DB
require_once '../includes/academics-data.php';
$groups = pmdc_academics_get_all('hsc');

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">

            <div class="ph-kicker reveal">Academic Info</div>
            <h1 class="reveal">HSC Program</h1>
            <p class="reveal">Higher Secondary Certificate — groups, subjects, and program structure</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <!-- Program Overview Strip -->
            <div class="prog-overview-strip reveal">
                <div class="prog-overview-item">
                    <i class="fas fa-graduation-cap"></i>
                    <div>
                        <div class="poi-label">Program</div>
                        <div class="poi-val">HSC (Higher Secondary Certificate)</div>
                    </div>
                </div>
                <div class="prog-overview-sep"></div>
                <div class="prog-overview-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <div class="poi-label">Duration</div>
                        <div class="poi-val">2 Years (Class XI &amp; XII)</div>
                    </div>
                </div>
                <div class="prog-overview-sep"></div>
                <div class="prog-overview-item">
                    <i class="fas fa-layer-group"></i>
                    <div>
                        <div class="poi-label">Groups Offered</div>
                        <div class="poi-val">Science, Humanities, Business Studies</div>
                    </div>
                </div>
            </div>

            <!-- Exam Structure -->
            <div class="ai-info-card reveal" style="margin-bottom:32px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px;">
                    <i class="fas fa-list-ol" style="color:var(--blue);font-size:1rem;"></i>
                    <strong style="font-size:.95rem;color:var(--navy);font-family:'Inter',sans-serif;">Internal Examination Structure</strong>
                </div>
                <div class="prog-exam-grid">
                    <div class="prog-exam-card">
                        <div class="pec-year">Class XI (1st Year)</div>
                        <div class="pec-exams">
                            <span class="ai-badge badge-college">Half-Yearly Exam</span>
                            <span class="ai-badge badge-college">Year-Change Exam</span>
                        </div>
                        <div class="pec-note">Students failing any subject in the Year-Change exam are NOT promoted to Class XII.</div>
                    </div>
                    <div class="prog-exam-card">
                        <div class="pec-year">Class XII (2nd Year)</div>
                        <div class="pec-exams">
                            <span class="ai-badge badge-exam">Pre-Test Exam</span>
                            <span class="ai-badge badge-exam">Test Exam</span>
                        </div>
                        <div class="pec-note">Students failing even 1 subject in the Test Exam are NOT permitted to fill the HSC Board form.</div>
                    </div>
                </div>
            </div>

            <!-- Group Cards -->
            <?php foreach ($groups as $g): ?>
            <div class="prog-group-card reveal" style="--prog-accent:<?php echo $g['accent']; ?>;--prog-bg:<?php echo $g['accent']; ?>10;">
                <div class="pgc-header">
                    <div class="pgc-icon-wrap" style="background:<?php echo $g['accent']; ?>20;color:<?php echo $g['accent']; ?>;">
                        <i class="<?php echo $g['icon']; ?>"></i>
                    </div>
                    <div>
                        <div class="pgc-name"><?php echo htmlspecialchars($g['name']); ?></div>
                        <div class="pgc-bengali"><?php echo htmlspecialchars($g['bengali']); ?></div>
                    </div>
                    <span class="pgc-badge" style="background:<?php echo $g['accent']; ?>15;color:<?php echo $g['accent']; ?>;"><?php echo count($g['compulsory']) + count($g['optional']); ?>+ Subjects</span>
                </div>
                <div class="pgc-subjects">
                    <div class="pgc-col">
                        <div class="pgc-col-head" style="color:<?php echo $g['accent']; ?>;">
                            <i class="fas fa-check-circle"></i> Compulsory Subjects
                        </div>
                        <ul class="pgc-subject-list">
                            <?php foreach ($g['compulsory'] as $sub): ?>
                            <li class="pgc-subject-item pgc-compulsory"><?php echo htmlspecialchars($sub); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="pgc-col">
                        <div class="pgc-col-head" style="color:<?php echo $g['accent']; ?>;">
                            <i class="fas fa-list"></i> Optional Subjects <span class="pgc-note-tag"><?php echo htmlspecialchars($g['optional_note']); ?></span>
                        </div>
                        <ul class="pgc-subject-list">
                            <?php foreach ($g['optional'] as $sub): ?>
                            <li class="pgc-subject-item pgc-optional"><?php echo htmlspecialchars($sub); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php if (!empty($g['fourth'])): ?>
                    <div class="pgc-col pgc-fourth-col">
                        <div class="pgc-col-head" style="color:#f59e0b;">
                            <i class="fas fa-plus-circle"></i> 4th Subject <span class="pgc-note-tag"><?php echo htmlspecialchars($g['fourth_note']); ?></span>
                        </div>
                        <ul class="pgc-subject-list">
                            <?php foreach ($g['fourth'] as $sub): ?>
                            <li class="pgc-subject-item pgc-fourth"><?php echo htmlspecialchars($sub); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- GPA Note -->
            <div class="ai-info-card reveal" style="margin-top:32px;background:linear-gradient(135deg,#f0f9ff,#e0f2fe);border-color:#bae6fd;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                    <i class="fas fa-star" style="color:#0284c7;"></i>
                    <strong style="font-size:.95rem;color:#0c4a6e;font-family:'Inter',sans-serif;">Grading Scale (HSC)</strong>
                </div>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(120px,1fr));gap:8px;">
                    <?php
                    $grades = [
                        ['range'=>'80–100','grade'=>'A+','gp'=>'5.00','color'=>'#16a34a'],
                        ['range'=>'70–79', 'grade'=>'A', 'gp'=>'4.00','color'=>'#2563eb'],
                        ['range'=>'60–69', 'grade'=>'A−','gp'=>'3.50','color'=>'#7c3aed'],
                        ['range'=>'50–59', 'grade'=>'B', 'gp'=>'3.00','color'=>'#d97706'],
                        ['range'=>'40–49', 'grade'=>'C', 'gp'=>'2.00','color'=>'#ea580c'],
                        ['range'=>'33–39', 'grade'=>'D', 'gp'=>'1.00','color'=>'#dc2626'],
                        ['range'=>'0–32',  'grade'=>'F', 'gp'=>'0.00','color'=>'#6b7280'],
                    ];
                    foreach ($grades as $g): ?>
                    <div style="background:#fff;border-radius:10px;padding:10px 12px;text-align:center;border:1px solid #e0f2fe;">
                        <div style="font-size:1.2rem;font-weight:800;color:<?php echo $g['color']; ?>;font-family:'Inter',sans-serif;"><?php echo $g['grade']; ?></div>
                        <div style="font-size:.7rem;color:#64748b;font-family:'Inter',sans-serif;margin-top:2px;">GP <?php echo $g['gp']; ?></div>
                        <div style="font-size:.68rem;color:#94a3b8;font-family:'Inter',sans-serif;"><?php echo $g['range']; ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <p style="font-size:.78rem;color:#0369a1;font-family:'Inter',sans-serif;margin-top:14px;padding-top:12px;border-top:1px solid #bae6fd;">
                    <i class="fas fa-info-circle" style="margin-right:5px;"></i>
                    4th subject bonus: GP above 2.00 is added as bonus to the total GPA. Each internal exam has an independent GPA — no combined totals across exams.
                </p>
            </div>

        </div>
    </div>

<style>
/* ── Program page specific styles ─────────────────────────── */
.prog-overview-strip {
    display: flex; align-items: stretch; flex-wrap: wrap;
    background: #fff; border: 1px solid var(--border);
    border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,.07);
    padding: 20px 24px; gap: 0; margin-bottom: 28px;
}
.prog-overview-item {
    display: flex; align-items: center; gap: 12px;
    padding: 6px 20px; flex: 1; min-width: 160px;
}
.prog-overview-item i { font-size: 1.2rem; color: var(--blue); flex-shrink: 0; }
.poi-label { font-size: .68rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .07em; font-family: 'Inter',sans-serif; }
.poi-val   { font-size: .82rem; font-weight: 700; color: var(--navy); font-family: 'Inter',sans-serif; margin-top: 2px; }
.prog-overview-sep { width: 1px; background: var(--border); margin: 4px 0; flex-shrink: 0; }

.prog-exam-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.prog-exam-card { background: var(--surface); border-radius: 12px; padding: 16px 18px; }
.pec-year  { font-size: .88rem; font-weight: 800; color: var(--navy); font-family: 'Inter',sans-serif; margin-bottom: 10px; }
.pec-exams { display: flex; flex-wrap: wrap; gap: 7px; margin-bottom: 10px; }
.pec-note  { font-size: .75rem; color: var(--muted); font-family: 'Inter',sans-serif; line-height: 1.5; }

/* Group card */
.prog-group-card {
    background: #fff; border: 1px solid var(--border);
    border-top: 4px solid var(--prog-accent);
    border-radius: 16px; padding: 24px 28px;
    box-shadow: 0 2px 12px rgba(0,0,0,.07);
    margin-bottom: 20px;
}
.pgc-header {
    display: flex; align-items: center; gap: 14px;
    margin-bottom: 22px; flex-wrap: wrap;
}
.pgc-icon-wrap {
    width: 48px; height: 48px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; flex-shrink: 0;
}
.pgc-name   { font-size: 1.15rem; font-weight: 800; color: var(--navy); font-family: 'Inter',sans-serif; }
.pgc-bengali{ font-size: .8rem; color: var(--muted); font-family: 'Inter',sans-serif; margin-top: 2px; }
.pgc-badge  { margin-left: auto; padding: 5px 14px; border-radius: 20px; font-size: .75rem; font-weight: 700; font-family: 'Inter',sans-serif; white-space: nowrap; }

.pgc-subjects { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
.pgc-col {}
.pgc-col-head {
    font-size: .74rem; font-weight: 800; text-transform: uppercase;
    letter-spacing: .07em; display: flex; align-items: center; gap: 6px;
    margin-bottom: 10px; font-family: 'Inter',sans-serif;
}
.pgc-note-tag {
    font-size: .68rem; font-weight: 500; color: #94a3b8;
    text-transform: none; letter-spacing: 0;
}
.pgc-subject-list { display: flex; flex-direction: column; gap: 5px; }
.pgc-subject-item {
    font-size: .8rem; font-family: 'Inter',sans-serif;
    padding: 6px 11px; border-radius: 8px;
    font-weight: 600; line-height: 1.4;
}
.pgc-compulsory { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
.pgc-optional   { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
.pgc-fourth     { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }

@media (max-width: 900px) {
    .prog-overview-strip { gap: 8px; }
    .prog-overview-item  { padding: 6px 12px; min-width: 140px; }
    .prog-overview-sep   { display: none; }
    .pgc-subjects { grid-template-columns: 1fr 1fr; }
    .pgc-fourth-col { grid-column: 1 / -1; }
    .prog-exam-grid { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
    .prog-group-card { padding: 18px 16px; }
    .pgc-subjects { grid-template-columns: 1fr; }
    .pgc-fourth-col { grid-column: auto; }
}
</style>

<?php include '../includes/footer.php'; ?>
