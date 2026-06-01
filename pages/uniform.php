<?php
$page       = 'uniform';
$page_group = 'academic';
$page_title = 'Uniform | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'May 31, 2026';

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">

            <div class="ph-kicker reveal">Academic Info</div>
            <h1 class="reveal">Uniform</h1>
            <p class="reveal">Official PMDC uniform guidelines for all students</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <div class="ai-top-row">
                <span class="ai-session-label"><i class="fas fa-tshirt"></i> Official Dress Code — Mandatory for all students</span>
                <div class="ai-meta-row">
                    <span class="ai-last-updated">Last Updated: <?php echo $last_updated; ?></span>
                    <button class="ai-print-btn" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;" class="uniform-grid">

                <!-- Girls Uniform -->
                <div class="ai-card" style="padding:28px 28px 24px;">
                    <div class="ai-content-section" style="margin-bottom:0;">
                        <h2><i class="fas fa-female"></i> For Students</h2>
                        <ul class="ai-bullet-list">
                            <li class="ai-bullet-item">White shalwar</li>
                            <li class="ai-bullet-item">White kamiz</li>
                            <li class="ai-bullet-item">Navy blue orna</li>
                            <li class="ai-bullet-item">Navy blue belt</li>
                            <li class="ai-bullet-item">White socks</li>
                            <li class="ai-bullet-item">White canvas shoes</li>
                            <li class="ai-bullet-item">White apron</li>
                            <li class="ai-bullet-item">White scarf</li>
                        </ul>
                    </div>
                </div>

                <!-- Important Notes -->
                <div class="ai-card" style="padding:28px 28px 24px;">
                    <div class="ai-content-section" style="margin-bottom:0;">
                        <h2><i class="fas fa-exclamation-circle"></i> Important Notes</h2>
                        <ul class="ai-bullet-list">
                            <li class="ai-bullet-item">Students are required to wear the prescribed uniform to college regularly.</li>
                            <li class="ai-bullet-item">Every student must obtain an identity card and wear it around the neck.</li>
                            <li class="ai-bullet-item">No improper or disorderly behavior outside the college is permitted while in college dress or uniform.</li>
                            <li class="ai-bullet-item">Uniform should be kept clean and well-arranged at all times.</li>
                            <li class="ai-bullet-item">The college may take disciplinary action for repeated uniform violations.</li>
                        </ul>
                    </div>
                </div>

            </div>

            <!-- Uniform Procurement -->
            <div class="ai-info-card" style="margin-top:24px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
                    <i class="fas fa-store" style="color:var(--blue);font-size:1rem;"></i>
                    <strong style="font-size:.95rem;color:var(--navy);font-family:'Inter',sans-serif;">Uniform Reminder</strong>
                </div>
                <div class="ai-info-grid">
                    <div class="ai-info-item">
                        <span class="ai-info-label">Dress Code</span>
                        <span class="ai-info-value">White shalwar, white kamiz, navy blue orna, navy blue belt</span>
                    </div>
                    <div class="ai-info-item">
                        <span class="ai-info-label">Footwear</span>
                        <span class="ai-info-value">White socks and white canvas shoes</span>
                    </div>
                    <div class="ai-info-item">
                        <span class="ai-info-label">Additional Items</span>
                        <span class="ai-info-value">White apron and white scarf</span>
                    </div>
                    <div class="ai-info-item">
                        <span class="ai-info-label">Requirement</span>
                        <span class="ai-info-value">Uniform is mandatory for all students</span>
                    </div>
                </div>
                <p style="font-size:.82rem;color:var(--muted);font-family:'Inter',sans-serif;border-top:1px solid var(--border);padding-top:14px;margin-top:4px;">
                    For any queries regarding the uniform, please contact the college office during working hours.
                </p>
            </div>

        </div>
    </div>

<style>
@media (max-width: 640px) {
    .uniform-grid { grid-template-columns: 1fr !important; }
}
</style>

<?php include '../includes/footer.php'; ?>
