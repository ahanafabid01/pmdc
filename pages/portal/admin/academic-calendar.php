<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Calendar | PMDC Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/teacher.css">
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
            <a href="index.php" class="nav-item"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
            <a href="students.php" class="nav-item"><i class="fas fa-users"></i><span>Students</span></a>
            <a href="teacher.php" class="nav-item"><i class="fas fa-chalkboard-teacher"></i><span>Teachers &amp; Staff</span></a>
            <a href="gallery.php" class="nav-item"><i class="fas fa-images"></i><span>Gallery</span></a>
            <a href="academics.php" class="nav-item"><i class="fas fa-book-open"></i><span>Academics</span></a>
            <div class="nav-divider"></div>
            <span class="nav-section-label">Management</span>
            <a href="academic-calendar.php" class="nav-item active"><i class="fas fa-calendar-alt"></i><span>Academic Calendar</span></a>
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

    <!-- Main -->
    <main class="main-content">
        <header class="top-header">
            <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
            <div class="th-breadcrumb">
                <a href="index.php">Dashboard</a>
                <i class="fas fa-chevron-right"></i>
                <span>Academic Calendar</span>
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
                    <h1>Academic Calendar</h1>
                    <p>One calendar file (image or PDF) per academic year, shown on the public website</p>
                </div>
                <div class="tm-header-actions">
                    <a href="../../../pages/academic-calendar.php" target="_blank" class="btn-preview">
                        <i class="fas fa-external-link-alt"></i> Preview Public Page
                    </a>
                    <button class="btn-add-staff" id="btnUpload">
                        <i class="fas fa-upload"></i> Upload Calendar
                    </button>
                </div>
            </div>

            <!-- Info banner -->
            <div style="display:flex;align-items:center;gap:12px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:13px 18px;font-size:.85rem;color:#1e40af;font-family:'Inter',sans-serif;">
                <i class="fas fa-info-circle" style="font-size:1rem;flex-shrink:0;"></i>
                <span>Each academic year holds <strong>exactly one</strong> calendar file. Uploading for an existing year automatically replaces the old file.</span>
            </div>

            <!-- Calendar table -->
            <div class="tm-card" id="calCard">
                <div class="tm-table-wrap">
                    <table class="tm-table" id="calTable">
                        <thead>
                            <tr>
                                <th width="80">Year</th>
                                <th width="100">Preview</th>
                                <th>File</th>
                                <th width="80">Type</th>
                                <th width="150">Uploaded</th>
                                <th width="110">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="calBody">
                            <tr>
                                <td colspan="6" style="text-align:center;padding:40px;color:#94a3b8;">
                                    <i class="fas fa-circle-notch fa-spin" style="font-size:1.4rem;"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- ══ UPLOAD MODAL ══════════════════════════════════════ -->
    <div class="tm-modal-overlay" id="uploadModal">
        <div class="tm-modal tm-modal-sm">
            <div class="tm-modal-header">
                <h2><i class="fas fa-calendar-alt"></i> Upload Calendar</h2>
                <button class="tm-modal-close" id="closeUpload"><i class="fas fa-times"></i></button>
            </div>
            <div class="tm-modal-body">

                <div class="tm-form-group" style="margin-bottom:18px;">
                    <label for="upYear">Academic Year <span class="req">*</span></label>
                    <select id="upYear"></select>
                </div>

                <!-- Drop zone -->
                <div id="dropZone" style="
                    border:2px dashed var(--border); border-radius:var(--radius);
                    padding:36px 20px; text-align:center; cursor:pointer;
                    background:var(--bg); transition:border-color var(--transition),background var(--transition);
                ">
                    <i class="fas fa-cloud-upload-alt" id="dzIcon" style="font-size:2.2rem;color:var(--text-light);display:block;margin-bottom:12px;transition:color var(--transition),transform var(--transition);"></i>
                    <p style="font-size:.9rem;color:var(--text);margin-bottom:4px;font-weight:500;">
                        Drag &amp; drop here, or <label for="fileInput" style="color:var(--blue);font-weight:700;cursor:pointer;text-decoration:underline;text-underline-offset:2px;">browse</label>
                    </p>
                    <p style="font-size:.75rem;color:var(--muted);">JPG, PNG, WEBP or PDF &nbsp;·&nbsp; Max 10 MB</p>
                    <input type="file" id="fileInput" accept=".jpg,.jpeg,.png,.webp,.pdf" style="display:none;">
                </div>

                <!-- Selected file preview -->
                <div id="filePreview" style="display:none;margin-top:16px;">
                    <div style="display:flex;align-items:center;gap:12px;background:var(--bg);border:1px solid var(--border);border-radius:10px;padding:12px 14px;">
                        <div id="prevIcon" style="width:42px;height:42px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;"></div>
                        <div style="flex:1;min-width:0;">
                            <div id="prevName" style="font-weight:600;font-size:.85rem;color:var(--text);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"></div>
                            <div id="prevSize" style="font-size:.75rem;color:var(--muted);margin-top:2px;"></div>
                        </div>
                        <button id="clearFile" style="background:none;border:none;color:var(--red);cursor:pointer;font-size:.85rem;padding:4px;" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Replace warning -->
                <div id="replaceWarn" style="display:none;margin-top:14px;padding:10px 14px;background:#fffbeb;border:1px solid #fde68a;border-radius:8px;font-size:.82rem;color:#92400e;font-family:'Inter',sans-serif;">
                    <i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>
                    A calendar already exists for this year. Uploading will <strong>replace</strong> it.
                </div>

                <!-- Progress -->
                <div id="uploadProgress" style="display:none;margin-top:16px;">
                    <div style="height:7px;background:var(--border);border-radius:10px;overflow:hidden;margin-bottom:8px;">
                        <div id="upBar" style="height:100%;width:0%;background:linear-gradient(90deg,var(--blue),#60a5fa);border-radius:10px;transition:width .3s ease;"></div>
                    </div>
                    <p id="upStatus" style="font-size:.8rem;color:var(--muted);text-align:center;font-weight:500;font-family:'Inter',sans-serif;">Uploading…</p>
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

    <!-- ══ DELETE CONFIRM ════════════════════════════════════ -->
    <div class="tm-modal-overlay" id="deleteModal">
        <div class="tm-modal tm-modal-sm">
            <div class="tm-modal-header">
                <h2><i class="fas fa-trash-alt" style="color:var(--red);"></i> Delete Calendar</h2>
                <button class="tm-modal-close" id="closeDelete"><i class="fas fa-times"></i></button>
            </div>
            <div class="tm-modal-body">
                <p style="font-size:.925rem;color:#475569;font-family:'Inter',sans-serif;line-height:1.6;">
                    Delete the <strong id="deleteYearLabel"></strong> calendar?
                    It will be removed from the public website immediately.
                </p>
                <p class="del-warn">This action cannot be undone.</p>
                <input type="hidden" id="deleteYear">
            </div>
            <div class="tm-modal-footer">
                <button class="btn-cancel" id="cancelDelete">Cancel</button>
                <button class="btn-delete-confirm" id="confirmDelete">
                    <i class="fas fa-trash-alt"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div class="tm-toast" id="acToast"></div>

    <script>
    (function () {
        'use strict';

        const API  = 'api/academic-calendar.php';
        const BASE = '../../../uploads/academic-calendar/';
        const $    = id => document.getElementById(id);

        let calendars  = [];   // loaded data
        let uploadFile = null; // selected File object

        /* ── Toast ────────────────────────────────────────── */
        function toast(msg, type = 'success') {
            const el = $('acToast');
            el.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${msg}`;
            el.className = `tm-toast ${type} show`;
            setTimeout(() => el.classList.remove('show'), 3200);
        }

        /* ── Modal helpers ────────────────────────────────── */
        function openModal(id)  { $(id).classList.add('active'); }
        function closeModal(id) { $(id).classList.remove('active'); }

        /* ── Year select ──────────────────────────────────── */
        function buildYearSelect(selId, selected) {
            const sel = $(selId); sel.innerHTML = '';
            const cur = new Date().getFullYear();
            for (let y = cur + 1; y >= 2018; y--) {
                const o = document.createElement('option');
                o.value = y; o.textContent = `${y}–${y+1}`;
                if (y === selected) o.selected = true;
                sel.appendChild(o);
            }
        }

        /* ── Format file size ─────────────────────────────── */
        function fmtSize(bytes) {
            if (bytes < 1024)       return bytes + ' B';
            if (bytes < 1048576)    return (bytes/1024).toFixed(1) + ' KB';
            return (bytes/1048576).toFixed(1) + ' MB';
        }

        /* ── Format date ──────────────────────────────────── */
        function fmtDate(d) {
            if (!d) return '—';
            return new Date(d).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' });
        }

        /* ── Load calendars ───────────────────────────────── */
        function load() {
            fetch(API + '?action=list')
                .then(r => r.json())
                .then(data => { calendars = data.calendars || []; render(); })
                .catch(() => { calendars = []; render(); });
        }

        /* ── Render table ─────────────────────────────────── */
        function render() {
            const body = $('calBody');
            if (!calendars.length) {
                body.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align:center;padding:56px 20px;">
                            <i class="fas fa-calendar-times" style="font-size:2.2rem;color:#d1d5db;display:block;margin-bottom:12px;"></i>
                            <p style="color:#94a3b8;font-size:.92rem;">No calendars uploaded yet.</p>
                        </td>
                    </tr>`;
                return;
            }

            body.innerHTML = calendars.map(c => {
                const isPdf   = c.file_type === 'pdf';
                const fileUrl = BASE + encodeURIComponent(c.filename);
                const preview = isPdf
                    ? `<div style="width:48px;height:48px;background:#fef2f2;border-radius:9px;display:flex;align-items:center;justify-content:center;color:#dc2626;font-size:1.2rem;border:1.5px solid #fecaca;"><i class="fas fa-file-pdf"></i></div>`
                    : `<a href="${fileUrl}" target="_blank"><img src="${fileUrl}" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:9px;border:1.5px solid #e2e8f0;display:block;transition:transform .2s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'"></a>`;

                const typeBadge = isPdf
                    ? `<span style="display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:.7rem;font-weight:700;background:#fef2f2;color:#dc2626;"><i class="fas fa-file-pdf"></i> PDF</span>`
                    : `<span style="display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:.7rem;font-weight:700;background:#dbeafe;color:#1e40af;"><i class="fas fa-image"></i> Image</span>`;

                return `<tr>
                    <td style="font-weight:800;color:#1e293b;font-size:.95rem;">${c.year}–${parseInt(c.year)+1}</td>
                    <td>${preview}</td>
                    <td>
                        <a href="${fileUrl}" target="_blank" style="color:var(--blue);font-weight:600;font-size:.85rem;word-break:break-all;" title="Open file">
                            <i class="fas fa-external-link-alt" style="font-size:.72rem;margin-right:4px;"></i>${c.filename}
                        </a>
                    </td>
                    <td>${typeBadge}</td>
                    <td style="color:#64748b;font-size:.82rem;">${fmtDate(c.uploaded_at || c.updated_at)}</td>
                    <td>
                        <div class="tm-row-actions">
                            <button class="btn-edit" onclick="replaceCalendar(${c.year})" title="Replace file"><i class="fas fa-retweet"></i></button>
                            <button class="btn-del"  onclick="deleteCalendar(${c.year},'${c.year}–${parseInt(c.year)+1}')" title="Delete"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>`;
            }).join('');
        }

        /* ── Upload Modal ─────────────────────────────────── */
        function openUploadModal(presetYear) {
            uploadFile = null;
            $('fileInput').value = '';
            $('filePreview').style.display    = 'none';
            $('replaceWarn').style.display    = 'none';
            $('uploadProgress').style.display = 'none';
            $('submitUpload').disabled        = true;
            buildYearSelect('upYear', presetYear || new Date().getFullYear());
            checkReplaceWarn();
            openModal('uploadModal');
        }

        $('btnUpload').addEventListener('click', () => openUploadModal());
        window.replaceCalendar = year => openUploadModal(year);

        ['closeUpload','cancelUpload'].forEach(id => $(id).addEventListener('click', () => closeModal('uploadModal')));

        $('upYear').addEventListener('change', checkReplaceWarn);

        function checkReplaceWarn() {
            const yr   = parseInt($('upYear').value);
            const has  = calendars.some(c => parseInt(c.year) === yr);
            $('replaceWarn').style.display = has ? '' : 'none';
        }

        /* Drop zone */
        const dz = $('dropZone');
        dz.addEventListener('click', () => $('fileInput').click());
        dz.addEventListener('dragover',  e => { e.preventDefault(); dz.style.borderColor='var(--blue)'; dz.style.background='var(--blue-light)'; $('dzIcon').style.color='var(--blue)'; $('dzIcon').style.transform='translateY(-4px)'; });
        dz.addEventListener('dragleave', () => resetDz());
        dz.addEventListener('drop', e => { e.preventDefault(); resetDz(); handleFile(e.dataTransfer.files[0]); });
        $('fileInput').addEventListener('change', e => handleFile(e.target.files[0]));
        function resetDz() { dz.style.borderColor=''; dz.style.background=''; $('dzIcon').style.color=''; $('dzIcon').style.transform=''; }

        function handleFile(f) {
            if (!f) return;
            uploadFile = f;
            const isPdf = f.type === 'application/pdf';
            $('prevIcon').style.cssText = isPdf
                ? 'background:#fef2f2;color:#dc2626;width:42px;height:42px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;'
                : 'background:#dbeafe;color:#1e40af;width:42px;height:42px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;';
            $('prevIcon').innerHTML = isPdf ? '<i class="fas fa-file-pdf"></i>' : '<i class="fas fa-image"></i>';
            $('prevName').textContent = f.name;
            $('prevSize').textContent = fmtSize(f.size);
            $('filePreview').style.display = '';
            $('submitUpload').disabled      = false;
        }

        $('clearFile').addEventListener('click', () => {
            uploadFile = null; $('fileInput').value = '';
            $('filePreview').style.display = 'none';
            $('submitUpload').disabled     = true;
        });

        /* Submit upload */
        $('submitUpload').addEventListener('click', () => {
            if (!uploadFile) return;
            const fd = new FormData();
            fd.append('action', 'upload');
            fd.append('year',   $('upYear').value);
            fd.append('file',   uploadFile);

            $('uploadProgress').style.display = '';
            $('submitUpload').disabled = true;
            $('upBar').style.width = '0%';

            const xhr = new XMLHttpRequest(); xhr.open('POST', API);
            xhr.upload.onprogress = e => { if (e.lengthComputable) $('upBar').style.width = Math.round(e.loaded/e.total*100)+'%'; };
            xhr.onload = () => {
                $('upBar').style.width = '100%';
                try {
                    const d = JSON.parse(xhr.responseText);
                    if (d.ok) {
                        $('upStatus').textContent = '✓ Uploaded!';
                        setTimeout(() => { closeModal('uploadModal'); load(); toast('Calendar uploaded successfully.'); }, 800);
                    } else {
                        $('upStatus').textContent = 'Error: ' + (d.msg || 'Upload failed.');
                        $('submitUpload').disabled = false;
                    }
                } catch(e) { $('upStatus').textContent = 'Server error.'; $('submitUpload').disabled = false; }
            };
            xhr.onerror = () => { $('upStatus').textContent = 'Network error.'; $('submitUpload').disabled = false; };
            xhr.send(fd);
        });

        /* ── Delete ───────────────────────────────────────── */
        window.deleteCalendar = function(year, label) {
            $('deleteYear').value       = year;
            $('deleteYearLabel').textContent = label + ' academic year';
            openModal('deleteModal');
        };
        ['closeDelete','cancelDelete'].forEach(id => $(id).addEventListener('click', () => closeModal('deleteModal')));
        $('confirmDelete').addEventListener('click', () => {
            const yr = $('deleteYear').value;
            const fd = new FormData(); fd.append('action','delete'); fd.append('year', yr);
            fetch(API, {method:'POST', body:fd}).then(r=>r.json()).then(d => {
                if (d.ok) { closeModal('deleteModal'); load(); toast('Calendar deleted.'); }
                else       toast('Failed to delete.', 'error');
            });
        });

        /* ── Sidebar ──────────────────────────────────────── */
        const sidebar = $('sidebar'), overlay = $('sidebarOverlay');
        function open()  { sidebar.classList.add('open');    overlay.classList.add('active');    document.body.style.overflow='hidden'; }
        function close() { sidebar.classList.remove('open'); overlay.classList.remove('active'); document.body.style.overflow=''; }
        $('menuToggle')?.addEventListener('click', open);
        $('closeSidebar')?.addEventListener('click', close);
        overlay?.addEventListener('click', close);

        /* ── Escape ───────────────────────────────────────── */
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') ['uploadModal','deleteModal'].forEach(closeModal);
        });

        /* ── Init ─────────────────────────────────────────── */
        load();
    })();
    </script>
</body>
</html>


