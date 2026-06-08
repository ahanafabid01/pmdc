<?php
require_once '../../../includes/session_check.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../portal-login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results Dashboard | Admin Portal | PMDC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/admin/css/styles.css?v=2">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/teacher/css/attendance.css?v=2">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/admin/css/results.css?v=2">
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <div class="logo-icon"><i class="fas fa-university"></i></div>
            <div class="logo-text">
                <span class="logo-name">PMDC</span>
                <span class="logo-role">Admin Portal</span>
            </div>
        </div>
        <button class="close-sidebar" id="closeSidebar">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <span class="nav-section-label">Main</span>
        <a href="<?= BASE_URL ?>/admin" class="nav-item">
            <i class="fas fa-th-large"></i>
            <span>Dashboard</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/students" class="nav-item"><i class="fas fa-users"></i><span>Students</span>

        </a>
        <a href="<?= BASE_URL ?>/admin/staff" class="nav-item">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Teachers &amp; Staff</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/gallery" class="nav-item">
            <i class="fas fa-images"></i>
            <span>Gallery</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/academics" class="nav-item">
            <i class="fas fa-book-open"></i>
            <span>Academics</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/results" class="nav-item active">
            <i class="fas fa-graduation-cap"></i>
            <span>Results</span>
        </a>

        <div class="nav-divider"></div>
        <span class="nav-section-label">Management</span>
        <a href="<?= BASE_URL ?>/admin/calendar" class="nav-item">
            <i class="fas fa-calendar-alt"></i>
            <span>Academic Calendar</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/assign-teachers" class="nav-item">
            <i class="fas fa-tasks"></i>
            <span>Assign Teachers</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>Finance</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/announcement" class="nav-item">
            <i class="fas fa-bell"></i>
            <span>Announcements</span>

        </a>
        <a href="<?= BASE_URL ?>/admin/registration" class="nav-item">
            <i class="fas fa-file-alt"></i>
            <span>HSC Registration</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/registration-degree" class="nav-item">
            <i class="fas fa-university"></i>
            <span>Degree Registration</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-chart-line"></i>
            <span>Reports</span>
        </a>

        <div class="nav-divider"></div>
        <span class="nav-section-label">System</span>
        <a href="#" class="nav-item">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="avatar">AN</div>
            <div class="user-info">
                <div class="user-name">Admin Nasrin</div>
                <div class="user-role">System Administrator</div>
            </div>
        </div>
    </div>
</aside>

<main class="main-content">
    <header class="top-header">
        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="th-breadcrumb">
            <a href="<?= BASE_URL ?>/admin">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <span>Results</span>
        </div>
        <div class="header-right">
            <button class="icon-btn" title="Notifications">
                <i class="far fa-bell"></i>
                <span class="notification-dot"></span>
            </button>
            <button class="icon-btn" title="Messages">
                <i class="far fa-envelope"></i>
            </button>
            <div class="header-divider"></div>
            <div class="user-menu">
                <img src="https://ui-avatars.com/api/?name=Admin+Nasrin&background=1a3a5c&color=fff&bold=true" alt="Admin Nasrin">
                <span class="um-name">Admin Nasrin</span>
            </div>
            <a href="<?= BASE_URL ?>/admin/login" class="logout-btn" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </header>

    <div class="content-area">
        <div class="welcome-banner" style="margin-bottom: 24px;">
            <div class="welcome-content">
                <h1 style="display:flex; align-items:center; gap:12px;"><i class="fas fa-chart-pie"></i> Result Publishing</h1>
                <p style="margin-top:8px;">Oversee teacher submissions and securely release final results to the public portal.</p>
            </div>
        </div>

        <div class="card att-card">
            <div class="card-header">
                <h3><i class="fas fa-sliders-h"></i> Select Exam & Program</h3>
            </div>
            <div class="card-body att-pad">
                <div class="att-filter-grid results-filter">
                    <div class="att-field">
                        <label>Exam</label>
                        <select id="examSelect"><option value="">Loading...</option></select>
                    </div>
                    <div class="att-field">
                        <label>Program</label>
                        <select id="programSelect"><option value="">Loading...</option></select>
                    </div>
                    <div class="att-field">
                        <button class="btn-att-primary" id="loadProgressBtn" style="width: 100%; padding: 10px; margin-top: 22px;">
                            <i class="fas fa-search"></i> Check Progress
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="progressDashboard" style="display:none;">
            <!-- Summary Stats -->
            <div class="stats-grid" style="margin-bottom: 20px;">
                <div class="stat-card">
                    <div class="stat-icon" style="background:#e0f2fe; color:#0284c7;"><i class="fas fa-book"></i></div>
                    <div class="stat-info">
                        <h3>Total Subjects</h3>
                        <p id="statTotal">0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#dcfce7; color:#16a34a;"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-info">
                        <h3>Published</h3>
                        <p id="statPublished">0</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#fef9c3; color:#ca8a04;"><i class="fas fa-clock"></i></div>
                    <div class="stat-info">
                        <h3>Pending</h3>
                        <p id="statPending">0</p>
                    </div>
                </div>
            </div>

            <!-- Subject Progress Table -->
            <div class="card">
                <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3><i class="fas fa-tasks"></i> Teacher Submissions</h3>
                    <div id="releaseControls">
                        <button class="btn-success" id="releaseBtn" disabled>
                            <i class="fas fa-globe"></i> Release Results
                        </button>
                    </div>
                </div>
                <div class="card-body" style="padding:0;">
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" id="progressBarFill" style="width: 0%;"></div>
                    </div>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="min-width:180px;">Subject</th>
                                <th style="min-width:200px;">Assigned Teacher</th>
                                <th style="min-width:120px;">Status</th>
                            </tr>
                        </thead>
                        <tbody id="progressTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

<div class="toast" id="toast"><i class="fas fa-info-circle"></i><span id="toastMsg">Saved</span></div>

<div class="modal-overlay" id="releaseModal">
    <div class="modal-box modal-sm">
        <div class="modal-header">
            <h2><i class="fas fa-globe"></i> Confirm Release</h2>
            <button class="modal-close" id="closeReleaseModal"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="publish-confirm">
                <p id="releaseConfirmText">Are you sure you want to release these results?</p>
                <div class="form-actions" style="margin-top:20px; display:flex; gap:10px; justify-content:center;">
                    <button class="btn-att-primary" style="background:#64748b; border:none; padding:10px 20px; color:white; border-radius:8px;" id="cancelRelease">Cancel</button>
                    <button class="btn-success" id="confirmReleaseBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>window.BASE_URL = "<?= BASE_URL ?>";</script>
    <script src="<?= BASE_URL ?>/pages/portal/admin/js/portal.js?v=<?= time() ?>"></script>
<script src="<?= BASE_URL ?>/pages/portal/admin/js/results.js?v=<?= time() ?>"></script>
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
</body>
</html>

