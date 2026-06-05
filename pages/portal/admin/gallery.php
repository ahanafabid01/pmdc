<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Management | PMDC Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/teacher.css">
    <link rel="stylesheet" href="css/gallery-admin.css">
</head>
<body>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ── Sidebar (identical to teacher.php) ──────────────── -->
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
            <a href="teacher.php" class="nav-item"><i class="fas fa-chalkboard-teacher"></i><span>Teachers &amp; Staff</span></a>
            <a href="gallery.php" class="nav-item active"><i class="fas fa-images"></i><span>Gallery</span></a>
            <a href="academics.php" class="nav-item"><i class="fas fa-book-open"></i><span>Academics</span></a>
            <div class="nav-divider"></div>
            <span class="nav-section-label">Management</span>
            <a href="academic-calendar.php" class="nav-item"><i class="fas fa-calendar-alt"></i><span>Academic Calendar</span></a>
            <a href="#" class="nav-item"><i class="fas fa-file-invoice-dollar"></i><span>Finance</span></a>
            <a href="announcements.php" class="nav-item"><i class="fas fa-bell"></i><span>Announcements</span><span class="badge warn">3</span></a>
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

    <!-- ── Main ──────────────────────────────────────────────── -->
    <main class="main-content">
        <header class="top-header">
            <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
            <div class="th-breadcrumb">
                <a href="index.php">Dashboard</a>
                <i class="fas fa-chevron-right"></i>
                <span>Gallery</span>
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

            <!-- Page Header -->
            <div class="tm-page-header">
                <div class="tm-page-title">
                    <h1>Gallery Management</h1>
                    <p>Upload, organise and manage photos displayed on the public gallery</p>
                </div>
                <div class="tm-header-actions">
                    <a href="../../../pages/gallery.php" target="_blank" class="btn-preview">
                        <i class="fas fa-external-link-alt"></i> Preview Public Page
                    </a>
                    <button class="btn-add-staff" id="btnUpload">
                        <i class="fas fa-cloud-upload-alt"></i> Upload Photos
                    </button>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="tm-stats-row">
                <div class="tm-stat-pill" id="statGalleryTotal">
                    <i class="fas fa-images"></i>
                    <span class="ts-val" id="statTotal">—</span>
                    <span class="ts-lbl">Total Photos</span>
                </div>
                <div class="tm-stat-pill" id="statGalleryAlbums">
                    <i class="fas fa-layer-group"></i>
                    <span class="ts-val" id="statYears">—</span>
                    <span class="ts-lbl">Year Albums</span>
                </div>
                <div class="tm-stat-pill" id="statGalleryLatest">
                    <i class="fas fa-clock"></i>
                    <span class="ts-val" id="statLatest">—</span>
                    <span class="ts-lbl">Latest Upload</span>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="gm-toolbar">
                <div class="gm-toolbar-left">
                    <div class="gm-bulk-actions" id="bulkActions" style="display:none;">
                        <button class="btn-bulk-delete" id="btnBulkDelete">
                            <i class="fas fa-trash"></i> Delete Selected (<span id="bulkCount">0</span>)
                        </button>
                    </div>
                    <label class="gm-select-all" id="selectAllWrap" style="display:none;">
                        <input type="checkbox" id="selectAll"> Select All
                    </label>
                    <select id="filterYear" class="gm-year-select">
                        <option value="all">All Years</option>
                    </select>
                    <div class="gm-search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search photos…">
                    </div>
                </div>
                <div class="gm-toolbar-right">
                    <button class="gm-view-btn active" id="viewGrid" title="Grid view"><i class="fas fa-th"></i></button>
                    <button class="gm-view-btn" id="viewList" title="List view"><i class="fas fa-list"></i></button>
                </div>
            </div>

            <!-- Grid View -->
            <div class="gm-grid" id="adminGrid"></div>

            <!-- List View -->
            <div class="tm-card" id="adminList" style="display:none;">
                <div class="tm-table-wrap">
                    <table class="tm-table">
                        <thead>
                            <tr>
                                <th width="40"><input type="checkbox" id="selectAllList"></th>
                                <th width="68">Photo</th>
                                <th>Title</th>
                                <th width="80">Year</th>
                                <th width="130">Date Added</th>
                                <th width="96">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="listBody"></tbody>
                    </table>
                </div>
            </div>

            <!-- Empty -->
            <div class="gm-empty" id="adminEmpty" style="display:none;">
                <i class="fas fa-photo-video"></i>
                <p>No photos yet. Click <strong>Upload Photos</strong> to get started.</p>
            </div>

        </div><!-- /content-area -->
    </main>

    <!-- ══ UPLOAD MODAL ══════════════════════════════════════ -->
    <div class="tm-modal-overlay" id="uploadModal">
        <div class="tm-modal">
            <div class="tm-modal-header">
                <h2><i class="fas fa-cloud-upload-alt"></i> Upload Photos</h2>
                <button class="tm-modal-close" id="closeUpload"><i class="fas fa-times"></i></button>
            </div>
            <div class="tm-modal-body">
                <!-- Drop Zone -->
                <div class="gm-drop-zone" id="dropZone">
                    <i class="fas fa-cloud-upload-alt gm-dz-icon"></i>
                    <p class="gm-dz-main">Drag &amp; drop photos here, or <label for="fileInput" class="gm-dz-browse">browse files</label></p>
                    <p class="gm-dz-sub">JPG, PNG, WEBP &nbsp;·&nbsp; Max 5 MB per file &nbsp;·&nbsp; Multiple allowed</p>
                    <input type="file" id="fileInput" accept=".jpg,.jpeg,.png,.webp" multiple style="display:none;">
                </div>

                <!-- Preview -->
                <div class="gm-upload-preview" id="uploadPreview"></div>

                <!-- Meta fields -->
                <div class="gm-upload-meta" id="uploadMeta" style="display:none;">
                    <div class="gm-meta-row">
                        <div class="tm-form-group">
                            <label for="upYear">Year <span class="req">*</span></label>
                            <select id="upYear"></select>
                        </div>
                        <div class="tm-form-group">
                            <label for="upDate">Date</label>
                            <input type="date" id="upDate">
                        </div>
                    </div>
                    <div class="tm-form-group">
                        <label for="upTitle">Title <span class="opt-label">(optional — applied to all)</span></label>
                        <input type="text" id="upTitle" placeholder="e.g. Annual Day 2026">
                    </div>
                </div>

                <!-- Progress -->
                <div class="gm-progress" id="uploadProgress" style="display:none;">
                    <div class="gm-bar-wrap"><div class="gm-bar" id="upBar"></div></div>
                    <p class="gm-status" id="upStatus">Uploading…</p>
                </div>
            </div>
            <div class="tm-modal-footer">
                <button class="btn-cancel" id="cancelUpload">Cancel</button>
                <button class="btn-save" id="submitUpload" disabled>
                    <i class="fas fa-upload"></i> Upload
                </button>
            </div>
        </div>
    </div>

    <!-- ══ EDIT MODAL ════════════════════════════════════════ -->
    <div class="tm-modal-overlay" id="editModal">
        <div class="tm-modal tm-modal-sm">
            <div class="tm-modal-header">
                <h2><i class="fas fa-pencil-alt"></i> Edit Photo</h2>
                <button class="tm-modal-close" id="closeEdit"><i class="fas fa-times"></i></button>
            </div>
            <div class="tm-modal-body">
                <input type="hidden" id="editId">
                <div class="tm-form-group">
                    <label for="editTitle">Title</label>
                    <input type="text" id="editTitle" placeholder="Photo title">
                </div>
                <div class="tm-form-grid">
                    <div class="tm-form-group">
                        <label for="editYear">Year</label>
                        <select id="editYear"></select>
                    </div>
                    <div class="tm-form-group">
                        <label for="editDate">Date</label>
                        <input type="date" id="editDate">
                    </div>
                </div>
            </div>
            <div class="tm-modal-footer">
                <button class="btn-cancel" id="cancelEdit">Cancel</button>
                <button class="btn-save" id="submitEdit">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </div>
    </div>

    <!-- ══ DELETE CONFIRM ════════════════════════════════════ -->
    <div class="tm-modal-overlay" id="deleteModal">
        <div class="tm-modal tm-modal-sm">
            <div class="tm-modal-header">
                <h2><i class="fas fa-trash-alt" style="color:var(--red);"></i> Delete Photo</h2>
                <button class="tm-modal-close" id="closeDelete"><i class="fas fa-times"></i></button>
            </div>
            <div class="tm-modal-body">
                <p style="font-size:.925rem;color:#475569;font-family:'Inter',sans-serif;line-height:1.6;">
                    Are you sure you want to delete this photo?<br>It will also be removed from the public gallery.
                </p>
                <p class="del-warn">This action cannot be undone.</p>
                <input type="hidden" id="deleteId">
            </div>
            <div class="tm-modal-footer">
                <button class="btn-cancel" id="cancelDelete">Cancel</button>
                <button class="btn-delete-confirm" id="confirmDelete">
                    <i class="fas fa-trash-alt"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>

    <!-- ══ BULK DELETE CONFIRM ════════════════════════════════ -->
    <div class="tm-modal-overlay" id="bulkDeleteModal">
        <div class="tm-modal tm-modal-sm">
            <div class="tm-modal-header">
                <h2><i class="fas fa-trash-alt" style="color:var(--red);"></i> Bulk Delete</h2>
                <button class="tm-modal-close" id="closeBulkDelete"><i class="fas fa-times"></i></button>
            </div>
            <div class="tm-modal-body">
                <p style="font-size:.925rem;color:#475569;font-family:'Inter',sans-serif;line-height:1.6;">
                    Delete <strong id="bulkDeleteCount">0</strong> selected photos from the gallery?
                </p>
                <p class="del-warn">This action cannot be undone.</p>
            </div>
            <div class="tm-modal-footer">
                <button class="btn-cancel" id="cancelBulkDelete">Cancel</button>
                <button class="btn-delete-confirm" id="confirmBulkDelete">
                    <i class="fas fa-trash-alt"></i> Delete All
                </button>
            </div>
        </div>
    </div>

    <!-- Toast (same pattern as teacher.php) -->
    <div class="tm-toast" id="gmToast"></div>

<script src="js/gallery.js"></script>
</body>
</html>


