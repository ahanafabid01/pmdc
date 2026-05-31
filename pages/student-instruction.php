<?php
$page       = 'student-instruction';
$page_group = 'academic';
$page_title = 'Student Instruction | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'May 31, 2025';

$categories = [
    'Admission & Registration' => [
        'Complete your admission process within the deadline mentioned in the college notice. Late admission will not be accepted.',
        'Ensure all submitted documents are original and verified. Any false documentation will result in cancellation of admission.',
        'After admission, collect your college ID card from the administrative office within one week.',
        'Students must register for examinations through the prescribed form available at the college office within the announced deadline.',
        'Keep a photocopy of all submitted documents for your personal records.',
    ],
    'Academic Guidelines' => [
        'Attend all classes regularly and maintain the minimum 75% attendance requirement. Shortfall will bar you from appearing in examinations.',
        'Participate actively in class discussions and submit all assignments and homework on time.',
        'If you are unable to attend class, inform your class teacher in advance and apply for leave in writing.',
        'Students are encouraged to use the library during free periods for self-study and research.',
        'Make proper use of laboratory facilities. Handle equipment carefully and report any damage to the teacher immediately.',
        'Any academic difficulty should be communicated to the subject teacher or guide teacher at the earliest opportunity.',
    ],
    'Examination Guidelines' => [
        'Collect your admit card from the college office before each examination. Verify all details on the admit card carefully.',
        'Report to the examination hall at least 15 minutes before the scheduled start time.',
        'Bring all required stationery (pen, pencil, ruler, etc.) to the examination. Borrowing during examination is not permitted.',
        'Read all instructions on the question paper carefully before beginning to write.',
        'Write your roll number, registration number, and exam name legibly on the answer sheet.',
        'In case of any error in your admit card or answer sheet, immediately inform the invigilator — do not attempt to correct it yourself.',
    ],
    'Fee & Financial Matters' => [
        'Pay all college fees (tuition, examination, session) within the announced deadline. Late payment may incur a fine.',
        'Fees once paid are non-refundable. However, adjustments may be made in exceptional cases — apply in writing to the Principal.',
        'Students facing financial hardship should contact the college office to inquire about available scholarships or fee waiver programs.',
        'Always collect and preserve receipts for all fee payments made to the college.',
    ],
    'Communication & Notices' => [
        'Check the college notice board and official communication channels regularly for important announcements.',
        'Follow the college\'s official website (pmdc.edu.bd) and announcements page for updates on exams, results, and events.',
        'All official communication with the college must be made in writing through the proper channel.',
        'For complaints or grievances, submit a written application to the Principal\'s office. Anonymous complaints will not be entertained.',
        'Parents and guardians are welcome to meet with teachers during designated parent-teacher meeting hours.',
    ],
];

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-breadcrumb">
                <a href="../index.php">Home</a>
                <i class="fas fa-chevron-right"></i>
                <span>Student Instruction</span>
            </div>
            <div class="ph-kicker reveal">Academic Info</div>
            <h1 class="reveal">Student Instruction</h1>
            <p class="reveal">Important instructions for all students of Phulpur Mohila Degree College</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <div class="ai-top-row">
                <span class="ai-session-label"><i class="fas fa-info-circle"></i> Please read all instructions carefully</span>
                <div class="ai-meta-row">
                    <span class="ai-last-updated">Last Updated: <?php echo $last_updated; ?></span>
                    <button class="ai-print-btn" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>

            <?php $globalNum = 1;
            $icons = ['fas fa-user-plus','fas fa-chalkboard','fas fa-pen-alt','fas fa-money-bill-wave','fas fa-bullhorn'];
            $iconIdx = 0;
            foreach ($categories as $catName => $items): ?>
            <div class="ai-content-section reveal" style="margin-bottom:32px;">
                <h2><i class="<?php echo $icons[$iconIdx++ % count($icons)]; ?>"></i> <?php echo htmlspecialchars($catName); ?></h2>
                <div class="ai-rule-list">
                    <?php foreach ($items as $item): ?>
                    <div class="ai-rule-item">
                        <div class="ai-rule-num"><?php echo $globalNum++; ?></div>
                        <div class="ai-rule-body">
                            <div class="ai-rule-desc" style="color:var(--text);"><?php echo htmlspecialchars($item); ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>
