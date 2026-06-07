<?php require_once '../../../includes/session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HSC Registration Management | PMDC Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css?v=<?= time() ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/admin/css/styles.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/admin/css/teacher.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/admin/css/registration-admin.css?v=<?= time() ?>">
</head>
<body data-reg-type="hsc">

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <div class="logo-icon"><i class="fas fa-university"></i></div>
            <div class="logo-text"><span class="logo-name">PMDC</span><span class="logo-role">Admin Portal</span></div>
        </div>
        <button class="close-sidebar" id="closeSidebar"><i class="fas fa-times"></i></button>
    </div>
    <nav class="sidebar-nav">
        <span class="nav-section-label">Main</span>
        <a href="<?= BASE_URL ?>/admin" class="nav-item"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
        <a href="<?= BASE_URL ?>/admin/students" class="nav-item"><i class="fas fa-users"></i><span>Students</span></a>
        <a href="<?= BASE_URL ?>/admin/staff" class="nav-item"><i class="fas fa-chalkboard-teacher"></i><span>Teachers &amp; Staff</span></a>
        <a href="<?= BASE_URL ?>/admin/gallery" class="nav-item"><i class="fas fa-images"></i><span>Gallery</span></a>
        <a href="<?= BASE_URL ?>/admin/academics" class="nav-item"><i class="fas fa-book-open"></i><span>Academics</span></a>
            <a href="<?= BASE_URL ?>/admin/results" class="nav-item"><i class="fas fa-graduation-cap"></i><span>Results</span></a>
        <div class="nav-divider"></div>
        <span class="nav-section-label">Management</span>
        <a href="<?= BASE_URL ?>/admin/calendar" class="nav-item"><i class="fas fa-calendar-alt"></i><span>Academic Calendar</span></a>
            <a href="<?= BASE_URL ?>/admin/assign-teachers" class="nav-item"><i class="fas fa-tasks"></i><span>Assign Teachers</span></a>
        <a href="#" class="nav-item"><i class="fas fa-file-invoice-dollar"></i><span>Finance</span></a>
        <a href="<?= BASE_URL ?>/admin/announcement" class="nav-item"><i class="fas fa-bell"></i><span>Announcements</span></a>
        <a href="<?= BASE_URL ?>/admin/registration" class="nav-item active"><i class="fas fa-file-alt"></i><span>HSC Registration</span></a>
        <a href="<?= BASE_URL ?>/admin/registration-degree" class="nav-item"><i class="fas fa-university"></i><span>Degree Registration</span></a>
        <a href="#" class="nav-item"><i class="fas fa-chart-line"></i><span>Reports</span></a>
        <div class="nav-divider"></div>
        <span class="nav-section-label">System</span>
        <a href="#" class="nav-item"><i class="fas fa-cog"></i><span>Settings</span></a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="avatar">AN</div>
            <div class="user-info"><div class="user-name">Admin Nasrin</div><div class="user-role">System Administrator</div></div>
        </div>
    </div>
</aside>

