<?php require_once '../../../includes/session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance | Teacher Portal | PMDC</title>
    <meta name="description" content="Take section-wise attendance, view attendance history, and generate attendance reports.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/attendance.css">
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo"><i class="fas fa-school"></i><span>PMDC</span></div>
        <div class="close-sidebar" id="closeSidebar"><i class="fas fa-times"></i></div>
    </div>
    <nav class="sidebar-nav">
        <a href="index.php" class="nav-item"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
        <a href="attendance.php" class="nav-item active"><i class="fas fa-clipboard-check"></i><span>Attendance</span></a>
        <a href="grades.php" class="nav-item"><i class="fas fa-graduation-cap"></i><span>Results</span></a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-avatar">AB</div>
        <div class="user-info">
            <div class="user-name">Ms. Afroza Begum</div>
            <div class="user-role">Science Department</div>
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
            <img class="user-avatar-sm"
                 src="https://ui-avatars.com/api/?name=Afroza+Begum&background=2563eb&color=fff"
                 alt="Afroza Begum">
            <a href="../portal-login.php" class="logout-btn" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
                <span class="logout-text">Log Out</span>
            </a>
        </div>
    </header>

    <div class="content-area">
        <div class="att-page-header">
            <div>
                <h1 class="att-title"><i class="fas fa-clipboard-check"></i> Attendance Management</h1>
                <p class="att-subtitle">Take period-wise attendance, review records, and generate section reports.</p>
            </div>
            <div class="att-date-chip" id="todayDateChip">Today</div>
        </div>

        <div class="att-tabs" role="tablist" aria-label="Attendance Tabs">
            <button class="att-tab active" data-tab="take" role="tab" aria-selected="true">Take Attendance</button>
            <button class="att-tab" data-tab="history" role="tab" aria-selected="false">Attendance History</button>
            <button class="att-tab" data-tab="report" role="tab" aria-selected="false">Attendance Report</button>
        </div>

        <section class="att-tab-panel active" id="tab-take" role="tabpanel">
            <div class="card att-card">
                <div class="card-header">
                    <h3><i class="fas fa-sliders-h"></i> Select Class &amp; Period</h3>
                </div>
                <div class="card-body att-pad">
                    <div class="att-filter-grid">
                        <div class="att-field">
                            <label for="takeYear">Year</label>
                            <select id="takeYear">
                                <option value="">Select Year</option>
                                <option value="xi">HSC 1st Year</option>
                                <option value="xii">HSC 2nd Year</option>
                            </select>
                        </div>
                        <div class="att-field">
                            <label for="takeGroup">Group</label>
                            <select id="takeGroup">
                                <option value="">Select Group</option>
                                <option value="science">Science</option>
                                <option value="commerce">Business</option>
                                <option value="humanities">Humanities</option>
                            </select>
                        </div>
                        <div class="att-field">
                            <label for="takeSection">Section</label>
                            <select id="takeSection">
                                <option value="">Select Section</option>
                            </select>
                        </div>
                        <div class="att-field">
                            <label for="takePeriod">Period / Class</label>
                            <select id="takePeriod">
                                <option value="">Select Period</option>
                                <option value="1">Period 1</option>
                                <option value="2">Period 2</option>
                                <option value="3">Period 3</option>
                                <option value="4">Period 4</option>
                                <option value="5">Period 5</option>
                                <option value="6">Period 6</option>
                                <option value="7">Period 7</option>
                                <option value="8">Period 8</option>
                            </select>
                        </div>
                        <div class="att-field att-field-date">
                            <label>Date</label>
                            <input type="text" id="takeDateView" readonly>
                        </div>
                    </div>
                    <button class="btn-att-primary" id="loadStudentsBtn">
                        <i class="fas fa-users"></i> Load Students
                    </button>
                    <div class="att-alert" id="takeAlert" style="display:none;"></div>
                    <div class="att-alert att-alert-success" id="takeSuccess" style="display:none;"></div>
                </div>
            </div>

            <div class="card att-card" id="takeListCard" style="display:none;">
                <div class="card-header att-list-header">
                    <div class="att-list-meta" id="takeListMeta"></div>
                    <div class="att-list-actions">
                        <button class="btn-mark-all btn-mark-present" id="markAllPresentBtn">
                            <i class="fas fa-check"></i> Mark All Present
                        </button>
                        <button class="btn-mark-all btn-mark-absent" id="markAllAbsentBtn">
                            <i class="fas fa-times"></i> Mark All Absent
                        </button>
                    </div>
                </div>
                <div class="card-body">
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
                    </div>
                    <div class="att-summary-bar" id="takeSummaryBar">Present: 0 | Absent: 0 | Total: 0</div>
                    <button class="btn-att-submit" id="submitAttendanceBtn">
                        <i class="fas fa-save"></i> Submit Attendance
                    </button>
                </div>
            </div>
        </section>

        <section class="att-tab-panel" id="tab-history" role="tabpanel">
            <div class="card att-card">
                <div class="card-header">
                    <h3><i class="fas fa-history"></i> Search Attendance History</h3>
                </div>
                <div class="card-body att-pad">
                    <div class="att-filter-grid history-grid">
                        <div class="att-field">
                            <label for="historyYear">Year</label>
                            <select id="historyYear">
                                <option value="xi">HSC 1st Year</option>
                                <option value="xii">HSC 2nd Year</option>
                            </select>
                        </div>
                        <div class="att-field">
                            <label for="historyGroup">Group</label>
                            <select id="historyGroup">
                                <option value="science">Science</option>
                                <option value="commerce">Business</option>
                                <option value="humanities">Humanities</option>
                            </select>
                        </div>
                        <div class="att-field">
                            <label for="historySection">Section</label>
                            <select id="historySection"></select>
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

        <section class="att-tab-panel" id="tab-report" role="tabpanel">
            <div class="card att-card">
                <div class="card-header">
                    <h3><i class="fas fa-chart-line"></i> Generate Attendance Report</h3>
                </div>
                <div class="card-body att-pad">
                    <div class="att-filter-grid report-grid">
                        <div class="att-field">
                            <label for="reportYear">Year</label>
                            <select id="reportYear">
                                <option value="xi">HSC 1st Year</option>
                                <option value="xii">HSC 2nd Year</option>
                            </select>
                        </div>
                        <div class="att-field">
                            <label for="reportGroup">Group</label>
                            <select id="reportGroup">
                                <option value="science">Science</option>
                                <option value="commerce">Business</option>
                                <option value="humanities">Humanities</option>
                            </select>
                        </div>
                        <div class="att-field">
                            <label for="reportSection">Section</label>
                            <select id="reportSection"></select>
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
                        <button class="btn-report-action" id="printReportBtn"><i class="fas fa-print"></i> Print View</button>
                        <button class="btn-report-action btn-report-pdf" id="exportPdfBtn"><i class="fas fa-file-pdf"></i> Export PDF</button>
                    </div>
                </div>
                <div class="card-body att-pad">
                    <div class="print-head" id="reportPrintHeader"></div>
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
                            <div class="att-sum-label">Perfect Attendance Count</div>
                            <div class="att-sum-value" id="sumPerfectCount">0</div>
                        </div>
                    </div>
                    <div class="report-search-row">
                        <div class="att-search">
                            <i class="fas fa-search"></i>
                            <input type="text" id="reportSearchInput" placeholder="Search by roll or student name...">
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
    </div>
</main>

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

<script src="js/attendance.js"></script>
</body>
</html>

