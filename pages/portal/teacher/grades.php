<?php require_once '../../../includes/session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results | Teacher Portal | PMDC</title>
    <meta name="description" content="Enter and manage student exam results — HSC and Degree programs.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/teacher/css/styles.css?v=2">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/teacher/css/dashboard.css?v=2">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/teacher/css/attendance.css?v=2">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/teacher/css/grades.css?v=2">
    <script>
        window.onerror = function(msg, url, line, col, error) {
            alert("JS Error: " + msg + "\nURL: " + url + "\nLine: " + line);
        };
        window.addEventListener('unhandledrejection', function(event) {
            alert("Unhandled Promise Rejection: " + event.reason);
        });
    </script>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo"><i class="fas fa-school"></i><span>PMDC</span></div>
        <div class="close-sidebar" id="closeSidebar"><i class="fas fa-times"></i></div>
    </div>
    <nav class="sidebar-nav">
        <a href="<?= BASE_URL ?>/teacher"      class="nav-item"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
        <a href="attendance.php" class="nav-item"><i class="fas fa-clipboard-check"></i><span>Attendance</span></a>
        <a href="grades.php"     class="nav-item active"><i class="fas fa-graduation-cap"></i><span>Results</span></a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-avatar" id="sidebarAvatar">T</div>
        <div class="user-info">
            <div class="user-name t-name">Loading…</div>
            <div class="user-role t-role">Teacher</div>
        </div>
    </div>
</aside>