<main class="main-content">
    <header class="top-header">
        <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
        <div class="th-breadcrumb">
            <a href="<?= BASE_URL ?>/admin">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <span>HSC Registration</span>
        </div>
        <div class="header-right">
            <button class="icon-btn"><i class="far fa-bell"></i><span class="notification-dot"></span></button>
            <div class="header-divider"></div>
            <div class="user-menu">
                <img src="https://ui-avatars.com/api/?name=Admin+Nasrin&background=1a3a5c&color=fff&bold=true" alt="Admin">
                <span class="um-name">Admin Nasrin</span>
            </div>
            <a href="<?= BASE_URL ?>/admin/login" class="logout-btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </header>

    <div class="content-area">

        <!-- Page Header -->
        <div class="tm-page-header">
            <div class="tm-page-title">
                <h1>HSC Registration</h1>
                <p>Manage HSC admission registrations — settings, review, and approval</p>
            </div>
            <div class="tm-header-actions">
                <a href="<?= BASE_URL ?>/register-hsc" target="_blank" class="btn-preview">
                    <i class="fas fa-external-link-alt"></i> View Public Form
                </a>
            </div>
        </div>

        <!-- ── Settings Card ── -->
        <div class="tm-card ra-settings-card">
            <div style="font-size:.88rem;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px;margin-bottom:16px;">
                <i class="fas fa-cog" style="color:var(--blue);"></i> Registration Settings
            </div>

            <!-- Status Toggle -->
            <div class="ra-status-row">
                <div class="ra-status-info">
                    <div style="width:40px;height:40px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;color:#2563eb;">
                        <i class="fas fa-toggle-on"></i>
                    </div>
                    <div>
                        <div class="ra-status-label">Registration Status</div>
                        <div class="ra-status-sub">Toggle to open or close the public HSC registration form</div>
                    </div>
                </div>
                <div class="ra-toggle-wrap">
                    <span class="ra-toggle-lbl closed" id="toggleLbl">CLOSED</span>
                    <label class="ra-toggle">
                        <input type="checkbox" id="statusToggle">
                        <span class="ra-toggle-slider"></span>
                    </label>
                </div>
            </div>

            <div class="ra-settings-grid" style="margin-top:16px;">
                <div class="tm-form-group">
                    <label>Academic Session</label>
                    <input type="text" id="settingsSession" placeholder="e.g. 2026-2027" class="tm-input">
                </div>
                <div class="tm-form-group">
                    <label>Registration Fee (৳)</label>
                    <div class="ra-fee-row">
                        <span class="ra-fee-prefix">৳</span>
                        <input type="number" id="settingsFee" placeholder="200" min="0" class="tm-input">
                    </div>
                </div>
                <div class="tm-form-group">
                    <label>
                        <i class="fas fa-calendar-plus" style="color:#16a34a;margin-right:5px;"></i>
                        Registration Open Date
                    </label>
                    <input type="date" id="settingsOpenDate" class="tm-input">
                    <span style="font-size:.72rem;color:var(--muted);margin-top:4px;display:block;">Leave blank to open immediately when toggle is ON</span>
                </div>
                <div class="tm-form-group">
                    <label>
                        <i class="fas fa-calendar-times" style="color:#dc2626;margin-right:5px;"></i>
                        Auto-Close Date
                    </label>
                    <input type="date" id="settingsCloseDate" class="tm-input">
                    <span style="font-size:.72rem;color:var(--muted);margin-top:4px;display:block;">Registration auto-closes after this date (leave blank for manual only)</span>
                </div>
                <div class="tm-form-group">
                    <label>bKash Number</label>
                    <input type="text" id="settingsBkash" placeholder="01XXXXXXXXX" class="tm-input">
                </div>
                <div class="tm-form-group">
                    <label>Nagad Number</label>
                    <input type="text" id="settingsNagad" placeholder="01XXXXXXXXX" class="tm-input">
                </div>
                <div class="tm-form-group">
                    <label>Rocket Number</label>
                    <input type="text" id="settingsRocket" placeholder="01XXXXXXXXX" class="tm-input">
                </div>
                <div style="grid-column: 1 / -1; display: flex; justify-content: flex-end; margin-top: 6px; padding-top: 16px; border-top: 1px dashed var(--border);">
                    <button class="btn-add-staff" id="btnSaveSettings" style="padding: 10px 24px;">
                        <i class="fas fa-save"></i> Save Settings
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="tm-stats-row">
            <div class="tm-stat-pill">
                <i class="fas fa-file-alt" style="color:var(--blue);font-size:1rem;flex-shrink:0;"></i>
                <span class="ts-val" id="statTotal">0</span>
                <span class="ts-lbl">Total Applications</span>
            </div>
            <div class="tm-stat-pill">
                <i class="fas fa-clock" style="color:#d97706;font-size:1rem;flex-shrink:0;"></i>
                <span class="ts-val" id="statPending">0</span>
                <span class="ts-lbl">Pending Review</span>
            </div>
            <div class="tm-stat-pill">
                <i class="fas fa-check-circle" style="color:var(--green);font-size:1rem;flex-shrink:0;"></i>
                <span class="ts-val" id="statApproved">0</span>
                <span class="ts-lbl">Approved</span>
            </div>
            <div class="tm-stat-pill">
                <i class="fas fa-times-circle" style="color:var(--red);font-size:1rem;flex-shrink:0;"></i>
                <span class="ts-val" id="statRejected">0</span>
                <span class="ts-lbl">Rejected</span>
            </div>
        </div>

        <!-- Applications Table -->
        <div class="ra-section-head">
            <div class="ra-section-left">
                <div class="ra-section-icon" style="background:#eff6ff;color:#2563eb;"><i class="fas fa-list-alt"></i></div>
                <div>
                    <div class="ra-section-title">Applications</div>
                    <div class="ra-section-sub">All HSC registration applications for the current session</div>
                </div>
            </div>
            <button class="ra-export-btn" id="btnExport">
                <i class="fas fa-download"></i> Export CSV
            </button>
        </div>

        <div class="tm-card" style="padding:0;">
            <div class="ra-filter-bar">
                <div class="tm-search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search name, ref, transaction…" autocomplete="off">
                </div>
                <select class="ra-select" id="filterStatus">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
                <select class="ra-select" id="filterGroup">
                    <option value="all">All Groups</option>
                    <option>Science</option>
                    <option>Humanities</option>
                    <option>Business Studies</option>
                </select>
                <select class="ra-select" id="filterPayment">
                    <option value="all">All Payment</option>
                    <option value="bKash">bKash</option>
                    <option value="Nagad">Nagad</option>
                    <option value="Rocket">Rocket</option>
                </select>
            </div>

            <div class="tm-table-wrap">
                <table class="tm-table" id="appTable">
                    <thead>
                        <tr>
                            <th>Ref No.</th>
                            <th>Name</th>
                            <th>Desired Group</th>
                            <th width="70" class="text-center">SSC GPA</th>
                            <th width="80">Payment</th>
                            <th>Transaction ID</th>
                            <th width="130">Submitted</th>
                            <th width="100">Status</th>
                            <th width="100">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="appTbody"></tbody>
                </table>
            </div>

            <div class="ra-empty" id="appEmpty" style="display:none;">
                <i class="fas fa-inbox"></i>
                <p>No applications found</p>
                <span>Applications will appear here when registration is open</span>
            </div>

            <div class="ra-pagination" id="appPagination">
                <span id="pagInfo"></span>
                <div class="ra-page-btns" id="pagBtns"></div>
            </div>
        </div>

    </div><!-- /content-area -->
