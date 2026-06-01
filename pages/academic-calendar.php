<?php
$page       = 'academic-calendar';
$page_group = 'academic';
$page_title = 'Academic Calendar | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'May 31, 2026';

$sessions = ['2024–2025', '2023–2024'];
$currentSession = $_GET['session'] ?? '2024–2025';

$calendar = [
    'January 2025' => [
        ['date'=>'01 Jan', 'event'=>'New Year — College Closed',          'notes'=>'Public holiday', 'important'=>false],
        ['date'=>'15 Jan', 'event'=>'Class Commencement (2nd Year)',       'notes'=>'All groups resume', 'important'=>true],
        ['date'=>'20 Jan', 'event'=>'Half-Yearly / Year-Change planning begins', 'notes'=>'Class XI exam schedule update', 'important'=>true],
    ],
    'February 2025' => [
        ['date'=>'01 Feb', 'event'=>'Half-Yearly Exam Registration Begins','notes'=>'Deadline: Feb 15', 'important'=>true],
        ['date'=>'21 Feb', 'event'=>'International Mother Language Day',   'notes'=>'College closed', 'important'=>false],
    ],
    'March 2025' => [
        ['date'=>'01 Mar', 'event'=>'Half-Yearly Examination Begins',      'notes'=>'HSC 1st Year', 'important'=>true],
        ['date'=>'15 Mar', 'event'=>'Half-Yearly Examination Ends',        'notes'=>'Results expected in April', 'important'=>true],
        ['date'=>'26 Mar', 'event'=>'Independence Day',                    'notes'=>'College closed', 'important'=>false],
    ],
    'April 2025' => [
        ['date'=>'01 Apr', 'event'=>'Half-Yearly Result Published',        'notes'=>'Check notice board', 'important'=>true],
        ['date'=>'14 Apr', 'event'=>'Bengali New Year (Pahela Baishakh)',  'notes'=>'College closed', 'important'=>false],
        ['date'=>'20 Apr', 'event'=>'Annual Sports Day',                   'notes'=>'Main ground, 9:00 AM', 'important'=>false],
    ],
    'May 2025' => [
        ['date'=>'01 May', 'event'=>'May Day — College Closed',            'notes'=>'Public holiday', 'important'=>false],
        ['date'=>'10 May', 'event'=>'Pre-Test Examination Registration',   'notes'=>'HSC 2nd Year only', 'important'=>true],
        ['date'=>'25 May', 'event'=>'Pre-Test Examination Begins',         'notes'=>'HSC 2nd Year', 'important'=>true],
    ],
    'June 2025' => [
        ['date'=>'07 Jun', 'event'=>'Eid-ul-Adha Vacation Begins',         'notes'=>'3-day holiday', 'important'=>false],
        ['date'=>'15 Jun', 'event'=>'Pre-Test Examination Ends',           'notes'=>'Results in July', 'important'=>true],
    ],
    'July 2025' => [
        ['date'=>'05 Jul', 'event'=>'Pre-Test Result Published',           'notes'=>'Check notice board', 'important'=>true],
        ['date'=>'15 Jul', 'event'=>'Test Exam Registration Begins',       'notes'=>'HSC 2nd Year only', 'important'=>true],
    ],
    'August 2025' => [
        ['date'=>'01 Aug', 'event'=>'Test Examination Begins',             'notes'=>'HSC 2nd Year', 'important'=>true],
        ['date'=>'15 Aug', 'event'=>'National Mourning Day',               'notes'=>'College closed', 'important'=>false],
        ['date'=>'20 Aug', 'event'=>'Test Examination Ends',               'notes'=>'Admit cards issued 10 days before exam', 'important'=>true],
    ],
    'September 2025' => [
        ['date'=>'01 Sep', 'event'=>'College Foundation Day',              'notes'=>'Cultural program', 'important'=>false],
        ['date'=>'10 Sep', 'event'=>'Test Result Published',               'notes'=>'HSC 2nd Year results', 'important'=>true],
        ['date'=>'20 Sep', 'event'=>'HSC Board Exam Begins',              'notes'=>'Dhaka Board schedule', 'important'=>true],
    ],
    'October 2025' => [
        ['date'=>'02 Oct', 'event'=>'Durga Puja Vacation',                 'notes'=>'2-day holiday', 'important'=>false],
        ['date'=>'15 Oct', 'event'=>'1st Year Annual Exam Registration',   'notes'=>'Deadline: Oct 30', 'important'=>true],
    ],
    'November 2025' => [
        ['date'=>'01 Nov', 'event'=>'1st Year Annual Examination Begins',  'notes'=>'All groups', 'important'=>true],
        ['date'=>'20 Nov', 'event'=>'1st Year Annual Examination Ends',    'notes'=>'', 'important'=>true],
    ],
    'December 2025' => [
        ['date'=>'16 Dec', 'event'=>'Victory Day',                         'notes'=>'College closed', 'important'=>false],
        ['date'=>'25 Dec', 'event'=>'Christmas Day',                       'notes'=>'College closed', 'important'=>false],
        ['date'=>'31 Dec', 'event'=>'Annual Report & Prize Distribution',  'notes'=>'Assembly hall, 10 AM', 'important'=>false],
    ],
];

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">

            <div class="ph-kicker reveal">Academic Info</div>
            <h1 class="reveal">Academic Calendar</h1>
            <p class="reveal">Key academic dates, examinations, and events for each session</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <div class="ai-top-row">
                <form method="GET" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                    <span class="ai-session-label"><i class="fas fa-layer-group"></i> Session:</span>
                    <select name="session" class="ai-filter-select" onchange="this.form.submit()" style="min-width:140px;">
                        <?php foreach($sessions as $s): ?>
                        <option value="<?php echo $s; ?>" <?php echo $currentSession===$s?'selected':''; ?>><?php echo $s; ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
                <div class="ai-meta-row">
                    <span class="ai-last-updated">Last Updated: <?php echo $last_updated; ?></span>
                    <button class="ai-print-btn" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>

            <!-- Legend -->
            <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:24px;font-family:'Inter',sans-serif;font-size:.78rem;align-items:center;">
                <span style="color:var(--muted);font-weight:600;">Legend:</span>
                <span class="ai-badge badge-exam" style="gap:6px;"><i class="fas fa-star" style="font-size:.55rem;"></i> Important</span>
                <span class="ai-badge badge-event" style="gap:6px;"><i class="fas fa-circle" style="font-size:.45rem;"></i> Regular Event</span>
            </div>

            <div class="ai-timeline">
                <?php foreach ($calendar as $month => $events): ?>
                <div class="ai-month-block reveal">
                    <div class="ai-month-heading">
                        <span class="ai-month-pill"><?php echo $month; ?></span>
                        <div class="ai-month-line"></div>
                    </div>
                    <div class="ai-event-list">
                        <?php foreach ($events as $ev): ?>
                        <div class="ai-event-item <?php echo $ev['important'] ? 'ai-event-important' : ''; ?>">
                            <div class="ai-event-date">
                                <span class="ed-day"><?php echo explode(' ',$ev['date'])[0]; ?></span>
                                <span class="ed-mon"><?php echo explode(' ',$ev['date'])[1]; ?></span>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div class="ai-event-name">
                                    <?php if($ev['important']): ?>
                                    <span class="ai-badge badge-exam" style="margin-right:6px;font-size:.65rem;padding:2px 8px;">Key Date</span>
                                    <?php endif; ?>
                                    <?php echo htmlspecialchars($ev['event']); ?>
                                </div>
                                <?php if($ev['notes']): ?>
                                <div class="ai-event-note"><?php echo htmlspecialchars($ev['notes']); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>
