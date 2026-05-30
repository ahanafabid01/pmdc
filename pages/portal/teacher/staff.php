<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management | Teacher Portal | PMDC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/staff.css">
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ═══ SIDEBAR ═══ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo"><i class="fas fa-school"></i><span>PMDC</span></div>
        <div class="close-sidebar" id="closeSidebar"><i class="fas fa-times"></i></div>
    </div>
    <nav class="sidebar-nav">
        <a href="index.php"         class="nav-item"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
        <a href="students.php"      class="nav-item"><i class="fas fa-users"></i><span>Students</span></a>
        <a href="announcements.php" class="nav-item"><i class="fas fa-bullhorn"></i><span>Announcements</span></a>
        <a href="staff.php"         class="nav-item active"><i class="fas fa-id-badge"></i><span>Staff</span></a>
        <a href="grades.php"        class="nav-item"><i class="fas fa-graduation-cap"></i><span>Results</span></a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-avatar">AB</div>
        <div class="user-info">
            <div class="user-name">Ms. Afroza Begum</div>
            <div class="user-role">Science Department</div>
        </div>
    </div>
</aside>

<!-- ═══ MAIN ═══ -->
<main class="main-content">
    <header class="top-header">
        <div class="header-left">
            <button class="menu-toggle" id="menuToggle" aria-label="Open menu"><i class="fas fa-bars"></i></button>
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <i class="fas fa-home"></i>
                <i class="fas fa-chevron-right sep"></i>
                <strong>Staff Management</strong>
            </nav>
        </div>
        <div class="header-right">
            <button class="icon-btn" title="Notifications"><i class="far fa-bell"></i><span class="notification-dot"></span></button>
            <button class="icon-btn" title="Messages"><i class="far fa-envelope"></i></button>
            <img class="user-avatar-sm"
                 src="https://ui-avatars.com/api/?name=Afroza+Begum&background=2563eb&color=fff"
                 alt="Afroza Begum">
            <a href="../portal-login.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span class="logout-text">Log Out</span>
            </a>
        </div>
    </header>

    <div class="content-area">

        <!-- Page Header -->
        <div class="sm-page-header">
            <div>
                <h1 class="page-title"><i class="fas fa-id-badge"></i> Staff Management</h1>
                <p class="page-subtitle">Add, edit, and manage all teaching and non-teaching staff</p>
            </div>
            <button class="btn-add-staff" id="btnAddStaff">
                <i class="fas fa-plus"></i> Add Staff Member
            </button>
        </div>

        <!-- Stats -->
        <div class="sm-stats-row">
            <div class="sm-stat-card">
                <div class="smsc-icon smsc-total"><i class="fas fa-id-badge"></i></div>
                <div><div class="smsc-val" id="stTotal">0</div><div class="smsc-lbl">Total Staff</div></div>
            </div>
            <div class="sm-stat-card">
                <div class="smsc-icon smsc-teacher"><i class="fas fa-chalkboard-teacher"></i></div>
                <div><div class="smsc-val" id="stTeachers">0</div><div class="smsc-lbl">Teachers</div></div>
            </div>
            <div class="sm-stat-card">
                <div class="smsc-icon smsc-admin"><i class="fas fa-briefcase"></i></div>
                <div><div class="smsc-val" id="stAdmin">0</div><div class="smsc-lbl">Admin</div></div>
            </div>
            <div class="sm-stat-card">
                <div class="smsc-icon smsc-support"><i class="fas fa-users"></i></div>
                <div><div class="smsc-val" id="stSupport">0</div><div class="smsc-lbl">Support</div></div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card sm-card">
            <div class="sm-toolbar">
                <div class="sm-search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" id="smSearch" placeholder="Search by name..." autocomplete="off">
                </div>
                <select class="sm-filter-select" id="smFilter">
                    <option value="all">All Categories</option>
                    <option value="teacher">Teachers</option>
                    <option value="admin">Admin</option>
                    <option value="support">Support</option>
                </select>
            </div>

            <div class="sm-table-wrap">
                <table class="sm-table" id="smTable">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Category</th>
                            <th>Subject / Dept.</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="smTbody"></tbody>
                </table>
                <div class="sm-empty" id="smEmpty" style="display:none;">
                    <i class="fas fa-id-badge"></i>
                    <p>No staff members found.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Toast -->
<div class="toast" id="toast"><i class="fas fa-check-circle"></i><span id="toastMsg">Done!</span></div>

