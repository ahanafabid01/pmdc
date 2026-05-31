<?php
$page       = 'hsc-form-fillup';
$page_group = 'academic';
$page_title = 'HSC Form Fillup | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'May 31, 2025';

$formInfo = [
    'published'       => true,
    'start_date'      => '2025-08-15',
    'end_date'        => '2025-08-30',
    'fee'             => 'BDT 500',
    'submit_location' => 'College Accounts Office (Room 102)',
    'instructions'    => 'All HSC 2nd Year students must complete their board examination form fillup within the announced dates. Failure to submit within the deadline will result in inability to appear in the HSC Board Examination. Contact the college office immediately for any issues.',
    'documents' => [
        'Original Birth Certificate or National ID Card',
        'SSC admit card and certificate (original + 1 photocopy)',
        'College registration card (original + 1 photocopy)',
        '4 copies of recent passport-size photographs (with white background)',
        'Previous semester result sheet / admit card',
        'Fee payment receipt (pay at accounts office before form submission)',
    ],
];

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-breadcrumb">
                <a href="../index.php">Home</a>
                <i class="fas fa-chevron-right"></i>
                <span>HSC Form Fillup</span>
            </div>
            <div class="ph-kicker reveal">Academic Info</div>
            <h1 class="reveal">HSC Form Fillup</h1>
            <p class="reveal">Board examination form fillup schedule, fees, and required documents</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container" style="max-width:860px;">

            <div class="ai-top-row">
                <span class="ai-session-label"><i class="fas fa-file-alt"></i> HSC Board Examination 2025 — 2nd Year</span>
                <div class="ai-meta-row">
                    <span class="ai-last-updated">Last Updated: <?php echo $last_updated; ?></span>
                    <button class="ai-print-btn" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
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
                        <div style="font-size:1rem;font-weight:800;color:var(--navy);font-family:'Inter',sans-serif;">Form Fillup Schedule</div>
                        <div style="font-size:.76rem;color:var(--muted);font-family:'Inter',sans-serif;">HSC Board Examination 2025</div>
                    </div>
                    <span class="ai-badge badge-college" style="margin-left:auto;">Active</span>
                </div>
                <div class="ai-info-grid">
                    <div class="ai-info-item">
                        <span class="ai-info-label">Start Date</span>
                        <span class="ai-info-value"><?php echo date('d F Y', strtotime($formInfo['start_date'])); ?></span>
                    </div>
                    <div class="ai-info-item">
                        <span class="ai-info-label">End Date</span>
                        <span class="ai-info-value"><?php echo date('d F Y', strtotime($formInfo['end_date'])); ?></span>
                    </div>
                    <div class="ai-info-item">
                        <span class="ai-info-label">Form Fee</span>
                        <span class="ai-info-value" style="color:#16a34a;"><?php echo htmlspecialchars($formInfo['fee']); ?></span>
                    </div>
                    <div class="ai-info-item">
                        <span class="ai-info-label">Where to Submit</span>
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
                    <i class="fas fa-paperclip" style="color:var(--blue);"></i> Required Documents
                </h2>
                <ul class="ai-bullet-list">
                    <?php foreach ($formInfo['documents'] as $doc): ?>
                    <li class="ai-bullet-item"><?php echo htmlspecialchars($doc); ?></li>
                    <?php endforeach; ?>
                </ul>
                <div style="margin-top:18px;padding:12px 16px;background:#fef9c3;border:1px solid #fde68a;border-radius:9px;font-size:.82rem;color:#92400e;font-family:'Inter',sans-serif;">
                    <i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>
                    Students who fail to submit the form before <strong><?php echo date('d F Y', strtotime($formInfo['end_date'])); ?></strong> will not be able to appear in the HSC Board Examination. No extensions will be granted.
                </div>
            </div>

            <?php else: ?>
            <div class="ai-not-published reveal">
                <i class="fas fa-file-alt"></i>
                <h3>Not Announced Yet</h3>
                <p>The HSC Form Fillup schedule has not been announced yet. Please check back later or contact the college office for more information.</p>
            </div>
            <?php endif; ?>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>
