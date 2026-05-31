<?php
$page       = 'class-routine';
$page_group = 'academic';
$page_title = 'Class Routine | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'May 31, 2025';

$years    = ['1st Year', '2nd Year'];
$groups   = ['Science', 'Humanities', 'Business Studies'];
$sections = ['A', 'B'];
$days     = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];

$selYear    = $_GET['year']    ?? '1st Year';
$selGroup   = $_GET['group']   ?? 'Science';
$selSection = $_GET['section'] ?? 'A';

// Seeded timetable data — [year][group][section][period][day]
$routines = [
    '1st Year' => [
        'Science' => [
            'A' => [
                1 => ['Saturday'=>['sub'=>'Physics','teacher'=>'Ms. Afroza Begum'],        'Sunday'=>['sub'=>'Chemistry','teacher'=>'Mrs. Rashida Akter'],  'Monday'=>['sub'=>'Biology','teacher'=>'Ms. Nasrin Sultana'],      'Tuesday'=>['sub'=>'Mathematics','teacher'=>'Mrs. Fatema Begum'],  'Wednesday'=>['sub'=>'English','teacher'=>'Ms. Tania Akter'],       'Thursday'=>['sub'=>'Bangla','teacher'=>'Mrs. Morjina Khatun']],
                2 => ['Saturday'=>['sub'=>'Mathematics','teacher'=>'Mrs. Fatema Begum'],   'Sunday'=>['sub'=>'Physics','teacher'=>'Ms. Afroza Begum'],       'Monday'=>['sub'=>'Chemistry','teacher'=>'Mrs. Rashida Akter'],    'Tuesday'=>['sub'=>'Biology','teacher'=>'Ms. Nasrin Sultana'],      'Wednesday'=>['sub'=>'ICT','teacher'=>'Mrs. Sonia Islam'],          'Thursday'=>['sub'=>'English','teacher'=>'Ms. Tania Akter']],
                3 => ['Saturday'=>['sub'=>'Break','teacher'=>''],                           'Sunday'=>['sub'=>'Break','teacher'=>''],                         'Monday'=>['sub'=>'Break','teacher'=>''],                           'Tuesday'=>['sub'=>'Break','teacher'=>''],                           'Wednesday'=>['sub'=>'Break','teacher'=>''],                         'Thursday'=>['sub'=>'Break','teacher'=>'']],
                4 => ['Saturday'=>['sub'=>'Biology','teacher'=>'Ms. Nasrin Sultana'],      'Sunday'=>['sub'=>'Mathematics','teacher'=>'Mrs. Fatema Begum'],  'Monday'=>['sub'=>'Physics','teacher'=>'Ms. Afroza Begum'],        'Tuesday'=>['sub'=>'ICT','teacher'=>'Mrs. Sonia Islam'],            'Wednesday'=>['sub'=>'Chemistry','teacher'=>'Mrs. Rashida Akter'], 'Thursday'=>['sub'=>'Mathematics','teacher'=>'Mrs. Fatema Begum']],
                5 => ['Saturday'=>['sub'=>'English','teacher'=>'Ms. Tania Akter'],         'Sunday'=>['sub'=>'ICT','teacher'=>'Mrs. Sonia Islam'],           'Monday'=>['sub'=>'Bangla','teacher'=>'Mrs. Morjina Khatun'],      'Tuesday'=>['sub'=>'Physics','teacher'=>'Ms. Afroza Begum'],        'Wednesday'=>['sub'=>'Biology','teacher'=>'Ms. Nasrin Sultana'],   'Thursday'=>['sub'=>'Chemistry','teacher'=>'Mrs. Rashida Akter']],
                6 => ['Saturday'=>['sub'=>'Bangla','teacher'=>'Mrs. Morjina Khatun'],      'Sunday'=>['sub'=>'English','teacher'=>'Ms. Tania Akter'],        'Monday'=>['sub'=>'Mathematics','teacher'=>'Mrs. Fatema Begum'],   'Tuesday'=>['sub'=>'Chemistry','teacher'=>'Mrs. Rashida Akter'],   'Wednesday'=>['sub'=>'Physics','teacher'=>'Ms. Afroza Begum'],      'Thursday'=>['sub'=>'Biology','teacher'=>'Ms. Nasrin Sultana']],
            ],
        ],
        'Humanities' => [
            'A' => [
                1 => ['Saturday'=>['sub'=>'Bangla','teacher'=>'Mrs. Morjina Khatun'],     'Sunday'=>['sub'=>'English','teacher'=>'Ms. Tania Akter'],        'Monday'=>['sub'=>'Civics','teacher'=>'Ms. Roksana Begum'],        'Tuesday'=>['sub'=>'History','teacher'=>'Ms. Popy Begum'],          'Wednesday'=>['sub'=>'Economics','teacher'=>'Mrs. Shaila Parvin'],  'Thursday'=>['sub'=>'Bangla','teacher'=>'Mrs. Morjina Khatun']],
                2 => ['Saturday'=>['sub'=>'English','teacher'=>'Ms. Tania Akter'],        'Sunday'=>['sub'=>'History','teacher'=>'Ms. Popy Begum'],         'Monday'=>['sub'=>'Bangla','teacher'=>'Mrs. Morjina Khatun'],      'Tuesday'=>['sub'=>'Economics','teacher'=>'Mrs. Shaila Parvin'],    'Wednesday'=>['sub'=>'Civics','teacher'=>'Ms. Roksana Begum'],      'Thursday'=>['sub'=>'English','teacher'=>'Ms. Tania Akter']],
                3 => ['Saturday'=>['sub'=>'Break','teacher'=>''],                          'Sunday'=>['sub'=>'Break','teacher'=>''],                         'Monday'=>['sub'=>'Break','teacher'=>''],                           'Tuesday'=>['sub'=>'Break','teacher'=>''],                           'Wednesday'=>['sub'=>'Break','teacher'=>''],                         'Thursday'=>['sub'=>'Break','teacher'=>'']],
                4 => ['Saturday'=>['sub'=>'Economics','teacher'=>'Mrs. Shaila Parvin'],   'Sunday'=>['sub'=>'Civics','teacher'=>'Ms. Roksana Begum'],       'Monday'=>['sub'=>'History','teacher'=>'Ms. Popy Begum'],          'Tuesday'=>['sub'=>'Bangla','teacher'=>'Mrs. Morjina Khatun'],      'Wednesday'=>['sub'=>'English','teacher'=>'Ms. Tania Akter'],       'Thursday'=>['sub'=>'History','teacher'=>'Ms. Popy Begum']],
                5 => ['Saturday'=>['sub'=>'Civics','teacher'=>'Ms. Roksana Begum'],       'Sunday'=>['sub'=>'Economics','teacher'=>'Mrs. Shaila Parvin'],   'Monday'=>['sub'=>'English','teacher'=>'Ms. Tania Akter'],         'Tuesday'=>['sub'=>'History','teacher'=>'Ms. Popy Begum'],          'Wednesday'=>['sub'=>'Bangla','teacher'=>'Mrs. Morjina Khatun'],   'Thursday'=>['sub'=>'Civics','teacher'=>'Ms. Roksana Begum']],
                6 => ['Saturday'=>['sub'=>'History','teacher'=>'Ms. Popy Begum'],         'Sunday'=>['sub'=>'Bangla','teacher'=>'Mrs. Morjina Khatun'],     'Monday'=>['sub'=>'Economics','teacher'=>'Mrs. Shaila Parvin'],    'Tuesday'=>['sub'=>'Civics','teacher'=>'Ms. Roksana Begum'],        'Wednesday'=>['sub'=>'History','teacher'=>'Ms. Popy Begum'],        'Thursday'=>['sub'=>'Economics','teacher'=>'Mrs. Shaila Parvin']],
            ],
        ],
        'Business Studies' => [
            'A' => [
                1 => ['Saturday'=>['sub'=>'Accounting','teacher'=>'Ms. Dilruba Islam'],   'Sunday'=>['sub'=>'Economics','teacher'=>'Mrs. Shaila Parvin'],   'Monday'=>['sub'=>'Bangla','teacher'=>'Mrs. Morjina Khatun'],      'Tuesday'=>['sub'=>'English','teacher'=>'Ms. Tania Akter'],         'Wednesday'=>['sub'=>'ICT','teacher'=>'Mrs. Sonia Islam'],          'Thursday'=>['sub'=>'Accounting','teacher'=>'Ms. Dilruba Islam']],
                2 => ['Saturday'=>['sub'=>'English','teacher'=>'Ms. Tania Akter'],        'Sunday'=>['sub'=>'Accounting','teacher'=>'Ms. Dilruba Islam'],   'Monday'=>['sub'=>'Economics','teacher'=>'Mrs. Shaila Parvin'],    'Tuesday'=>['sub'=>'ICT','teacher'=>'Mrs. Sonia Islam'],            'Wednesday'=>['sub'=>'Bangla','teacher'=>'Mrs. Morjina Khatun'],   'Thursday'=>['sub'=>'English','teacher'=>'Ms. Tania Akter']],
                3 => ['Saturday'=>['sub'=>'Break','teacher'=>''],                          'Sunday'=>['sub'=>'Break','teacher'=>''],                         'Monday'=>['sub'=>'Break','teacher'=>''],                           'Tuesday'=>['sub'=>'Break','teacher'=>''],                           'Wednesday'=>['sub'=>'Break','teacher'=>''],                         'Thursday'=>['sub'=>'Break','teacher'=>'']],
                4 => ['Saturday'=>['sub'=>'Bangla','teacher'=>'Mrs. Morjina Khatun'],     'Sunday'=>['sub'=>'ICT','teacher'=>'Mrs. Sonia Islam'],           'Monday'=>['sub'=>'Accounting','teacher'=>'Ms. Dilruba Islam'],    'Tuesday'=>['sub'=>'Economics','teacher'=>'Mrs. Shaila Parvin'],    'Wednesday'=>['sub'=>'Economics','teacher'=>'Mrs. Shaila Parvin'],  'Thursday'=>['sub'=>'ICT','teacher'=>'Mrs. Sonia Islam']],
                5 => ['Saturday'=>['sub'=>'ICT','teacher'=>'Mrs. Sonia Islam'],           'Sunday'=>['sub'=>'Bangla','teacher'=>'Mrs. Morjina Khatun'],     'Monday'=>['sub'=>'English','teacher'=>'Ms. Tania Akter'],         'Tuesday'=>['sub'=>'Accounting','teacher'=>'Ms. Dilruba Islam'],    'Wednesday'=>['sub'=>'Accounting','teacher'=>'Ms. Dilruba Islam'],  'Thursday'=>['sub'=>'Bangla','teacher'=>'Mrs. Morjina Khatun']],
                6 => ['Saturday'=>['sub'=>'Economics','teacher'=>'Mrs. Shaila Parvin'],   'Sunday'=>['sub'=>'English','teacher'=>'Ms. Tania Akter'],        'Monday'=>['sub'=>'ICT','teacher'=>'Mrs. Sonia Islam'],            'Tuesday'=>['sub'=>'Bangla','teacher'=>'Mrs. Morjina Khatun'],      'Wednesday'=>['sub'=>'English','teacher'=>'Ms. Tania Akter'],       'Thursday'=>['sub'=>'Economics','teacher'=>'Mrs. Shaila Parvin']],
            ],
        ],
    ],
];

