<?php
$page       = 'admit-card';
$page_group = 'academic';
$page_title = 'Admit Card | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'May 31, 2025';

$examTypes = ['Half-Yearly', 'Year-Change', 'Pre-Test', 'Test Exam'];
$years     = ['1st Year', '2nd Year'];

// Sample admit card data (simulated)
$sampleCards = [
    '1001' => ['name'=>'Fatema Akter',    'roll'=>'1001','group'=>'Science',          'section'=>'A','year'=>'2nd Year','exam'=>'Pre-Test',   'subjects'=>['Bangla','English','Physics','Chemistry','Biology','ICT']],
    '1002' => ['name'=>'Nasrin Begum',    'roll'=>'1002','group'=>'Science',          'section'=>'A','year'=>'2nd Year','exam'=>'Pre-Test',   'subjects'=>['Bangla','English','Physics','Chemistry','Biology','Higher Math']],
    '1003' => ['name'=>'Rina Parvin',     'roll'=>'1003','group'=>'Humanities',       'section'=>'A','year'=>'1st Year','exam'=>'Half-Yearly','subjects'=>['Bangla','English','History','Civics','Economics']],
    '1004' => ['name'=>'Sumaiya Khatun', 'roll'=>'1004','group'=>'Business Studies', 'section'=>'B','year'=>'1st Year','exam'=>'Half-Yearly','subjects'=>['Bangla','English','Accounting','Economics','Business Org.']],
    '1005' => ['name'=>'Mitu Akter',      'roll'=>'1005','group'=>'Science',          'section'=>'B','year'=>'2nd Year','exam'=>'Test Exam',  'subjects'=>['Bangla','English','Physics','Chemistry','Biology','ICT']],
];

$searched = false;
$found = null;
$searchRoll = '';
$searchExam = '';
$searchYear = '';

if (!empty($_GET['roll'])) {
    $searched = true;
    $searchRoll = trim($_GET['roll'] ?? '');
    $searchExam = $_GET['exam'] ?? '';
    $searchYear = $_GET['year'] ?? '';

    if (isset($sampleCards[$searchRoll])) {
        $card = $sampleCards[$searchRoll];
        if ($card['exam'] === $searchExam && $card['year'] === $searchYear) {
            $found = $card;
        }
    }
}

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">

            <div class="ph-kicker reveal">Academic Info</div>
            <h1 class="reveal">Admit Card</h1>
            <p class="reveal">Download your examination admit card by entering your roll number</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <div class="ai-top-row">
                <span class="ai-session-label"><i class="fas fa-id-card"></i> Session: 2024–2025 — Admit cards are issued by the college administration</span>
                <div class="ai-meta-row">
                    <span class="ai-last-updated">Last Updated: <?php echo $last_updated; ?></span>
                </div>
            </div>

            <!-- Search Form -->
            <div class="ai-search-card reveal">
                <h2><i class="fas fa-search"></i> Search Admit Card</h2>
                <form method="GET">
                    <div class="ai-search-grid">
                        <div class="ai-form-group">
                            <label for="rollInput">Roll Number</label>
                            <input type="text" id="rollInput" name="roll" placeholder="Enter your roll number" value="<?php echo htmlspecialchars($searchRoll); ?>">
                        </div>
                        <div class="ai-form-group">
                            <label for="yearSelect">Year</label>
                            <select id="yearSelect" name="year">
                                <option value="">Select Year</option>
                                <?php foreach($years as $y): ?>
                                <option value="<?php echo $y; ?>" <?php echo $searchYear===$y?'selected':''; ?>><?php echo $y; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="ai-form-group" style="grid-column:1/-1;">
                            <label for="examSelect">Exam Type</label>
                            <select id="examSelect" name="exam">
                                <option value="">Select Exam</option>
                                <?php foreach($examTypes as $e): ?>
                                <option value="<?php echo $e; ?>" <?php echo $searchExam===$e?'selected':''; ?>><?php echo $e; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="ai-search-btn"><i class="fas fa-search"></i> Search Admit Card</button>
                </form>
                <p style="font-size:.72rem;color:#94a3b8;margin-top:12px;text-align:center;font-family:'Inter',sans-serif;">
                    Demo: try roll <strong>1001–1005</strong> with matching Exam/Year to see a sample admit card
                </p>
            </div>

            <!-- Result -->
            <?php if ($searched): ?>
                <?php if ($found): ?>
                <div class="ai-admit-result reveal">
                    <div class="ai-admit-header">
                        <div>
                            <div class="ai-admit-title">Phulpur Mohila Degree College</div>
                            <div style="font-size:.78rem;color:var(--muted);font-family:'Inter',sans-serif;"><?php echo htmlspecialchars($found['exam']); ?> Examination — Academic Session 2024–2025</div>
                        </div>
                        <span class="ai-badge badge-college">Admit Card</span>
                    </div>
                    <div class="ai-admit-grid">
                        <div class="ai-admit-field">
                            <span class="ai-admit-label">Student Name</span>
                            <span class="ai-admit-value"><?php echo htmlspecialchars($found['name']); ?></span>
                        </div>
                        <div class="ai-admit-field">
                            <span class="ai-admit-label">Roll Number</span>
                            <span class="ai-admit-value"><?php echo htmlspecialchars($found['roll']); ?></span>
                        </div>
                        <div class="ai-admit-field">
                            <span class="ai-admit-label">Group</span>
                            <span class="ai-admit-value"><?php echo htmlspecialchars($found['group']); ?></span>
                        </div>
                        <div class="ai-admit-field">
                            <span class="ai-admit-label">Section</span>
                            <span class="ai-admit-value">Section <?php echo htmlspecialchars($found['section']); ?></span>
                        </div>
                        <div class="ai-admit-field">
                            <span class="ai-admit-label">Year</span>
                            <span class="ai-admit-value"><?php echo htmlspecialchars($found['year']); ?></span>
                        </div>
                        <div class="ai-admit-field">
                            <span class="ai-admit-label">Examination</span>
                            <span class="ai-admit-value"><?php echo htmlspecialchars($found['exam']); ?></span>
                        </div>
                    </div>
                    <div style="margin-bottom:16px;">
                        <div style="font-size:.74rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.07em;font-family:'Inter',sans-serif;margin-bottom:8px;">Subjects</div>
                        <div style="display:flex;flex-wrap:wrap;gap:7px;">
                            <?php foreach($found['subjects'] as $sub): ?>
                            <span class="ai-badge badge-college"><?php echo htmlspecialchars($sub); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <hr class="ai-info-divider" style="margin:16px 0;">
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;">
                        <div style="font-size:.76rem;color:var(--muted);font-family:'Inter',sans-serif;">
                            <i class="fas fa-info-circle" style="color:var(--blue);"></i>
                            Bring this admit card + college ID card to every exam. Loss of admit card is not grounds for exemption.
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="ai-not-published" style="margin-top:8px;">
                    <i class="fas fa-id-card"></i>
                    <h3>Admit Card Not Found</h3>
                    <p>No admit card found for Roll <strong><?php echo htmlspecialchars($searchRoll); ?></strong> in the <?php echo htmlspecialchars($searchExam ?: 'selected'); ?> exam for <?php echo htmlspecialchars($searchYear ?: 'selected'); ?>. Please verify your details or contact the college office.</p>
                </div>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>
