<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers & Staff | PMDC Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/teacher.css">
</head>
<body>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ── Sidebar (shared) ─────────────────────────────────── -->
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
            <a href="#" class="nav-item"><i class="fas fa-users"></i><span>Students</span><span class="badge">450</span></a>
            <a href="teacher.php" class="nav-item active"><i class="fas fa-chalkboard-teacher"></i><span>Teachers &amp; Staff</span></a>
            <a href="gallery.php" class="nav-item"><i class="fas fa-images"></i><span>Gallery</span></a>
            <a href="#" class="nav-item"><i class="fas fa-book"></i><span>Courses</span></a>
            <div class="nav-divider"></div>
            <span class="nav-section-label">Management</span>
            <a href="#" class="nav-item"><i class="fas fa-calendar-alt"></i><span>Academic Calendar</span></a>
            <a href="#" class="nav-item"><i class="fas fa-file-invoice-dollar"></i><span>Finance</span></a>
            <a href="#" class="nav-item"><i class="fas fa-bell"></i><span>Announcements</span><span class="badge warn">3</span></a>
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
                <span>Teachers &amp; Staff</span>
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
                    <i class="fas fa-chevron-down"></i>
                </div>
                <a href="../portal-login.php" class="logout-btn" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </header>

        <div class="content-area">

            <!-- Page Header -->
            <div class="tm-page-header">
                <div class="tm-page-title">
                    <h1>Teachers &amp; Staff</h1>
                    <p>Manage staff records displayed on the public website</p>
                </div>
                <div class="tm-header-actions">
                    <a href="../../../pages/teachers.php" target="_blank" class="btn-preview">
                        <i class="fas fa-external-link-alt"></i> Preview Public Page
                    </a>
                    <button class="btn-export" id="btnExport">
                        <i class="fas fa-file-export"></i> Export CSV
                    </button>
                    <button class="btn-add-staff" id="btnAddStaff">
                        <i class="fas fa-plus"></i> Add Staff Member
                    </button>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="tm-stats-row">
                <div class="tm-stat-pill" id="statTotal">
                    <i class="fas fa-users"></i>
                    <span class="ts-val" id="statTotalVal">—</span>
                    <span class="ts-lbl">Total Staff</span>
                </div>
                <div class="tm-stat-pill" id="statTeacher">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span class="ts-val" id="statTeacherVal">—</span>
                    <span class="ts-lbl">Teachers</span>
                </div>
                <div class="tm-stat-pill" id="statAdmin">
                    <i class="fas fa-briefcase"></i>
                    <span class="ts-val" id="statAdminVal">—</span>
                    <span class="ts-lbl">Admin Staff</span>
                </div>
                <div class="tm-stat-pill" id="statSupport">
                    <i class="fas fa-hard-hat"></i>
                    <span class="ts-val" id="statSupportVal">—</span>
                    <span class="ts-lbl">Support Staff</span>
                </div>
            </div>

            <!-- Table Controls -->
            <div class="tm-controls">
                <div class="tm-search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="tmSearch" placeholder="Search by name, designation, subject…">
                </div>
                <div class="tm-filter-tabs" id="tmFilterTabs">
                    <button class="tm-tab active" data-cat="all">All</button>
                    <button class="tm-tab" data-cat="teacher">Teachers</button>
                    <button class="tm-tab" data-cat="admin">Admin</button>
                    <button class="tm-tab" data-cat="support">Support</button>
                </div>
            </div>

            <!-- Staff Table -->
            <div class="tm-card">
                <div class="tm-table-wrap">
                    <table class="tm-table" id="staffTable">
                        <thead>
                            <tr>
                                <th style="width:36px;">#</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Category</th>
                                <th>Subject</th>
                                <th>Phone</th>
                                <th style="width:100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="staffTableBody">
                            <tr class="tm-loading-row">
                                <td colspan="7" style="text-align:center;padding:40px;color:#94a3b8;">
                                    <i class="fas fa-circle-notch fa-spin" style="font-size:1.4rem;"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tm-table-footer">
                    <span id="tmRowCount">Loading…</span>
                    <div class="tm-pagination" id="tmPagination"></div>
                </div>
            </div>

        </div><!-- /content-area -->
    </main>

    <!-- ══════════════ ADD / EDIT MODAL ══════════════ -->
    <div class="tm-modal-overlay" id="tmModalOverlay">
        <div class="tm-modal" id="tmModal">
            <div class="tm-modal-header">
                <h2 id="modalTitle"><i class="fas fa-user-plus"></i> Add Staff Member</h2>
                <button class="tm-modal-close" id="tmModalClose"><i class="fas fa-times"></i></button>
            </div>
            <div class="tm-modal-body">
                <form id="staffForm" novalidate>
                    <input type="hidden" id="fId">

                    <!-- Photo Upload -->
                    <div class="tm-photo-row">
                        <div class="tm-photo-preview" id="photoPreview">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="tm-photo-upload">
                            <label class="tm-upload-btn" for="fPhoto">
                                <i class="fas fa-camera"></i> Upload Photo
                                <input type="file" id="fPhoto" accept="image/*" hidden>
                            </label>
                            <p>JPG, PNG, WEBP — max 2MB</p>
                            <button type="button" class="tm-clear-photo" id="btnClearPhoto">Remove Photo</button>
                        </div>
                    </div>

                    <!-- Fields grid -->
                    <div class="tm-form-grid">
                        <div class="tm-form-group tm-span2">
                            <label for="fName">Full Name <span class="req">*</span></label>
                            <input type="text" id="fName" placeholder="e.g. Rowshan Ara Begum" required>
                        </div>
                        <div class="tm-form-group">
                            <label for="fDesignation">Designation <span class="req">*</span></label>
                            <input type="text" id="fDesignation" placeholder="e.g. Assistant Professor" required>
                        </div>
                        <div class="tm-form-group">
                            <label for="fCategory">Category <span class="req">*</span></label>
                            <select id="fCategory" required>
                                <option value="">Select category</option>
                                <option value="teacher">Teacher</option>
                                <option value="admin">Administrative Staff</option>
                                <option value="support">Support Staff</option>
                            </select>
                        </div>
                        <div class="tm-form-group">
                            <label for="fSubject">Subject / Department</label>
                            <input type="text" id="fSubject" placeholder="e.g. Mathematics">
                        </div>
                        <div class="tm-form-group">
                            <label for="fQualification">Qualification</label>
                            <input type="text" id="fQualification" placeholder="e.g. M.Sc., B.Ed.">
                        </div>
                        <div class="tm-form-group">
                            <label for="fPhone">Phone Number</label>
                            <input type="text" id="fPhone" placeholder="e.g. 01712-227983">
                        </div>
                        <div class="tm-form-group">
                            <label for="fEmail">Email Address</label>
                            <input type="email" id="fEmail" placeholder="e.g. name@pmdc.edu.bd">
                        </div>
                        <div class="tm-form-group tm-span2">
                            <label class="tm-checkbox-label">
                                <input type="checkbox" id="fIsPrincipal">
                                <span class="tm-checkmark"></span>
                                Mark as <strong>Principal</strong> (featured at the top of the public page)
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tm-modal-footer">
                <button type="button" class="btn-cancel" id="btnCancel">Cancel</button>
                <button type="button" class="btn-save" id="btnSave">
                    <i class="fas fa-save"></i> Save Staff Member
                </button>
            </div>
        </div>
    </div>

    <!-- ══════════════ DELETE CONFIRM ══════════════ -->
    <div class="tm-modal-overlay" id="tmDeleteOverlay">
        <div class="tm-modal tm-modal-sm">
            <div class="tm-modal-header">
                <h2><i class="fas fa-trash-alt" style="color:#dc2626;"></i> Delete Staff Member</h2>
                <button class="tm-modal-close" id="tmDeleteClose"><i class="fas fa-times"></i></button>
            </div>
            <div class="tm-modal-body">
                <p style="font-size:.925rem;color:#475569;font-family:'Inter',sans-serif;line-height:1.6;">
                    Are you sure you want to delete <strong id="deleteTargetName"></strong>?
                    This will also remove them from the public website.
                </p>
            </div>
            <div class="tm-modal-footer">
                <button class="btn-cancel" id="btnDeleteCancel">Cancel</button>
                <button class="btn-delete-confirm" id="btnDeleteConfirm">
                    <i class="fas fa-trash-alt"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div class="tm-toast" id="tmToast"></div>

    <script src="js/teacher.js"></script>
    <script>
    (function() {
        const sidebar  = document.getElementById('sidebar');
        const overlay  = document.getElementById('sidebarOverlay');
        const menuBtn  = document.getElementById('menuToggle');
        const closeBtn = document.getElementById('closeSidebar');
        function open()  { sidebar.classList.add('open'); overlay.classList.add('active'); document.body.style.overflow='hidden'; }
        function close() { sidebar.classList.remove('open'); overlay.classList.remove('active'); document.body.style.overflow=''; }
        menuBtn?.addEventListener('click', open);
        closeBtn?.addEventListener('click', close);
        overlay?.addEventListener('click', close);
    })();
    </script>
</body>
</html>
