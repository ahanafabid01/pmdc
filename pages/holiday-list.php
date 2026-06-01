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
    ['name'=>'International Mother Language Day',      'date'=>'2025-02-21', 'type'=>'govt'],
    ['name'=>'Independence Day',                        'date'=>'2025-03-26', 'type'=>'govt'],
    ['name'=>'Bengali New Year (Pahela Baishakh)',      'date'=>'2025-04-14', 'type'=>'govt'],
    ['name'=>'Good Friday',                             'date'=>'2025-04-18', 'type'=>'religious'],
    ['name'=>'May Day',                                 'date'=>'2025-05-01', 'type'=>'govt'],
    ['name'=>'Buddha Purnima',                          'date'=>'2025-05-12', 'type'=>'religious'],
    ['name'=>'Eid-ul-Adha',                             'date'=>'2025-06-07', 'type'=>'religious'],
    ['name'=>'Eid-ul-Adha Holiday',                    'date'=>'2025-06-08', 'type'=>'religious'],
    ['name'=>'Eid-ul-Adha Holiday',                    'date'=>'2025-06-09', 'type'=>'religious'],
    ['name'=>'National Mourning Day',                   'date'=>'2025-08-15', 'type'=>'govt'],
    ['name'=>'Annual College Foundation Day',           'date'=>'2025-09-01', 'type'=>'college'],
    ['name'=>'Durga Puja (Maha Ashtami)',               'date'=>'2025-10-02', 'type'=>'religious'],
    ['name'=>'Victory Day',                             'date'=>'2025-12-16', 'type'=>'govt'],
    ['name'=>'Christmas Day',                           'date'=>'2025-12-25', 'type'=>'religious'],
];

usort($holidays, fn($a,$b) => strcmp($a['date'], $b['date']));

include '../includes/header.php';
?>

    <!-- Hero -->
    <section class="page-hero">
        <div class="container ph-content">

            <div class="ph-kicker reveal">Academic Info</div>
            <h1 class="reveal">Holiday List</h1>
            <p class="reveal">Official public holidays and college holidays for the current academic session</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <div class="ai-top-row">
                <span class="ai-session-label"><i class="fas fa-calendar"></i> Academic Session: <?php echo $session; ?></span>
                <div class="ai-meta-row">
                    <span class="ai-last-updated">Last Updated: <?php echo $last_updated; ?></span>
                    <button class="ai-print-btn" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>

            <!-- Legend -->
            <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px;font-family:'Inter',sans-serif;font-size:.78rem;">
                <span class="ai-badge badge-govt"><i class="fas fa-circle" style="font-size:.45rem;"></i> Government</span>
                <span class="ai-badge badge-college"><i class="fas fa-circle" style="font-size:.45rem;"></i> College</span>
                <span class="ai-badge badge-religious"><i class="fas fa-circle" style="font-size:.45rem;"></i> Religious</span>
            </div>

            <div class="ai-card">
                <div class="ai-table-wrap">
                    <table class="ai-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Holiday Name</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($holidays as $i => $h):
                            $ts     = strtotime($h['date']);
                            $isPast = $h['date'] < $today;
                            $isTdy  = $h['date'] === $today;
                            $rowClass = $isTdy ? 'ai-row-today' : ($isPast ? 'ai-row-past' : 'ai-row-upcoming');
                            $badge = match($h['type']) {
                                'govt'     => '<span class="ai-badge badge-govt">Government</span>',
                                'college'  => '<span class="ai-badge badge-college">College</span>',
                                'religious'=> '<span class="ai-badge badge-religious">Religious</span>',
                                default    => ''
                            };
                        ?>
                        <tr class="<?php echo $rowClass; ?>">
                            <td><span class="ai-rownum"><?php echo $i+1; ?></span></td>
                            <td style="font-weight:600;color:var(--navy);">
                                <?php if($isTdy): ?><span class="ai-badge badge-today" style="margin-right:6px;">Today</span><?php endif; ?>
                                <?php echo htmlspecialchars($h['name']); ?>
                            </td>
                            <td class="ai-date-cell"><?php echo date('d M Y', $ts); ?></td>
                            <td><?php echo date('l', $ts); ?></td>
                            <td><?php echo $badge; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>
