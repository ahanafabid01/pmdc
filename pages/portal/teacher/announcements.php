<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements | Teacher Portal | PMDC</title>
    <meta name="description" content="Manage public announcements for Phulpur Mohila Degree College.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/announcements.css">
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
        <a href="index.php"         class="nav-item"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
        <a href="attendance.php" class="nav-item"><i class="fas fa-clipboard-check"></i><span>Attendance</span></a>
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

<!-- ═══════════════ MAIN ═══════════════ -->
<main class="main-content">

    <!-- Top Header -->
    <header class="top-header">
        <div class="header-left">
            <button class="menu-toggle" id="menuToggle" aria-label="Open menu"><i class="fas fa-bars"></i></button>
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <i class="fas fa-home"></i>
                <i class="fas fa-chevron-right sep"></i>
                <strong>Announcements</strong>
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

        <!-- ── Page Header ── -->
        <div class="ann-page-header">
            <div class="aph-left">
                <h1 class="page-title"><i class="fas fa-bullhorn"></i> Announcements</h1>
                <p class="page-subtitle">Create and manage public announcements</p>
            </div>
            <button class="btn-new-ann" id="btnNewAnn">
                <i class="fas fa-plus"></i> New Announcement
            </button>
        </div>

        <!-- ── Stat Cards ── -->
        <div class="ann-stats-row">
            <div class="ann-stat-card">
                <div class="asc-icon asc-total"><i class="fas fa-bullhorn"></i></div>
                <div class="asc-body">
                    <div class="asc-val" id="statTotal">0</div>
                    <div class="asc-lbl">Total</div>
                </div>
            </div>
            <div class="ann-stat-card">
                <div class="asc-icon asc-pub"><i class="fas fa-globe"></i></div>
                <div class="asc-body">
                    <div class="asc-val" id="statPublished">0</div>
                    <div class="asc-lbl">Published</div>
                </div>
            </div>
            <div class="ann-stat-card">
                <div class="asc-icon asc-draft"><i class="fas fa-file-alt"></i></div>
                <div class="asc-body">
                    <div class="asc-val" id="statDrafts">0</div>
                    <div class="asc-lbl">Drafts</div>
                </div>
            </div>
        </div>

        <!-- ── Announcements Table Card ── -->
        <div class="card ann-card">

            <!-- Toolbar -->
            <div class="ann-toolbar">
                <div class="ann-search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" id="annSearch" placeholder="Search by title…" autocomplete="off">
                </div>
                <select class="ann-filter-select" id="annFilter">
                    <option value="all">All Status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>

            <!-- Table -->
            <div class="ann-table-wrap" id="annTableWrap">
                <table class="ann-table" id="annTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Attachment</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="annTbody">
                        <!-- JS populated -->
                    </tbody>
                </table>

                <!-- Empty state -->
                <div class="ann-empty" id="annEmpty" style="display:none;">
                    <i class="fas fa-bullhorn"></i>
                    <p>No announcements yet</p>
                    <span>Click '+ New Announcement' to create your first one</span>
                    <button class="btn-new-ann" onclick="openModal()">
                        <i class="fas fa-plus"></i> New Announcement
                    </button>
                </div>
            </div>

            <!-- Pagination -->
            <div class="ann-pagination" id="annPagination">
                <span class="ap-info" id="apInfo"></span>
                <div class="ap-btns" id="apBtns"></div>
            </div>
        </div>

    </div><!-- /content-area -->
</main>

<!-- Toast -->
<div class="toast" id="toast">
    <i class="fas fa-check-circle"></i>
    <span id="toastMsg">Done!</span>
</div>

<!-- ═══════════════ CREATE / EDIT MODAL ═══════════════ -->
<div class="modal-overlay" id="annModalOverlay">
    <div class="modal-box" id="annModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-header">
            <h2 id="modalTitle">New Announcement</h2>
            <button class="modal-close" id="modalClose" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <form id="annForm" novalidate>
                <input type="hidden" id="editId">

                <!-- Title -->
                <div class="mf-group">
                    <label for="fTitle">Title <span class="req">*</span></label>
                    <input type="text" id="fTitle" placeholder="Enter announcement title…">
                    <span class="field-err" id="errTitle"></span>
                </div>

                <!-- Message -->
                <div class="mf-group">
                    <label for="fMessage">Message / Body <span class="req">*</span></label>
                    <textarea id="fMessage" rows="5" placeholder="Write the announcement message…"></textarea>
                    <span class="field-err" id="errMessage"></span>
                </div>

                <!-- Date -->
                <div class="mf-group">
                    <label for="fDate">Date <span class="req">*</span></label>
                    <input type="date" id="fDate">
                    <span class="field-err" id="errDate"></span>
                </div>

                <!-- Attachment -->
                <div class="mf-group">
                    <label>Attachment <span class="mf-opt">(optional — max 5 MB)</span></label>
                    <div class="file-drop" id="fileDrop">
                        <i class="fas fa-paperclip"></i>
                        <span>Drag &amp; drop or <label for="fFile" class="file-browse">browse</label></span>
                        <small>Accepts .jpg .png .pdf .docx</small>
                        <input type="file" id="fFile" accept=".jpg,.jpeg,.png,.pdf,.docx" hidden>
                    </div>
                    <div class="file-preview" id="filePreview" style="display:none;"></div>
                    <span class="field-err" id="errFile"></span>
                </div>

                <!-- Status -->
                <div class="mf-group">
                    <label>Status</label>
                    <div class="status-radios">
                        <label class="radio-opt">
                            <input type="radio" name="fStatus" value="published" checked>
                            <span class="radio-pill">
                                <i class="fas fa-globe"></i> Publish immediately
                            </span>
                        </label>
                        <label class="radio-opt">
                            <input type="radio" name="fStatus" value="draft">
                            <span class="radio-pill">
                                <i class="fas fa-file-alt"></i> Save as Draft
                            </span>
                        </label>
                    </div>
                </div>

            </form>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" id="modalCancel">Cancel</button>
            <div class="mf-right-btns">
                <button class="btn-save-draft" id="btnSaveDraft">Save as Draft</button>
                <button class="btn-publish" id="btnPublish">
                    <i class="fas fa-globe"></i> Publish
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════ DELETE CONFIRM MODAL ═══════════════ -->
<div class="modal-overlay" id="deleteOverlay">
    <div class="modal-box delete-box" role="dialog" aria-modal="true" aria-labelledby="deleteTitle">
        <div class="modal-header">
            <h2 id="deleteTitle"><i class="fas fa-trash-alt"></i> Delete Announcement</h2>
            <button class="modal-close" id="deleteClose" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <div class="delete-body">
            <p>Are you sure you want to delete this announcement?<br>
            <strong>This action cannot be undone.</strong></p>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" id="deleteCancelBtn">Cancel</button>
            <button class="btn-delete-confirm" id="deleteConfirmBtn">
                <i class="fas fa-trash-alt"></i> Delete
            </button>
        </div>
    </div>
</div>

<script src="js/announcements.js"></script>
<script src="js/portal.js" onerror="void(0)"></script>
</body>
</html>
