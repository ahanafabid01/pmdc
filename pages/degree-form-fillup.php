<?php
$page       = 'degree-form-fillup';
$page_group = 'academic';
$page_title = 'Degree Form Fillup | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'May 31, 2025';

require_once '../includes/registration-data.php';
$reg_status    = reg_get_status('degree');
$reg_state     = $reg_status['state'];
$reg_session   = $reg_status['session'];
$reg_close_fmt = !empty($reg_status['close_date']) ? date('d M Y', strtotime($reg_status['close_date'])) : '';
$reg_open_fmt  = !empty($reg_status['open_date'])  ? date('d M Y', strtotime($reg_status['open_date']))  : '';

$formInfo = [
    'published'       => true,
    'start_date'      => '2025-09-01',
    'end_date'        => '2025-09-20',
    'fee'             => 'BDT 250',
    'submit_location' => 'College Accounts Office (Room 102)',
    'instructions'    => 'All Degree 1st Year students must complete the National University form fillup within the announced dates. Failure to submit within the deadline will result in cancellation of enrollment. Contact the college office immediately for any issues or queries.',
    'documents' => [
        'Original HSC Certificate and Mark Sheet (original + 2 photocopies)',
        'SSC Certificate and Mark Sheet (original + 1 photocopy)',
        'National ID Card or Birth Certificate (original + 1 photocopy)',
        'College Admission Receipt (original)',
        '4 copies of recent passport-size photographs (white background)',
        'Online form fill-up confirmation printout (if applicable)',
        'Fee payment receipt (pay at accounts office before submission)',
    ],
];

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-kicker reveal" data-i18n="hero.academic_info">Academic Info</div>
            <h1 class="reveal" data-i18n="hero.degree_fillup">Degree Form Fillup</h1>
            <p class="reveal" data-i18n="hero.degree_fillup_desc">National University examination form fillup schedule, fees, and required documents</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container" style="max-width:860px;">

            <div class="ai-top-row">
                <span class="ai-session-label"><i class="fas fa-university"></i> <span data-i18n="fillup.degree_title">Degree (Pass) Examination — National University</span></span>
                <div class="ai-meta-row">
                    <span class="ai-last-updated"><span data-i18n="fillup.last_updated">Last Updated:</span> <?php echo $last_updated; ?></span>
                </div>
            </div>

            <?php if ($formInfo['published']): ?>

            <!-- Schedule Card -->
            <div class="ai-info-card reveal" style="margin-bottom:20px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                    <div style="width:42px;height:42px;border-radius:12px;background:#eff6ff;color:var(--blue);display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <div style="font-size:1rem;font-weight:800;color:var(--navy);font-family:'Inter',sans-serif;" data-i18n="fillup.schedule">Form Fillup Schedule</div>
                        <div style="font-size:.76rem;color:var(--muted);font-family:'Inter',sans-serif;" data-i18n="fillup.degree_sub">Degree (Pass) — National University</div>
                    </div>
                    <span class="ai-badge badge-college" style="margin-left:auto;">Active</span>
                </div>
                <div class="ai-info-grid">
                    <div class="ai-info-item">
                        <span class="ai-info-label" data-i18n="fillup.start_date">Start Date</span>
                        <span class="ai-info-value"><?php echo date('d F Y', strtotime($formInfo['start_date'])); ?></span>
                    </div>
                    <div class="ai-info-item">
                        <span class="ai-info-label" data-i18n="fillup.end_date">End Date</span>
                        <span class="ai-info-value"><?php echo date('d F Y', strtotime($formInfo['end_date'])); ?></span>
                    </div>
                    <div class="ai-info-item">
                        <span class="ai-info-label" data-i18n="fillup.form_fee">Form Fee</span>
                        <span class="ai-info-value" style="color:#16a34a;"><?php echo htmlspecialchars($formInfo['fee']); ?></span>
                    </div>
                    <div class="ai-info-item">
                        <span class="ai-info-label" data-i18n="fillup.where_submit">Where to Submit</span>
                        <span class="ai-info-value"><?php echo htmlspecialchars($formInfo['submit_location']); ?></span>
                    </div>
                </div>
                <hr class="ai-info-divider">
                <div style="font-size:.86rem;color:var(--text);font-family:'Inter',sans-serif;line-height:1.7;">
                    <i class="fas fa-info-circle" style="color:var(--blue);margin-right:6px;"></i>
                    <?php echo htmlspecialchars($formInfo['instructions']); ?>
                </div>
            </div>

            <!-- Required Documents -->
            <div class="ai-card reveal" style="padding:24px 28px;">
                <h2 style="font-size:.95rem;font-weight:800;color:var(--navy);font-family:'Inter',sans-serif;display:flex;align-items:center;gap:8px;margin-bottom:16px;padding-bottom:12px;border-bottom:2px solid var(--border);">
                    <i class="fas fa-paperclip" style="color:var(--blue);"></i> <span data-i18n="fillup.required_docs">Required Documents</span>
                </h2>
                <ul class="ai-bullet-list">
                    <?php foreach ($formInfo['documents'] as $doc): ?>
                    <li class="ai-bullet-item"><?php echo htmlspecialchars($doc); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php else: ?>
            <div class="ai-not-published reveal">
                <i class="fas fa-university"></i>
                <h3 data-i18n="fillup.not_announced">Not Announced Yet</h3>
                <p>The Degree Form Fillup schedule has not been announced yet.</p>
            </div>
            <?php endif; ?>

            <!-- ── ONLINE REGISTRATION BANNER ─────────────────────────── -->
            <div class="ai-card reveal" style="margin-top:20px;padding:28px;background:linear-gradient(135deg,#1a2942 0%,#1e3a5f 100%);border-radius:16px;color:#fff;display:flex;align-items:center;gap:24px;flex-wrap:wrap;">
                <div style="flex:1;min-width:220px;">
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(255,255,255,.6);margin-bottom:6px;font-family:'Inter',sans-serif;">
                        <span data-i18n="fillup.online_admission">ONLINE ADMISSION</span> — SESSION <?php echo htmlspecialchars($reg_session); ?>
                    </div>
                    <?php if ($reg_state === 'open'): ?>
                    <div style="font-size:1.15rem;font-weight:800;color:#fff;font-family:'Inter',sans-serif;margin-bottom:6px;">
                        <i class="fas fa-circle" style="color:#4ade80;font-size:.65rem;vertical-align:middle;margin-right:6px;"></i> <span data-i18n="fillup.reg_open">Registration is Open!</span>
                    </div>
                    <div style="font-size:.82rem;color:rgba(255,255,255,.75);font-family:'Inter',sans-serif;line-height:1.6;">
                        Apply online for Degree admission <?php echo htmlspecialchars($reg_session); ?>.
                        <?php if ($reg_close_fmt): ?><br>Closes on <strong style="color:#fbbf24;"><?php echo $reg_close_fmt; ?></strong>.<?php endif; ?>
                    </div>
                    <?php elseif ($reg_state === 'not_open_yet'): ?>
                    <div style="font-size:1.1rem;font-weight:800;color:#fbbf24;font-family:'Inter',sans-serif;margin-bottom:6px;">
                        <i class="fas fa-hourglass-half" style="margin-right:6px;"></i> <span data-i18n="fillup.reg_opening_soon">Registration Opening Soon</span>
                    </div>
                    <div style="font-size:.82rem;color:rgba(255,255,255,.75);font-family:'Inter',sans-serif;line-height:1.6;">
                        Online registration for session <?php echo htmlspecialchars($reg_session); ?> has not started yet.
                        <?php if ($reg_open_fmt): ?><br>Opens on <strong style="color:#fbbf24;"><?php echo $reg_open_fmt; ?></strong>.<?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div style="font-size:1.1rem;font-weight:800;color:#f87171;font-family:'Inter',sans-serif;margin-bottom:6px;">
                        <i class="fas fa-lock" style="margin-right:6px;"></i> <span data-i18n="fillup.reg_closed">Registration Closed</span>
                    </div>
                    <div style="font-size:.82rem;color:rgba(255,255,255,.75);font-family:'Inter',sans-serif;line-height:1.6;">
                        Online registration for session <?php echo htmlspecialchars($reg_session); ?> is closed.
                    </div>
                    <?php endif; ?>
                </div>
                <div style="flex-shrink:0;">
                    <?php if ($reg_state === 'open'): ?>
                    <a href="<?= BASE_URL ?>/apply/degree"
                       style="display:inline-flex;align-items:center;gap:8px;padding:13px 28px;border-radius:12px;background:#2563eb;color:#fff;font-size:.95rem;font-weight:800;text-decoration:none;font-family:'Inter',sans-serif;box-shadow:0 4px 16px rgba(37,99,235,.4);transition:all .2s;"
                       onmouseover="this.style.background='#1d4ed8';this.style.transform='translateY(-2px)';"
                       onmouseout="this.style.background='#2563eb';this.style.transform='';">
                        <i class="fas fa-university"></i> <span data-i18n="fillup.apply_now">Apply Now</span>
                    </a>
                    <?php elseif ($reg_state === 'not_open_yet'): ?>
                    <span style="display:inline-flex;align-items:center;gap:8px;padding:13px 28px;border-radius:12px;background:rgba(255,255,255,.1);border:1.5px solid rgba(255,255,255,.2);color:rgba(255,255,255,.6);font-size:.9rem;font-weight:700;font-family:'Inter',sans-serif;cursor:not-allowed;">
                        <i class="fas fa-hourglass-half"></i> <span data-i18n="fillup.not_open_btn">Not Open Yet</span>
                    </span>
                    <?php else: ?>
                    <a href="<?= BASE_URL ?>/announcement"
                       style="display:inline-flex;align-items:center;gap:8px;padding:13px 24px;border-radius:12px;border:1.5px solid rgba(255,255,255,.25);background:transparent;color:rgba(255,255,255,.8);font-size:.88rem;font-weight:700;text-decoration:none;font-family:'Inter',sans-serif;transition:all .2s;"
                       onmouseover="this.style.background='rgba(255,255,255,.1)';"
                       onmouseout="this.style.background='transparent';">
                        <i class="fas fa-bell"></i> <span data-i18n="fillup.view_announcements">View Announcements</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>
