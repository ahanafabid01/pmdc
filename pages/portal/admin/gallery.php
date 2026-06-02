<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Management | PMDC Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/gallery-admin.css">
</head>
<body>

    <!-- Sidebar Overlay -->
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
            <a href="index.php" class="nav-item">
                <i class="fas fa-th-large"></i><span>Dashboard</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-users"></i><span>Students</span>
                <span class="badge">450</span>
            </a>
            <a href="teacher.php" class="nav-item">
                <i class="fas fa-chalkboard-teacher"></i><span>Teachers &amp; Staff</span>
            </a>
            <a href="gallery.php" class="nav-item active">
                <i class="fas fa-images"></i><span>Gallery</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-book"></i><span>Courses</span>
            </a>

            <div class="nav-divider"></div>
            <span class="nav-section-label">Management</span>
            <a href="#" class="nav-item">
                <i class="fas fa-calendar-alt"></i><span>Academic Calendar</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-bell"></i><span>Announcements</span>
                <span class="badge warn">3</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-chart-line"></i><span>Reports</span>
            </a>

            <div class="nav-divider"></div>
            <span class="nav-section-label">System</span>
            <a href="#" class="nav-item">
                <i class="fas fa-cog"></i><span>Settings</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sf-user">
                <div class="sf-avatar">A</div>
                <div class="sf-info">
                    <span class="sf-name">Admin</span>
                    <span class="sf-role">Administrator</span>
                </div>
            </div>
            <a href="../portal-login.php" class="sf-logout" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </aside>

    <!-- Main -->
    <div class="main-wrapper">

        <!-- Topbar -->
        <header class="topbar">
            <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
            <div class="topbar-title">
                <h1>Gallery</h1>
                <p>Manage public photo gallery</p>
            </div>
            <div class="topbar-actions">
                <button class="btn-primary-admin" id="btnUpload">
                    <i class="fas fa-cloud-upload-alt"></i> Upload Photos
                </button>
            </div>
        </header>

        <!-- Stats -->
        <div class="admin-content">
            <div class="gallery-stats-row" id="statsRow">
                <div class="gstat-card">
                    <div class="gsc-icon"><i class="fas fa-images"></i></div>
                    <div class="gsc-body">
                        <div class="gsc-val" id="statTotal">—</div>
                        <div class="gsc-lbl">Total Photos</div>
                    </div>
                </div>
                <div class="gstat-card">
                    <div class="gsc-icon gsc-green"><i class="fas fa-calendar-alt"></i></div>
                    <div class="gsc-body">
                        <div class="gsc-val" id="statYears">—</div>
                        <div class="gsc-lbl">Years / Albums</div>
                    </div>
                </div>
                <div class="gstat-card">
                    <div class="gsc-icon gsc-gold"><i class="fas fa-clock"></i></div>
                    <div class="gsc-body">
                        <div class="gsc-val" id="statLatest">—</div>
                        <div class="gsc-lbl">Latest Upload</div>
                    </div>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="gallery-toolbar">
                <div class="gtb-left">
                    <div class="bulk-actions" id="bulkActions" style="display:none;">
                        <button class="btn-danger-sm" id="btnBulkDelete">
                            <i class="fas fa-trash"></i> Delete Selected (<span id="bulkCount">0</span>)
                        </button>
                    </div>
                    <label class="gtb-check" id="selectAllWrap" style="display:none;">
                        <input type="checkbox" id="selectAll"> Select All
                    </label>
                    <select id="filterYear" class="gtb-select">
                        <option value="all">All Years</option>
                    </select>
                    <div class="gtb-search">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search photos...">
                    </div>
                </div>
                <div class="gtb-right">
                    <button class="gtb-view active" id="viewGrid" title="Grid view"><i class="fas fa-th"></i></button>
                    <button class="gtb-view" id="viewList" title="List view"><i class="fas fa-list"></i></button>
                </div>
            </div>

            <!-- Grid View -->
            <div class="admin-gallery-grid" id="adminGrid"></div>

            <!-- List View -->
            <div class="admin-gallery-list" id="adminList" style="display:none;">
                <table class="ag-table">
                    <thead>
                        <tr>
                            <th width="40"><input type="checkbox" id="selectAllList"></th>
                            <th width="70">Photo</th>
                            <th>Title</th>
                            <th width="80">Year</th>
                            <th width="120">Date</th>
                            <th width="100">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="listBody"></tbody>
                </table>
            </div>

            <!-- Empty -->
            <div class="admin-empty" id="adminEmpty" style="display:none;">
                <i class="fas fa-images"></i>
                <p>No photos yet. Upload your first photos!</p>
            </div>
        </div>
    </div>

    <!-- ══ UPLOAD MODAL ══════════════════════════════════════ -->
    <div class="modal-overlay" id="uploadModal">
        <div class="modal-box modal-lg">
            <div class="modal-header">
                <h3><i class="fas fa-cloud-upload-alt"></i> Upload Photos</h3>
                <button class="modal-close" id="closeUpload"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <!-- Drop Zone -->
                <div class="drop-zone" id="dropZone">
                    <div class="dz-inner">
                        <i class="fas fa-cloud-upload-alt dz-icon"></i>
                        <p class="dz-main">Drag &amp; drop photos here, or <label for="fileInput" class="dz-browse">browse</label></p>
                        <p class="dz-sub">JPG, PNG, WEBP · Max 5MB per photo · Multiple allowed</p>
                    </div>
                    <input type="file" id="fileInput" accept=".jpg,.jpeg,.png,.webp" multiple style="display:none;">
                </div>

                <!-- Preview grid -->
                <div class="upload-preview" id="uploadPreview"></div>

                <!-- Meta fields -->
                <div class="upload-meta" id="uploadMeta" style="display:none;">
                    <div class="um-row">
                        <div class="um-group">
                            <label>Year <span class="req">*</span></label>
                            <select id="upYear"></select>
                        </div>
                        <div class="um-group">
                            <label>Date</label>
                            <input type="date" id="upDate">
                        </div>
                    </div>
                    <div class="um-group">
                        <label>Title <span class="um-opt">(optional — applies to all)</span></label>
                        <input type="text" id="upTitle" placeholder="e.g. Annual Day 2026">
                    </div>
                </div>

                <!-- Progress -->
                <div class="upload-progress" id="uploadProgress" style="display:none;">
                    <div class="up-bar-wrap">
                        <div class="up-bar" id="upBar"></div>
                    </div>
                    <p class="up-status" id="upStatus">Uploading…</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-ghost-admin" id="cancelUpload">Cancel</button>
                <button class="btn-primary-admin" id="submitUpload" disabled>
                    <i class="fas fa-upload"></i> Upload
                </button>
            </div>
        </div>
    </div>

    <!-- ══ EDIT MODAL ════════════════════════════════════════ -->
    <div class="modal-overlay" id="editModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3><i class="fas fa-pencil-alt"></i> Edit Photo</h3>
                <button class="modal-close" id="closeEdit"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editId">
                <div class="um-group">
                    <label>Title</label>
                    <input type="text" id="editTitle" placeholder="Photo title">
                </div>
                <div class="um-row">
                    <div class="um-group">
                        <label>Year</label>
                        <select id="editYear"></select>
                    </div>
                    <div class="um-group">
                        <label>Date</label>
                        <input type="date" id="editDate">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-ghost-admin" id="cancelEdit">Cancel</button>
                <button class="btn-primary-admin" id="submitEdit">
                    <i class="fas fa-save"></i> Save
                </button>
            </div>
        </div>
    </div>

    <!-- ══ DELETE CONFIRM ════════════════════════════════════ -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box modal-sm">
            <div class="modal-header">
                <h3><i class="fas fa-exclamation-triangle"></i> Confirm Delete</h3>
                <button class="modal-close" id="closeDelete"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this photo?</p>
                <p class="del-warn">This action cannot be undone.</p>
                <input type="hidden" id="deleteId">
            </div>
            <div class="modal-footer">
                <button class="btn-ghost-admin" id="cancelDelete">Cancel</button>
                <button class="btn-danger-admin" id="confirmDelete">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>

    <!-- ══ BULK DELETE CONFIRM ════════════════════════════════ -->
    <div class="modal-overlay" id="bulkDeleteModal">
        <div class="modal-box modal-sm">
            <div class="modal-header">
                <h3><i class="fas fa-exclamation-triangle"></i> Bulk Delete</h3>
                <button class="modal-close" id="closeBulkDelete"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <p>Delete <strong id="bulkDeleteCount">0</strong> selected photos?</p>
                <p class="del-warn">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button class="btn-ghost-admin" id="cancelBulkDelete">Cancel</button>
                <button class="btn-danger-admin" id="confirmBulkDelete">
                    <i class="fas fa-trash"></i> Delete All
                </button>
            </div>
        </div>
    </div>

    <script src="../../js/admin.js"></script>
    <script>
    /* ════════════════════════════════════════════════════════════
       Gallery Admin JS
    ════════════════════════════════════════════════════════════ */
    (function () {
        'use strict';

        const API    = '../../../api/gallery-upload.php';
        const $ = id => document.getElementById(id);

        let allPhotos  = [];
        let filtered   = [];
        let selected   = new Set();
        let viewMode   = 'grid';
        let currentYear = 'all';
        let searchTerm  = '';

        /* ── Year options helper ──────────────────────────── */
        function yearOptions(selId, val) {
            const sel = $(selId);
            sel.innerHTML = '';
            const cur = new Date().getFullYear();
            for (let y = cur; y >= 2020; y--) {
                const o = document.createElement('option');
                o.value = y; o.textContent = y;
                if (y == val) o.selected = true;
                sel.appendChild(o);
            }
        }

        /* ── Load photos from server ─────────────────────── */
        function loadPhotos() {
            fetch(API + '?action=list')
                .then(r => r.json()).then(data => {
                    allPhotos = data.photos || SAMPLE_PHOTOS;
                    renderAll();
                }).catch(() => {
                    allPhotos = SAMPLE_PHOTOS;
                    renderAll();
                });
        }

        /* ── Fallback sample ─────────────────────────────── */
        const SAMPLE_PHOTOS = [
            { id:1,  title:'Annual Prize Giving Ceremony', filename:'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=400&fit=crop', year:2026, date_uploaded:'2026-03-15', is_external:1 },
            { id:2,  title:'Science Fair 2026',            filename:'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=400&h=400&fit=crop', year:2026, date_uploaded:'2026-02-20', is_external:1 },
            { id:3,  title:'National Day Celebration',     filename:'https://images.unsplash.com/photo-1567168544646-208fa5d408fb?w=400&h=400&fit=crop', year:2026, date_uploaded:'2026-03-26', is_external:1 },
            { id:4,  title:'Campus Life 2026',             filename:'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=400&h=400&fit=crop', year:2026, date_uploaded:'2026-04-10', is_external:1 },
            { id:5,  title:'HSC Farewell 2025',            filename:'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=400&h=400&fit=crop', year:2025, date_uploaded:'2025-11-30', is_external:1 },
            { id:6,  title:'Cultural Programme 2025',      filename:'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=400&h=400&fit=crop', year:2025, date_uploaded:'2025-10-15', is_external:1 },
        ];

        /* ── Stats ───────────────────────────────────────── */
        function renderStats() {
            $('statTotal').textContent  = allPhotos.length;
            const years = [...new Set(allPhotos.map(p => p.year))];
            $('statYears').textContent  = years.length;
            const sorted = [...allPhotos].sort((a,b) => new Date(b.date_uploaded) - new Date(a.date_uploaded));
            $('statLatest').textContent = sorted[0] ? sorted[0].date_uploaded : '—';
            // Populate year filter
            const sel = $('filterYear');
            sel.innerHTML = '<option value="all">All Years</option>';
            years.sort((a,b) => b-a).forEach(y => {
                const o = document.createElement('option');
                o.value = y; o.textContent = y;
                sel.appendChild(o);
            });
        }

        /* ── Filter & search ─────────────────────────────── */
        function applyFilter() {
            filtered = allPhotos.filter(p => {
                const matchYear  = currentYear === 'all' || p.year == currentYear;
                const matchSearch = !searchTerm || p.title.toLowerCase().includes(searchTerm);
                return matchYear && matchSearch;
            });
            renderPhotos();
        }

        function renderAll() {
            renderStats();
            applyFilter();
        }

        /* ── Photo URL helper ────────────────────────────── */
        function photoUrl(p) {
            if (p.is_external) return p.filename;
            return '../../../uploads/gallery/' + p.filename;
        }

        /* ── Render Grid ─────────────────────────────────── */
        function renderPhotos() {
            const empty = $('adminEmpty');
            const grid  = $('adminGrid');
            const list  = $('adminList');
            const body  = $('listBody');

            if (filtered.length === 0) {
                empty.style.display = '';
                grid.style.display  = 'none';
                list.style.display  = 'none';
                return;
            }
            empty.style.display = 'none';

            $('selectAllWrap').style.display = filtered.length > 0 ? '' : 'none';

            if (viewMode === 'grid') {
                grid.style.display = '';
                list.style.display = 'none';
                grid.innerHTML = filtered.map(p => `
                    <div class="ag-thumb" data-id="${p.id}">
                        <img src="${photoUrl(p)}" alt="${esc(p.title)}" loading="lazy">
                        <div class="agt-overlay">
                            <button class="agt-btn" onclick="editPhoto(${p.id})" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                            <button class="agt-btn agt-del" onclick="deletePhoto(${p.id})" title="Delete"><i class="fas fa-trash"></i></button>
                        </div>
                        <div class="agt-year-badge">${p.year}</div>
                        <label class="agt-check">
                            <input type="checkbox" data-id="${p.id}" ${selected.has(p.id) ? 'checked' : ''} onchange="toggleSelect(${p.id}, this.checked)">
                        </label>
                    </div>`).join('');
            } else {
                grid.style.display = 'none';
                list.style.display = '';
                body.innerHTML = filtered.map(p => `
                    <tr>
                        <td><input type="checkbox" data-id="${p.id}" ${selected.has(p.id) ? 'checked' : ''} onchange="toggleSelect(${p.id}, this.checked)"></td>
                        <td><img src="${photoUrl(p)}" alt="" class="ag-list-thumb" loading="lazy"></td>
                        <td class="ag-list-title">${esc(p.title) || '<em>Untitled</em>'}</td>
                        <td>${p.year}</td>
                        <td>${p.date_uploaded}</td>
                        <td>
                            <button class="agt-btn-sm" onclick="editPhoto(${p.id})"><i class="fas fa-pencil-alt"></i></button>
                            <button class="agt-btn-sm agt-del" onclick="deletePhoto(${p.id})"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>`).join('');
            }
        }

        function esc(s) {
            const d = document.createElement('div');
            d.textContent = s || '';
            return d.innerHTML;
        }

        /* ── Selection ───────────────────────────────────── */
        window.toggleSelect = function(id, checked) {
            checked ? selected.add(id) : selected.delete(id);
            updateBulkBar();
        };

        function updateBulkBar() {
            const count = selected.size;
            $('bulkActions').style.display = count > 0 ? '' : 'none';
            $('bulkCount').textContent = count;
            $('bulkDeleteCount').textContent = count;
        }

        $('selectAll').addEventListener('change', function() {
            filtered.forEach(p => this.checked ? selected.add(p.id) : selected.delete(p.id));
            renderPhotos();
            updateBulkBar();
        });

        /* ── Upload Modal ────────────────────────────────── */
        let uploadFiles = [];

        $('btnUpload').addEventListener('click', () => {
            uploadFiles = [];
            $('uploadPreview').innerHTML = '';
            $('uploadMeta').style.display = 'none';
            $('uploadProgress').style.display = 'none';
            $('submitUpload').disabled = true;
            yearOptions('upYear', new Date().getFullYear());
            $('upDate').value = new Date().toISOString().split('T')[0];
            $('upTitle').value = '';
            $('uploadModal').classList.add('open');
        });

        ['closeUpload','cancelUpload'].forEach(id => {
            $(id).addEventListener('click', () => $('uploadModal').classList.remove('open'));
        });

        // Drop zone
        const dz = $('dropZone');
        dz.addEventListener('click', () => $('fileInput').click());
        dz.addEventListener('dragover', e => { e.preventDefault(); dz.classList.add('drag-over'); });
        dz.addEventListener('dragleave', () => dz.classList.remove('drag-over'));
        dz.addEventListener('drop', e => {
            e.preventDefault(); dz.classList.remove('drag-over');
            handleFiles(e.dataTransfer.files);
        });
        $('fileInput').addEventListener('change', e => handleFiles(e.target.files));

        function handleFiles(files) {
            uploadFiles = [...files];
            const preview = $('uploadPreview');
            preview.innerHTML = '';
            uploadFiles.forEach(f => {
                const div = document.createElement('div');
                div.className = 'up-preview-item';
                const img = document.createElement('img');
                img.src = URL.createObjectURL(f);
                const lbl = document.createElement('span');
                lbl.textContent = f.name;
                div.appendChild(img); div.appendChild(lbl);
                preview.appendChild(div);
            });
            $('uploadMeta').style.display = uploadFiles.length > 0 ? '' : 'none';
            $('submitUpload').disabled = uploadFiles.length === 0;
        }

        $('submitUpload').addEventListener('click', () => {
            if (!uploadFiles.length) return;
            const fd = new FormData();
            fd.append('action', 'upload');
            fd.append('year', $('upYear').value);
            fd.append('date', $('upDate').value);
            fd.append('title', $('upTitle').value);
            uploadFiles.forEach(f => fd.append('photos[]', f));

            $('uploadProgress').style.display = '';
            $('submitUpload').disabled = true;
            $('upBar').style.width = '0%';

            const xhr = new XMLHttpRequest();
            xhr.open('POST', API);
            xhr.upload.onprogress = e => {
                if (e.lengthComputable) {
                    $('upBar').style.width = Math.round(e.loaded / e.total * 100) + '%';
                }
            };
            xhr.onload = () => {
                $('upBar').style.width = '100%';
                $('upStatus').textContent = 'Done!';
                setTimeout(() => {
                    $('uploadModal').classList.remove('open');
                    loadPhotos();
                }, 800);
            };
            xhr.onerror = () => { $('upStatus').textContent = 'Upload failed.'; };
            xhr.send(fd);
        });

        /* ── Edit Modal ──────────────────────────────────── */
        window.editPhoto = function(id) {
            const p = allPhotos.find(x => x.id === id);
            if (!p) return;
            $('editId').value    = id;
            $('editTitle').value = p.title || '';
            $('editDate').value  = p.date_uploaded;
            yearOptions('editYear', p.year);
            $('editModal').classList.add('open');
        };

        ['closeEdit','cancelEdit'].forEach(id => {
            $(id).addEventListener('click', () => $('editModal').classList.remove('open'));
        });

        $('submitEdit').addEventListener('click', () => {
            const fd = new FormData();
            fd.append('action', 'edit');
            fd.append('id',     $('editId').value);
            fd.append('title',  $('editTitle').value);
            fd.append('year',   $('editYear').value);
            fd.append('date',   $('editDate').value);
            fetch(API, { method:'POST', body: fd })
                .then(r => r.json()).then(d => {
                    if (d.ok) { $('editModal').classList.remove('open'); loadPhotos(); }
                });
        });

        /* ── Delete Modal ────────────────────────────────── */
        window.deletePhoto = function(id) {
            $('deleteId').value = id;
            $('deleteModal').classList.add('open');
        };

        ['closeDelete','cancelDelete'].forEach(id => {
            $(id).addEventListener('click', () => $('deleteModal').classList.remove('open'));
        });

        $('confirmDelete').addEventListener('click', () => {
            const id = $('deleteId').value;
            const fd = new FormData();
            fd.append('action', 'delete');
            fd.append('id', id);
            fetch(API, { method:'POST', body: fd })
                .then(r => r.json()).then(d => {
                    if (d.ok) {
                        $('deleteModal').classList.remove('open');
                        selected.delete(parseInt(id));
                        loadPhotos();
                    }
                });
        });

        /* ── Bulk Delete ─────────────────────────────────── */
        $('btnBulkDelete').addEventListener('click', () => {
            $('bulkDeleteCount').textContent = selected.size;
            $('bulkDeleteModal').classList.add('open');
        });
        ['closeBulkDelete','cancelBulkDelete'].forEach(id => {
            $(id).addEventListener('click', () => $('bulkDeleteModal').classList.remove('open'));
        });
        $('confirmBulkDelete').addEventListener('click', () => {
            const fd = new FormData();
            fd.append('action', 'bulk_delete');
            fd.append('ids', JSON.stringify([...selected]));
            fetch(API, { method:'POST', body: fd })
                .then(r => r.json()).then(d => {
                    if (d.ok) {
                        selected.clear();
                        $('bulkDeleteModal').classList.remove('open');
                        loadPhotos();
                        updateBulkBar();
                    }
                });
        });

        /* ── View toggle ─────────────────────────────────── */
        $('viewGrid').addEventListener('click', () => {
            viewMode = 'grid';
            $('viewGrid').classList.add('active');
            $('viewList').classList.remove('active');
            renderPhotos();
        });
        $('viewList').addEventListener('click', () => {
            viewMode = 'list';
            $('viewList').classList.add('active');
            $('viewGrid').classList.remove('active');
            renderPhotos();
        });

        /* ── Filters ─────────────────────────────────────── */
        $('filterYear').addEventListener('change', function() {
            currentYear = this.value; applyFilter();
        });
        $('searchInput').addEventListener('input', function() {
            searchTerm = this.value.trim().toLowerCase(); applyFilter();
        });

        /* ── Sidebar ─────────────────────────────────────── */
        $('menuToggle').addEventListener('click', () => $('sidebar').classList.toggle('open'));
        $('closeSidebar').addEventListener('click', () => $('sidebar').classList.remove('open'));
        $('sidebarOverlay').addEventListener('click', () => $('sidebar').classList.remove('open'));

        /* ── Init ────────────────────────────────────────── */
        yearOptions('upYear', new Date().getFullYear());
        yearOptions('editYear', new Date().getFullYear());
        loadPhotos();

    })();
    </script>
</body>
</html>
