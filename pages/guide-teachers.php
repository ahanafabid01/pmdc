<?php
$page       = 'guide-teachers';
$page_group = 'academic';
$page_title = 'Guide Teachers List | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'May 31, 2025';

$guideTeachers = [
    '1st Year' => [
        ['teacher'=>'Ms. Afroza Begum',   'designation'=>'Senior Lecturer', 'section'=>'A', 'group'=>'Science',          'phone'=>'+880-1700-000011'],
        ['teacher'=>'Mrs. Rashida Akter', 'designation'=>'Lecturer',        'section'=>'B', 'group'=>'Science',          'phone'=>'+880-1700-000012'],
        ['teacher'=>'Ms. Nasrin Sultana', 'designation'=>'Lecturer',        'section'=>'A', 'group'=>'Humanities',       'phone'=>'+880-1700-000013'],
        ['teacher'=>'Mrs. Shaila Parvin', 'designation'=>'Lecturer',        'section'=>'B', 'group'=>'Humanities',       'phone'=>'+880-1700-000016'],
        ['teacher'=>'Ms. Dilruba Islam',  'designation'=>'Lecturer',        'section'=>'A', 'group'=>'Business Studies', 'phone'=>'+880-1700-000015'],
        ['teacher'=>'Ms. Roksana Begum',  'designation'=>'Asst. Lecturer',  'section'=>'B', 'group'=>'Business Studies', 'phone'=>'+880-1700-000017'],
    ],
    '2nd Year' => [
        ['teacher'=>'Mrs. Fatema Begum',  'designation'=>'Senior Lecturer', 'section'=>'A', 'group'=>'Science',          'phone'=>'+880-1700-000014'],
        ['teacher'=>'Mrs. Sonia Islam',   'designation'=>'Asst. Lecturer',  'section'=>'B', 'group'=>'Science',          'phone'=>'+880-1700-000020'],
        ['teacher'=>'Ms. Popy Begum',     'designation'=>'Lecturer',        'section'=>'A', 'group'=>'Humanities',       'phone'=>'+880-1700-000021'],
        ['teacher'=>'Ms. Tania Akter',    'designation'=>'Lecturer',        'section'=>'B', 'group'=>'Humanities',       'phone'=>'+880-1700-000019'],
        ['teacher'=>'Mrs. Morjina Khatun','designation'=>'Lecturer',        'section'=>'A', 'group'=>'Business Studies', 'phone'=>'+880-1700-000018'],
        ['teacher'=>'Ms. Nasrin Sultana', 'designation'=>'Lecturer',        'section'=>'B', 'group'=>'Business Studies', 'phone'=>'+880-1700-000013'],
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
