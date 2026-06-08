<?php require_once '../../../includes/session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages | PMDC Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/admin/css/styles.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/admin/css/teacher.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/admin/css/contact-messages.css?v=<?= time() ?>">
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
            <a href="<?= BASE_URL ?>/admin" class="nav-item"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
            <a href="<?= BASE_URL ?>/admin/students" class="nav-item"><i class="fas fa-users"></i><span>Students</span></a>
            <a href="<?= BASE_URL ?>/admin/staff" class="nav-item"><i class="fas fa-chalkboard-teacher"></i><span>Teachers &amp; Staff</span></a>
            <a href="<?= BASE_URL ?>/admin/gallery" class="nav-item"><i class="fas fa-images"></i><span>Gallery</span></a>
            <a href="<?= BASE_URL ?>/admin/academics" class="nav-item"><i class="fas fa-book-open"></i><span>Academics</span></a>
            <a href="<?= BASE_URL ?>/admin/results" class="nav-item"><i class="fas fa-graduation-cap"></i><span>Results</span></a>
            <div class="nav-divider"></div>
            <span class="nav-section-label">Management</span>
            <a href="<?= BASE_URL ?>/admin/calendar" class="nav-item"><i class="fas fa-calendar-alt"></i><span>Academic Calendar</span></a>
            <a href="<?= BASE_URL ?>/admin/assign-teachers" class="nav-item"><i class="fas fa-tasks"></i><span>Assign Teachers</span></a>
            <a href="#" class="nav-item"><i class="fas fa-file-invoice-dollar"></i><span>Finance</span></a>
            <a href="<?= BASE_URL ?>/admin/announcement" class="nav-item"><i class="fas fa-bell"></i><span>Announcements</span></a>
            <a href="<?= BASE_URL ?>/admin/contact-messages" class="nav-item active"><i class="fas fa-envelope"></i><span>Contact Messages</span></a>
            <a href="<?= BASE_URL ?>/admin/registration" class="nav-item"><i class="fas fa-file-alt"></i><span>HSC Registration</span></a>
            <a href="<?= BASE_URL ?>/admin/registration-degree" class="nav-item"><i class="fas fa-university"></i><span>Degree Registration</span></a>
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
                <a href="<?= BASE_URL ?>/admin">Dashboard</a>
                <i class="fas fa-chevron-right"></i>
                <span>Contact Messages</span>
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
                <a href="<?= BASE_URL ?>/admin/login" class="logout-btn" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </header>

        <div class="content-area">
            
            <!-- Page Header -->
            <div class="tm-page-header">
                <div class="tm-page-title">
                    <h1>Contact Messages</h1>
                    <p>View and manage messages sent through the public contact form.</p>
                </div>
                <div class="tm-header-actions">
                    <button class="btn-export" onclick="loadMessages()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>

            <!-- Summary Stats -->
            <div class="tm-stats-row">
                <div class="tm-stat-pill">
                    <i class="fas fa-envelope" style="background:#3b82f6;"></i>
                    <span class="ts-val" id="statTotal">0</span>
                    <span class="ts-lbl">Total Messages</span>
                </div>
                <div class="tm-stat-pill">
                    <i class="fas fa-envelope-open-text" style="background:#10b981;"></i>
                    <span class="ts-val" id="statUnread">0</span>
                    <span class="ts-lbl">Unread</span>
                </div>
            </div>

            <!-- Table View -->
            <div class="tm-card">
                <div class="tm-table-wrap">
                    <table class="tm-table" id="messagesTable">
                        <thead>
                            <tr>
                                <th style="min-width:200px;">Sender</th>
                                <th style="min-width:250px;">Subject</th>
                                <th style="min-width:150px;">Date</th>
                                <th style="min-width:100px;">Status</th>
                                <th style="text-align: center; min-width: 80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="messagesTableBody">
                            <tr class="tm-empty-row"><td colspan="5"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- ════════════════════ VIEW MESSAGE MODAL ════════════════════ -->
    <div class="tm-modal-overlay" id="viewModal">
        <div class="tm-modal">
            <div class="tm-modal-header">
                <h2><i class="fas fa-envelope-open-text"></i> Message Details</h2>
                <button class="tm-modal-close" id="closeViewModal"><i class="fas fa-times"></i></button>
            </div>
            <div class="tm-modal-body">
                <div class="msg-detail-header">
                    <h3 id="msgViewSubject">Subject here</h3>
                    <div class="msg-meta">
                        <div class="msg-meta-item">
                            <i class="fas fa-user"></i> <span id="msgViewName">Name</span>
                        </div>
                        <div class="msg-meta-item">
                            <i class="fas fa-envelope"></i> <a href="#" id="msgViewEmail">Email</a>
                        </div>
                        <div class="msg-meta-item">
                            <i class="fas fa-phone"></i> <a href="#" id="msgViewPhone">Phone</a>
                        </div>
                        <div class="msg-meta-item">
                            <i class="fas fa-calendar-alt"></i> <span id="msgViewDate">Date</span>
                        </div>
                    </div>
                </div>
                <div class="msg-body" id="msgViewBody">
                    Message content goes here...
                </div>
            </div>
            <div class="tm-modal-footer">
                <button type="button" class="btn-cancel" id="btnCloseModalBtn">Close</button>
                <button type="button" class="btn-delete-confirm" id="btnDeleteMsg" style="background: #dc2626; color: white;">
                    <i class="fas fa-trash-alt"></i> Delete Message
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="tm-toast" id="tmToast"></div>

    <script>window.BASE_URL = "<?= BASE_URL ?>";</script>
    <script src="<?= BASE_URL ?>/pages/portal/admin/js/contact-messages.js?v=<?= time() ?>"></script>
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