</main>

<div class="tm-toast" id="raToast"></div>

<!-- ══ DETAIL MODAL ══════════════════════════════════════ -->
<div class="tm-modal-overlay" id="detailOverlay">
    <div class="tm-modal ra-detail-modal" role="dialog" aria-modal="true">
        <div class="tm-modal-header">
            <div>
                <h2 style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                    <i class="fas fa-file-alt" style="color:var(--blue);"></i>
                    <span id="detailRef">—</span>
                    <span id="detailStatus" class="ra-badge pending"><i class="fas fa-clock"></i> Pending</span>
                </h2>
                <div style="font-size:.75rem;color:var(--muted);margin-top:4px;">Submitted: <span id="detailDate">—</span></div>
            </div>
            <button class="tm-modal-close" id="detailClose"><i class="fas fa-times"></i></button>
        </div>
        <div class="tm-modal-body">
            <div class="ra-modal-actions" style="justify-content: flex-end;">
                <button class="btn-cancel" id="detailPrint"><i class="fas fa-print"></i> Print</button>
            </div>            <div id="rejectionReasonWrap" style="display:none;background:#fee2e2;border-radius:10px;padding:12px 16px;margin-top:12px;font-size:.82rem;color:#991b1b;font-family:'Inter',sans-serif;">
                <strong>Rejection reason:</strong> <span id="rejectionReasonText"></span>
            </div>

            <div class="ra-detail-section" style="margin-top:20px;">
                <div class="ra-detail-section-title"><i class="fas fa-user"></i> Personal Information</div>
                <div class="ra-detail-grid">
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Full Name (EN)</span><span class="ra-detail-val" id="dName">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Full Name (BN)</span><span class="ra-detail-val" id="dNameBn">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Date of Birth</span><span class="ra-detail-val" id="dDob">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Religion</span><span class="ra-detail-val" id="dReligion">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Blood Group</span><span class="ra-detail-val" id="dBlood">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">NID Number</span><span class="ra-detail-val" id="dNid">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Birth Cert No.</span><span class="ra-detail-val" id="dBirth">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Student Phone</span><span class="ra-detail-val" id="dStudentPhone">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Email</span><span class="ra-detail-val" id="dEmail">—</span></div>
                </div>
            </div>

            <div class="ra-detail-section">
                <div class="ra-detail-section-title"><i class="fas fa-users"></i> Parents/Guardian Information</div>
                <div class="ra-detail-grid">
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Father's Name</span><span class="ra-detail-val" id="dFather">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Father's NID</span><span class="ra-detail-val" id="dFatherNid">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Father's Occ.</span><span class="ra-detail-val" id="dFatherOcc">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Mother's Name</span><span class="ra-detail-val" id="dMother">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Mother's NID</span><span class="ra-detail-val" id="dMotherNid">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Mother's Occ.</span><span class="ra-detail-val" id="dMotherOcc">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Guardian Phone</span><span class="ra-detail-val" id="dPhone">—</span></div>
                </div>
            </div>

            <div class="ra-detail-section">
                <div class="ra-detail-section-title"><i class="fas fa-map-marker-alt"></i> Address Information</div>
                <div class="ra-detail-grid">
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Present Address</span><span class="ra-detail-val" id="dPresentAddress">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Permanent Address</span><span class="ra-detail-val" id="dPermanentAddress">—</span></div>
                </div>
            </div>

            <div class="ra-detail-section">
                <div class="ra-detail-section-title"><i class="fas fa-graduation-cap"></i> Academic Information (SSC)</div>
                <div class="ra-detail-grid">
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Roll Number</span><span class="ra-detail-val" id="dAcadRoll">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Registration No.</span><span class="ra-detail-val" id="dAcadReg">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Board</span><span class="ra-detail-val" id="dAcadBoard">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Passing Year</span><span class="ra-detail-val" id="dAcadYear">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">GPA</span><span class="ra-detail-val" id="dAcadGPA">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Previous Group</span><span class="ra-detail-val" id="dAcadPrevGroup">—</span></div>
                    <div class="ra-detail-item full"><span class="ra-detail-lbl">Previous Institution</span><span class="ra-detail-val" id="dAcadInst">—</span></div>
                </div>
            </div>

            <div class="ra-detail-section">
                <div class="ra-detail-section-title"><i class="fas fa-bullseye"></i> Admission Preference</div>
                <div class="ra-detail-grid">
                    <div class="ra-detail-item full"><span class="ra-detail-lbl">Desired Group</span><span class="ra-detail-val" id="dAcadDesiredGroup">—</span></div>
                    <div class="ra-detail-item full"><span class="ra-detail-lbl">Optional Subjects</span><span class="ra-detail-val" id="dAcadOptSubjects" style="color:#d97706;font-weight:600;">—</span></div>
                    <div class="ra-detail-item full"><span class="ra-detail-lbl">4th Subject</span><span class="ra-detail-val" id="dAcadFourthSubject" style="color:#2563eb;font-weight:600;">—</span></div>
                </div>
            </div>

            <div class="ra-detail-section">
                <div class="ra-detail-section-title"><i class="fas fa-file-image"></i> Documents</div>
                <div class="ra-doc-grid">
                    <div class="ra-doc-card"><div id="docPhoto"><div class="ra-doc-none"><i class="fas fa-user"></i></div></div><div class="ra-doc-label">Passport Photo</div></div>
                    <div class="ra-doc-card"><div id="docCert"><div class="ra-doc-none"><i class="fas fa-file-alt"></i></div></div><div class="ra-doc-label">SSC Certificate</div></div>
                    <div class="ra-doc-card"><div id="docBirth"><div class="ra-doc-none"><i class="fas fa-baby"></i></div></div><div class="ra-doc-label">Birth Certificate</div></div>
                </div>
            </div>

            <div class="ra-detail-section">
                <div class="ra-detail-section-title"><i class="fas fa-money-bill-wave"></i> Payment Details</div>
                <div class="ra-detail-grid">
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Payment Method</span><span class="ra-detail-val" id="dPayMethod">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Transaction ID</span><span class="ra-detail-val" id="dPayTxn">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Amount Paid</span><span class="ra-detail-val" id="dPayAmount">—</span></div>
                    <div class="ra-detail-item"><span class="ra-detail-lbl">Payment Date</span><span class="ra-detail-val" id="dPayDate">—</span></div>
                </div>
            </div>

            <div class="ra-detail-section">
                <div class="ra-detail-section-title"><i class="fas fa-sticky-note"></i> Admin Note (Internal)</div>
                <div class="ra-admin-note-wrap">
                    <textarea id="adminNoteTA" rows="3" placeholder="Add internal notes about this application…"></textarea>
                    <button class="btn-cancel" id="btnSaveNote" style="align-self:flex-start;"><i class="fas fa-save"></i> Save Note</button>
                </div>
            </div>

            <div class="ra-modal-actions" style="margin-top: 30px; display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid var(--border); padding-top: 20px;">
                <button class="ra-btn-reject-full"  id="detailRejectBtn"><i class="fas fa-times"></i> Reject</button>
                <button class="ra-btn-approve-full" id="detailApproveBtn"><i class="fas fa-check"></i> Approve</button>
            </div>
        </div>
    </div>
