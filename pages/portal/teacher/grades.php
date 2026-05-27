<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HSC Results | Teacher Portal | PMDC</title>
    <meta name="description" content="Bangladesh HSC Result Management — enter and view per-exam, per-subject marks and GPA for your students.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/grades.css">
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ════════════════════════ SIDEBAR ════════════════════════ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo"><i class="fas fa-school"></i><span>PMDC</span></div>
        <div class="close-sidebar" id="closeSidebar"><i class="fas fa-times"></i></div>
    </div>
    <nav class="sidebar-nav">
        <a href="index.php"    class="nav-item"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
        <a href="students.php" class="nav-item"><i class="fas fa-users"></i><span>Students</span></a>
        <a href="announcements.php" class="nav-item"><i class="fas fa-bullhorn"></i><span>Announcements</span></a>
        <a href="attendance.php" class="nav-item"><i class="fas fa-clipboard-check"></i><span>Attendance</span></a>
        <a href="grades.php"   class="nav-item active"><i class="fas fa-graduation-cap"></i><span>Results</span></a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-avatar">AB</div>
        <div class="user-info">
            <div class="user-name">Ms. Afroza Begum</div>
            <div class="user-role">Science Department</div>
        </div>
    </div>
</aside>

<!-- ════════════════════════ MAIN ════════════════════════ -->
<main class="main-content">

    <!-- Top Header -->
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
            <img class="user-avatar-sm"
                 src="https://ui-avatars.com/api/?name=Afroza+Begum&background=2563eb&color=fff"
                 alt="Afroza Begum">
            <a href="../portal-login.php" class="logout-btn" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
                <span class="logout-text">Log Out</span>
            </a>
        </div>
    </header>

    <!-- Content Area -->
    <div class="content-area">

        <!-- ── Page Title ── -->
        <div class="page-header">
            <div class="page-header-left">
                <h1 class="page-title"><i class="fas fa-graduation-cap"></i> HSC Result Management</h1>
                <p class="page-subtitle">
                    Each exam is <strong>independent</strong>.
                    &nbsp;·&nbsp; HSC 1st Year: <em>Half-Yearly</em> &amp; <em>Year-Change</em>
                    &nbsp;·&nbsp; HSC 2nd Year: <em>Pre-Test</em> &amp; <em>Test Exam</em>
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

        <!-- ── Grade Stats ── -->
        <div class="grades-stats-grid">
            <div class="gr-stat-card" style="--accent:#3182ce;">
                <div class="gr-stat-icon" style="background:linear-gradient(135deg,#3182ce,#63b3ed);">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="gr-stat-body">
                    <div class="gr-stat-value">4.21</div>
                    <div class="gr-stat-label">Average GPA</div>
                </div>
                <div class="gr-sparkline" id="spark1"></div>
            </div>
            <div class="gr-stat-card" style="--accent:#38a169;">
                <div class="gr-stat-icon" style="background:linear-gradient(135deg,#38a169,#68d391);">
                    <i class="fas fa-award"></i>
                </div>
                <div class="gr-stat-body">
                    <div class="gr-stat-value">38</div>
                    <div class="gr-stat-label">A+ Results</div>
                </div>
                <div class="gr-sparkline" id="spark2"></div>
            </div>
            <div class="gr-stat-card" style="--accent:#d69e2e;">
                <div class="gr-stat-icon" style="background:linear-gradient(135deg,#d69e2e,#f6ad55);">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="gr-stat-body">
                    <div class="gr-stat-value" id="pendingCount">—</div>
                    <div class="gr-stat-label">Marks Pending</div>
                </div>
                <div class="gr-sparkline" id="spark3"></div>
            </div>
            <div class="gr-stat-card" style="--accent:#e53e3e;">
                <div class="gr-stat-icon" style="background:linear-gradient(135deg,#e53e3e,#fc8181);">
                    <i class="fas fa-user-times"></i>
                </div>
                <div class="gr-stat-body">
                    <div class="gr-stat-value">8</div>
                    <div class="gr-stat-label">F Grade (Fail)</div>
                </div>
                <div class="gr-sparkline" id="spark4"></div>
            </div>
        </div>

        <!-- ── Tabs + Filters ── -->
        <div class="card grades-filter-card">
            <!-- Class Tabs -->
            <div class="grades-tabs" id="gradesTabs">
                <button class="grade-tab active" data-class="all">All Groups</button>
                <button class="grade-tab" data-class="sci_xi">Science — 1st Year</button>
                <button class="grade-tab" data-class="sci_xii">Science — 2nd Year</button>
                <button class="grade-tab" data-class="com_xi">Business — 1st Year</button>
                <button class="grade-tab" data-class="com_xii">Business — 2nd Year</button>
                <button class="grade-tab" data-class="hum_xi">Humanities — 1st Year</button>
                <button class="grade-tab" data-class="hum_xii">Humanities — 2nd Year</button>
            </div>

            <!-- Filter Row -->
            <div class="grades-filter-row">
                <div class="filter-search">
                    <i class="fas fa-search"></i>
                    <input type="text" id="gradeSearch" placeholder="Search by name or roll no...">
                </div>
                <div class="filter-group">
                    <label>Session (শিক্ষাবর্ষ)</label>
                    <select id="sessionFilter" class="filter-select">
                        <option value="">All Sessions</option>
                        <option value="2022–2023">2022–2023</option>
                        <option value="2023–2024">2023–2024</option>
                        <option value="2024–2025">2024–2025</option>
                        <option value="2025–2026">2025–2026</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Exam (পরীক্ষা)</label>
                    <select id="examFilter" class="filter-select">
                        <!--
                            Options are injected by teacher-grades.js.
                            They change based on which class tab is active:
                            1st Year → Half-Yearly Exam, Year-Change Exam
                            2nd Year → Pre-Test Exam, Test Exam
                        -->
                        <option value="">All Exams</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>GPA Grade</label>
                    <select id="gradeFilter" class="filter-select">
                        <option value="">All Grades</option>
                        <option value="A+">A+  (GPA 5.00)</option>
                        <option value="A">A   (GPA 4.00)</option>
                        <option value="A-">A-  (GPA 3.50)</option>
                        <option value="B">B   (GPA 3.00)</option>
                        <option value="C">C   (GPA 2.00)</option>
                        <option value="D">D   (GPA 1.00)</option>
                        <option value="F">F   (ফেল — 0.00)</option>
                    </select>
                </div>
            </div>

        </div>

        <!-- ── Overview Cards (Chart + Top Performers + Attention) ── -->
        <div class="grades-overview-grid">
            <div class="card grades-chart-card">
                <div class="card-header">
                    <h3><i class="fas fa-chart-bar"></i> GPA Distribution</h3>
                    <div class="chart-class-label" id="chartClassLabel">All Groups</div>
                </div>
                <div class="card-body">
                    <div class="grade-bar-chart" id="gradeBarChart"></div>
                    <div class="grade-dist-legend">
                        <span class="legend-item"><span class="legend-dot" style="background:#276749;"></span>A+</span>
                        <span class="legend-item"><span class="legend-dot" style="background:#38a169;"></span>A</span>
                        <span class="legend-item"><span class="legend-dot" style="background:#3182ce;"></span>A-</span>
                        <span class="legend-item"><span class="legend-dot" style="background:#d69e2e;"></span>B</span>
                        <span class="legend-item"><span class="legend-dot" style="background:#dd6b20;"></span>C/D</span>
                        <span class="legend-item"><span class="legend-dot" style="background:#e53e3e;"></span>F</span>
                    </div>
                </div>
            </div>

            <div class="card top-performers-card">
                <div class="card-header">
                    <h3><i class="fas fa-trophy"></i> Top Performers</h3>
                </div>
                <div class="card-body">
                    <div id="topPerformersList"></div>
                </div>
            </div>

            <div class="card needs-attention-card">
                <div class="card-header">
                    <h3><i class="fas fa-exclamation-circle"></i> Needs Attention</h3>
                </div>
                <div class="card-body">
                    <div id="attentionList"></div>
                </div>
            </div>
        </div>

        <!-- ── Gradebook Table ── -->
        <div class="card" id="gradebookCard">
            <div class="card-header">
                <h3>
                    <i class="fas fa-table"></i> Gradebook
                    <span class="count-badge" id="gradeCount">120 students</span>
                </h3>
                <div class="gradebook-header-actions">
                    <button class="btn-publish" id="publishBtn2" onclick="document.getElementById('publishBtn').click()">
                        <i class="fas fa-paper-plane"></i> Publish
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="grades-table" id="gradesTable">
                    <thead>
                        <tr>
                            <!-- rebuilt by grades.js buildTableHeader() on each tab/filter change -->
                            <th>Student</th>
                            <th>Roll No</th>
                            <th>Session</th>
                            <th>Group / Class</th>
                            <th class="exam-col-header">GPA</th>
                            <th class="exam-col-header">Grade</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody id="gradesTableBody">
                        <!-- Populated by teacher-grades.js -->
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <div class="table-info" id="gradeTableInfo">Loading…</div>
                <div class="pagination" id="gradePagination"></div>
            </div>
        </div>

    </div><!-- /content-area -->
</main>

<!-- ════════════════════════ GENERIC MODAL ════════════════════════ -->
<div class="modal-overlay" id="gradeModal">
    <div class="modal-box modal-wide">
        <div class="modal-header">
            <h2 id="modalTitle"><i class="fas fa-graduation-cap"></i> Results</h2>
            <button class="modal-close" id="closeGradeModal"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body" id="modalContent">
            <!-- Dynamically populated by JS -->
        </div>
    </div>
</div>

<!-- ════════════════════════ PUBLISH MODAL ════════════════════════ -->
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

<!-- ════════════════════════ TOAST ════════════════════════ -->
<div class="toast" id="toast">
    <i class="fas fa-check-circle"></i>
    <span id="toastMsg">Saved!</span>
</div>

<script src="js/portal.js"></script>
<script src="js/grades.js"></script>
</body>
</html>