<main class="main-content">

    <header class="top-header">
        <div class="header-left">
            <button class="menu-toggle" id="menuToggle" aria-label="Open menu"><i class="fas fa-bars"></i></button>
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <i class="fas fa-home"></i>
                <i class="fas fa-chevron-right sep"></i>
                <strong>Results</strong>
            </nav>
        </div>
        <div class="header-right">
            <button class="icon-btn" title="Notifications"><i class="far fa-bell"></i><span class="notification-dot"></span></button>
            <button class="icon-btn" title="Messages"><i class="far fa-envelope"></i></button>
            <img class="user-avatar-sm" id="headerAvatar"
                 src="https://ui-avatars.com/api/?name=Teacher&background=2563eb&color=fff"
                 alt="Teacher">
            <a href="<?= BASE_URL ?>/admin/login" class="logout-btn" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
                <span class="logout-text">Log Out</span>
            </a>
        </div>
    </header>

    <div class="content-area">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left">
                <h1 class="page-title"><i class="fas fa-graduation-cap"></i> Result Management</h1>
                <p class="page-subtitle">
                    Each exam is <strong>independent</strong>.&nbsp;·&nbsp;
                    Enter marks per subject per exam for each student.
                </p>
            </div>
            <div class="page-header-actions">
                <button class="btn-export" id="exportGradesBtn">
                    <i class="fas fa-download"></i> Export CSV
                </button>
                <button class="btn-publish" id="publishBtn">
                    <i class="fas fa-paper-plane"></i> Publish Results
                </button>
            </div>
        </div>

        <!-- Loading Banner -->
        <div class="att-loading-banner" id="gradesLoadingBanner">
            <i class="fas fa-spinner fa-spin"></i>
            <span>Loading your assigned classes…</span>
        </div>

        <!-- No Programs Warning -->
        <div class="att-no-programs" id="gradesNoPrograms" style="display:none;">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>No programs assigned</strong>
                <p>Contact your administrator to assign classes and programs to your account.</p>
            </div>
        </div>

        <!-- Stats Grid — populated by JS -->
        <div class="grades-stats-grid" id="gradesStatsGrid" style="display:none;">
            <div class="gr-stat-card" style="--accent:#3182ce;">
                <div class="gr-stat-icon" style="background:linear-gradient(135deg,#3182ce,#63b3ed);">
                    <i class="fas fa-users"></i>
                </div>
                <div class="gr-stat-body">
                    <div class="gr-stat-value" id="statTotalStudents">0</div>
                    <div class="gr-stat-label">Total Students</div>
                </div>
            </div>
            <div class="gr-stat-card" style="--accent:#38a169;">
                <div class="gr-stat-icon" style="background:linear-gradient(135deg,#38a169,#68d391);">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="gr-stat-body">
                    <div class="gr-stat-value" id="statSubjectCount">0</div>
                    <div class="gr-stat-label">My Subjects</div>
                </div>
            </div>
            <div class="gr-stat-card" style="--accent:#d69e2e;">
                <div class="gr-stat-icon" style="background:linear-gradient(135deg,#d69e2e,#f6ad55);">
                    <i class="fas fa-university"></i>
                </div>
                <div class="gr-stat-body">
                    <div class="gr-stat-value" id="statProgramCount">0</div>
                    <div class="gr-stat-label">My Programs</div>
                </div>
            </div>
            <div class="gr-stat-card" style="--accent:#7c3aed;">
                <div class="gr-stat-icon" style="background:linear-gradient(135deg,#7c3aed,#a78bfa);">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="gr-stat-body">
                    <div class="gr-stat-value" id="statSectionCount">0</div>
                    <div class="gr-stat-label">Sections</div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card att-card" id="gradesFilterCard" style="display:none;">
            <div class="card-header">
                <h3><i class="fas fa-sliders-h"></i> Select Exam &amp; Subject</h3>
            </div>
            <div class="card-body att-pad">
                <div class="att-filter-grid">
                    <div class="att-field">
                        <label>Exam</label>
                        <select id="takeExam"><option value="">Loading…</option></select>
                    </div>
                    <div class="att-field">
                        <label>Program</label>
                        <select id="takeProgram"><option value="">Select Program</option></select>
                    </div>
                    <div class="att-field">
                        <label>Subject</label>
                        <select id="takeSubject"><option value="">Select Subject</option></select>
                    </div>
                    <div class="att-field">
                        <label>Full Marks</label>
                        <input type="number" id="takeMaxMarks" value="100" readonly>
                    </div>
                </div>
                <button class="btn-att-primary" id="loadStudentsBtn">
                    <i class="fas fa-users"></i> Load Students
                </button>
            </div>
        </div>

        <!-- Gradebook Table -->
        <div class="card" id="gradebookCard" style="display:none;">
            <div class="card-header">
                <h3>
                    <i class="fas fa-table"></i> Gradebook
                    <span class="count-badge" id="gradeCount">0 students</span>
                </h3>
                <div class="gradebook-header-actions">
                    <button class="btn-publish" id="publishBtn2">
                        <i class="fas fa-paper-plane"></i> Publish
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="grades-table" id="gradesTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Roll No</th>
                            <th>Mark</th>
                            <th class="exam-col-header">GPA</th>
                            <th class="exam-col-header">Grade</th>
                        </tr>
                    </thead>
                    <tbody id="gradesTableBody"></tbody>
                </table>
            </div>
            <div class="table-footer">
                <div class="table-info" id="gradeTableInfo">Loading…</div>
                <div class="pagination" id="gradePagination"></div>
            </div>
        </div>

        <!-- Empty State -->
        <div class="grades-empty-state" id="gradesEmptyState" style="display:none;">
            <i class="fas fa-user-graduate"></i>
            <h3>No students enrolled yet</h3>
            <p>Students will appear here once they are registered in the admin portal and assigned to your programs.</p>
        </div>

    </div><!-- /content-area -->
</main>

<!-- Save Status Toast -->
<div class="toast" id="toast">
    <i class="fas fa-info-circle"></i>
    <span id="toastMsg">Saved!</span>
</div>

<!-- Publish Modal -->
<div class="modal-overlay" id="publishModal">
    <div class="modal-box modal-sm">
        <div class="modal-header">
            <h2><i class="fas fa-paper-plane"></i> Publish Results</h2>
            <button class="modal-close" id="closePublishModal"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="publish-confirm">
                <div class="publish-icon"><i class="fas fa-check-circle"></i></div>
                <p>Publish results for <strong id="publishClassName">all classes</strong>? Students will be notified.</p>
                <div class="form-actions">
                    <button class="btn-cancel" id="cancelPublish">Cancel</button>
                    <button class="btn-submit" id="confirmPublish">
                        <i class="fas fa-paper-plane"></i> Confirm &amp; Publish
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="toast" id="toast">
    <i class="fas fa-check-circle"></i>
    <span id="toastMsg">Saved!</span>
</div>

<script>window.BASE_URL = "<?= BASE_URL ?>";</script>
    <script src="<?= BASE_URL ?>/pages/portal/teacher/js/portal.js?v=2"></script>
<script src="<?= BASE_URL ?>/pages/portal/teacher/js/grades.js?v=2"></script>
</body>
</html>
