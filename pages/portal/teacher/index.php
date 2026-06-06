<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Teacher Portal | PMDC</title>
    <meta name="description" content="Teacher portal dashboard for Phulpur Mohila Degree College — manage students and results.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ═══════════════ SIDEBAR ═══════════════ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo"><i class="fas fa-school"></i><span>PMDC</span></div>
        <div class="close-sidebar" id="closeSidebar"><i class="fas fa-times"></i></div>
    </div>
    <nav class="sidebar-nav">
        <a href="index.php"    class="nav-item active"><i class="fas fa-th-large"></i><span>Dashboard</span></a>

        <a href="attendance.php" class="nav-item"><i class="fas fa-clipboard-check"></i><span>Attendance</span></a>
        <a href="grades.php"   class="nav-item"><i class="fas fa-graduation-cap"></i><span>Results</span></a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-avatar">AB</div>
        <div class="user-info">
            <div class="user-name">Ms. Afroza Begum</div>
            <div class="user-role">Science Department</div>
        </div>
    </div>
</aside>

<!-- ═══════════════ MAIN ═══════════════ -->
<main class="main-content">

    <!-- Top Header -->
    <header class="top-header">
        <div class="header-left">
            <button class="menu-toggle" id="menuToggle" aria-label="Open menu"><i class="fas fa-bars"></i></button>
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <i class="fas fa-home"></i>
                <i class="fas fa-chevron-right sep"></i>
                <strong>Dashboard</strong>
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

    <!-- Content -->
    <div class="content-area">

        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div class="welcome-content">
                <h1>Welcome back, Ms. Afroza!</h1>
                <p>Phulpur Mohila Degree College — Teacher Portal</p>
            </div>
            <div class="welcome-meta">
                <div class="meta-chip">
                    <i class="fas fa-users"></i>
                    <span id="bannerStudentCount">120 Students</span>
                </div>
                <div class="meta-chip">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="bannerActiveSession">Session 2024–2025</span>
                </div>
                <div class="meta-chip">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Science Department</span>
                </div>
            </div>
        </div>

        <!-- ── Stat Cards ── -->
        <div class="stats-grid" id="statsGrid">
            <!-- Card 1: Total Students -->
            <div class="stat-card students">
                <div class="stat-icon-wrap"><i class="fas fa-users"></i></div>
                <div>
                    <div class="stat-value" id="statTotalStudents">120</div>
                    <div class="stat-label">Total Students</div>
                    <div class="stat-trend info">
                        <i class="fas fa-layer-group"></i> Across all groups &amp; sessions
                    </div>
                </div>
            </div>
            <!-- Card 2: Results Entered -->
            <div class="stat-card results">
                <div class="stat-icon-wrap"><i class="fas fa-graduation-cap"></i></div>
                <div>
                    <div class="stat-value" id="statResultsEntered">—</div>
                    <div class="stat-label">Results Entered</div>
                    <div class="stat-trend up">
                        <i class="fas fa-hourglass-half"></i>
                        <span id="statPending">— pending</span>
                    </div>
                </div>
            </div>
            <!-- Card 3: Active Sessions -->
            <div class="stat-card sessions">
                <div class="stat-icon-wrap"><i class="fas fa-calendar-alt"></i></div>
                <div>
                    <div class="stat-value" id="statActiveSessions">4</div>
                    <div class="stat-label">Academic Sessions</div>
                    <div class="stat-trend info">
                        <i class="fas fa-clock"></i>
                        <span id="statLatestSession">Latest: 2025–2026</span>
                    </div>
                </div>
            </div>
            <!-- Card 4: HSC Year Breakdown -->
            <div class="stat-card years">
                <div class="stat-icon-wrap"><i class="fas fa-school"></i></div>
                <div>
                    <div class="stat-value" id="statYearBreakdown">—</div>
                    <div class="stat-label">HSC 1st Year</div>
                    <div class="stat-trend info">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span id="statYearBreakdown2">— in 2nd Year</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Group & Session Breakdown Row ── -->
        <div class="breakdown-row">
            <!-- Group breakdown mini cards -->
            <div class="breakdown-card">
                <div class="breakdown-title"><i class="fas fa-flask" style="color:#15803d;"></i> Science</div>
                <div class="breakdown-val" id="bdSci">—</div>
                <div class="breakdown-sub">students</div>
            </div>
            <div class="breakdown-card">
                <div class="breakdown-title"><i class="fas fa-briefcase" style="color:#92400e;"></i> Business</div>
                <div class="breakdown-val" id="bdCom">—</div>
                <div class="breakdown-sub">students</div>
            </div>
            <div class="breakdown-card">
                <div class="breakdown-title"><i class="fas fa-book" style="color:#6b21a8;"></i> Humanities</div>
                <div class="breakdown-val" id="bdHum">—</div>
                <div class="breakdown-sub">students</div>
            </div>
            <!-- Session breakdown mini cards (populated by JS) -->
            <div class="breakdown-card" id="bdSess1"><div class="breakdown-title"><i class="fas fa-calendar"></i> —</div><div class="breakdown-val">—</div><div class="breakdown-sub">students</div></div>
            <div class="breakdown-card" id="bdSess2"><div class="breakdown-title"><i class="fas fa-calendar"></i> —</div><div class="breakdown-val">—</div><div class="breakdown-sub">students</div></div>
            <div class="breakdown-card" id="bdSess3"><div class="breakdown-title"><i class="fas fa-calendar"></i> —</div><div class="breakdown-val">—</div><div class="breakdown-sub">students</div></div>
            <div class="breakdown-card" id="bdSess4"><div class="breakdown-title"><i class="fas fa-calendar"></i> —</div><div class="breakdown-val">—</div><div class="breakdown-sub">students</div></div>
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

        <!-- ── Two-column: Recent Students + Recent Results ── -->
        <div class="dash-grid">

            <!-- SECTION 1 — Recent Students -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-users"></i> Recent Students</h3>
                    
                </div>
                <div class="card-body">
                    <table class="dash-table" id="recentStudentsTable">
                        <thead>
                            <tr>
                                <th>Roll No</th>
                                <th>Name</th>
                                <th>Session</th>
                                <th>Year</th>
                                <th>Group</th>
                            </tr>
                        </thead>
                        <tbody id="recentStudentsTbody">
                            <!-- JS populated -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECTION 2 — Recent Results -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-graduation-cap"></i> Recent Results</h3>
                    <a href="grades.php" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="card-body">
                    <table class="dash-table" id="recentResultsTable">
                        <thead>
                            <tr>
                                <th>Roll No</th>
                                <th>Name</th>
                                <th>Session</th>
                                <th>Exam</th>
                                <th>GPA</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody id="recentResultsTbody">
                            <!-- JS populated -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div><!-- /content-area -->
</main>

<div class="toast" id="toast">
    <i class="fas fa-check-circle"></i>
    <span id="toastMsg">Done!</span>
</div>

<script src="js/dashboard.js"></script>
</body>
</html>