$periodLabels = [
    1 => 'Period 1 (8:00–8:45)',
    2 => 'Period 2 (8:45–9:30)',
    3 => 'Break (9:30–10:00)',
    4 => 'Period 3 (10:00–10:45)',
    5 => 'Period 4 (10:45–11:30)',
    6 => 'Period 5 (11:30–12:15)',
];

$routine = $routines[$selYear][$selGroup][$selSection] ?? null;

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-breadcrumb">
                <a href="../index.php">Home</a>
                <i class="fas fa-chevron-right"></i>
                <span>Class Routine</span>
            </div>
            <div class="ph-kicker reveal">Academic Info</div>
            <h1 class="reveal">Class Routine</h1>
            <p class="reveal">Weekly class schedule for each year, group, and section</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <div class="ai-top-row">
                <span class="ai-session-label"><i class="fas fa-calendar"></i> Academic Session: 2024–2025</span>
                <div class="ai-meta-row">
                    <span class="ai-last-updated">Last Updated: <?php echo $last_updated; ?></span>
                    <button class="ai-print-btn" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>

            <!-- Filters -->
            <form method="GET" class="ai-filter-bar" style="margin-bottom:24px;">
                <label>Year</label>
                <select name="year" class="ai-filter-select" onchange="this.form.submit()">
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
                <label>Section</label>
                <select name="section" class="ai-filter-select" onchange="this.form.submit()">
                    <?php foreach($sections as $s): ?>
                    <option value="<?php echo $s; ?>" <?php echo $selSection===$s?'selected':''; ?>>Section <?php echo $s; ?></option>
                    <?php endforeach; ?>
                </select>
            </form>

            <?php if ($routine): ?>
            <div class="ai-card">
                <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;font-family:'Inter',sans-serif;">
                    <i class="fas fa-chalkboard" style="color:var(--blue);"></i>
                    <strong style="font-size:.95rem;color:var(--navy);"><?php echo $selYear; ?> — <?php echo $selGroup; ?> Group — Section <?php echo $selSection; ?></strong>
                </div>
                <div class="ai-timetable-wrap">
                    <table class="ai-timetable">
                        <thead>
                            <tr>
                                <th>Period / Time</th>
                                <?php foreach($days as $d): ?><th><?php echo $d; ?></th><?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($periodLabels as $p => $label): ?>
                        <tr>
                            <td class="period-label"><?php echo $label; ?></td>
                            <?php foreach($days as $d):
                                $cell = $routine[$p][$d] ?? null;
                                $isBreak = !$cell || $cell['sub'] === 'Break';
                            ?>
                            <td>
                                <?php if($isBreak): ?>
                                    <span class="tt-cell-break">— Break —</span>
                                <?php else: ?>
                                    <span class="tt-cell-subject"><?php echo htmlspecialchars($cell['sub']); ?></span>
                                    <span class="tt-cell-teacher"><?php echo htmlspecialchars($cell['teacher']); ?></span>
                                <?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php else: ?>
            <div class="ai-not-published">
                <i class="fas fa-chalkboard"></i>
                <h3>Routine Not Available</h3>
                <p>The class routine for <?php echo "$selYear — $selGroup Group — Section $selSection"; ?> has not been published yet. Please check back later.</p>
            </div>
            <?php endif; ?>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>
