<?php require_once '../../../includes/session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Teacher Portal | PMDC</title>
    <meta name="description" content="Teacher portal dashboard — Phulpur Mohila Degree College.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ═══ SIDEBAR ═══ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo"><i class="fas fa-school"></i><span>PMDC</span></div>
        <button class="close-sidebar" id="closeSidebar" aria-label="Close menu"><i class="fas fa-times"></i></button>
    </div>
    <nav class="sidebar-nav">
        <a href="index.php"      class="nav-item active"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
        <a href="attendance.php" class="nav-item"><i class="fas fa-clipboard-check"></i><span>Attendance</span></a>
        <a href="grades.php"     class="nav-item"><i class="fas fa-graduation-cap"></i><span>Results</span></a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-avatar" id="sidebarAvatar">T</div>
        <div class="user-info">
            <div class="user-name t-name">Loading…</div>
            <div class="user-role t-role">Teacher</div>
        </div>
    </div>
</aside>

<!-- ═══ MAIN ═══ -->
<main class="main-content">

    <!-- Top bar -->
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
            <img class="user-avatar-sm" id="headerAvatar"
                 src="https://ui-avatars.com/api/?name=Teacher&background=2563eb&color=fff"
                 alt="Teacher">
            <a href="../portal-login.php" class="logout-btn" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
                <span class="logout-text">Log Out</span>
            </a>
        </div>
    </header>

    <div class="content-area">

        <!-- ── WELCOME BANNER ── -->
        <div class="welcome-banner">
            <div class="wb-left">
                <div class="wb-greeting">Good <?php
                    $h = (int)date('G', strtotime('+6 hours'));
                    echo $h < 12 ? 'Morning' : ($h < 17 ? 'Afternoon' : 'Evening');
                ?>, <span class="t-name">Teacher</span>! 👋</div>
                <div class="wb-sub">Phulpur Mohila Degree College · Teacher Portal</div>
                <div class="wb-date" id="todayDateBanner">—</div>
            </div>
            <div class="wb-chips">
                <div class="wb-chip">
                    <i class="fas fa-users"></i>
                    <span id="bannerStudentCount">…</span>
                </div>
                <div class="wb-chip">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="currentSession">…</span>
                </div>
            </div>
        </div>

        <!-- ── STAT CARDS ── -->
        <div class="stat-grid">
            <div class="stat-card sc-blue">
                <div class="sc-icon"><i class="fas fa-users"></i></div>
                <div class="sc-body">
                    <div class="sc-val" id="statStudents">0</div>
                    <div class="sc-label">My Students</div>
                    <div class="sc-sub"><i class="fas fa-layer-group"></i> Across programs</div>
                </div>
            </div>
            <div class="stat-card sc-green">
                <div class="sc-icon"><i class="fas fa-book-open"></i></div>
                <div class="sc-body">
                    <div class="sc-val" id="statSubjects">0</div>
                    <div class="sc-label">My Subjects</div>
                    <div class="sc-sub"><i class="fas fa-check-circle"></i> Assigned to you</div>
                </div>
            </div>
            <div class="stat-card sc-purple">
                <div class="sc-icon"><i class="fas fa-university"></i></div>
                <div class="sc-body">
                    <div class="sc-val" id="statPrograms">0</div>
                    <div class="sc-label">My Programs</div>
                    <div class="sc-sub"><i class="fas fa-graduation-cap"></i> HSC / Degree</div>
                </div>
            </div>
            <div class="stat-card sc-orange">
                <div class="sc-icon"><i class="fas fa-layer-group"></i></div>
                <div class="sc-body">
                    <div class="sc-val" id="statSections">0</div>
                    <div class="sc-label">Sections</div>
                    <div class="sc-sub"><i class="fas fa-chalkboard-teacher"></i> Active sections</div>
                </div>
            </div>
        </div>

        <!-- ── MAIN CONTENT GRID ── -->
        <div class="dash-main-grid">

            <!-- Programs card -->
            <div class="card dash-card">
                <div class="card-header">
                    <h3><i class="fas fa-university" style="color:#2563eb;"></i> My Programs</h3>
                </div>
                <div class="card-body" id="programsList">
                    <div class="panel-loading"><i class="fas fa-spinner fa-spin"></i></div>
                </div>
            </div>

            <!-- Subjects card -->
            <div class="card dash-card">
                <div class="card-header">
                    <h3><i class="fas fa-book-open" style="color:#7c3aed;"></i> My Subjects</h3>
                </div>
                <div class="card-body" id="subjectsList">
                    <div class="panel-loading"><i class="fas fa-spinner fa-spin"></i></div>
                </div>
            </div>

            <!-- Distribution card -->
            <div class="card dash-card">
                <div class="card-header">
                    <h3><i class="fas fa-chart-pie" style="color:#059669;"></i> Student Distribution</h3>
                </div>
                <div class="card-body" id="groupDistChart">
                    <div class="panel-loading"><i class="fas fa-spinner fa-spin"></i></div>
                </div>
            </div>

        </div>

        <!-- ── BOTTOM TWO-COL ── -->
        <div class="dash-bottom-grid">

            <!-- Sections breakdown -->
            <div class="card dash-card">
                <div class="card-header">
                    <h3><i class="fas fa-layer-group" style="color:#d97706;"></i> Sections Breakdown</h3>
                </div>
                <div class="card-body" id="sectionsBreakdown">
                    <div class="panel-loading"><i class="fas fa-spinner fa-spin"></i></div>
                </div>
            </div>

            <!-- Students list -->
            <div class="card dash-card">
                <div class="card-header">
                    <h3><i class="fas fa-user-graduate" style="color:#db2777;"></i> Students in My Classes</h3>
                    <a href="attendance.php" class="view-all-link">Take Attendance <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="card-body" id="recentStudentsList">
                    <div class="panel-loading"><i class="fas fa-spinner fa-spin"></i></div>
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
