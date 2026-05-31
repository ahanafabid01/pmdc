<?php
$page       = 'syllabus';
$page_group = 'academic';
$page_title = 'Syllabus | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'May 31, 2025';

$years    = ['1st Year', '2nd Year'];
$groups   = ['Science', 'Humanities', 'Business Studies', 'All Groups'];
$examTypes= ['All Exams', 'Half-Yearly', 'Year-Change', 'Pre-Test', 'Test Exam'];

$selYear  = $_GET['year']  ?? '2nd Year';
$selGroup = $_GET['group'] ?? 'All Groups';
$selExam  = $_GET['exam']  ?? 'All Exams';

$allSyllabus = [
    ['subject'=>'Bangla',      'year'=>'Both',     'group'=>'All',             'exam'=>'All Exams',  'note'=>'As per Bangladesh National Curriculum & Textbook Board (NCTB) syllabus'],
    ['subject'=>'English',     'year'=>'Both',     'group'=>'All',             'exam'=>'All Exams',  'note'=>'NCTB prescribed textbooks and grammar'],
    ['subject'=>'ICT',         'year'=>'Both',     'group'=>'All',             'exam'=>'All Exams',  'note'=>'Theory + Practical components included'],
    ['subject'=>'Physics',     'year'=>'1st Year', 'group'=>'Science',         'exam'=>'All Exams',  'note'=>'Chapters 1–6 for Half-Yearly; Full for Annual'],
    ['subject'=>'Chemistry',   'year'=>'1st Year', 'group'=>'Science',         'exam'=>'All Exams',  'note'=>'Chapters 1–5 for Half-Yearly; Full for Annual'],
    ['subject'=>'Biology',     'year'=>'1st Year', 'group'=>'Science',         'exam'=>'All Exams',  'note'=>'Botany & Zoology combined'],
    ['subject'=>'Higher Math', 'year'=>'1st Year', 'group'=>'Science',         'exam'=>'All Exams',  'note'=>'Optional — for selected students only'],
    ['subject'=>'Physics',     'year'=>'2nd Year', 'group'=>'Science',         'exam'=>'Pre-Test',   'note'=>'Full syllabus — all chapters'],
    ['subject'=>'Chemistry',   'year'=>'2nd Year', 'group'=>'Science',         'exam'=>'Pre-Test',   'note'=>'Full syllabus — all chapters'],
    ['subject'=>'Biology',     'year'=>'2nd Year', 'group'=>'Science',         'exam'=>'Pre-Test',   'note'=>'Full syllabus — Botany & Zoology'],
    ['subject'=>'Physics',     'year'=>'2nd Year', 'group'=>'Science',         'exam'=>'Test Exam',  'note'=>'Board pattern — full syllabus'],
    ['subject'=>'Chemistry',   'year'=>'2nd Year', 'group'=>'Science',         'exam'=>'Test Exam',  'note'=>'Board pattern — full syllabus'],
    ['subject'=>'Accounting',  'year'=>'1st Year', 'group'=>'Business Studies','exam'=>'All Exams',  'note'=>'NCTB Accounting 1st Paper & 2nd Paper'],
    ['subject'=>'Economics',   'year'=>'Both',     'group'=>'Business Studies','exam'=>'All Exams',  'note'=>'Both papers prescribed'],
    ['subject'=>'Business Org.','year'=>'1st Year','group'=>'Business Studies','exam'=>'All Exams',  'note'=>'Management & Organisation'],
    ['subject'=>'Finance',     'year'=>'2nd Year', 'group'=>'Business Studies','exam'=>'All Exams',  'note'=>'Banking and Finance'],
    ['subject'=>'History',     'year'=>'Both',     'group'=>'Humanities',      'exam'=>'All Exams',  'note'=>'History of Bangladesh & World Civilization'],
    ['subject'=>'Civics',      'year'=>'Both',     'group'=>'Humanities',      'exam'=>'All Exams',  'note'=>'Political Science & Good Governance'],
    ['subject'=>'Economics',   'year'=>'Both',     'group'=>'Humanities',      'exam'=>'All Exams',  'note'=>'Both papers prescribed'],
    ['subject'=>'Philosophy',  'year'=>'2nd Year', 'group'=>'Humanities',      'exam'=>'All Exams',  'note'=>'Logic & Metaphysics'],
];

