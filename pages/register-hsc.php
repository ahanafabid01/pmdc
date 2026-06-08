<?php
/**
 * register-hsc.php — Public HSC Registration Form
 * Three states: not_open_yet | open | closed
 */
$page       = 'register-hsc';
$page_group = 'academic';
$page_title = 'HSC Admission Form | Phulpur Mohila Degree College';
$base_path  = '../';

require_once '../includes/registration-data.php';

$reg      = reg_get_status('hsc');
$state    = $reg['state'];       // 'not_open_yet' | 'open' | 'closed'
$session  = $reg['session'];
$fee      = (int)($reg['fee'] ?? 200);
$close_date = $reg['close_date'] ?? '';
$open_date  = $reg['open_date']  ?? '';
$s        = $reg['settings'] ?? [];
$bkash    = $s['bkash']  ?? '01XXXXXXXXX';
$nagad    = $s['nagad']  ?? '01XXXXXXXXX';
$rocket   = $s['rocket'] ?? '01XXXXXXXXX';

// Nice formatted dates
$open_date_fmt  = $open_date  ? date('d M Y', strtotime($open_date))  : '';
$close_date_fmt = $close_date ? date('d M Y', strtotime($close_date)) : '';

// Fetch Optional & 4th Subjects Map
$program_subjects = [];
$db = reg_db();
if ($db) {
    try {
        $stmt = $db->query("SELECT name, optional_subjects, fourth_subjects FROM academics_programs WHERE type = 'hsc'");
        while ($row = $stmt->fetch()) {
            $program_subjects[$row['name']] = [
                'optional' => json_decode($row['optional_subjects'], true) ?: [],
                'fourth'   => json_decode($row['fourth_subjects'], true) ?: []
            ];
        }
    } catch (Exception $e) {}
}

include '../includes/header.php';
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/styles/registration.css">

<!-- Page Hero -->
<section class="page-hero">
    <div class="container ph-content">
        <div class="ph-kicker reveal">ADMISSION <?php echo htmlspecialchars($session); ?></div>
        <h1 class="reveal" data-i18n="hero.hsc_admission">HSC Admission Form</h1>
        <?php if ($state === 'open'): ?>
        <div class="ph-badge-row reveal">
            <span class="ph-badge"><i class="fas fa-calendar-alt"></i> Session: <?php echo htmlspecialchars($session); ?></span>
            <span class="ph-badge"><i class="fas fa-money-bill-wave"></i> Application Fee: ৳<?php echo $fee; ?></span>
            <?php if ($close_date_fmt): ?>
            <span class="ph-badge" style="background:rgba(220,38,38,.25);border-color:rgba(220,38,38,.4);">
                <i class="fas fa-clock"></i> Closes: <?php echo $close_date_fmt; ?>
            </span>
            <?php endif; ?>
        </div>
        <?php elseif ($state === 'not_open_yet'): ?>
        <div class="ph-badge-row reveal">
            <span class="ph-badge"><i class="fas fa-calendar-alt"></i> Session: <?php echo htmlspecialchars($session); ?></span>
            <span class="ph-badge" style="background:rgba(245,158,11,.25);border-color:rgba(245,158,11,.4);">
                <i class="fas fa-clock"></i> Opens: <?php echo $open_date_fmt; ?>
            </span>
        </div>
        <?php endif; ?>
    </div>
</section>

