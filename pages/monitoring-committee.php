<?php
$page       = 'monitoring-committee';
$page_group = 'academic';
$page_title = 'Monitoring Committee | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'June 1, 2026';

$colors = ['#1a3a5c','#276749','#7b341e','#702459','#1a365d','#0f4c75','#4a1942','#2c3e7a'];
function initials($name) { $w=explode(' ',$name); return implode('',array_map(fn($x)=>strtoupper($x[0]),array_slice($w,0,2))); }
function avatarColor($name,$colors) { $h=0;foreach(str_split($name)as$c)$h=(($h<<5)-$h)+ord($c);return $colors[abs($h)%count($colors)]; }

// Real staff from PMDC prospectus (pmdc.md §3A)
$committees = [
    'Academic Monitoring Committee' => [
        ['name'=>'Rowshan Ara Begum',      'designation'=>'Principal',         'role'=>'Chairperson',          'phone'=>'01712-227983'],
        ['name'=>'Md. Hafizur Rahman',     'designation'=>'Assistant Professor','role'=>'Member Secretary',     'phone'=>'01725-659229'],
        ['name'=>'Shaheen Ara Begum',      'designation'=>'Assistant Professor','role'=>'Member',               'phone'=>'01552-881886'],
        ['name'=>'Md. Aminul Haq',         'designation'=>'Assistant Professor','role'=>'Member',               'phone'=>'01995-489780'],
        ['name'=>'Shah Humayun Kabir',     'designation'=>'Assistant Professor','role'=>'Member',               'phone'=>'01505-210622'],
        ['name'=>'Lily Bilkis Rana',       'designation'=>'Assistant Professor','role'=>'Member',               'phone'=>'01918-988038'],
    ],
    'Examination Monitoring Committee' => [
        ['name'=>'Rowshan Ara Begum',      'designation'=>'Principal',         'role'=>'Chief Examiner',        'phone'=>'01712-227983'],
        ['name'=>'Md. Saiful Islam',       'designation'=>'Assistant Professor','role'=>'Controller of Exams',  'phone'=>'01912-182229'],
        ['name'=>'Md. Shafayet Jamil',     'designation'=>'Assistant Professor','role'=>'Deputy Controller',    'phone'=>'01912-509919'],
        ['name'=>'Md. Enamul Haq',         'designation'=>'Assistant Professor','role'=>'Member',               'phone'=>'01984-880389'],
        ['name'=>'Nadira Sultana',         'designation'=>'Lecturer',          'role'=>'Member',               'phone'=>'01936-985311'],
        ['name'=>'Jobeda Khanam',          'designation'=>'Accounts Assistant', 'role'=>'Member (Finance)',     'phone'=>'01918-820956'],
    ],
];

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-breadcrumb">
                <a href="../index.php">Home</a>
                <i class="fas fa-chevron-right"></i>
                <span>Monitoring Committee</span>
            </div>
            <div class="ph-kicker reveal">Academic Info</div>
            <h1 class="reveal">Monitoring Committee</h1>
            <p class="reveal">Academic monitoring committee members for the current session</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <div class="ai-top-row">
                <span class="ai-session-label"><i class="fas fa-users-cog"></i> Session: 2024–2025 — Formed as per NCTB guidelines</span>
                <div class="ai-meta-row">
                    <span class="ai-last-updated">Last Updated: <?php echo $last_updated; ?></span>
                    <button class="ai-print-btn" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>

            <?php foreach ($committees as $commName => $members): ?>
            <div class="ai-content-section reveal" style="margin-bottom:36px;">
                <div class="ai-section-head">
                    <div class="ai-section-head-left">
                        <i class="fas fa-users"></i>
                        <?php echo htmlspecialchars($commName); ?>
                    </div>
                    <span class="ai-section-badge"><?php echo count($members); ?> Members</span>
                </div>
                <div class="ai-committee-grid">
                    <?php foreach ($members as $m):
                        $bg  = avatarColor($m['name'], $colors);
                        $ini = initials($m['name']);
                    ?>
                    <div class="ai-member-card">
                        <div class="ai-member-avatar" style="background:<?php echo $bg; ?>;"><?php echo $ini; ?></div>
                        <div class="ai-member-name"><?php echo htmlspecialchars($m['name']); ?></div>
                        <div class="ai-member-desig"><?php echo htmlspecialchars($m['designation']); ?></div>
                        <div class="ai-member-role"><?php echo htmlspecialchars($m['role']); ?></div>
                        <div class="ai-member-contact">
                            <div><i class="fas fa-phone" style="color:var(--blue);font-size:.65rem;margin-right:4px;"></i><?php echo htmlspecialchars($m['phone']); ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>
