<?php require_once '../../../includes/session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance | Teacher Portal | PMDC</title>
    <meta name="description" content="Take section-wise attendance, view attendance history, and generate attendance reports.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/teacher/css/styles.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/teacher/css/attendance.css?v=<?= time() ?>">
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
        <a href="<?= BASE_URL ?>/teacher/attendance" class="nav-item active"><i class="fas fa-clipboard-check"></i><span>Attendance</span></a>
        <a href="<?= BASE_URL ?>/teacher/grades"     class="nav-item"><i class="fas fa-graduation-cap"></i><span>Results</span></a>
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
                <strong>Attendance</strong>
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
        <div class="att-page-header">
            <div>
                <h1 class="att-title"><i class="fas fa-clipboard-check"></i> Attendance Management</h1>
                <p class="att-subtitle">Take period-wise attendance, review records, and generate section reports.</p>
            </div>
            <div class="att-date-chip" id="todayDateChip">—</div>
        </div>

        <!-- Context Loading Banner (shown while API loads) -->
        <div class="att-loading-banner" id="attLoadingBanner">
            <i class="fas fa-spinner fa-spin"></i>
            <span>Loading your assigned classes…</span>
        </div>

        <!-- No Programs Warning (shown if teacher has no assignments) -->
        <div class="att-no-programs" id="attNoPrograms" style="display:none;">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>No programs assigned</strong>
                <p>Contact your administrator to assign classes and programs to your account.</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="att-tabs" id="attTabBar" role="tablist" style="display:none;">
            <button class="att-tab active" data-tab="take"    role="tab" aria-selected="true"><i class="fas fa-pen"></i> Take Attendance</button>
            <button class="att-tab"        data-tab="history" role="tab" aria-selected="false"><i class="fas fa-history"></i> History</button>
            <button class="att-tab"        data-tab="report"  role="tab" aria-selected="false"><i class="fas fa-chart-bar"></i> Report</button>
        </div>

        <!-- ──────────────── TAKE ATTENDANCE ──────────────── -->
        <section class="att-tab-panel active" id="tab-take" role="tabpanel">
            <div class="card att-card">
                <div class="card-header">
                    <h3><i class="fas fa-sliders-h"></i> Select Class &amp; Period</h3>
                    <div class="att-context-pill" id="teacherContextPill"></div>
                </div>
                <div class="card-body att-pad">
                    <div class="att-filter-grid">
                        <div class="att-field">
                            <label for="takeProgram">Program</label>
                            <!-- Populated by JS -->
                            <select id="takeProgram"><option value="">Loading…</option></select>
                        </div>
                        <div class="att-field">
                            <label for="takeYear">Year</label>
                            <select id="takeYear"><option value="">Select Year</option></select>
                        </div>
                        <div class="att-field">
                            <label for="takeSection">Section</label>
                            <select id="takeSection"><option value="">Select Section</option></select>
                        </div>

                        <div class="att-field att-field-date">
                            <label>Date</label>
                            <input type="text" id="takeDateView" readonly placeholder="Today">
                        </div>
                    </div>
                    <button class="btn-att-primary" id="loadStudentsBtn">
                        <i class="fas fa-users"></i> Load Students
                    </button>
                    <div class="att-alert" id="takeAlert" style="display:none;"></div>
                    <div class="att-alert att-alert-success" id="takeSuccess" style="display:none;"></div>
                </div>
            </div>

            <!-- Student Attendance Table -->
            <div class="card att-card" id="takeListCard" style="display:none;">
                <div class="card-header att-list-header">
                    <div class="att-list-meta" id="takeListMeta"></div>
                    <div class="att-list-actions">
                        <button class="btn-mark-all btn-mark-present" id="markAllPresentBtn">
                            <i class="fas fa-check"></i> All Present
                        </button>
                        <button class="btn-mark-all btn-mark-absent" id="markAllAbsentBtn">
                            <i class="fas fa-times"></i> All Absent
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Quick summary bar -->
                    <div class="att-summary-bar" id="takeSummaryBar">Present: 0 | Absent: 0 | Total: 0</div>
                    <div class="table-responsive">
                        <table class="att-table" id="takeStudentsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Roll</th>
                                    <th>Student Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="takeStudentsTbody"></tbody>
                        </table>
                    </div>
                    <div class="att-empty" id="takeEmpty" style="display:none;">
                        <i class="fas fa-user-slash"></i>
                        <p>No students found for this class and section.</p>
                        <span>Try a different program or section.</span>
                    </div>
                    <button class="btn-att-submit" id="submitAttendanceBtn">
                        <i class="fas fa-save"></i> Submit Attendance
                    </button>
                </div>
            </div>
        </section>

        <!-- ──────────────── HISTORY ──────────────── -->
        <section class="att-tab-panel" id="tab-history" role="tabpanel">
            <div class="card att-card">
                <div class="card-header">
                    <h3><i class="fas fa-history"></i> Search Attendance History</h3>
                </div>
                <div class="card-body att-pad">
                    <div class="att-filter-grid history-grid">
                        <div class="att-field">
                            <label for="historyProgram">Program</label>
                            <select id="historyProgram"><option value="">All Programs</option></select>
                        </div>
                        <div class="att-field">
                            <label for="historyYear">Year</label>
                            <select id="historyYear"><option value="">All Years</option></select>
                        </div>
                        <div class="att-field">
                            <label for="historySection">Section</label>
                            <select id="historySection"><option value="">All Sections</option></select>
                        </div>
                        <div class="att-field">
                            <label for="historyDate">Date</label>
                            <input type="date" id="historyDate">
                        </div>
                    </div>
                    <button class="btn-att-primary" id="historySearchBtn"><i class="fas fa-search"></i> Search</button>
                </div>
            </div>
            <div id="historyResultsWrap"></div>
        </section>

        <!-- ──────────────── REPORT ──────────────── -->
        <section class="att-tab-panel" id="tab-report" role="tabpanel">
            <div class="card att-card">
                <div class="card-header">
                    <h3><i class="fas fa-chart-line"></i> Generate Attendance Report</h3>
                </div>
                <div class="card-body att-pad">
                    <div class="att-filter-grid report-grid">
                        <div class="att-field">
                            <label for="reportProgram">Program</label>
                            <select id="reportProgram"><option value="">Select Program</option></select>
                        </div>
                        <div class="att-field">
                            <label for="reportYear">Year</label>
                            <select id="reportYear"><option value="">Select Year</option></select>
                        </div>
                        <div class="att-field">
                            <label for="reportSection">Section</label>
                            <select id="reportSection"><option value="">Select Section</option></select>
                        </div>
                        <div class="att-field">
                            <label for="reportFromDate">From Date</label>
                            <input type="date" id="reportFromDate">
                        </div>
                        <div class="att-field">
                            <label for="reportToDate">To Date</label>
                            <input type="date" id="reportToDate">
                        </div>
                    </div>
                    <button class="btn-att-primary" id="generateReportBtn"><i class="fas fa-file-alt"></i> Generate Report</button>
                </div>
            </div>

            <div class="card att-card" id="reportCard" style="display:none;">
                <div class="card-header report-header">
                    <h3><i class="fas fa-table"></i> Student-wise Attendance Report</h3>
                    <div class="report-actions">
                        <button class="btn-report-action" id="printReportBtn"><i class="fas fa-print"></i> Print</button>
                        <button class="btn-report-action btn-report-pdf" id="exportPdfBtn"><i class="fas fa-file-pdf"></i> Export PDF</button>
                    </div>
                </div>
                <div class="card-body att-pad">
                    <div class="att-summary-cards">
                        <div class="att-sum-card">
                            <div class="att-sum-label">Total Classes Held</div>
                            <div class="att-sum-value" id="sumTotalClasses">0</div>
                        </div>
                        <div class="att-sum-card">
                            <div class="att-sum-label">Average Attendance %</div>
                            <div class="att-sum-value" id="sumAvgAttendance">0%</div>
                        </div>
                        <div class="att-sum-card">
                            <div class="att-sum-label">Most Absent Student</div>
                            <div class="att-sum-value small" id="sumMostAbsent">None</div>
                        </div>
                        <div class="att-sum-card">
                            <div class="att-sum-label">Perfect Attendance</div>
                            <div class="att-sum-value" id="sumPerfectCount">0</div>
                        </div>
                    </div>
                    <div class="report-search-row">
                        <div class="att-search">
                            <i class="fas fa-search"></i>
                            <input type="text" id="reportSearchInput" placeholder="Search by roll or student name…">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="att-table report-table" id="reportTable">
                            <thead>
                                <tr>
                                    <th>Roll</th>
                                    <th>Student Name</th>
                                    <th>Total Classes</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>Attendance %</th>
                                </tr>
                            </thead>
                            <tbody id="reportTbody"></tbody>
                        </table>
                    </div>
                    <div class="att-empty" id="reportEmpty" style="display:none;">
                        <i class="fas fa-inbox"></i>
                        <p>No attendance data found for the selected filters.</p>
                        <span>Try a different date range or section.</span>
                    </div>
                </div>
            </div>
        </section>

    </div><!-- /content-area -->
</main>

<!-- Confirm Modal -->
<div class="modal-overlay" id="submitConfirmModal">
    <div class="modal-box modal-sm">
        <div class="modal-header">
            <h2><i class="fas fa-check-circle"></i> Confirm Submission</h2>
            <button class="modal-close" id="confirmCloseBtn"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <p id="confirmText"></p>
            <div class="form-actions">
                <button class="btn-cancel" id="confirmCancelBtn">Cancel</button>
                <button class="btn-submit" id="confirmSubmitBtn">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="toast" id="toast">
    <i class="fas fa-check-circle"></i>
    <span id="toastMsg">Saved</span>
</div>

<script>window.BASE_URL = "<?= BASE_URL ?>";</script>
    <script src="<?= BASE_URL ?>/pages/portal/teacher/js/attendance.js?v=2"></script>
</body>
</html>
