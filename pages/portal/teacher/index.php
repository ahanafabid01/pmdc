<?php require_once '../../../includes/session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Teacher Portal | PMDC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ═══════════════ SIDEBAR ═══════════════ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo"><i class="fas fa-school"></i><span>PMDC</span></div>
        <div class="close-sidebar" id="closeSidebar"><i class="fas fa-times"></i></div>
    </div>
    <nav class="sidebar-nav">
        <a href="index.php"      class="nav-item active"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
        <a href="attendance.php" class="nav-item"><i class="fas fa-clipboard-check"></i><span>Attendance</span></a>
        <a href="grades.php"     class="nav-item"><i class="fas fa-graduation-cap"></i><span>Results</span></a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-avatar" id="sidebarAvatar">?</div>
        <div class="user-info">
            <div class="user-name t-name">Loading...</div>
            <div class="user-role t-role">Teacher</div>
        </div>
    </div>
</aside>

<!-- ═══════════════ MAIN ═══════════════ -->
<main class="main-content">
    <header class="top-header">
        <div class="header-left">
            <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
            <nav class="page-breadcrumb">
                <i class="fas fa-home"></i>
                <i class="fas fa-chevron-right sep"></i>
                <strong>Dashboard</strong>
            </nav>
        </div>
        <div class="header-right">
            <button class="icon-btn" title="Notifications"><i class="far fa-bell"></i><span class="notification-dot"></span></button>
            <a href="../portal-login.php" class="logout-btn" title="Logout">
                <i class="fas fa-sign-out-alt"></i><span class="logout-text">Log Out</span>
            </a>
        </div>
    </header>

    <div class="content-area">

        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div class="welcome-content">
                <h1>Welcome back, <span class="t-name">Teacher</span>!</h1>
                <p>Phulpur Mohila Degree College — Teacher Portal</p>
            </div>
            <div class="welcome-meta">
                <div class="meta-chip"><i class="fas fa-users"></i><span id="bannerStudentCount">Loading...</span></div>
                <div class="meta-chip"><i class="fas fa-calendar-alt"></i><span id="currentSession">—</span></div>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="stats-grid" id="statsGrid">
            <div class="stat-card students">
                <div class="stat-icon-wrap"><i class="fas fa-users"></i></div>
                <div>
                    <div class="stat-value" id="statStudents">—</div>
                    <div class="stat-label">My Students</div>
                    <div class="stat-trend info"><i class="fas fa-layer-group"></i> Across assigned programs</div>
                </div>
            </div>
            <div class="stat-card results">
                <div class="stat-icon-wrap"><i class="fas fa-book-open"></i></div>
                <div>
                    <div class="stat-value" id="statSubjects">—</div>
                    <div class="stat-label">My Subjects</div>
                    <div class="stat-trend info"><i class="fas fa-check-circle"></i> Assigned to you</div>
                </div>
            </div>
            <div class="stat-card sessions">
                <div class="stat-icon-wrap"><i class="fas fa-university"></i></div>
                <div>
                    <div class="stat-value" id="statPrograms">—</div>
                    <div class="stat-label">My Programs</div>
                    <div class="stat-trend info"><i class="fas fa-graduation-cap"></i> HSC / Degree</div>
                </div>
            </div>
            <div class="stat-card years">
                <div class="stat-icon-wrap"><i class="fas fa-layer-group"></i></div>
                <div>
                    <div class="stat-value" id="statSections">—</div>
                    <div class="stat-label">Sections</div>
                    <div class="stat-trend info"><i class="fas fa-users"></i> Active class sections</div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grades-overview-grid">

            <!-- Programs assigned -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-university" style="color:#2563eb;"></i> My Programs</h3>
                </div>
                <div class="card-body" id="programsList">
                    <div style="color:#94a3b8;text-align:center;padding:30px;"><i class="fas fa-spinner fa-spin"></i></div>
                </div>
            </div>

            <!-- Subjects assigned -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-book-open" style="color:#8b5cf6;"></i> My Subjects</h3>
                </div>
                <div class="card-body" id="subjectsList">
                    <div style="color:#94a3b8;text-align:center;padding:30px;"><i class="fas fa-spinner fa-spin"></i></div>
                </div>
            </div>

            <!-- Group Distribution -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-chart-pie" style="color:#10b981;"></i> Student Distribution</h3>
                </div>
                <div class="card-body" id="groupDistChart">
                    <div style="color:#94a3b8;text-align:center;padding:30px;"><i class="fas fa-spinner fa-spin"></i></div>
                </div>
            </div>

        </div>

        <!-- Bottom Grid: Sections + Recent Students -->
        <div class="dash-grid">

            <!-- Sections Breakdown -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-layer-group" style="color:#f59e0b;"></i> Sections Breakdown</h3>
                </div>
                <div class="card-body" id="sectionsBreakdown">
                    <div style="color:#94a3b8;text-align:center;padding:30px;"><i class="fas fa-spinner fa-spin"></i></div>
                </div>
            </div>

            <!-- Recent Students -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-users" style="color:#ec4899;"></i> Students in My Classes</h3>
                    <a href="attendance.php" class="view-all-link">Attendance <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="card-body" id="recentStudentsList">
                    <div style="color:#94a3b8;text-align:center;padding:30px;"><i class="fas fa-spinner fa-spin"></i></div>
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
