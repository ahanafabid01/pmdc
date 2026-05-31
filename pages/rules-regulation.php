<?php
$page       = 'rules-regulation';
$page_group = 'academic';
$page_title = 'Rules & Regulation | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'May 31, 2025';

$ruleCategories = [
    'Attendance Rules' => [
        ['title'=>'Minimum Attendance Requirement',       'desc'=>'Every student must maintain a minimum of 75% attendance in all classes throughout the academic session. Failure to meet this requirement will result in cancellation of the student\'s examination form.'],
        ['title'=>'Leave of Absence',                     'desc'=>'Students must apply for leave in writing through the proper channel (class teacher → head teacher → Principal) before being absent. Unnotified absences will be marked accordingly.'],
        ['title'=>'Late Entry Policy',                    'desc'=>'Students arriving after 9:15 AM will be marked as late. Three late entries will be counted as one absent. Repeated late entry may result in disciplinary action.'],
        ['title'=>'Record Maintenance',                   'desc'=>'Attendance records are maintained class-wise and made available to guardians upon request. Monthly attendance sheets are displayed on the notice board.'],
    ],
    'Examination Rules' => [
        ['title'=>'Identity Card is Mandatory',           'desc'=>'Students must bring their valid college identity card and admit card (where applicable) to all examinations. Entry will be denied without proper identification.'],
        ['title'=>'No Electronic Devices',                'desc'=>'Mobile phones, smartwatches, earphones, or any electronic communication device are strictly prohibited in the examination hall. Possession will result in immediate disqualification.'],
        ['title'=>'Anti-Unfair Means Policy',             'desc'=>'Any form of cheating, copying, or possession of unauthorized material during examination is a serious offence. Such students will be expelled from the hall and may face suspension.'],
        ['title'=>'Seating Arrangement',                  'desc'=>'Students must sit according to the seating plan announced before the examination. Changing seats without permission is not allowed.'],
        ['title'=>'Exam Hall Conduct',                    'desc'=>'Students must maintain silence in the examination hall. Communicating with other examinees or disturbing the invigilation team is strictly prohibited.'],
    ],
    'Conduct & Discipline' => [
        ['title'=>'Respect for Faculty and Staff',        'desc'=>'Students are required to show respect to all teachers, administrative staff, and fellow students at all times. Rude or disrespectful behavior will not be tolerated.'],
        ['title'=>'Use of Mobile Phones',                 'desc'=>'Mobile phones must be switched off or kept on silent mode during classes and college events. Usage of phones in classrooms is strictly prohibited.'],
        ['title'=>'Campus Cleanliness',                   'desc'=>'Students are responsible for maintaining cleanliness on campus. Littering, vandalism, or damage to college property is a punishable offence.'],
        ['title'=>'Ragging & Harassment Policy',          'desc'=>'Ragging, bullying, or any form of physical or verbal harassment of students is strictly prohibited and will lead to immediate disciplinary action including expulsion.'],
        ['title'=>'Political Activity',                   'desc'=>'No political meetings, rallies, or activities of political parties are permitted on campus. Students participating in such activities will face disciplinary proceedings.'],
    ],
    'Library Rules' => [
        ['title'=>'Borrowing Policy',                     'desc'=>'Students may borrow up to 2 books at a time for a period of 7 days. Books must be returned on time. A fine of BDT 2 per day per book will be charged for late returns.'],
        ['title'=>'Library Silence',                      'desc'=>'The library is a quiet study area. Conversations, phone calls, or any loud activity is prohibited inside the library premises.'],
        ['title'=>'Damage to Library Books',              'desc'=>'Marking, tearing, or damaging library books will result in the student bearing the full replacement cost of the book in addition to a penalty.'],
    ],
];

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-breadcrumb">
                <a href="../index.php">Home</a>
                <i class="fas fa-chevron-right"></i>
                <span>Rules &amp; Regulation</span>
            </div>
            <div class="ph-kicker reveal">Academic Info</div>
            <h1 class="reveal">Rules &amp; Regulation</h1>
            <p class="reveal">College rules and regulations that every student must follow</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <div class="ai-top-row">
                <span class="ai-session-label"><i class="fas fa-gavel"></i> All students are bound by these regulations upon enrollment</span>
                <div class="ai-meta-row">
                    <span class="ai-last-updated">Last Updated: <?php echo $last_updated; ?></span>
                    <button class="ai-print-btn" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>

            <?php $globalNum = 1; foreach ($ruleCategories as $catName => $rules): ?>
            <div class="ai-content-section reveal" style="margin-bottom:32px;">
                <h2>
                    <?php
                    $icon = match($catName) {
                        'Attendance Rules'       => 'fas fa-clipboard-check',
                        'Examination Rules'      => 'fas fa-pen-alt',
                        'Conduct & Discipline'   => 'fas fa-shield-alt',
                        'Library Rules'          => 'fas fa-book',
                        default                  => 'fas fa-list',
                    };
                    ?><i class="<?php echo $icon; ?>"></i> <?php echo htmlspecialchars($catName); ?>
                </h2>
                <div class="ai-rule-list">
                    <?php foreach ($rules as $r): ?>
                    <div class="ai-rule-item">
                        <div class="ai-rule-num"><?php echo $globalNum++; ?></div>
                        <div class="ai-rule-body">
                            <div class="ai-rule-title"><?php echo htmlspecialchars($r['title']); ?></div>
                            <div class="ai-rule-desc"><?php echo htmlspecialchars($r['desc']); ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>