<!-- ═══ ADD / EDIT MODAL ═══ -->
<div class="modal-overlay" id="smModalOverlay">
    <div class="modal-box sm-modal" role="dialog" aria-modal="true">
        <div class="modal-header">
            <h2 id="smModalTitle"><i class="fas fa-id-badge"></i> Add Staff Member</h2>
            <button class="modal-close" id="smModalClose"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body sm-modal-body">
            <form id="smForm" novalidate>
                <input type="hidden" id="smEditId">

                <!-- Photo Upload -->
                <div class="sm-photo-section">
                    <div class="sm-photo-preview" id="smPhotoPreview">
                        <div class="spp-initials" id="sppInitials">?</div>
                    </div>
                    <div class="sm-photo-actions">
                        <label for="smPhotoInput" class="btn-photo-upload"><i class="fas fa-camera"></i> Upload Photo</label>
                        <input type="file" id="smPhotoInput" accept=".jpg,.jpeg,.png" hidden>
                        <button type="button" class="btn-photo-remove" id="smPhotoRemove" style="display:none;">
                            <i class="fas fa-times"></i> Remove
                        </button>
                        <span class="photo-hint">JPG or PNG, max 2 MB</span>
                    </div>
                </div>

                <div class="sm-form-grid">
                    <div class="mf-group">
                        <label for="smName">Full Name <span class="req">*</span></label>
                        <input type="text" id="smName" placeholder="e.g. Ms. Afroza Begum">
                        <span class="field-err" id="errSmName"></span>
                    </div>
                    <div class="mf-group">
                        <label for="smDesig">Designation <span class="req">*</span></label>
                        <input type="text" id="smDesig" placeholder="e.g. Senior Lecturer">
                        <span class="field-err" id="errSmDesig"></span>
                    </div>
                    <div class="mf-group">
                        <label for="smCategory">Category <span class="req">*</span></label>
                        <select id="smCategory">
                            <option value="">Select category...</option>
                            <option value="teacher">Teacher</option>
                            <option value="admin">Admin</option>
                            <option value="support">Support</option>
                        </select>
                        <span class="field-err" id="errSmCat"></span>
                    </div>
                    <div class="mf-group">
                        <label for="smSubject">Subject / Department <span class="mf-opt">(optional)</span></label>
                        <input type="text" id="smSubject" placeholder="e.g. Physics, Finance Office">
                    </div>
                    <div class="mf-group">
                        <label for="smQual">Qualification <span class="mf-opt">(optional)</span></label>
                        <input type="text" id="smQual" placeholder="e.g. M.Sc. Physics">
                    </div>
                    <div class="mf-group">
                        <label for="smEmail">Email <span class="mf-opt">(optional)</span></label>
                        <input type="email" id="smEmail" placeholder="name@pmdc.edu.bd">
                    </div>
                    <div class="mf-group">
                        <label for="smPhone">Phone <span class="mf-opt">(optional)</span></label>
                        <input type="tel" id="smPhone" placeholder="+880-1700-000000">
                    </div>
                </div>

                <div class="mf-group sm-principal-row">
                    <label class="checkbox-label">
                        <input type="checkbox" id="smIsPrincipal">
                        <span class="checkbox-pill">
                            <i class="fas fa-star"></i>
                            Mark as Principal / Head of Institution
                        </span>
                    </label>
                    <span class="field-hint">Shown as a featured card on the public page</span>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" id="smModalCancel">Cancel</button>
            <button class="btn-publish" id="smSaveBtn">
                <i class="fas fa-save"></i> <span class="btn-text">Save</span>
                <span class="btn-spin" style="display:none;"><i class="fas fa-spinner fa-spin"></i> Saving...</span>
            </button>
        </div>
    </div>
</div>

<!-- ═══ DELETE CONFIRM ═══ -->
<div class="modal-overlay" id="smDeleteOverlay">
    <div class="modal-box delete-box" role="dialog" aria-modal="true">
        <div class="modal-header">
            <h2><i class="fas fa-trash-alt"></i> Remove Staff Member</h2>
            <button class="modal-close" id="smDeleteClose"><i class="fas fa-times"></i></button>
        </div>
        <div class="delete-body">
            <p>Are you sure you want to remove <strong id="deleteStaffName">this staff member</strong> from the list?<br>
            <strong style="color:#dc2626;">This action cannot be undone.</strong></p>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" id="smDeleteCancel">Cancel</button>
            <button class="btn-delete-confirm" id="smDeleteConfirm"><i class="fas fa-trash-alt"></i> Delete</button>
        </div>
    </div>
</div>

<script src="js/portal.js"></script>
<script src="js/staff.js"></script>
</body>
</html>