<div class="reg-page">
    <div class="container">

    <?php if ($state === 'not_open_yet'): ?>
    <!-- ══ NOT OPEN YET ═════════════════════════════════════ -->
    <div class="reg-closed-wrap">
        <div class="reg-closed-icon" style="background:#fffbeb;border-color:#fde68a;color:#d97706;">
            <i class="fas fa-hourglass-half"></i>
        </div>
        <div class="reg-closed-title">Admission Not Open Yet</div>
        <div class="reg-closed-title-bn">ভর্তি আবেদন এখনও শুরু হয়নি</div>
        <p class="reg-closed-msg">
            HSC admission for session <strong><?php echo htmlspecialchars($session); ?></strong> has not started yet.
            <?php if ($open_date_fmt): ?>
            Admission will open on <strong><?php echo $open_date_fmt; ?></strong>.
            <?php endif; ?>
        </p>
        <p class="reg-closed-session">Please check the announcements page for updates.</p>
        <a href="<?= BASE_URL ?>/announcement" class="reg-closed-btn"><i class="fas fa-bell"></i> View Announcements →</a>
    </div>

    <?php elseif ($state === 'closed'): ?>
    <!-- ══ CLOSED ═══════════════════════════════════════════ -->
    <div class="reg-closed-wrap">
        <div class="reg-closed-icon"><i class="fas fa-lock"></i></div>
        <div class="reg-closed-title">Admission Closed</div>
        <div class="reg-closed-title-bn">ভর্তি আবেদন বন্ধ</div>
        <p class="reg-closed-msg">
            Admission for session <strong><?php echo htmlspecialchars($session); ?></strong> is currently closed.
            <?php if ($close_date_fmt): ?>
            The application window closed on <strong><?php echo $close_date_fmt; ?></strong>.
            <?php endif; ?>
        </p>
        <p class="reg-closed-session">Please check the announcements page for updates on the next session.</p>
        <a href="<?= BASE_URL ?>/announcement" class="reg-closed-btn"><i class="fas fa-bell"></i> View Announcements →</a>
    </div>

    <?php else: /* OPEN */ ?>

    <!-- ══ SUCCESS STATE ════════════════════════════════════ -->
    <div id="regSuccess" class="reg-success">
        <div class="reg-success-wrap">
            <div class="reg-success-icon"><i class="fas fa-check"></i></div>
            <div class="reg-success-title">Application Submitted Successfully!</div>
            <div class="reg-success-title-bn">আবেদন সফলভাবে জমা হয়েছে!</div>
            <div class="reg-ref-box">
                <div class="reg-ref-label">Application Reference Number</div>
                <div class="reg-ref-number" id="successRefNumber">PMDC-HSC-2026-00001</div>
                <div class="reg-ref-save"><i class="fas fa-exclamation-circle"></i> Save this number for future reference</div>
            </div>
            <div class="reg-success-summary"><table><tbody id="successSummaryBody"></tbody></table></div>
            <div class="reg-success-note">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>Action Required:</strong> Your application has been successfully received and is currently under review. Please visit the college campus with all original documents within <strong>7 days</strong> for final verification.
                </div>
            </div>
            <div class="reg-success-btns">
                <a href="<?= BASE_URL ?>/" class="reg-btn-home"><i class="fas fa-home"></i> Go to Home</a>
                <button class="reg-btn-print" id="btnPrint"><i class="fas fa-print"></i> Print Application</button>
            </div>
        </div>
    </div>

    <!-- ══ REGISTRATION FORM ════════════════════════════════ -->
    <div id="regFormWrap">
    <div class="reg-card">
        <!-- Progress -->
        <div class="reg-progress">
            <div class="reg-step-node active"><div class="reg-step-circle">1</div><div class="reg-step-label">Personal Info</div></div>
            <div class="reg-step-node"><div class="reg-step-circle">2</div><div class="reg-step-label">Academic Info</div></div>
            <div class="reg-step-node"><div class="reg-step-circle">3</div><div class="reg-step-label">Documents</div></div>
            <div class="reg-step-node"><div class="reg-step-circle">4</div><div class="reg-step-label">Payment</div></div>
        </div>

        <div class="reg-steps-wrap">

        <!-- STEP 1 -->
        <div class="reg-step active" id="step1">
            <div class="reg-step-title"><i class="fas fa-user"></i> Personal Information</div>
            <div class="reg-step-sub">Enter your personal details exactly as on your official documents.</div>
            <div class="reg-grid">
                <div class="reg-group"><label for="full_name_en">Full Name (English) <span class="req">*</span></label><input type="text" id="full_name_en" placeholder="e.g. Fatema Khatun" autocomplete="name"><span class="reg-err" id="err_full_name_en"></span></div>
                <div class="reg-group"><label for="full_name_bn">পূর্ণ নাম (বাংলা) <span class="req">*</span></label><input type="text" id="full_name_bn" placeholder="যেমন: ফাতেমা খাতুন"><span class="reg-err" id="err_full_name_bn"></span></div>
                <div class="reg-group"><label for="dob">Date of Birth <span class="req">*</span></label><input type="date" id="dob" max="<?php echo date('Y-m-d'); ?>"><span class="reg-err" id="err_dob"></span></div>
                <div class="reg-group"><label for="email">Email Address <span class="req">*</span></label><input type="email" id="email" placeholder="example@gmail.com" required><span class="reg-err" id="err_email"></span><input type="hidden" id="gender" value="female"></div>
                <div class="reg-group"><label for="religion">Religion <span class="req">*</span></label><select id="religion"><option value="">— Select —</option><option>Islam</option><option>Hindu</option><option>Christian</option><option>Buddhist</option><option>Other</option></select><span class="reg-err" id="err_religion"></span></div>
                <div class="reg-group"><label for="blood_group">Blood Group</label><select id="blood_group"><option value="">— Optional —</option><option>A+</option><option>A-</option><option>B+</option><option>B-</option><option>O+</option><option>O-</option><option>AB+</option><option>AB-</option></select></div>
                <div class="reg-group"><label for="nid_number">National ID Number <span style="color:#64748b;font-weight:400;">(optional if under 18)</span></label><input type="text" id="nid_number" placeholder="10 or 17 digit NID" maxlength="17"></div>
                <div class="reg-group"><label for="birth_cert_num">Birth Certificate Number <span class="req">*</span></label><input type="text" id="birth_cert_num" placeholder="Birth Certificate No." required><span class="reg-err" id="err_birth_cert_num"></span></div>
            </div>
            <hr class="reg-section-sep"><div class="reg-section-head"><i class="fas fa-users"></i> Parent / Guardian Information</div>
            <div class="reg-grid">
                <div class="reg-group"><label for="father_name">Father's Full Name <span class="req">*</span></label><input type="text" id="father_name" placeholder="Father's name"><span class="reg-err" id="err_father_name"></span></div>
                <div class="reg-group"><label for="father_nid">Father's NID</label><input type="text" id="father_nid" placeholder="NID (optional)"></div>
                <div class="reg-group"><label for="father_occupation">Father's Occupation</label><input type="text" id="father_occupation" placeholder="e.g. Farmer, Business"></div>
                <div class="reg-group"><label for="mother_name">Mother's Full Name <span class="req">*</span></label><input type="text" id="mother_name" placeholder="Mother's name"><span class="reg-err" id="err_mother_name"></span></div>
                <div class="reg-group"><label for="mother_nid">Mother's NID</label><input type="text" id="mother_nid" placeholder="NID (optional)"></div>
                <div class="reg-group"><label for="mother_occupation">Mother's Occupation</label><input type="text" id="mother_occupation" placeholder="e.g. Housewife, Teacher"></div>
                <div class="reg-group"><label for="guardian_phone">Guardian Phone <span class="req">*</span></label><input type="tel" id="guardian_phone" placeholder="01XXXXXXXXX" maxlength="11"><span class="reg-err" id="err_guardian_phone"></span></div>
                <div class="reg-group"><label for="student_phone">Student Phone</label><input type="tel" id="student_phone" placeholder="01XXXXXXXXX (optional)" maxlength="11"></div>
            </div>
            <hr class="reg-section-sep"><div class="reg-section-head"><i class="fas fa-map-marker-alt"></i> Address</div>
            <div class="reg-grid">
                <div class="reg-group full"><label for="present_address">Present Address <span class="req">*</span></label><textarea id="present_address" rows="3" placeholder="Village / Road, Union / Ward, Upazila, District"></textarea><span class="reg-err" id="err_present_address"></span></div>
                <div class="reg-group full"><label class="reg-check-label" style="margin-bottom:8px;"><input type="checkbox" id="same_address"> Same as present address</label><label for="permanent_address">Permanent Address</label><textarea id="permanent_address" rows="3" placeholder="Permanent address (if different)"></textarea></div>
            </div>
            <div class="reg-nav"><span></span><button class="reg-btn-next" data-action="next">Next <i class="fas fa-arrow-right"></i></button></div>
        </div>

        <!-- STEP 2 -->
        <div class="reg-step" id="step2">
            <div class="reg-step-title"><i class="fas fa-graduation-cap"></i> Academic Information</div>
            <div class="reg-step-sub">Enter your SSC examination details accurately.</div>
            <div class="reg-section-head"><i class="fas fa-school"></i> SSC Examination Details</div>
            <div class="reg-grid">
                <div class="reg-group"><label for="ssc_roll">SSC Roll Number <span class="req">*</span></label><input type="text" id="ssc_roll" placeholder="e.g. 123456"><span class="reg-err" id="err_ssc_roll"></span></div>
                <div class="reg-group"><label for="ssc_reg">SSC Registration No. <span class="req">*</span></label><input type="text" id="ssc_reg" placeholder="e.g. 1234567890"><span class="reg-err" id="err_ssc_reg"></span></div>
                <div class="reg-group"><label for="ssc_board">SSC Board <span class="req">*</span></label><select id="ssc_board"><option value="">— Select Board —</option><option>Dhaka</option><option>Mymensingh</option><option>Rajshahi</option><option>Chittagong</option><option>Comilla</option><option>Jessore</option><option>Sylhet</option><option>Barisal</option><option>Dinajpur</option><option>Madrasha</option><option>Technical</option></select><span class="reg-err" id="err_ssc_board"></span></div>
                <div class="reg-group"><label for="ssc_year">SSC Passing Year <span class="req">*</span></label><select id="ssc_year"><option value="">— Select Year —</option><?php for($y=2026;$y>=2020;$y--): ?><option><?php echo $y; ?></option><?php endfor; ?></select><span class="reg-err" id="err_ssc_year"></span></div>
                <div class="reg-group"><label for="ssc_gpa">SSC GPA <span class="req">*</span></label><input type="number" id="ssc_gpa" placeholder="e.g. 4.50" min="0" max="5" step="0.01"><span class="reg-err" id="err_ssc_gpa"></span></div>
                <div class="reg-group"><label for="ssc_group">SSC Group <span class="req">*</span></label><select id="ssc_group"><option value="">— Select —</option><option>Science</option><option>Humanities</option><option>Business Studies</option></select><span class="reg-err" id="err_ssc_group"></span></div>
                <div class="reg-group full"><label for="prev_institution">Previous Institution Name <span class="req">*</span></label><input type="text" id="prev_institution" placeholder="School where you passed SSC"><span class="reg-err" id="err_prev_institution"></span></div>
            </div>
            <hr class="reg-section-sep"><div class="reg-section-head"><i class="fas fa-book-open"></i> Admission Preferences</div>
            <div class="reg-grid">
                <div class="reg-group full"><label for="desired_group">Program Group Preference <span class="req">*</span></label><select id="desired_group"><option value="">— Select —</option><option>Science</option><option>Humanities</option><option>Business Studies</option></select><span class="reg-err" id="err_desired_group"></span></div>
                
                <!-- Dynamic Subjects Container -->
                <div id="dynamic_subjects_container" style="grid-column: 1 / -1; display: none;"></div>
            </div>
            <div class="reg-nav"><button class="reg-btn-back" data-action="back"><i class="fas fa-arrow-left"></i> Back</button><button class="reg-btn-next" data-action="next">Next <i class="fas fa-arrow-right"></i></button></div>
        </div>

        <!-- STEP 3 -->
        <div class="reg-step" id="step3">
            <div class="reg-step-title"><i class="fas fa-file-upload"></i> Document Upload</div>
            <div class="reg-step-sub">Upload clear, legible scanned copies or photos of your documents.</div>
            <div class="reg-uploads">
                <div class="reg-upload-zone" id="zone_photo"><input type="file" id="upload_photo" accept=".jpg,.jpeg,.png"><div class="reg-photo-placeholder"><i class="fas fa-user"></i></div><img class="reg-photo-preview" id="photo_preview" src="" alt="Photo"><div class="reg-upload-info"><div class="reg-upload-title">Passport Size Photo <span class="req" style="color:#dc2626;">*</span></div><div class="reg-upload-hint">Recent passport size photo (white background) · JPG/PNG · Max 2MB</div><div class="reg-upload-cta"><i class="fas fa-cloud-upload-alt"></i> Click to upload or drag &amp; drop</div><div class="reg-upload-filename" id="photo_filename"></div></div><button type="button" class="reg-upload-remove" title="Remove"><i class="fas fa-times"></i></button></div>
                <div class="reg-upload-zone" id="zone_cert"><input type="file" id="upload_cert" accept=".pdf,application/pdf"><div class="reg-doc-placeholder"><i class="fas fa-file-alt"></i></div><img class="reg-doc-thumb" id="cert_preview" src="" alt="Certificate"><div class="reg-upload-info"><div class="reg-upload-title">SSC Certificate / Marksheet <span class="req" style="color:#dc2626;">*</span></div><div class="reg-upload-hint">Clear PDF scan · PDF Only · Max 5MB</div><div class="reg-upload-cta"><i class="fas fa-cloud-upload-alt"></i> Click to upload or drag &amp; drop</div><div class="reg-upload-filename" id="cert_filename"></div></div><button type="button" class="reg-upload-remove" title="Remove"><i class="fas fa-times"></i></button></div>
                <div class="reg-upload-zone" id="zone_birth"><input type="file" id="upload_birth" accept=".pdf,application/pdf"><div class="reg-doc-placeholder"><i class="fas fa-baby"></i></div><img class="reg-doc-thumb" id="birth_preview" src="" alt="Birth cert"><div class="reg-upload-info"><div class="reg-upload-title">Birth Certificate <span class="req" style="color:#dc2626;">*</span></div><div class="reg-upload-hint">Online or physical birth certificate · PDF Only · Max 5MB</div><div class="reg-upload-cta"><i class="fas fa-cloud-upload-alt"></i> Click to upload or drag &amp; drop</div><div class="reg-upload-filename" id="birth_filename"></div></div><button type="button" class="reg-upload-remove" title="Remove"><i class="fas fa-times"></i></button></div>
            </div>
            <div class="reg-nav"><button class="reg-btn-back" data-action="back"><i class="fas fa-arrow-left"></i> Back</button><button class="reg-btn-next" data-action="next">Next <i class="fas fa-arrow-right"></i></button></div>
        </div>

        <!-- STEP 4 -->
        <div class="reg-step" id="step4">
            <div class="reg-step-title"><i class="fas fa-money-bill-wave"></i> Payment</div>
            <div class="reg-step-sub">Send the registration fee and enter your transaction details below.</div>
            <div class="reg-pay-info">
                <div class="reg-pay-info-title">Application Fee</div>
                <div class="reg-pay-amount" id="reg-fee-display" data-fee="<?php echo $fee; ?>"><sup>৳</sup><?php echo $fee; ?></div>
                <div class="reg-pay-instruction">Send the fee to any number below using <strong>bKash</strong>, <strong>Nagad</strong>, or <strong>Rocket</strong> (Personal → Send Money). Then enter your transaction ID below.</div>
            </div>
            <div class="reg-pay-methods">
                <div class="reg-pay-card bkash"><div class="reg-pay-card-logo">🟣 bKash</div><div class="reg-pay-card-type">Personal · Send Money</div><div class="reg-pay-card-number"><?php echo htmlspecialchars($bkash); ?></div><button type="button" class="reg-pay-copy-btn" data-number="<?php echo htmlspecialchars($bkash); ?>"><i class="fas fa-copy"></i> Copy</button></div>
                <div class="reg-pay-card nagad"><div class="reg-pay-card-logo">🟠 Nagad</div><div class="reg-pay-card-type">Personal · Send Money</div><div class="reg-pay-card-number"><?php echo htmlspecialchars($nagad); ?></div><button type="button" class="reg-pay-copy-btn" data-number="<?php echo htmlspecialchars($nagad); ?>"><i class="fas fa-copy"></i> Copy</button></div>
                <div class="reg-pay-card rocket"><div class="reg-pay-card-logo">🟤 Rocket</div><div class="reg-pay-card-type">Personal · Send Money</div><div class="reg-pay-card-number"><?php echo htmlspecialchars($rocket); ?></div><button type="button" class="reg-pay-copy-btn" data-number="<?php echo htmlspecialchars($rocket); ?>"><i class="fas fa-copy"></i> Copy</button></div>
            </div>
            <div class="reg-grid">
                <div class="reg-group full"><label>Payment Method <span class="req">*</span></label><div class="reg-radio-group"><label class="reg-radio-label"><input type="radio" name="payment_method" value="bKash"> bKash</label><label class="reg-radio-label"><input type="radio" name="payment_method" value="Nagad"> Nagad</label><label class="reg-radio-label"><input type="radio" name="payment_method" value="Rocket"> Rocket</label></div></div>
                <div class="reg-group"><label for="transaction_id">Transaction ID <span class="req">*</span></label><input type="text" id="transaction_id" placeholder="e.g. 8N7A2K3B9Q"><span class="reg-err" id="err_transaction_id"></span></div>
                <div class="reg-group"><label for="amount_paid">Amount Paid (৳) <span class="req">*</span></label><input type="number" id="amount_paid" value="<?php echo $fee; ?>" min="0" step="0.01"><span class="reg-err" id="err_amount_paid"></span></div>
                <div class="reg-group"><label for="payment_date">Payment Date <span class="req">*</span></label><input type="date" id="payment_date" max="<?php echo date('Y-m-d'); ?>"><span class="reg-err" id="err_payment_date"></span></div>
            </div>
            <div class="reg-summary" style="margin-top:24px;">
                <div class="reg-summary-toggle"><span><i class="fas fa-list-ul" style="margin-right:8px;color:#2563eb;"></i> Application Summary</span><i class="fas fa-chevron-down"></i></div>
                <div class="reg-summary-body"><div id="summaryBody"></div><div style="margin-top:10px;font-size:.78rem;"><span class="reg-summary-edit" data-goto-step="1">← Edit Personal Info</span> &nbsp;|&nbsp; <span class="reg-summary-edit" data-goto-step="2">← Edit Academic Info</span></div></div>
            </div>
            <div class="reg-nav">
                <button class="reg-btn-back" data-action="back"><i class="fas fa-arrow-left"></i> Back</button>
                <button class="reg-btn-submit" id="btnSubmit"><span id="submitSpinner" style="display:none;"><i class="fas fa-spinner fa-spin"></i></span><i class="fas fa-paper-plane"></i> <span data-i18n="submit">Submit Application</span></button>
            </div>
        </div>

        </div><!-- /reg-steps-wrap -->
    </div><!-- /reg-card -->
    </div><!-- /regFormWrap -->

    <!-- Confirm Dialog -->
    <div class="reg-confirm-overlay" id="regConfirmOverlay">
        <div class="reg-confirm-box">
            <div class="reg-confirm-icon"><i class="fas fa-question-circle"></i></div>
            <div class="reg-confirm-title">Submit Your Application?</div>
            <div class="reg-confirm-msg">Are you sure you want to submit? <strong>You cannot edit it after submission.</strong> Please review all details carefully.</div>
            <div class="reg-confirm-btns"><button class="reg-confirm-cancel" id="confirmCancel">Review Again</button><button class="reg-confirm-submit" id="confirmSubmit"><i class="fas fa-paper-plane"></i> Submit</button></div>
        </div>
    </div>

    <?php endif; /* end open state */ ?>

    </div><!-- /container -->
</div><!-- /reg-page -->

<div class="reg-toast" id="regToast"></div>
<script>
    document.body.dataset.formType = 'hsc';
    const programSubjects = <?php echo json_encode($program_subjects); ?>;
</script>
<script src="<?= BASE_URL ?>/javascript/registration.js?v=<?= time() ?>"></script>
<?php include '../includes/footer.php'; ?>
