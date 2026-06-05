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

    <script>
    /* ════════════════════════════════════════════════════════════
       Gallery Admin JS
    ════════════════════════════════════════════════════════════ */
    (function () {
        'use strict';

        const API = '../../../api/gallery-upload.php';
        const $   = id => document.getElementById(id);

        let allPhotos   = [];
        let filtered    = [];
        let selected    = new Set();
        let viewMode    = 'grid';
        let currentYear = 'all';
        let searchTerm  = '';

        /* ── Toast helper ─────────────────────────────────── */
        function toast(msg, type = 'success') {
            const el = $('gmToast');
            el.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${msg}`;
            el.className = `tm-toast ${type} show`;
            setTimeout(() => el.classList.remove('show'), 3000);
        }

        /* ── Year options helper ──────────────────────────── */
        function yearOptions(selId, val) {
            const sel = $(selId); sel.innerHTML = '';
            const cur = new Date().getFullYear();
            for (let y = cur; y >= 2018; y--) {
                const o = document.createElement('option');
                o.value = y; o.textContent = y;
                if (y == val) o.selected = true;
                sel.appendChild(o);
            }
        }

        /* ── Load photos ──────────────────────────────────── */
        function loadPhotos() {
            fetch(API + '?action=list')
                .then(r => r.json())
                .then(data => { allPhotos = data.photos || SAMPLE; renderAll(); })
                .catch(() => { allPhotos = SAMPLE; renderAll(); });
        }

        /* ── Sample data ──────────────────────────────────── */
        const SAMPLE = [
            { id:1, title:'Annual Prize Giving Ceremony', filename:'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=500&h=500&fit=crop', year:2026, date_uploaded:'2026-03-15', is_external:1 },
            { id:2, title:'Science Fair 2026',            filename:'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=500&h=500&fit=crop', year:2026, date_uploaded:'2026-02-20', is_external:1 },
            { id:3, title:'National Day Celebration',     filename:'https://images.unsplash.com/photo-1567168544646-208fa5d408fb?w=500&h=500&fit=crop', year:2026, date_uploaded:'2026-03-26', is_external:1 },
            { id:4, title:'Campus Life 2026',             filename:'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=500&h=500&fit=crop', year:2026, date_uploaded:'2026-04-10', is_external:1 },
            { id:5, title:'HSC Farewell 2025',            filename:'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=500&h=500&fit=crop', year:2025, date_uploaded:'2025-11-30', is_external:1 },
            { id:6, title:'Cultural Programme 2025',      filename:'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=500&h=500&fit=crop', year:2025, date_uploaded:'2025-10-15', is_external:1 },
            { id:7, title:'Sports Day 2025',              filename:'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=500&h=500&fit=crop', year:2025, date_uploaded:'2025-09-05', is_external:1 },
            { id:8, title:'Orientation 2024',             filename:'https://images.unsplash.com/photo-1606761568499-6d2451b23c66?w=500&h=500&fit=crop', year:2024, date_uploaded:'2024-01-12', is_external:1 },
        ];

        /* ── Stats ────────────────────────────────────────── */
        function renderStats() {
            $('statTotal').textContent = allPhotos.length;
            const years = [...new Set(allPhotos.map(p => p.year))];
            $('statYears').textContent = years.length;
            const sorted = [...allPhotos].sort((a,b) => new Date(b.date_uploaded) - new Date(a.date_uploaded));
            $('statLatest').textContent = sorted[0] ? fmtDate(sorted[0].date_uploaded) : '—';
            // Year filter
            const sel = $('filterYear');
            sel.innerHTML = '<option value="all">All Years</option>';
            years.sort((a,b) => b-a).forEach(y => {
                const o = document.createElement('option');
                o.value = y; o.textContent = y;
                if (String(y) === currentYear) o.selected = true;
                sel.appendChild(o);
            });
        }

        /* ── Filter ───────────────────────────────────────── */
        function applyFilter() {
            filtered = allPhotos.filter(p => {
                const matchYear   = currentYear === 'all' || p.year == currentYear;
                const matchSearch = !searchTerm || (p.title || '').toLowerCase().includes(searchTerm);
                return matchYear && matchSearch;
            });
            renderPhotos();
        }

        function renderAll() { renderStats(); applyFilter(); }

        /* ── Helpers ──────────────────────────────────────── */
        function photoUrl(p) { return p.is_external ? p.filename : '../../../uploads/gallery/' + p.filename; }
        function esc(s) { const d = document.createElement('div'); d.textContent = s||''; return d.innerHTML; }
        function fmtDate(d) {
            if (!d) return '—';
            return new Date(d).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' });
        }

        /* ── Render ───────────────────────────────────────── */
        function renderPhotos() {
            const empty = $('adminEmpty'), grid = $('adminGrid'), list = $('adminList'), body = $('listBody');

            if (!filtered.length) {
                empty.style.display = ''; grid.style.display = 'none'; list.style.display = 'none';
                return;
            }
            empty.style.display = 'none';
            $('selectAllWrap').style.display = '';

            if (viewMode === 'grid') {
                grid.style.display = ''; list.style.display = 'none';
                grid.innerHTML = filtered.map(p => `
                    <div class="gm-thumb${selected.has(p.id)?' selected':''}" data-id="${p.id}">
                        <img src="${photoUrl(p)}" alt="${esc(p.title)}" loading="lazy">
                        <div class="gm-thumb-overlay">
                            <button class="gm-thumb-btn" onclick="editPhoto(${p.id})" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                            <button class="gm-thumb-btn btn-del" onclick="deletePhoto(${p.id})" title="Delete"><i class="fas fa-trash"></i></button>
                        </div>
                        <div class="gm-year-badge">${p.year}</div>
                        <label class="gm-checkbox-wrap"><input type="checkbox" data-id="${p.id}" ${selected.has(p.id)?'checked':''} onchange="toggleSelect(${p.id},this.checked)"></label>
                    </div>`).join('');
            } else {
                grid.style.display = 'none'; list.style.display = '';
                body.innerHTML = filtered.map(p => `
                    <tr>
                        <td><input type="checkbox" ${selected.has(p.id)?'checked':''} onchange="toggleSelect(${p.id},this.checked)"></td>
                        <td><img src="${photoUrl(p)}" alt="" class="gm-list-thumb" loading="lazy"></td>
                        <td class="tm-staff-name">${esc(p.title)||'<em style="color:#94a3b8">Untitled</em>'}</td>
                        <td style="font-weight:700">${p.year}</td>
                        <td style="color:#64748b;font-size:.82rem">${fmtDate(p.date_uploaded)}</td>
                        <td>
                            <div class="tm-row-actions">
                                <button class="btn-edit" onclick="editPhoto(${p.id})" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                                <button class="btn-del" onclick="deletePhoto(${p.id})" title="Delete"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>`).join('');
            }
        }

        /* ── Selection ────────────────────────────────────── */
        window.toggleSelect = function(id, checked) {
            checked ? selected.add(id) : selected.delete(id);
            const t = document.querySelector(`.gm-thumb[data-id="${id}"]`);
            if (t) t.classList.toggle('selected', checked);
            updateBulkBar();
        };
        function updateBulkBar() {
            const n = selected.size;
            $('bulkActions').style.display = n > 0 ? '' : 'none';
            $('bulkCount').textContent = n;
            $('bulkDeleteCount').textContent = n;
        }
        $('selectAll').addEventListener('change', function() {
            filtered.forEach(p => this.checked ? selected.add(p.id) : selected.delete(p.id));
            renderPhotos(); updateBulkBar();
        });

        /* ── Modal helpers ────────────────────────────────── */
        function openModal(id)  { $(id).classList.add('active'); }
        function closeModal(id) { $(id).classList.remove('active'); }

        /* ── Upload Modal ─────────────────────────────────── */
        let uploadFiles = [];
        $('btnUpload').addEventListener('click', () => {
            uploadFiles = [];
            $('uploadPreview').innerHTML = '';
            $('uploadMeta').style.display = 'none';
            $('uploadProgress').style.display = 'none';
            $('submitUpload').disabled = true;
            yearOptions('upYear', new Date().getFullYear());
            $('upDate').value  = new Date().toISOString().split('T')[0];
            $('upTitle').value = '';
            openModal('uploadModal');
        });
        ['closeUpload','cancelUpload'].forEach(id => $(id).addEventListener('click', () => closeModal('uploadModal')));

        const dz = $('dropZone');
        dz.addEventListener('click', () => $('fileInput').click());
        dz.addEventListener('dragover',  e => { e.preventDefault(); dz.classList.add('drag-over'); });
        dz.addEventListener('dragleave', () => dz.classList.remove('drag-over'));
        dz.addEventListener('drop', e => { e.preventDefault(); dz.classList.remove('drag-over'); handleFiles(e.dataTransfer.files); });
        $('fileInput').addEventListener('change', e => handleFiles(e.target.files));

        function handleFiles(files) {
            uploadFiles = [...files];
            const preview = $('uploadPreview'); preview.innerHTML = '';
            uploadFiles.forEach(f => {
                const div = document.createElement('div'); div.className = 'gm-preview-item';
                const img = document.createElement('img'); img.src = URL.createObjectURL(f);
                const lbl = document.createElement('span'); lbl.textContent = f.name;
                div.appendChild(img); div.appendChild(lbl); preview.appendChild(div);
            });
            $('uploadMeta').style.display = uploadFiles.length ? '' : 'none';
            $('submitUpload').disabled     = !uploadFiles.length;
        }

        $('submitUpload').addEventListener('click', () => {
            if (!uploadFiles.length) return;
            const fd = new FormData();
            fd.append('action', 'upload'); fd.append('year', $('upYear').value);
            fd.append('date', $('upDate').value); fd.append('title', $('upTitle').value);
            uploadFiles.forEach(f => fd.append('photos[]', f));
            $('uploadProgress').style.display = ''; $('submitUpload').disabled = true; $('upBar').style.width = '0%';
            const xhr = new XMLHttpRequest(); xhr.open('POST', API);
            xhr.upload.onprogress = e => { if (e.lengthComputable) $('upBar').style.width = Math.round(e.loaded/e.total*100)+'%'; };
            xhr.onload = () => { $('upBar').style.width='100%'; $('upStatus').textContent='✓ Done!'; setTimeout(() => { closeModal('uploadModal'); loadPhotos(); toast('Photos uploaded successfully.'); }, 900); };
            xhr.onerror = () => { $('upStatus').textContent = 'Upload failed. Please try again.'; };
            xhr.send(fd);
        });

        /* ── Edit Modal ───────────────────────────────────── */
        window.editPhoto = function(id) {
            const p = allPhotos.find(x => x.id === id); if (!p) return;
            $('editId').value=''; $('editTitle').value = p.title||''; $('editDate').value = p.date_uploaded;
            $('editId').value = id; yearOptions('editYear', p.year); openModal('editModal');
        };
        ['closeEdit','cancelEdit'].forEach(id => $(id).addEventListener('click', () => closeModal('editModal')));
        $('submitEdit').addEventListener('click', () => {
            const fd = new FormData();
            fd.append('action','edit'); fd.append('id',$('editId').value);
            fd.append('title',$('editTitle').value); fd.append('year',$('editYear').value); fd.append('date',$('editDate').value);
            fetch(API,{method:'POST',body:fd}).then(r=>r.json()).then(d=>{if(d.ok){closeModal('editModal');loadPhotos();toast('Photo updated.');}});
        });

        /* ── Delete Modal ─────────────────────────────────── */
        window.deletePhoto = function(id) { $('deleteId').value=id; openModal('deleteModal'); };
        ['closeDelete','cancelDelete'].forEach(id => $(id).addEventListener('click', () => closeModal('deleteModal')));
        $('confirmDelete').addEventListener('click', () => {
            const id = $('deleteId').value; const fd = new FormData();
            fd.append('action','delete'); fd.append('id',id);
            fetch(API,{method:'POST',body:fd}).then(r=>r.json()).then(d=>{if(d.ok){closeModal('deleteModal');selected.delete(parseInt(id));loadPhotos();toast('Photo deleted.');updateBulkBar();}});
        });

        /* ── Bulk Delete ──────────────────────────────────── */
        $('btnBulkDelete').addEventListener('click', () => { $('bulkDeleteCount').textContent=selected.size; openModal('bulkDeleteModal'); });
        ['closeBulkDelete','cancelBulkDelete'].forEach(id => $(id).addEventListener('click', () => closeModal('bulkDeleteModal')));
        $('confirmBulkDelete').addEventListener('click', () => {
            const fd = new FormData();
            fd.append('action','bulk_delete'); fd.append('ids',JSON.stringify([...selected]));
            fetch(API,{method:'POST',body:fd}).then(r=>r.json()).then(d=>{if(d.ok){selected.clear();closeModal('bulkDeleteModal');loadPhotos();updateBulkBar();toast(`${d.deleted||'Selected'} photos deleted.`);}});
        });

        /* ── View toggle ──────────────────────────────────── */
        $('viewGrid').addEventListener('click', () => { viewMode='grid'; $('viewGrid').classList.add('active'); $('viewList').classList.remove('active'); renderPhotos(); });
        $('viewList').addEventListener('click', () => { viewMode='list'; $('viewList').classList.add('active'); $('viewGrid').classList.remove('active'); renderPhotos(); });

        /* ── Filters ──────────────────────────────────────── */
        $('filterYear').addEventListener('change', function() { currentYear=this.value; applyFilter(); });
        $('searchInput').addEventListener('input', function() { searchTerm=this.value.trim().toLowerCase(); applyFilter(); });

        /* ── Sidebar ──────────────────────────────────────── */
        (function() {
            const sidebar  = $('sidebar'), overlay = $('sidebarOverlay');
            const menuBtn  = $('menuToggle'), closeBtn = $('closeSidebar');
            function open()  { sidebar.classList.add('open');    overlay.classList.add('active');    document.body.style.overflow='hidden'; }
            function close() { sidebar.classList.remove('open'); overlay.classList.remove('active'); document.body.style.overflow=''; }
            menuBtn?.addEventListener('click', open);
            closeBtn?.addEventListener('click', close);
            overlay?.addEventListener('click', close);
        })();

        /* ── Escape closes modals ─────────────────────────── */
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') ['uploadModal','editModal','deleteModal','bulkDeleteModal'].forEach(closeModal);
        });

        /* ── Init ─────────────────────────────────────────── */
        yearOptions('upYear',   new Date().getFullYear());
        yearOptions('editYear', new Date().getFullYear());
        loadPhotos();

    })();
    </script>
</body>
</html>

