<?php require_once '../../../includes/session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements | PMDC Admin</title>
    <meta name="description" content="Manage public announcements for Phulpur Mohila Degree College.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/admin/css/styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/admin/css/teacher.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/admin/css/announcements.css">
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
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
            <a href="<?= BASE_URL ?>/admin/announcement" class="nav-item active"><i class="fas fa-bell"></i><span>Announcements</span></a>
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

    <!-- Main -->
    <main class="main-content">
        <header class="top-header">
            <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
            <div class="th-breadcrumb">
                <a href="<?= BASE_URL ?>/admin">Dashboard</a>
                <i class="fas fa-chevron-right"></i>
                <span>Announcements</span>
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
                    <h1>Announcements</h1>
                    <p>Create and manage public announcements for the college website</p>
                </div>
                <div class="tm-header-actions">
                    <button class="btn-add-staff" id="btnNewAnn">
                        <i class="fas fa-plus"></i> New Announcement
                    </button>
                </div>
            </div>

            <!-- Stats -->
            <div class="tm-stats-row">
                <div class="tm-stat-pill">
                    <i class="fas fa-bullhorn" style="color:var(--blue);"></i>
                    <span class="ts-val" id="statTotal">0</span>
                    <span class="ts-lbl">Total</span>
                </div>
                <div class="tm-stat-pill">
                    <i class="fas fa-globe" style="color:var(--green);"></i>
                    <span class="ts-val" id="statPublished">0</span>
                    <span class="ts-lbl">Published</span>
                </div>
                <div class="tm-stat-pill">
                    <i class="fas fa-file-alt" style="color:var(--muted);"></i>
                    <span class="ts-val" id="statDrafts">0</span>
                    <span class="ts-lbl">Drafts</span>
                </div>
            </div>

            <!-- Table Card -->
            <div class="tm-card">

                <!-- Toolbar -->
                <div class="ann-toolbar">
                    <div class="tm-search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="annSearch" placeholder="Search by title…" autocomplete="off">
                    </div>
                    <div class="tm-filter-tabs" id="annFilterTabs">
                        <button class="tm-tab active" data-filter="all">All</button>
                        <button class="tm-tab" data-filter="published">Published</button>
                        <button class="tm-tab" data-filter="draft">Draft</button>
                    </div>
                </div>

                <!-- Table -->
                <div class="tm-table-wrap">
                    <table class="tm-table" id="annTable">
                        <thead>
                            <tr>
                                <th width="36">#</th>
                                <th>Title</th>
                                <th width="120">Date</th>
                                <th width="100">Attachment</th>
                                <th width="110">Status</th>
                                <th width="110">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="annTbody">
                            <tr>
                                <td colspan="6" style="text-align:center;padding:40px;color:#94a3b8;">
                                    <i class="fas fa-circle-notch fa-spin" style="font-size:1.4rem;"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Empty state -->
                <div class="ann-empty" id="annEmpty" style="display:none;">
                    <i class="fas fa-bullhorn"></i>
                    <p>No announcements yet</p>
                    <span>Click '+ New Announcement' to create the first one</span>
                    <button class="btn-add-staff" onclick="openModal()" style="margin-top:8px;">
                        <i class="fas fa-plus"></i> New Announcement
                    </button>
                </div>

                <!-- Pagination -->
                <div class="tm-table-footer" id="annPagination">
                    <span id="apInfo"></span>
                    <div class="tm-pagination" id="apBtns"></div>
                </div>
            </div>

        </div><!-- /content-area -->
    </main>

    <!-- Toast -->
    <div class="tm-toast" id="annToast"></div>

    <!-- ══ CREATE / EDIT MODAL ══════════════════════════════ -->
    <div class="tm-modal-overlay" id="annModalOverlay">
        <div class="tm-modal" id="annModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <div class="tm-modal-header">
                <h2 id="modalTitle"><i class="fas fa-bullhorn"></i> New Announcement</h2>
                <button class="tm-modal-close" id="modalClose" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="tm-modal-body">
                <form id="annForm" novalidate>
                    <input type="hidden" id="editId">

                    <!-- Title -->
                    <div class="tm-form-group">
                        <label for="fTitle">Title <span class="req">*</span></label>
                        <input type="text" id="fTitle" placeholder="Enter announcement title…">
                        <span class="ann-field-err" id="errTitle"></span>
                    </div>

                    <!-- Category -->
                    <div class="tm-form-group">
                        <label for="fCategory">Category <span class="req">*</span></label>
                        <select id="fCategory" style="width:100%;padding:10px;border:1px solid var(--border);border-radius:8px;font-family:'Inter',sans-serif;">
                            <option value="notice">Notice</option>
                            <option value="academic">Academic</option>
                            <option value="admission">Admission</option>
                            <option value="event">Event</option>
                        </select>
                    </div>

                    <!-- Badge -->
                    <div style="display:flex;gap:15px;">
                        <div class="tm-form-group" style="flex:1;">
                            <label for="fBadgeLabel">Badge Text <span class="ann-opt">(optional)</span></label>
                            <input type="text" id="fBadgeLabel" placeholder="e.g. Urgent">
                        </div>
                        <div class="tm-form-group" style="flex:1;">
                            <label for="fBadgeClass">Badge Style</label>
                            <select id="fBadgeClass" style="width:100%;padding:10px;border:1px solid var(--border);border-radius:8px;font-family:'Inter',sans-serif;">
                                <option value="">None / Default</option>
                                <option value="badge-urgent">Red (Urgent)</option>
                                <option value="badge-important">Orange (Important)</option>
                                <option value="badge-new">Green (New)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="tm-form-group">
                        <label for="fMessage">Message / Body <span class="req">*</span></label>
                        <textarea id="fMessage" rows="5" placeholder="Write the announcement message…"></textarea>
                        <span class="ann-field-err" id="errMessage"></span>
                    </div>

                    <!-- Date -->
                    <div class="tm-form-group">
                        <label for="fDate">Date <span class="req">*</span></label>
                        <input type="date" id="fDate">
                        <span class="ann-field-err" id="errDate"></span>
                    </div>

                    <!-- Attachment -->
                    <div class="tm-form-group">
                        <label>Attachment <span class="ann-opt">(optional — max 5 MB)</span></label>
                        <div class="ann-file-drop" id="fileDrop">
                            <i class="fas fa-paperclip"></i>
                            <span>Drag &amp; drop or <label for="fFile" class="ann-file-browse">browse</label></span>
                            <small>Accepts .jpg .png .pdf .docx</small>
                            <input type="file" id="fFile" accept=".jpg,.jpeg,.png,.pdf,.docx" hidden>
                        </div>
                        <div class="ann-file-preview" id="filePreview" style="display:none;"></div>
                        <span class="ann-field-err" id="errFile"></span>
                    </div>

                    <!-- Status -->
                    <div class="tm-form-group">
                        <label>Status</label>
                        <div class="ann-status-radios">
                            <label class="ann-radio-opt">
                                <input type="radio" name="fStatus" value="published" checked>
                                <span class="ann-radio-pill"><i class="fas fa-globe"></i> Publish immediately</span>
                            </label>
                            <label class="ann-radio-opt">
                                <input type="radio" name="fStatus" value="draft">
                                <span class="ann-radio-pill"><i class="fas fa-file-alt"></i> Save as Draft</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tm-modal-footer">
                <button class="btn-cancel" id="modalCancel">Cancel</button>
                <div style="display:flex;gap:10px;">
                    <button class="ann-btn-draft" id="btnSaveDraft">Save as Draft</button>
                    <button class="btn-save" id="btnPublish">
                        <i class="fas fa-globe"></i> Publish
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ══ DELETE CONFIRM MODAL ══════════════════════════════ -->
    <div class="tm-modal-overlay" id="deleteOverlay">
        <div class="tm-modal tm-modal-sm" role="dialog" aria-modal="true">
            <div class="tm-modal-header">
                <h2><i class="fas fa-trash-alt" style="color:var(--red);"></i> Delete Announcement</h2>
                <button class="tm-modal-close" id="deleteClose" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="tm-modal-body">
                <p style="font-size:.925rem;color:#475569;font-family:'Inter',sans-serif;line-height:1.6;">
                    Are you sure you want to delete this announcement?<br>
                    It will be removed from the public website immediately.
                </p>
                <p class="del-warn">This action cannot be undone.</p>
            </div>
            <div class="tm-modal-footer">
                <button class="btn-cancel" id="deleteCancelBtn">Cancel</button>
                <button class="btn-delete-confirm" id="deleteConfirmBtn">
                    <i class="fas fa-trash-alt"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/pages/portal/admin/js/announcements.js"></script>
    <script>
    (function() {
        const sidebar  = document.getElementById('sidebar');
        const overlay  = document.getElementById('sidebarOverlay');
        const menuBtn  = document.getElementById('menuToggle');
        const closeBtn = document.getElementById('closeSidebar');
        function open()  { sidebar.classList.add('open');    overlay.classList.add('active');    document.body.style.overflow='hidden'; }
        function close() { sidebar.classList.remove('open'); overlay.classList.remove('active'); document.body.style.overflow=''; }
        menuBtn?.addEventListener('click', open);
        closeBtn?.addEventListener('click', close);
        overlay?.addEventListener('click', close);
    })();
    </script>
</body>
</html>



