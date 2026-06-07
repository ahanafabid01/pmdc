<?php
$page       = 'exam-routine';
$page_group = 'academic';
$page_title = 'Exam Routine | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'May 31, 2025';

$years    = ['1st Year', '2nd Year'];
$examTypes= ['Half-Yearly', 'Year-Change', 'Pre-Test', 'Test Exam'];

$selYear = $_GET['year'] ?? '2nd Year';
$selExam = $_GET['exam'] ?? 'Pre-Test';

$today = date('Y-m-d');

$exams = [
    '2nd Year' => [
        'Pre-Test' => [
            ['date'=>'2025-05-25','subject'=>'Bangla 1st Paper',   'paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-05-27','subject'=>'Bangla 2nd Paper',   'paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-05-29','subject'=>'English 1st Paper',  'paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-05-31','subject'=>'English 2nd Paper',  'paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-06-02','subject'=>'Physics / Accounting / History','paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-06-04','subject'=>'Physics / Accounting / History','paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-06-08','subject'=>'Chemistry / Economics / Civics','paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-06-10','subject'=>'Chemistry / Economics / Civics','paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-06-12','subject'=>'Biology / Business Org. / Geography','paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-06-14','subject'=>'Biology / Business Org. / Geography','paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-06-16','subject'=>'Higher Mathematics / Philosophy / Finance','paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-06-18','subject'=>'ICT (Practical)','paper'=>'Practical','start'=>'10:00 AM','end'=>'12:00 PM','marks'=>50],
        ],
        'Test Exam' => [
            ['date'=>'2025-08-01','subject'=>'Bangla 1st Paper',   'paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-08-03','subject'=>'Bangla 2nd Paper',   'paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-08-05','subject'=>'English 1st Paper',  'paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-08-07','subject'=>'English 2nd Paper',  'paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-08-10','subject'=>'Physics / Accounting / History','paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-08-12','subject'=>'Physics / Accounting / History','paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-08-14','subject'=>'Chemistry / Economics / Civics','paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-08-16','subject'=>'Chemistry / Economics / Civics','paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-08-18','subject'=>'ICT (Practical)','paper'=>'Practical','start'=>'10:00 AM','end'=>'12:00 PM','marks'=>50],
        ],
        'Half-Yearly' => [
            ['date'=>'2025-03-01','subject'=>'Bangla 1st Paper',  'paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-03-03','subject'=>'Bangla 2nd Paper',  'paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-03-05','subject'=>'English 1st Paper', 'paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-03-07','subject'=>'English 2nd Paper', 'paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-03-10','subject'=>'Optional Subject',  'paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-03-12','subject'=>'Optional Subject',  'paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
        ],
    ],
    '1st Year' => [
        'Half-Yearly' => [
            ['date'=>'2025-03-02','subject'=>'Bangla 1st Paper',  'paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-03-04','subject'=>'Bangla 2nd Paper',  'paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-03-06','subject'=>'English 1st Paper', 'paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-03-08','subject'=>'English 2nd Paper', 'paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-03-11','subject'=>'Optional Subject',  'paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
        ],
        'Year-Change' => [
            ['date'=>'2025-11-01','subject'=>'Bangla 1st Paper',  'paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-11-03','subject'=>'Bangla 2nd Paper',  'paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-11-05','subject'=>'English 1st Paper', 'paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-11-07','subject'=>'English 2nd Paper', 'paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-11-10','subject'=>'Optional Subject 1','paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-11-12','subject'=>'Optional Subject 1','paper'=>'2nd Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-11-14','subject'=>'Optional Subject 2','paper'=>'1st Paper','start'=>'10:00 AM','end'=>'1:00 PM','marks'=>100],
            ['date'=>'2025-11-16','subject'=>'ICT (Practical)',   'paper'=>'Practical','start'=>'10:00 AM','end'=>'12:00 PM','marks'=>50],
        ],
        'Pre-Test' => [],
        'Test Exam' => [],
    ],
];

$schedule = $exams[$selYear][$selExam] ?? [];

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">

            <div class="ph-kicker reveal">
                <span class="show-en">Academic Info</span>
                <span class="show-bn">একাডেমিক তথ্য</span>
            </div>
            <h1 class="reveal">
                <span class="show-en">Exam Routine</span>
                <span class="show-bn">পরীক্ষার রুটিন</span>
            </h1>
            <p class="reveal">Examination schedule for each year and exam type</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <div class="ai-top-row">
                <span class="ai-session-label"><i class="fas fa-calendar"></i> Academic Session: 2024–2025</span>
                <div class="ai-meta-row">
                    <span class="ai-last-updated">Last Updated: <?php echo $last_updated; ?></span>
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
                <label>Exam</label>
                <select name="exam" class="ai-filter-select" onchange="this.form.submit()">
                    <?php foreach($examTypes as $e): ?>
                    <option value="<?php echo $e; ?>" <?php echo $selExam===$e?'selected':''; ?>><?php echo $e; ?></option>
                    <?php endforeach; ?>
                </select>
            </form>

            <?php if (!empty($schedule)): ?>
            <div class="ai-card">
                <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;font-family:'Inter',sans-serif;">
                    <i class="fas fa-pen-alt" style="color:var(--blue);"></i>
                    <strong style="font-size:.95rem;color:var(--navy);"><?php echo "$selYear — $selExam Examination"; ?></strong>
                </div>
                <div class="ai-table-wrap">
                    <table class="ai-table" style="min-width:700px;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Subject</th>
                                <th>Paper</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Full Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($schedule as $row):
                            $ts      = strtotime($row['date']);
                            $isPast  = $row['date'] < $today;
                            $isTdy   = $row['date'] === $today;
                            $rClass  = $isTdy ? 'ai-row-today' : ($isPast ? 'ai-row-past' : '');
                        ?>
                        <tr class="<?php echo $rClass; ?>">
                            <td style="white-space:nowrap;"><?php echo date('d M Y', $ts); ?></td>
                            <td><?php echo date('l', $ts); ?></td>
                            <td style="font-weight:600;color:var(--navy);">
                                <?php if($isTdy): ?><span class="ai-badge badge-today" style="margin-right:6px;font-size:.65rem;">Today</span><?php endif; ?>
                                <?php echo htmlspecialchars($row['subject']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['paper']); ?></td>
                            <td><?php echo $row['start']; ?></td>
                            <td><?php echo $row['end']; ?></td>
                            <td style="font-weight:700;"><?php echo $row['marks']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php else: ?>
            <div class="ai-not-published">
                <i class="fas fa-pen-alt"></i>
                <h3>Routine Not Published</h3>
                <p>The <?php echo "$selExam"; ?> exam routine for <?php echo $selYear; ?> has not been published yet. Please check back later or contact the college office.</p>
            </div>
            <?php endif; ?>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>
