<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academics | PMDC Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/teacher.css">
    <link rel="stylesheet" href="css/academics.css">
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
            <a href="#" class="nav-item"><i class="fas fa-users"></i><span>Students</span><span class="badge">450</span></a>
            <a href="teacher.php" class="nav-item"><i class="fas fa-chalkboard-teacher"></i><span>Teachers &amp; Staff</span></a>
            <a href="gallery.php" class="nav-item"><i class="fas fa-images"></i><span>Gallery</span></a>
            <a href="academics.php" class="nav-item active"><i class="fas fa-book-open"></i><span>Academics</span></a>
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

    <!-- Main -->
    <main class="main-content">
        <header class="top-header">
            <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
            <div class="th-breadcrumb">
                <a href="index.php">Dashboard</a>
                <i class="fas fa-chevron-right"></i>
                <span>Academics</span>
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
                    <h1>Academics</h1>
                    <p>Manage HSC groups and Degree programs — subjects, curriculum, and structure</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="tm-stats-row" id="statsRow">
                <div class="tm-stat-pill">
                    <i class="fas fa-school" style="color:var(--blue);font-size:1rem;flex-shrink:0;"></i>
                    <span class="ts-val" id="statHsc">0</span>
                    <span class="ts-lbl">HSC Groups</span>
                </div>
                <div class="tm-stat-pill">
                    <i class="fas fa-university" style="color:#7c3aed;font-size:1rem;flex-shrink:0;"></i>
                    <span class="ts-val" id="statDeg">0</span>
                    <span class="ts-lbl">Degree Programs</span>
                </div>
                <div class="tm-stat-pill">
                    <i class="fas fa-book" style="color:var(--green);font-size:1rem;flex-shrink:0;"></i>
                    <span class="ts-val" id="statSubjects">0</span>
                    <span class="ts-lbl">Total Subjects</span>
                </div>
            </div>

            <!-- ── HSC Programs Table ── -->
            <div class="ac-section-label">
                <div class="ac-sl-left">
                    <div class="ac-sl-icon" style="background:#eff6ff;color:#2563eb;"><i class="fas fa-school"></i></div>
                    <div>
                        <div class="ac-sl-title">HSC Program</div>
                        <div class="ac-sl-sub">Higher Secondary Certificate · Dhaka Education Board · 2 Years</div>
                    </div>
                </div>
                <button class="btn-add-staff" id="btnAddHsc">
                    <i class="fas fa-plus"></i> Add Group
                </button>
            </div>

            <div class="tm-card ac-table-card">
                <div class="tm-table-wrap">
                    <table class="tm-table" id="hscTable">
                        <thead>
                            <tr>
                                <th width="36">#</th>
                                <th>Group Name</th>
                                <th>Bengali</th>
                                <th width="90" class="text-center">Compulsory</th>
                                <th width="90" class="text-center">Optional</th>
                                <th width="90" class="text-center">4th Subject</th>
                                <th width="110">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="hscTbody"></tbody>
                    </table>
                </div>
                <div class="ac-empty" id="hscEmpty" style="display:none;">
                    <i class="fas fa-school"></i>
                    <p>No HSC groups yet</p>
                    <button class="btn-add-staff" onclick="openModal('hsc')"><i class="fas fa-plus"></i> Add Group</button>
                </div>
            </div>

            <!-- ── Degree Programs Table ── -->
            <div class="ac-section-label" style="margin-top:8px;">
                <div class="ac-sl-left">
                    <div class="ac-sl-icon" style="background:#faf5ff;color:#7c3aed;"><i class="fas fa-university"></i></div>
                    <div>
                        <div class="ac-sl-title">Degree Program</div>
                        <div class="ac-sl-sub">BA / BSS / BSc / BMT · National University · 3 Years</div>
                    </div>
                </div>
                <button class="btn-add-staff" id="btnAddDeg">
                    <i class="fas fa-plus"></i> Add Program
                </button>
            </div>

            <div class="tm-card ac-table-card">
                <div class="tm-table-wrap">
                    <table class="tm-table" id="degTable">
                        <thead>
                            <tr>
                                <th width="36">#</th>
                                <th>Program</th>
                                <th>Full Name</th>
                                <th>Bengali</th>
                                <th width="100" class="text-center">Compulsory</th>
                                <th width="100" class="text-center">Optional</th>
                                <th width="110">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="degTbody"></tbody>
                    </table>
                </div>
                <div class="ac-empty" id="degEmpty" style="display:none;">
                    <i class="fas fa-university"></i>
                    <p>No Degree programs yet</p>
                    <button class="btn-add-staff" onclick="openModal('degree')"><i class="fas fa-plus"></i> Add Program</button>
                </div>
            </div>

        </div><!-- /content-area -->
    </main>

    <!-- Toast -->
    <div class="tm-toast" id="acToast"></div>

    <!-- ══ ADD / EDIT MODAL ══════════════════════════════════ -->
    <div class="tm-modal-overlay" id="acModalOverlay">
        <div class="tm-modal ac-modal" id="acModal" role="dialog" aria-modal="true">
            <div class="tm-modal-header">
                <h2 id="acModalTitle"><i class="fas fa-book-open"></i> Add Program</h2>
                <button class="tm-modal-close" id="acModalClose"><i class="fas fa-times"></i></button>
            </div>
            <div class="tm-modal-body">
                <form id="acForm" novalidate>
                    <input type="hidden" id="acEditId">
                    <input type="hidden" id="acEditType">

                    <!-- Row 1: Name + Bengali -->
                    <div class="ac-form-row">
                        <div class="tm-form-group">
                            <label for="fName">Group / Program Name <span class="req">*</span></label>
                            <input type="text" id="fName" placeholder="e.g. Science, BA">
                            <span class="ac-err" id="errName"></span>
                        </div>
                        <div class="tm-form-group" id="fFullWrap">
                            <label for="fFull">Full Name <span class="req">*</span></label>
                            <input type="text" id="fFull" placeholder="e.g. Bachelor of Arts">
                            <span class="ac-err" id="errFull"></span>
                        </div>
                    </div>

                    <!-- Bengali -->
                    <div class="tm-form-group">
                        <label for="fBengali">Bengali Name <span class="req">*</span></label>
                        <input type="text" id="fBengali" placeholder="e.g. বিজ্ঞান শাখা">
                        <span class="ac-err" id="errBengali"></span>
                    </div>

                    <!-- Accent color + Icon -->
                    <div class="ac-form-row">
                        <div class="tm-form-group">
                            <label>Accent Color</label>
                            <div class="ac-color-row">
                                <input type="color" id="fColor" value="#2563eb" class="ac-color-input">
                                <div class="ac-color-presets">
                                    <button type="button" class="ac-preset" data-color="#2563eb" style="background:#2563eb;" title="Blue"></button>
                                    <button type="button" class="ac-preset" data-color="#7c3aed" style="background:#7c3aed;" title="Purple"></button>
                                    <button type="button" class="ac-preset" data-color="#059669" style="background:#059669;" title="Green"></button>
                                    <button type="button" class="ac-preset" data-color="#d97706" style="background:#d97706;" title="Amber"></button>
                                    <button type="button" class="ac-preset" data-color="#dc2626" style="background:#dc2626;" title="Red"></button>
                                    <button type="button" class="ac-preset" data-color="#0891b2" style="background:#0891b2;" title="Cyan"></button>
                                </div>
                            </div>
                        </div>
                        <div class="tm-form-group">
                            <label for="fIcon">Icon (FontAwesome class)</label>
                            <div class="ac-icon-row">
                                <input type="text" id="fIcon" value="fas fa-book" placeholder="fas fa-book">
                                <span class="ac-icon-preview"><i id="fIconPreview" class="fas fa-book"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Compulsory Subjects -->
                    <div class="tm-form-group">
                        <label for="fCompulsory">Compulsory Subjects <span class="req">*</span> <span class="ac-hint">— one per line</span></label>
                        <textarea id="fCompulsory" rows="4" placeholder="Bangla (বাংলা)&#10;English&#10;ICT (তথ্য ও যোগাযোগ প্রযুক্তি)"></textarea>
                        <span class="ac-err" id="errCompulsory"></span>
                    </div>

                    <!-- Optional Subjects -->
                    <div class="tm-form-group">
                        <label for="fOptional">Optional Subjects <span class="ac-hint">— one per line (leave blank if none)</span></label>
                        <textarea id="fOptional" rows="4" placeholder="Physics (পদার্থ বিজ্ঞান)&#10;Chemistry (রসায়ন)&#10;Biology (জীব বিজ্ঞান)"></textarea>
                    </div>

                    <!-- Optional note -->
                    <div class="tm-form-group" id="fOptNoteWrap">
                        <label for="fOptNote">Optional Subject Note</label>
                        <input type="text" id="fOptNote" placeholder="e.g. Choose any 3">
                    </div>

                    <!-- 4th Subject (HSC only) -->
                    <div id="fFourthSection">
                        <div class="tm-form-group">
                            <label for="fFourth">4th Subject Options <span class="ac-hint">— one per line</span></label>
                            <textarea id="fFourth" rows="3" placeholder="Higher Mathematics (উচ্চতর গণিত)&#10;Biology (জীব বিজ্ঞান)"></textarea>
                        </div>
                        <div class="tm-form-group">
                            <label for="fFourthNote">4th Subject Note</label>
                            <input type="text" id="fFourthNote" placeholder="e.g. Choose any 1 (optional)">
                        </div>
                    </div>

                    <!-- Degree-only: Conductor -->
                    <div class="tm-form-group" id="fConductorWrap">
                        <label for="fConductor">Conducted By</label>
                        <input type="text" id="fConductor" value="National University of Bangladesh">
                    </div>

                </form>
            </div>
            <div class="tm-modal-footer">
                <button class="btn-cancel" id="acModalCancel">Cancel</button>
                <button class="btn-save" id="acModalSave">
                    <i class="fas fa-save"></i> Save Program
                </button>
            </div>
        </div>
    </div>

    <!-- ══ DELETE CONFIRM MODAL ══════════════════════════════ -->
    <div class="tm-modal-overlay" id="acDeleteOverlay">
        <div class="tm-modal tm-modal-sm" role="dialog" aria-modal="true">
            <div class="tm-modal-header">
                <h2><i class="fas fa-trash-alt" style="color:var(--red);"></i> Delete Program</h2>
                <button class="tm-modal-close" id="acDeleteClose"><i class="fas fa-times"></i></button>
            </div>
            <div class="tm-modal-body">
                <p style="font-size:.9rem;color:#475569;line-height:1.6;font-family:'Inter',sans-serif;">
                    Are you sure you want to delete <strong id="deleteProgName">"this program"</strong>?<br>
                    This will remove all subject data associated with it.
                </p>
                <p style="font-size:.82rem;color:var(--red);font-weight:700;margin-top:10px;font-family:'Inter',sans-serif;">This action cannot be undone.</p>
            </div>
            <div class="tm-modal-footer">
                <button class="btn-cancel" id="acDeleteCancel">Cancel</button>
                <button class="btn-delete-confirm" id="acDeleteConfirm">
                    <i class="fas fa-trash-alt"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>

    <script src="js/academics.js"></script>
    <script>
    (function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        function open()  { sidebar.classList.add('open');    overlay.classList.add('active');    document.body.style.overflow='hidden'; }
        function close() { sidebar.classList.remove('open'); overlay.classList.remove('active'); document.body.style.overflow=''; }
        document.getElementById('menuToggle')?.addEventListener('click', open);
        document.getElementById('closeSidebar')?.addEventListener('click', close);
        overlay?.addEventListener('click', close);
    })();
    </script>
</body>
</html>