</div>

<!-- ══ REJECT MODAL ══ -->
<div class="tm-modal-overlay" id="rejectOverlay">
    <div class="tm-modal ra-reject-modal" role="dialog" aria-modal="true">
        <div class="tm-modal-header">
            <h2><i class="fas fa-times-circle" style="color:var(--red);"></i> Reject Application</h2>
            <button class="tm-modal-close" id="rejectClose"><i class="fas fa-times"></i></button>
        </div>
        <div class="tm-modal-body">
            <p style="font-size:.88rem;color:var(--muted);margin-bottom:16px;font-family:'Inter',sans-serif;">Optionally provide a reason for rejection. This will be saved with the record.</p>
            <div class="tm-form-group">
                <label for="rejectReasonInput">Reason <span style="font-weight:400;color:var(--muted);">(optional)</span></label>
                <textarea id="rejectReasonInput" rows="3" style="width:100%;padding:10px 13px;border:1.5px solid var(--border);border-radius:9px;font-size:.85rem;font-family:'Inter',sans-serif;resize:vertical;outline:none;box-sizing:border-box;" placeholder="e.g. Incomplete documents, unclear photo…"></textarea>
            </div>
        </div>
        <div class="tm-modal-footer">
            <button class="btn-cancel" id="rejectCancel">Cancel</button>
            <button class="btn-delete-confirm" id="rejectConfirm"><i class="fas fa-times"></i> Confirm Reject</button>
        </div>
    </div>
</div>

<script>
(function(){
    const sidebar=document.getElementById('sidebar'),overlay=document.getElementById('sidebarOverlay');
    function open(){sidebar.classList.add('open');overlay.classList.add('active');document.body.style.overflow='hidden';}
    function close(){sidebar.classList.remove('open');overlay.classList.remove('active');document.body.style.overflow='';}
    document.getElementById('menuToggle')?.addEventListener('click',open);
    document.getElementById('closeSidebar')?.addEventListener('click',close);
    overlay?.addEventListener('click',close);
})();
</script>
<script>window.BASE_URL = "<?= BASE_URL ?>";</script>
    <script src="<?= BASE_URL ?>/pages/portal/admin/js/registration-admin.js?v=<?= time() ?>"></script>
</body>
</html>



