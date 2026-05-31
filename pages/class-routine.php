<?php
$page         = 'class-routine';
$page_group   = 'academic';
$page_title   = 'Class Routine | Phulpur Mohila Degree College';
$page_css     = 'academic.css';
$base_path    = '../';
$last_updated = 'May 31, 2026';

$hscRoutine = [
    'Class XI' => [
        ['day' => 'Sunday',    'periods' => ['Bangla K/Kh (19/24)', 'Islamic Studies-19, Biology-10, Accounting', 'History-19, Mathematics-10', 'Civics & Phy.-10, P/N, Business Org.-16', 'English K/Kh (19/24)', 'Social Work K/Kh, Chemistry-10, Marketing-16']],
        ['day' => 'Monday',    'periods' => ['Economics', 'ICT', 'Civics', 'Bangla', 'History, Physics', 'Islamic Studies, Geo.']],
        ['day' => 'Tuesday',   'periods' => ['English', 'Physical Exercise', 'Social Work, Chemistry, Accounting', 'Logic, Mathematics, Marketing', 'Bangla', 'Geography, Physics-b(+)']],
        ['day' => 'Wednesday', 'periods' => ['ICT', 'Logic, Chemistry, Business, Organization', 'Economics, Physics', 'Social Work, Bio., Accounting', 'English', 'Geography, Bio.-b(+)']],
        ['day' => 'Thursday',  'periods' => ['Logic, Bio.-Science, Business Org.', 'Bangla', 'Geography, Mathematics', 'Civics, Chemistry, Bio-Science, Accounting', 'Economics, Physics', 'Marketing']],
    ],
    'Class XII' => [
        ['day' => 'Sunday',    'periods' => ['Economics-12, Physics-06b', 'English 12-10', 'Logic-12, Chemistry-06b, Marketing-18b', 'ICT-18/12', 'Civics, Mathematics-06b, Accounting', 'Geo., Bio.-06b']],
        ['day' => 'Monday',    'periods' => ['Geography', 'ICT-P(21)', 'Civics, Bio., Marketing', 'Eco., Bangla', 'History, Physics', 'ICT-T+...']],
        ['day' => 'Tuesday',   'periods' => ['Social Work, Physics-b(+)', 'Physical Exercise', 'Geography, Mathematics', 'English', 'Logic, Chemistry, Accounting, Marketing', 'Bangla']],
        ['day' => 'Wednesday', 'periods' => ['Geography, Bio. Science, Business-practical', 'Civics, Bio.', 'English', 'Economics, Chemistry', 'Logic, Physics, Business Org.', 'Social Work']],
        ['day' => 'Thursday',  'periods' => ['Islamic Studies, Chemistry, Marketing', 'English-P(1)', 'Social Work, Physics, Accounting, Business Org.', 'History, Bio-Science, Business Org.', 'ICT', 'Physics-b(+)']],
    ],
];

$degreeRoutine = [
    ['day' => 'Saturday', 'rows' => [
        ['year' => '1st Year', 'periods' => ['History, Chemistry', 'Political Science, Botany', 'Social Welfare, Zoology', 'Islamic Studies', 'Development History']],
        ['year' => '2nd Year', 'periods' => ['Social Welfare, Botany', 'Economics, Zoology', 'Political Science, Bangla', 'Islamic Studies', '—']],
        ['year' => '3rd Year', 'periods' => ['Philosophy, Zoology', 'Islamic Studies, Chemistry', 'Economics, Botany', 'History', '—']],
    ]],
    ['day' => 'Sunday', 'rows' => [
        ['year' => '1st Year', 'periods' => ['Political Science', 'Development History of Bangladesh', 'Islamic Studies, Zoology', 'Economics, Botany', 'History']],
        ['year' => '2nd Year', 'periods' => ['History', 'Economics, Zoology', 'Political Science', 'Islamic Studies', '—']],
        ['year' => '3rd Year', 'periods' => ['Islamic Studies', 'Economics, Zoology', '—', '—', '—']],
    ]],
];

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
            <p class="reveal">Prospectus sample routines for HSC and Degree sections</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <div class="ai-top-row">
                <span class="ai-session-label"><i class="fas fa-calendar"></i> Source: PMDC Prospectus (Sample Routine)</span>
                <div class="ai-meta-row">
                    <span class="ai-last-updated">Last Updated: <?php echo $last_updated; ?></span>
                    <button class="ai-print-btn" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>

            <div class="ai-content-section reveal" style="margin-bottom:32px;">
                <h2><i class="fas fa-school"></i> HSC Class Routine 2023</h2>
                <p style="margin:-6px 0 18px;color:var(--muted);font-family:'Inter',sans-serif;">মানবিক / বিজ্ঞান / ব্যবসায় শিক্ষা</p>

                <?php foreach ($hscRoutine as $className => $rows): ?>
                <div class="ai-card" style="margin-bottom:24px; overflow:hidden;">
                    <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;font-family:'Inter',sans-serif;">
                        <i class="fas fa-chalkboard" style="color:var(--blue);"></i>
                        <strong style="font-size:.95rem;color:var(--navy);"><?php echo htmlspecialchars($className); ?></strong>
                    </div>
                    <div class="ai-timetable-wrap">
                        <table class="ai-timetable">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>10:00–10:80</th>
                                    <th>10:80–11:20</th>
                                    <th>11:20–12:00</th>
                                    <th>12:00–12:80</th>
                                    <th>12:80–1:20</th>
                                    <th>1:20–1:55</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $row): ?>
                                <tr>
                                    <td class="period-label"><?php echo htmlspecialchars($row['day']); ?></td>
                                    <?php foreach ($row['periods'] as $period): ?>
                                    <td><?php echo htmlspecialchars($period); ?></td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endforeach; ?>

                <div style="font-size:.82rem;color:var(--muted);font-family:'Inter',sans-serif;margin-top:8px;">
                    This is the 2023 routine from the prospectus. Replace with the current year's routine when updating the website.
                </div>
            </div>

            <div class="ai-content-section reveal" style="margin-bottom:32px;">
                <h2><i class="fas fa-university"></i> Degree Class Routine</h2>
                <p style="margin:-6px 0 18px;color:var(--muted);font-family:'Inter',sans-serif;">Saturday–Thursday</p>

                <div class="ai-card" style="overflow:hidden;">
                    <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;font-family:'Inter',sans-serif;">
                        <i class="fas fa-book-open" style="color:var(--blue);"></i>
                        <strong style="font-size:.95rem;color:var(--navy);">Prospectus Sample Routine</strong>
                    </div>
                    <div class="ai-timetable-wrap">
                        <table class="ai-timetable">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Year</th>
                                    <th>10:30–11:20</th>
                                    <th>11:20–12:00</th>
                                    <th>12:00–12:80</th>
                                    <th>12:80–1:20</th>
                                    <th>1:20–</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($degreeRoutine as $dayBlock): ?>
                                    <?php foreach ($dayBlock['rows'] as $index => $row): ?>
                                    <tr>
                                        <?php if ($index === 0): ?>
                                        <td class="period-label" rowspan="<?php echo count($dayBlock['rows']); ?>"><?php echo htmlspecialchars($dayBlock['day']); ?></td>
                                        <?php endif; ?>
                                        <td><?php echo htmlspecialchars($row['year']); ?></td>
                                        <?php foreach ($row['periods'] as $period): ?>
                                        <td><?php echo htmlspecialchars($period); ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="font-size:.82rem;color:var(--muted);font-family:'Inter',sans-serif;margin-top:8px;">
                    This is sample data from the prospectus. Update with the current session schedule.
                </div>
            </div>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>