<?php
$page       = 'holiday-list';
$page_group = 'academic';
$page_title = 'Holiday List | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';

$session = '2024–2025';
$last_updated = 'May 31, 2025';
$today = date('Y-m-d');

$holidays = [
    ['name_en'=>'International Mother Language Day', 'name_bn'=>'আন্তর্জাতিক মাতৃভাষা দিবস', 'date'=>'2025-02-21', 'type'=>'govt'],
    ['name_en'=>'Independence Day', 'name_bn'=>'স্বাধীনতা দিবস', 'date'=>'2025-03-26', 'type'=>'govt'],
    ['name_en'=>'Bengali New Year (Pahela Baishakh)', 'name_bn'=>'বাংলা নববর্ষ (পহেলা বৈশাখ)', 'date'=>'2025-04-14', 'type'=>'govt'],
    ['name_en'=>'Good Friday', 'name_bn'=>'গুড ফ্রাইডে', 'date'=>'2025-04-18', 'type'=>'religious'],
    ['name_en'=>'May Day', 'name_bn'=>'মে দিবস', 'date'=>'2025-05-01', 'type'=>'govt'],
    ['name_en'=>'Buddha Purnima', 'name_bn'=>'বুদ্ধ পূর্ণিমা', 'date'=>'2025-05-12', 'type'=>'religious'],
    ['name_en'=>'Eid-ul-Adha', 'name_bn'=>'ঈদুল আযহা', 'date'=>'2025-06-07', 'type'=>'religious'],
    ['name_en'=>'Eid-ul-Adha Holiday', 'name_bn'=>'ঈদুল আযহার ছুটি', 'date'=>'2025-06-08', 'type'=>'religious'],
    ['name_en'=>'Eid-ul-Adha Holiday', 'name_bn'=>'ঈদুল আযহার ছুটি', 'date'=>'2025-06-09', 'type'=>'religious'],
    ['name_en'=>'National Mourning Day', 'name_bn'=>'জাতীয় শোক দিবস', 'date'=>'2025-08-15', 'type'=>'govt'],
    ['name_en'=>'Annual College Foundation Day', 'name_bn'=>'বার্ষিক কলেজ প্রতিষ্ঠা দিবস', 'date'=>'2025-09-01', 'type'=>'college'],
    ['name_en'=>'Durga Puja (Maha Ashtami)', 'name_bn'=>'দুর্গা পূজা (মহা অষ্টমী)', 'date'=>'2025-10-02', 'type'=>'religious'],
    ['name_en'=>'Victory Day', 'name_bn'=>'বিজয় দিবস', 'date'=>'2025-12-16', 'type'=>'govt'],
    ['name_en'=>'Christmas Day', 'name_bn'=>'বড়দিন', 'date'=>'2025-12-25', 'type'=>'religious'],
];

usort($holidays, fn($a,$b) => strcmp($a['date'], $b['date']));

