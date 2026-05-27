<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | PMDC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <i class="fas fa-university"></i>
                <span>PMDC Admin</span>
            </div>
            <div class="close-sidebar" id="closeSidebar">
                <i class="fas fa-times"></i>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="#" class="nav-item active">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-users"></i>
                <span>Students</span>
                <span class="badge">450</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Teachers</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-book"></i>
                <span>Courses</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-calendar-alt"></i>
                <span>Academic Calendar</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Finance</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-bell"></i>
                <span>Announcements</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-chart-line"></i>
                <span>Reports</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="avatar">AS</div>
                <div class="user-info">
                    <div class="user-name">Admin Nasrin</div>
                    <div class="user-role">System Administrator</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-left">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search users, courses, records...">
                </div>
            </div>
            <div class="header-right">
                <button class="icon-btn">
                    <i class="far fa-bell"></i>
                    <span class="notification-dot"></span>
                </button>
                <button class="icon-btn">
                    <i class="far fa-envelope"></i>
                </button>
                <div class="user-menu">
                    <img src="https://ui-avatars.com/api/?name=Admin+Nasrin&background=d69e2e&color=fff" alt="User">
                    <i class="fas fa-chevron-down"></i>
                </div>
                <a href="../portal-login.php" class="logout-btn" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="content-area">
            <!-- Welcome Section -->
            <div class="welcome-banner admin-banner">
                <div class="welcome-content">
                    <h1>Welcome, Admin Nasrin! 🔐</h1>
                    <p>System Status: All services operational • শিক্ষা র্যানডম সিস্টেম PMDC HSC College Portal</p>
                </div>
                <div class="system-status">
                    <div class="status-indicator">
                        <i class="fas fa-check-circle"></i> System Operational
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #3182ce 0%, #63b3ed 100%);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">450</div>
                        <div class="stat-label">Total Students</div>
                        <div class="stat-change positive">+12 this month</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #38a169 0%, #48bb78 100%);">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">45</div>
                        <div class="stat-label">Faculty Members</div>
                        <div class="stat-change positive">+3 new</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #805ad5 0%, #b794f4 100%);">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">30</div>
                        <div class="stat-label">Total HSC Subjects</div>
                        <div class="stat-change">3 groups (XI & XII)</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #d69e2e 0%, #f6ad55 100%);">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">₹45L</div>
                        <div class="stat-label">Fees Collected</div>
                        <div class="stat-change positive">85% collection</div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="dashboard-grid">
                <!-- Left Column -->
                <div class="dashboard-left">
                    <!-- Recent Registrations -->
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-user-plus"></i> Recent Student Registrations</h3>
                            <a href="#" class="view-all">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="data-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Name</th>
                                            <th>Course</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>#2024045</td>
                                            <td>Fatema Akter</td>
                                            <td>HSC 1st Year — Science Group</td>
                                            <td>Feb 9, 2026</td>
                                            <td><span class="status-badge pending">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <td>#2024046</td>
                                            <td>Rashida Begum</td>
                                            <td>HSC 1st Year — Commerce Group</td>
                                            <td>Feb 9, 2026</td>
                                            <td><span class="status-badge approved">Approved</span></td>
                                        </tr>
                                        <tr>
                                            <td>#2024047</td>
                                            <td>Nusrat Jahan</td>
                                            <td>HSC 2nd Year — Humanities Group</td>
                                            <td>Feb 8, 2026</td>
                                            <td><span class="status-badge approved">Approved</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Overview -->
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-chart-area"></i> Financial Overview</h3>
                            <select class="filter-select">
                                <option>This Month</option>
                                <option>This Quarter</option>
                                <option>This Year</option>
                            </select>
                        </div>
                        <div class="card-body">
                            <div class="financial-grid">
                                <div class="finance-item">
                                    <h4>Total Revenue</h4>
                                    <div class="amount">₹52,50,000</div>
                                    <div class="trend up">↑ 12% from last month</div>
                                </div>
                                <div class="finance-item">
                                    <h4>Pending Fees</h4>
                                    <div class="amount">₹8,75,000</div>
                                    <div class="trend">15% pending</div>
                                </div>
                                <div class="finance-item">
                                    <h4>Expenses</h4>
                                    <div class="amount">₹18,20,000</div>
                                    <div class="trend">Operating costs</div>
                                </div>
                                <div class="finance-item">
                                    <h4>Scholarships</h4>
                                    <div class="amount">₹3,50,000</div>
                                    <div class="trend">45 students</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Logs -->
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-history"></i> Recent System Activity</h3>
                            <a href="#" class="view-all">View Logs</a>
                        </div>
                        <div class="card-body">
                            <div class="activity-list">
                                <div class="activity-item">
                                    <div class="activity-icon success">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="activity-details">
                                        <h4>Database Backup Completed</h4>
                                        <p>System • 2 hours ago</p>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon info">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div class="activity-details">
                                        <h4>New Teacher Account Created</h4>
                                        <p>Prof. Meera Joshi • 4 hours ago</p>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="activity-details">
                                        <h4>Storage Warning: 85% Full</h4>
                                        <p>System • 6 hours ago</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="dashboard-right">
                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                        </div>
                        <div class="card-body">
                            <div class="action-grid">
                                <button class="action-card">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Add Student</span>
                                </button>
                                <button class="action-card">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    <span>Add Teacher</span>
                                </button>
                                <button class="action-card">
                                    <i class="fas fa-book"></i>
                                    <span>Add Course</span>
                                </button>
                                <button class="action-card">
                                    <i class="fas fa-bell"></i>
                                    <span>Send Notice</span>
                                </button>
                                <button class="action-card">
                                    <i class="fas fa-file-export"></i>
                                    <span>Export Data</span>
                                </button>
                                <button class="action-card">
                                    <i class="fas fa-chart-bar"></i>
                                    <span>Generate Report</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Approvals -->
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-tasks"></i> Pending Approvals</h3>
                        </div>
                        <div class="card-body">
                            <div class="approval-list">
                                <div class="approval-item">
                                    <div class="approval-info">
                                        <h4>Leave Request</h4>
                                        <p>Prof. Anjali Verma</p>
                                    </div>
                                    <div class="approval-actions">
                                        <button class="btn-approve"><i class="fas fa-check"></i></button>
                                        <button class="btn-reject"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="approval-item">
                                    <div class="approval-info">
                                        <h4>Fee Waiver Request</h4>
                                        <p>Student #2024032</p>
                                    </div>
                                    <div class="approval-actions">
                                        <button class="btn-approve"><i class="fas fa-check"></i></button>
                                        <button class="btn-reject"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="approval-item">
                                    <div class="approval-info">
                                        <h4>Course Material Upload</h4>
                                        <p>Prof. Priya Gupta</p>
                                    </div>
                                    <div class="approval-actions">
                                        <button class="btn-approve"><i class="fas fa-check"></i></button>
                                        <button class="btn-reject"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Overview -->
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-chart-pie"></i> Today's Attendance</h3>
                        </div>
                        <div class="card-body">
                            <div class="attendance-chart">
                                <div class="chart-wrapper">
                                    <svg viewBox="0 0 100 100">
                                        <circle cx="50" cy="50" r="40" fill="none" stroke="#e2e8f0" stroke-width="10"></circle>
                                        <circle cx="50" cy="50" r="40" fill="none" stroke="#38a169" stroke-width="10" 
                                                stroke-dasharray="251.2" stroke-dashoffset="37.68" 
                                                transform="rotate(-90 50 50)"></circle>
                                    </svg>
                                    <div class="chart-center">
                                        <div class="percentage">85%</div>
                                        <div class="label">Present</div>
                                    </div>
                                </div>
                                <div class="attendance-stats">
                                    <div class="stat-row">
                                        <span class="dot present"></span>
                                        <span>Present: 383</span>
                                    </div>
                                    <div class="stat-row">
                                        <span class="dot absent"></span>
                                        <span>Absent: 67</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Health -->
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-server"></i> System Health</h3>
                        </div>
                        <div class="card-body">
                            <div class="health-metrics">
                                <div class="metric">
                                    <div class="metric-label">CPU Usage</div>
                                    <div class="metric-bar">
                                        <div class="metric-fill" style="width: 45%; background: #38a169;"></div>
                                    </div>
                                    <div class="metric-value">45%</div>
                                </div>
                                <div class="metric">
                                    <div class="metric-label">Memory</div>
                                    <div class="metric-bar">
                                        <div class="metric-fill" style="width: 62%; background: #d69e2e;"></div>
                                    </div>
                                    <div class="metric-value">62%</div>
                                </div>
                                <div class="metric">
                                    <div class="metric-label">Storage</div>
                                    <div class="metric-bar">
                                        <div class="metric-fill" style="width: 85%; background: #e53e3e;"></div>
                                    </div>
                                    <div class="metric-value">85%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="js/portal.js"></script>
</body>
</html>
