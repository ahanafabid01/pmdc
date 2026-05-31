<?php
$page       = 'monitoring-committee';
$page_group = 'academic';
$page_title = 'Monitoring Committee | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'May 31, 2025';

$colors = ['#1a3a5c','#276749','#7b341e','#702459','#1a365d','#0f4c75','#4a1942','#2c3e7a'];
function initials($name) { $w=explode(' ',$name); return implode('',array_map(fn($x)=>strtoupper($x[0]),array_slice($w,0,2))); }
function avatarColor($name,$colors) { $h=0;foreach(str_split($name)as$c)$h=(($h<<5)-$h)+ord($c);return $colors[abs($h)%count($colors)]; }

$committees = [
    'Academic Monitoring Committee' => [
        ['name'=>'Dr. Halima Khatun',   'designation'=>'Principal',        'role'=>'Chairperson',           'phone'=>'+880-1700-000010','email'=>'principal@pmdc.edu.bd'],
        ['name'=>'Ms. Afroza Begum',    'designation'=>'Senior Lecturer',   'role'=>'Member Secretary',      'phone'=>'+880-1700-000011','email'=>'afroza@pmdc.edu.bd'],
        ['name'=>'Mrs. Rashida Akter',  'designation'=>'Lecturer',          'role'=>'Member',                'phone'=>'+880-1700-000012','email'=>'rashida@pmdc.edu.bd'],
        ['name'=>'Mrs. Fatema Begum',   'designation'=>'Senior Lecturer',   'role'=>'Member',                'phone'=>'+880-1700-000014','email'=>'fatema@pmdc.edu.bd'],
        ['name'=>'Ms. Dilruba Islam',   'designation'=>'Lecturer',          'role'=>'Member',                'phone'=>'+880-1700-000015','email'=>'dilruba@pmdc.edu.bd'],
        ['name'=>'Mr. Rafiqul Islam',   'designation'=>'Office Supt.',      'role'=>'Member (Admin)',        'phone'=>'+880-1700-000030','email'=>'rafiq@pmdc.edu.bd'],
    ],
    'Examination Monitoring Committee' => [
        ['name'=>'Dr. Halima Khatun',   'designation'=>'Principal',        'role'=>'Chief Examiner',        'phone'=>'+880-1700-000010','email'=>'principal@pmdc.edu.bd'],
        ['name'=>'Mrs. Shaila Parvin',  'designation'=>'Lecturer',          'role'=>'Controller of Exams',   'phone'=>'+880-1700-000016','email'=>'shaila@pmdc.edu.bd'],
        ['name'=>'Ms. Nasrin Sultana',  'designation'=>'Lecturer',          'role'=>'Deputy Controller',     'phone'=>'+880-1700-000013','email'=>'nasrin@pmdc.edu.bd'],
        ['name'=>'Ms. Tania Akter',     'designation'=>'Lecturer',          'role'=>'Member',                'phone'=>'+880-1700-000019','email'=>'tania@pmdc.edu.bd'],
        ['name'=>'Ms. Mitu Akter',      'designation'=>'Accounts Officer',  'role'=>'Member (Finance)',      'phone'=>'+880-1700-000031','email'=>'mitu@pmdc.edu.bd'],
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
                            <div style="margin-top:3px;"><i class="fas fa-envelope" style="color:var(--blue);font-size:.65rem;margin-right:4px;"></i><a href="mailto:<?php echo htmlspecialchars($m['email']); ?>"><?php echo htmlspecialchars($m['email']); ?></a></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>
