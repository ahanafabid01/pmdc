<?php
$page       = 'uniform';
$page_group = 'academic';
$page_title = 'Uniform | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'May 31, 2025';

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-breadcrumb">
                <a href="../index.php">Home</a>
                <i class="fas fa-chevron-right"></i>
                <span>Uniform</span>
            </div>
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
                        <h2><i class="fas fa-female"></i> Girls Uniform</h2>
                        <ul class="ai-bullet-list">
                            <li class="ai-bullet-item">White salwar-kameez with the college monogram on the left chest pocket</li>
                            <li class="ai-bullet-item">White dupatta (worn over the shoulders at all times on campus)</li>
                            <li class="ai-bullet-item">White socks and white keds/canvas shoes</li>
                            <li class="ai-bullet-item">Hair tied neatly in a bun or braid — no loose hair on campus</li>
                            <li class="ai-bullet-item">No heavy jewellery — simple stud earrings only</li>
                            <li class="ai-bullet-item">ID card must be worn on a lanyard and visible at all times</li>
                            <li class="ai-bullet-item">No nail polish, mehendi, or heavy makeup during academic days</li>
                            <li class="ai-bullet-item">Uniform must be clean, well-ironed, and properly fitted</li>
                        </ul>
                    </div>
                </div>

                <!-- Important Notes -->
                <div class="ai-card" style="padding:28px 28px 24px;">
                    <div class="ai-content-section" style="margin-bottom:0;">
                        <h2><i class="fas fa-exclamation-circle"></i> Important Notes</h2>
                        <ul class="ai-bullet-list">
                            <li class="ai-bullet-item">Students not in proper uniform will not be allowed to enter the campus.</li>
                            <li class="ai-bullet-item">Uniform must be purchased from the approved college supplier only. Contact the college office for details.</li>
                            <li class="ai-bullet-item">Wearing torn, faded, or altered uniform is strictly prohibited.</li>
                            <li class="ai-bullet-item">During cultural programs and events, students may wear alternative attire as permitted by the Principal.</li>
                            <li class="ai-bullet-item">On examination days, the ID card is mandatory regardless of uniform.</li>
                            <li class="ai-bullet-item">Any student found violating the dress code repeatedly will face disciplinary action as per college rules.</li>
                            <li class="ai-bullet-item">For exemption due to medical reasons, a written application must be submitted to the Principal's office.</li>
                        </ul>
                    </div>
                </div>

            </div>

            <!-- Uniform Procurement -->
            <div class="ai-info-card" style="margin-top:24px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
                    <i class="fas fa-store" style="color:var(--blue);font-size:1rem;"></i>
                    <strong style="font-size:.95rem;color:var(--navy);font-family:'Inter',sans-serif;">Where to Get the Uniform</strong>
                </div>
                <div class="ai-info-grid">
                    <div class="ai-info-item">
                        <span class="ai-info-label">Approved Supplier</span>
                        <span class="ai-info-value">Phulpur Cloth House</span>
                    </div>
                    <div class="ai-info-item">
                        <span class="ai-info-label">Location</span>
                        <span class="ai-info-value">Near College Gate, Phulpur Bazar</span>
                    </div>
                    <div class="ai-info-item">
                        <span class="ai-info-label">Uniform Cost (Approx.)</span>
                        <span class="ai-info-value">BDT 600–800 (full set)</span>
                    </div>
                    <div class="ai-info-item">
                        <span class="ai-info-label">Monogram Stitching</span>
                        <span class="ai-info-value">Available at the supplier</span>
                    </div>
                </div>
                <p style="font-size:.82rem;color:var(--muted);font-family:'Inter',sans-serif;border-top:1px solid var(--border);padding-top:14px;margin-top:4px;">
                    For any queries regarding the uniform, please contact the college office during working hours (9:00 AM – 3:00 PM, Saturday to Thursday).
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