// Filter
$filtered = array_filter($allSyllabus, function($s) use ($selYear, $selGroup, $selExam) {
    $yearMatch  = $selYear  === 'All Years'  || $s['year']  === 'Both' || $s['year']  === $selYear;
    $groupMatch = $selGroup === 'All Groups' || $s['group'] === 'All'  || $s['group'] === $selGroup;
    $examMatch  = $selExam  === 'All Exams'  || $s['exam']  === 'All Exams' || $s['exam']  === $selExam;
    return $yearMatch && $groupMatch && $examMatch;
});

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-breadcrumb">
                <a href="../index.php">Home</a>
                <i class="fas fa-chevron-right"></i>
                <span>Syllabus</span>
            </div>
            <div class="ph-kicker reveal">Academic Info</div>
            <h1 class="reveal">Syllabus</h1>
            <p class="reveal">Subject-wise syllabus for each year, group, and examination</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <div class="ai-top-row">
                <span class="ai-session-label"><i class="fas fa-book-open"></i> Session: 2024–2025 — As per NCTB & Dhaka Board</span>
                <div class="ai-meta-row">
                    <span class="ai-last-updated">Last Updated: <?php echo $last_updated; ?></span>
                    <button class="ai-print-btn" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>

            <!-- Filters -->
            <form method="GET" class="ai-filter-bar" style="margin-bottom:24px;">
                <label>Year</label>
                <select name="year" class="ai-filter-select" onchange="this.form.submit()">
                    <option value="All Years"  <?php echo $selYear==='All Years'?'selected':''; ?>>All Years</option>
                    <?php foreach($years as $y): ?>
                    <option value="<?php echo $y; ?>" <?php echo $selYear===$y?'selected':''; ?>><?php echo $y; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="ai-filter-sep"></div>
                <label>Group</label>
                <select name="group" class="ai-filter-select" onchange="this.form.submit()">
                    <?php foreach($groups as $g): ?>
                    <option value="<?php echo $g; ?>" <?php echo $selGroup===$g?'selected':''; ?>><?php echo $g; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="ai-filter-sep"></div>
                <label>Exam</label>
                <select name="exam" class="ai-filter-select" onchange="this.form.submit()">
                    <?php foreach($examTypes as $e): ?>
                    <option value="<?php echo $e; ?>" <?php echo $selExam===$e?'selected':''; ?>><?php echo $e; ?></option>
                    <?php endforeach; ?>
                </select>
            </form>

            <?php if (!empty($filtered)): ?>
            <div class="ai-syllabus-grid">
                <?php foreach($filtered as $s): ?>
                <div class="ai-syllabus-card reveal">
                    <div>
                        <div class="syl-subject"><?php echo htmlspecialchars($s['subject']); ?></div>
                        <div class="syl-meta" style="margin-top:4px;">
                            <?php
                            $yr = $s['year'] === 'Both' ? '1st & 2nd Year' : $s['year'];
                            $gr = $s['group'] === 'All'  ? 'All Groups'     : $s['group'];
                            echo htmlspecialchars("$yr · $gr");
                            ?>
                        </div>
                    </div>
                    <div>
                        <span class="ai-badge badge-college" style="margin-bottom:8px;display:inline-flex;"><?php echo htmlspecialchars($s['exam']); ?></span>
                        <div style="font-size:.78rem;color:var(--muted);font-family:'Inter',sans-serif;line-height:1.5;"><?php echo htmlspecialchars($s['note']); ?></div>
                    </div>
                    <a href="#" class="syl-download" onclick="alert('Syllabus PDF will be available once uploaded.');return false;">
                        <i class="fas fa-download"></i> Download Syllabus
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="ai-not-published">
                <i class="fas fa-book-open"></i>
                <h3>No Syllabus Found</h3>
                <p>No syllabus matches your current filter selection. Try adjusting the Year, Group, or Exam type.</p>
            </div>
            <?php endif; ?>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>
