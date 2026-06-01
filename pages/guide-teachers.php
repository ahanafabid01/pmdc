<?php
$page       = 'guide-teachers';
$page_group = 'academic';
$page_title = 'Guide Teachers List | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'June 1, 2026';

// Real staff from PMDC prospectus (pmdc.md §3A)
// Guide teacher assignments are illustrative — update each session with actual assignments
$guideTeachers = [
    '1st Year (Class XI)' => [
        ['teacher'=>'Md. Hafizur Rahman',      'designation'=>'Assistant Professor', 'section'=>'A', 'group'=>'Science',          'phone'=>'01725-659229'],
        ['teacher'=>'Md. Khorshedul Rahman',   'designation'=>'Assistant Professor', 'section'=>'B', 'group'=>'Science',          'phone'=>'01716-490999'],
        ['teacher'=>'Md. Ali Akbar',           'designation'=>'Assistant Professor', 'section'=>'A', 'group'=>'Humanities',       'phone'=>'01721-930034'],
        ['teacher'=>'Shaheen Ara Begum',       'designation'=>'Assistant Professor', 'section'=>'B', 'group'=>'Humanities',       'phone'=>'01552-881886'],
        ['teacher'=>'Md. Aminul Haq',          'designation'=>'Assistant Professor', 'section'=>'A', 'group'=>'Business Studies', 'phone'=>'01995-489780'],
        ['teacher'=>'Md. Shafayet Jamil',      'designation'=>'Assistant Professor', 'section'=>'B', 'group'=>'Business Studies', 'phone'=>'01912-509919'],
    ],
    '2nd Year (Class XII)' => [
        ['teacher'=>'Md. Makbul Hosen',        'designation'=>'Assistant Professor', 'section'=>'A', 'group'=>'Science',          'phone'=>'01916-980300'],
        ['teacher'=>'Lily Bilkis Rana',        'designation'=>'Assistant Professor', 'section'=>'B', 'group'=>'Science',          'phone'=>'01918-988038'],
        ['teacher'=>'Md. Hosen Ali',           'designation'=>'Assistant Professor', 'section'=>'A', 'group'=>'Humanities',       'phone'=>'01716-909681'],
        ['teacher'=>'Md. Enamul Haq',          'designation'=>'Assistant Professor', 'section'=>'B', 'group'=>'Humanities',       'phone'=>'01984-880389'],
        ['teacher'=>'Md. Saiful Islam',        'designation'=>'Assistant Professor', 'section'=>'A', 'group'=>'Business Studies', 'phone'=>'01912-182229'],
        ['teacher'=>'Mohammad Alamgir',        'designation'=>'Assistant Professor', 'section'=>'B', 'group'=>'Business Studies', 'phone'=>'01914-603985'],
    ],
];

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-breadcrumb">
                <a href="../index.php">Home</a>
                <i class="fas fa-chevron-right"></i>
                <span>Guide Teachers List</span>
            </div>
            <div class="ph-kicker reveal">Academic Info</div>
            <h1 class="reveal">Guide Teachers List</h1>
            <p class="reveal">Assigned guide teachers for each section and group — Session 2024–2025</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <div class="ai-top-row">
                <span class="ai-session-label"><i class="fas fa-chalkboard-teacher"></i> Your guide teacher is your first point of contact for academic concerns</span>
                <div class="ai-meta-row">
                    <span class="ai-last-updated">Last Updated: <?php echo $last_updated; ?></span>
                    <button class="ai-print-btn" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>

            <?php foreach ($guideTeachers as $year => $teachers): ?>
            <div class="ai-content-section reveal" style="margin-bottom:32px;">
                <div class="ai-section-head">
                    <div class="ai-section-head-left">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <?php echo htmlspecialchars($year); ?>
                    </div>
                    <span class="ai-section-badge"><?php echo count($teachers); ?> Teachers</span>
                </div>
                <div class="ai-card">
                    <div class="ai-table-wrap">
                        <table class="ai-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Teacher Name</th>
                                    <th>Designation</th>
                                    <th>Assigned Section</th>
                                    <th>Group</th>
                                    <th>Contact</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($teachers as $i => $t): ?>
                            <tr>
                                <td><span class="ai-rownum"><?php echo $i+1; ?></span></td>
                                <td style="font-weight:700;color:var(--navy);"><?php echo htmlspecialchars($t['teacher']); ?></td>
                                <td><?php echo htmlspecialchars($t['designation']); ?></td>
                                <td>
                                    <span class="ai-badge badge-college">Section <?php echo htmlspecialchars($t['section']); ?></span>
                                </td>
                                <td>
                                    <?php
                                    $gBadge = match($t['group']) {
                                        'Science'          => 'badge-exam',
                                        'Humanities'       => 'badge-religious',
                                        'Business Studies' => 'badge-govt',
                                        default            => 'badge-college',
                                    };
                                    ?>
                                    <span class="ai-badge <?php echo $gBadge; ?>"><?php echo htmlspecialchars($t['group']); ?></span>
                                </td>
                                <td>
                                    <a href="tel:<?php echo htmlspecialchars($t['phone']); ?>" style="font-size:.82rem;color:var(--blue);font-family:'Inter',sans-serif;">
                                        <i class="fas fa-phone" style="font-size:.7rem;margin-right:4px;"></i><?php echo htmlspecialchars($t['phone']); ?>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>
