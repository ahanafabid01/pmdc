<?php require_once '../../../includes/session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Teachers | PMDC Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/assign_teachers.css">
</head>
<body>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ── Sidebar ──────────────────────────────────────────── -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <div class="logo-icon"><i class="fas fa-university"></i></div>
                <div class="logo-text">
                    <span class="logo-name">PMDC</span>
                    <span class="logo-role">Admin Portal</span>
                </div>
            </div>
            <button class="close-sidebar" id="closeSidebar"><i class="fas fa-times"></i></button>
        </div>
        <nav class="sidebar-nav">
            <span class="nav-section-label">Main</span>
            <a href="index.php" class="nav-item"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
            <a href="students.php" class="nav-item"><i class="fas fa-users"></i><span>Students</span></a>
            <a href="teacher.php" class="nav-item"><i class="fas fa-chalkboard-teacher"></i><span>Teachers &amp; Staff</span></a>
            <a href="gallery.php" class="nav-item"><i class="fas fa-images"></i><span>Gallery</span></a>
            <a href="academics.php" class="nav-item"><i class="fas fa-book-open"></i><span>Academics</span></a>
            <div class="nav-divider"></div>
            <span class="nav-section-label">Management</span>
            <a href="academic-calendar.php" class="nav-item"><i class="fas fa-calendar-alt"></i><span>Academic Calendar</span></a>
            <a href="assign_teachers.php" class="nav-item active"><i class="fas fa-tasks"></i><span>Assign Teachers</span></a>
            <a href="#" class="nav-item"><i class="fas fa-file-invoice-dollar"></i><span>Finance</span></a>
            <a href="announcements.php" class="nav-item"><i class="fas fa-bell"></i><span>Announcements</span></a>
            <a href="registration-hsc.php" class="nav-item"><i class="fas fa-file-alt"></i><span>HSC Registration</span></a>
            <a href="registration-degree.php" class="nav-item"><i class="fas fa-university"></i><span>Degree Registration</span></a>
            <a href="#" class="nav-item"><i class="fas fa-chart-line"></i><span>Reports</span></a>
            <div class="nav-divider"></div>
            <span class="nav-section-label">System</span>
            <a href="#" class="nav-item"><i class="fas fa-cog"></i><span>Settings</span></a>
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

    <!-- ── Main ─────────────────────────────────────────────── -->
    <main class="main-content">
        <header class="top-header">
            <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
            <div class="th-breadcrumb">
                <a href="index.php">Dashboard</a>
                <i class="fas fa-chevron-right"></i>
                <span>Assign Teachers</span>
            </div>
            <div class="header-right">
                <button class="icon-btn" title="Notifications">
                    <i class="far fa-bell"></i>
                    <span class="notification-dot"></span>
                </button>
                <div class="header-divider"></div>
                <div class="user-menu">
                    <img src="https://ui-avatars.com/api/?name=Admin+Nasrin&background=1a3a5c&color=fff&bold=true" alt="Admin">
                    <span class="um-name">Admin Nasrin</span>
                </div>
                <a href="../portal-login.php" class="logout-btn" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </header>

        <div class="content-area">
            <div class="tm-page-header">
                <div class="tm-page-title">
                    <h1>Assign Teachers</h1>
                    <p>Assign teachers to specific classes and subjects for Portal Access.</p>
                </div>
            </div>

            <div class="assign-container">
                <!-- Left: Form -->
                <div class="assign-form-panel">
                    <h3 class="panel-title"><i class="fas fa-plus-circle"></i> New Assignment</h3>
                    
                    <div class="form-group">
                        <label>Select Teacher</label>
                        <select id="assignStaffId" class="form-control">
                            <option value="">Loading teachers...</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Select Class/Program</label>
                        <select id="assignClassId" class="form-control">
                            <option value="">Loading classes...</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Select Subject</label>
                        <select id="assignSubjectId" class="form-control">
                            <option value="">Loading subjects...</option>
                        </select>
                    </div>

                    <button class="btn-primary" id="btnAddAssignment" style="width: 100%; margin-top: 1rem;">
                        <i class="fas fa-save"></i> Save Assignment
                    </button>
                    
                    <div id="assignLoginInfo" class="login-info-box" style="display:none; margin-top: 1.5rem;">
                        <!-- Generated login info will appear here -->
                    </div>
                </div>

                <!-- Right: Assignments List -->
                <div class="assign-list-panel">
                    <div class="list-header">
                        <h3 class="panel-title"><i class="fas fa-list"></i> Current Assignments</h3>
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchAssignments" placeholder="Search...">
                        </div>
                    </div>
                    
                    <div class="table-wrap">
                        <table class="assign-table">
                            <thead>
                                <tr>
                                    <th>Teacher</th>
                                    <th>Class / Program</th>
                                    <th>Subject</th>
                                    <th style="width: 60px; text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="assignTableBody">
                                <tr><td colspan="4" class="text-center">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Toast Notification -->
    <div class="tm-toast" id="tmToast"></div>

    <script src="js/assign_teachers.js"></script>
</body>
</html>