include '../includes/header.php';
?>

    <!-- Hero -->
    <section class="page-hero">
        <div class="container ph-content">

            <div class="ph-kicker reveal">
                <span class="show-en">Academic Info</span>
                <span class="show-bn">একাডেমিক তথ্য</span>
            </div>
            <h1 class="reveal">
                <span class="show-en">Holiday List</span>
                <span class="show-bn">ছুটির তালিকা</span>
            </h1>
            <p class="reveal">
                <span class="show-en">Official public holidays and college holidays for the current academic session</span>
                <span class="show-bn">চলতি শিক্ষাবর্ষের জন্য সরকারি ও কলেজের সরকারি ছুটির তালিকা</span>
            </p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <div class="ai-top-row">
                <span class="ai-session-label">
                    <i class="fas fa-calendar"></i> 
                    <span class="show-en">Academic Session: <?php echo $session; ?></span>
                    <span class="show-bn">শিক্ষাবর্ষ: <?php echo str_replace(['0','1','2','3','4','5','6','7','8','9'],['০','১','২','৩','৪','৫','৬','৭','৮','৯'],$session); ?></span>
                </span>
                <div class="ai-meta-row">
                    <span class="ai-last-updated">
                        <span class="show-en">Last Updated: <?php echo $last_updated; ?></span>
                        <span class="show-bn">সর্বশেষ আপডেট: ৩১ মে, ২০২৫</span>
                    </span>
                </div>
            </div>

            <!-- Legend -->
            <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px;font-family:'Inter',sans-serif;font-size:.78rem;">
                <span class="ai-badge badge-govt"><i class="fas fa-circle" style="font-size:.45rem;"></i> 
                    <span class="show-en">Government</span>
                    <span class="show-bn">সরকারি</span>
                </span>
                <span class="ai-badge badge-college"><i class="fas fa-circle" style="font-size:.45rem;"></i> 
                    <span class="show-en">College</span>
                    <span class="show-bn">কলেজ</span>
                </span>
                <span class="ai-badge badge-religious"><i class="fas fa-circle" style="font-size:.45rem;"></i> 
                    <span class="show-en">Religious</span>
                    <span class="show-bn">ধর্মীয়</span>
                </span>
            </div>

            <div class="ai-card">
                <div class="ai-table-wrap">
                    <table class="ai-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>
                                    <span class="show-en">Holiday Name</span>
                                    <span class="show-bn">ছুটির নাম</span>
                                </th>
                                <th>
                                    <span class="show-en">Date</span>
                                    <span class="show-bn">তারিখ</span>
                                </th>
                                <th>
                                    <span class="show-en">Type</span>
                                    <span class="show-bn">ধরন</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($holidays as $i => $h):
                            $ts     = strtotime($h['date']);
                            $isPast = $h['date'] < $today;
                            $isTdy  = $h['date'] === $today;
                            $rowClass = $isTdy ? 'ai-row-today' : ($isPast ? 'ai-row-past' : 'ai-row-upcoming');
                            
                            $badge_en = match($h['type']) {
                                'govt'     => '<span class="ai-badge badge-govt">Government</span>',
                                'college'  => '<span class="ai-badge badge-college">College</span>',
                                'religious'=> '<span class="ai-badge badge-religious">Religious</span>',
                                default    => ''
                            };
                            $badge_bn = match($h['type']) {
                                'govt'     => '<span class="ai-badge badge-govt">সরকারি</span>',
                                'college'  => '<span class="ai-badge badge-college">কলেজ</span>',
                                'religious'=> '<span class="ai-badge badge-religious">ধর্মীয়</span>',
                                default    => ''
                            };
                            
                            $date_en = date('F j, Y', $ts);
                            
                            $bn_months = ['January'=>'জানুয়ারি', 'February'=>'ফেব্রুয়ারি', 'March'=>'মার্চ', 'April'=>'এপ্রিল', 'May'=>'মে', 'June'=>'জুন', 'July'=>'জুলাই', 'August'=>'আগস্ট', 'September'=>'সেপ্টেম্বর', 'October'=>'অক্টোবর', 'November'=>'নভেম্বর', 'December'=>'ডিসেম্বর'];
                            $bn_nums = ['0'=>'০','1'=>'১','2'=>'২','3'=>'৩','4'=>'৪','5'=>'৫','6'=>'৬','7'=>'৭','8'=>'৮','9'=>'৯'];
                            
                            $date_bn = strtr(date('j F Y', $ts), array_merge($bn_months, $bn_nums));
                            $row_num_bn = strtr($i+1, $bn_nums);
                        ?>
                        <tr class="<?php echo $rowClass; ?>">
                            <td>
                                <span class="ai-rownum show-en"><?php echo $i+1; ?></span>
                                <span class="ai-rownum show-bn"><?php echo $row_num_bn; ?></span>
                            </td>
                            <td style="font-weight:600;color:var(--navy);">
                                <?php if($isTdy): ?>
                                    <span class="ai-badge badge-today show-en" style="margin-right:6px;">Today</span>
                                    <span class="ai-badge badge-today show-bn" style="margin-right:6px;">আজ</span>
                                <?php endif; ?>
                                <span class="show-en"><?php echo htmlspecialchars($h['name_en']); ?></span>
                                <span class="show-bn"><?php echo htmlspecialchars($h['name_bn']); ?></span>
                            </td>
                            <td>
                                <span class="show-en"><?php echo $date_en; ?></span>
                                <span class="show-bn"><?php echo $date_bn; ?></span>
                            </td>
                            <td>
                                <span class="show-en"><?php echo $badge_en; ?></span>
                                <span class="show-bn"><?php echo $badge_bn; ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>
