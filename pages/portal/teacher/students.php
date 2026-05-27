<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students | Teacher Portal | PMDC</title>
    <meta name="description" content="Manage all HSC students at Phulpur Mohila Degree College — view, add, edit and search student profiles.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/students.css">
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ════════════════════ SIDEBAR ════════════════════ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo"><i class="fas fa-school"></i><span>PMDC</span></div>
        <div class="close-sidebar" id="closeSidebar"><i class="fas fa-times"></i></div>
    </div>
    <nav class="sidebar-nav">
        <a href="index.php"    class="nav-item"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
        <a href="students.php" class="nav-item active"><i class="fas fa-users"></i><span>Students</span></a>
        <a href="announcements.php" class="nav-item"><i class="fas fa-bullhorn"></i><span>Announcements</span></a>
        <a href="grades.php"   class="nav-item"><i class="fas fa-graduation-cap"></i><span>Results</span></a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-avatar">AB</div>
        <div class="user-info">
            <div class="user-name">Ms. Afroza Begum</div>
            <div class="user-role">Science Department</div>
        </div>
    </div>
</aside>

<!-- ════════════════════ MAIN ════════════════════ -->
<main class="main-content">
    <header class="top-header">
        <div class="header-left">
            <button class="menu-toggle" id="menuToggle" aria-label="Open menu"><i class="fas fa-bars"></i></button>
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <i class="fas fa-home"></i>
                <i class="fas fa-chevron-right sep"></i>
                <strong>Students</strong>
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

    <div class="content-area">

        <!-- ── Page Header ── -->
        <div class="page-header">
            <div class="page-header-left">
                <h1 class="page-title"><i class="fas fa-users"></i> Students (শিক্ষার্থীবৃন্দ)</h1>
                <p class="page-subtitle">Full student profiles — HSC 1st Year &amp; 2nd Year across all groups</p>
            </div>
            <div class="page-header-actions">
                <button class="btn-export" id="exportBtn"><i class="fas fa-download"></i> Export CSV</button>
                <button class="btn-primary-action" id="addStudentBtn">
                    <i class="fas fa-user-plus"></i> Add Student
                </button>
            </div>
        </div>

        <!-- ── Summary Stats ── -->
        <div class="student-stats-row">
            <div class="sstat-card">
                <i class="fas fa-users sstat-icon" style="color:#3182ce;"></i>
                <div><div class="sstat-val" id="statTotal">120</div><div class="sstat-lbl">Total Students</div></div>
            </div>
            <div class="sstat-card">
                <i class="fas fa-flask sstat-icon" style="color:#38a169;"></i>
                <div><div class="sstat-val" id="statSci">40</div><div class="sstat-lbl">Science</div></div>
            </div>
            <div class="sstat-card">
                <i class="fas fa-briefcase sstat-icon" style="color:#d69e2e;"></i>
                <div><div class="sstat-val" id="statCom">40</div><div class="sstat-lbl">Business Studies</div></div>
            </div>
            <div class="sstat-card">
                <i class="fas fa-book sstat-icon" style="color:#805ad5;"></i>
                <div><div class="sstat-val" id="statHum">40</div><div class="sstat-lbl">Humanities</div></div>
            </div>
        </div>

        <div class="card filter-bar-card">
            <div class="filter-bar">
                <div class="filter-search">
                    <i class="fas fa-search"></i>
                    <input type="text" id="studentSearch" placeholder="Search by name, roll, or registration number...">
                </div>
                <div class="filter-group">
                    <label>Session (শিক্ষাবর্ষ)</label>
                    <select id="sessionFilter" class="filter-select">
                        <option value="">All Sessions</option>
                        <option value="2022–2023">2022–2023</option>
                        <option value="2023–2024">2023–2024</option>
                        <option value="2024–2025">2024–2025</option>
                        <option value="2025–2026">2025–2026</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Year</label>
                    <select id="yearFilter" class="filter-select">
                        <option value="">All Years</option>
                        <option value="xi">HSC 1st Year (একাদশ)</option>
                        <option value="xii">HSC 2nd Year (দ্বাদশ)</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Group (বিভাগ)</label>
                    <select id="groupFilter" class="filter-select">
                        <option value="">All Groups</option>
                        <option value="science">বিজ্ঞান (Science)</option>
                        <option value="commerce">ব্যবসায় শিক্ষা (Business Studies)</option>
                        <option value="humanities">মানবিক (Humanities)</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Section</label>
                    <select id="sectionFilter" class="filter-select">
                        <option value="">All Sections</option>
                        <option value="A">Section A</option>
                        <option value="B">Section B</option>
                        <option value="C">Section C</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Sort</label>
                    <select id="sortFilter" class="filter-select">
                        <option value="name">Name (A–Z)</option>
                        <option value="roll">Roll Number</option>
                        <option value="recent">Recently Added</option>
                    </select>
                </div>
            </div>
        </div>


        <!-- ── View Toggle + Bulk Actions ── -->
        <div class="table-toolbar">
            <div class="toolbar-left">
                <div class="bulk-actions" id="bulkActions" style="display:none;">
                    <span id="selectedCount">0 selected</span>
                    <button class="bulk-btn" id="bulkDelete"><i class="fas fa-trash"></i> Delete</button>
                    <button class="bulk-btn" id="bulkExport"><i class="fas fa-download"></i> Export</button>
                </div>
            </div>
            <div class="toolbar-right">
                <button class="view-toggle-btn active" id="tableViewBtn" title="Table view">
                    <i class="fas fa-list"></i>
                </button>
                <button class="view-toggle-btn" id="gridViewBtn" title="Card view">
                    <i class="fas fa-th-large"></i>
                </button>
            </div>
        </div>

        <!-- ── Table View ── -->
        <div class="card" id="tableView">
            <div class="table-responsive">
                <table class="students-table" id="studentsTable">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th class="sortable" data-col="id">Roll No <i class="fas fa-sort"></i></th>
                            <th class="sortable" data-col="name">Student Name <i class="fas fa-sort"></i></th>
                            <th>Session</th>
                            <th>Group (বিভাগ)</th>
                            <th>Year</th>
                            <th>Section</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody id="studentsTableBody">
                        <!-- JS populated -->
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <div class="table-info" id="tableInfo">Loading…</div>
                <div class="pagination" id="pagination"></div>
            </div>
        </div>

        <!-- ── Grid / Card View ── -->
        <div id="gridView" class="student-grid" style="display:none;"></div>

    </div>
</main>

<!-- ════════════════════ STUDENT DETAIL MODAL ════════════════════ -->
<div class="modal-overlay" id="studentModal">
    <div class="modal-box modal-xl">
        <div class="modal-header">
            <h2 id="modalTitle"><i class="fas fa-user"></i> Student Profile</h2>
            <button class="modal-close" id="closeStudentModal"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body" id="studentModalBody">
            <!-- JS populated -->
        </div>
    </div>
</div>

<!-- ════════════════════ ADD / EDIT STUDENT MODAL ════════════════════ -->
<div class="modal-overlay" id="addEditModal">
    <div class="modal-box modal-xl">
        <div class="modal-header">
            <h2 id="addEditTitle"><i class="fas fa-user-plus"></i> Add Student</h2>
            <button class="modal-close" id="closeAddEdit"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <form id="studentForm" novalidate>
                <input type="hidden" id="editStudentId">

                <!-- ── Section Tabs ── -->
                <div class="form-tabs">
                    <button type="button" class="ftab active" data-section="academic">
                        <i class="fas fa-graduation-cap"></i> Academic
                    </button>
                    <button type="button" class="ftab" data-section="personal">
                        <i class="fas fa-id-card"></i> Personal
                    </button>
                    <button type="button" class="ftab" data-section="contact">
                        <i class="fas fa-phone"></i> Contact
                    </button>
                    <button type="button" class="ftab" data-section="guardian">
                        <i class="fas fa-users"></i> Guardian / Parents
                    </button>
                    <button type="button" class="ftab" data-section="photo">
                        <i class="fas fa-camera"></i> Photo
                    </button>
                </div>

                <!-- ══ SECTION 1: ACADEMIC INFO ══ -->
                <div class="form-section active" id="section-academic">
                    <div class="form-section-title"><i class="fas fa-graduation-cap"></i> Academic Information</div>
                    <div class="form-grid">
                        <div class="form-group req">
                            <label for="fname">Full Name <span class="req-star">*</span></label>
                            <input type="text" id="fname" placeholder="e.g. Fatema Begum" required>
                            <span class="err" id="err-fname"></span>
                        </div>
                        <div class="form-group req">
                            <label for="roll">Roll Number <span class="req-star">*</span></label>
                            <input type="text" id="roll" placeholder="e.g. PMDC-XI-001" required>
                            <span class="err" id="err-roll"></span>
                        </div>
                        <div class="form-group">
                            <label for="regno">Registration Number</label>
                            <input type="text" id="regno" placeholder="e.g. 202412345678">
                        </div>
                        <div class="form-group req">
                            <label for="hscYear">HSC Year <span class="req-star">*</span></label>
                            <select id="hscYear" required>
                                <option value="">Select Year</option>
                                <option value="xi">HSC 1st Year (একাদশ শ্রেণি)</option>
                                <option value="xii">HSC 2nd Year (দ্বাদশ শ্রেণি)</option>
                            </select>
                            <span class="err" id="err-hscYear"></span>
                        </div>
                        <div class="form-group req">
                            <label for="group">Academic Group <span class="req-star">*</span></label>
                            <select id="group" required>
                                <option value="">Select Group</option>
                                <option value="science">বিজ্ঞান (Science)</option>
                                <option value="commerce">ব্যবসায় শিক্ষা (Business Studies)</option>
                                <option value="humanities">মানবিক (Humanities)</option>
                            </select>
                            <span class="err" id="err-group"></span>
                        </div>
                        <div class="form-group">
                            <label for="section">Section</label>
                            <select id="section">
                                <option value="">Select Section</option>
                                <option value="A">Section A</option>
                                <option value="B">Section B</option>
                                <option value="C">Section C</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="session">Session (শিক্ষাবর্ষ)</label>
                            <input type="text" id="session" placeholder="e.g. 2024–2025">
                        </div>
                        <div class="form-group">
                            <label for="institution">College / Institution Name</label>
                            <input type="text" id="institution" value="Phulpur Mohila Degree College">
                        </div>
                    </div>
                </div>

                <!-- ══ SECTION 2: PERSONAL INFO ══ -->
                <div class="form-section" id="section-personal">
                    <div class="form-section-title"><i class="fas fa-id-card"></i> Personal Information</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" id="dob">
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender">
                                <option value="">Select</option>
                                <option value="female">Female (মহিলা)</option>
                                <option value="male">Male (পুরুষ)</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="religion">Religion (ধর্ম)</label>
                            <select id="religion">
                                <option value="">Select</option>
                                <option value="islam">Islam (ইসলাম)</option>
                                <option value="hinduism">Hinduism (হিন্দু)</option>
                                <option value="christianity">Christianity (খ্রিষ্টান)</option>
                                <option value="buddhism">Buddhism (বৌদ্ধ)</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bloodGroup">Blood Group (রক্তের গ্রুপ)</label>
                            <select id="bloodGroup">
                                <option value="">Select (Optional)</option>
                                <option>A+</option><option>A-</option>
                                <option>B+</option><option>B-</option>
                                <option>AB+</option><option>AB-</option>
                                <option>O+</option><option>O-</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nid">National ID (NID) <small>10 or 17 digits</small></label>
                            <input type="text" id="nid" placeholder="For students 18+" maxlength="17">
                            <span class="err" id="err-nid"></span>
                        </div>
                        <div class="form-group">
                            <label for="birthCert">Birth Certificate No.</label>
                            <input type="text" id="birthCert" placeholder="For students under 18">
                        </div>
                    </div>
                </div>

                <!-- ══ SECTION 3: CONTACT INFO ══ -->
                <div class="form-section" id="section-contact">
                    <div class="form-section-title"><i class="fas fa-phone"></i> Contact Information</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="phone">Student Phone <small>01XXXXXXXXX</small></label>
                            <input type="tel" id="phone" placeholder="01XXXXXXXXX" maxlength="11">
                            <span class="err" id="err-phone"></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Student Email (Optional)</label>
                            <input type="email" id="email" placeholder="student@example.com">
                        </div>
                        <div class="form-group form-full">
                            <label for="presentAddr">Present Address (বর্তমান ঠিকানা)</label>
                            <textarea id="presentAddr" rows="2" placeholder="Village / Moholla, Upazila, District"></textarea>
                        </div>
                        <div class="form-group form-full">
                            <label for="permanentAddr">Permanent Address (স্থায়ী ঠিকানা)</label>
                            <textarea id="permanentAddr" rows="2" placeholder="Village / Moholla, Upazila, District"></textarea>
                            <label style="margin-top:6px;">
                                <input type="checkbox" id="sameAddress"> Same as present address
                            </label>
                        </div>
                    </div>
                </div>

                <!-- ══ SECTION 4: GUARDIAN / PARENTS ══ -->
                <div class="form-section" id="section-guardian">
                    <div class="form-section-title"><i class="fas fa-users"></i> Parent &amp; Guardian Information</div>

                    <div class="guardian-subsection">
                        <div class="gsub-title"><i class="fas fa-male"></i> Father's Information (পিতার তথ্য)</div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="fatherName">Father's Full Name</label>
                                <input type="text" id="fatherName" placeholder="Full name">
                            </div>
                            <div class="form-group">
                                <label for="fatherNid">Father's NID Number</label>
                                <input type="text" id="fatherNid" placeholder="10 or 17 digits" maxlength="17">
                                <span class="err" id="err-fatherNid"></span>
                            </div>
                            <div class="form-group">
                                <label for="fatherPhone">Father's Phone</label>
                                <input type="tel" id="fatherPhone" placeholder="01XXXXXXXXX" maxlength="11">
                                <span class="err" id="err-fatherPhone"></span>
                            </div>
                            <div class="form-group">
                                <label for="fatherOcc">Father's Occupation</label>
                                <input type="text" id="fatherOcc" placeholder="e.g. Farmer, Business, Govt. Employee">
                            </div>
                        </div>
                    </div>

                    <div class="guardian-subsection">
                        <div class="gsub-title"><i class="fas fa-female"></i> Mother's Information (মাতার তথ্য)</div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="motherName">Mother's Full Name</label>
                                <input type="text" id="motherName" placeholder="Full name">
                            </div>
                            <div class="form-group">
                                <label for="motherNid">Mother's NID Number</label>
                                <input type="text" id="motherNid" placeholder="10 or 17 digits" maxlength="17">
                                <span class="err" id="err-motherNid"></span>
                            </div>
                            <div class="form-group">
                                <label for="motherPhone">Mother's Phone</label>
                                <input type="tel" id="motherPhone" placeholder="01XXXXXXXXX" maxlength="11">
                                <span class="err" id="err-motherPhone"></span>
                            </div>
                            <div class="form-group">
                                <label for="motherOcc">Mother's Occupation</label>
                                <input type="text" id="motherOcc" placeholder="e.g. Housewife, Teacher">
                            </div>
                        </div>
                    </div>

                    <div class="guardian-subsection">
                        <div class="gsub-title"><i class="fas fa-user-shield"></i> Guardian (if different from parents)</div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="guardianName">Guardian Name</label>
                                <input type="text" id="guardianName" placeholder="Leave blank if parent is guardian">
                            </div>
                            <div class="form-group">
                                <label for="guardianPhone">Guardian Phone</label>
                                <input type="tel" id="guardianPhone" placeholder="01XXXXXXXXX" maxlength="11">
                                <span class="err" id="err-guardianPhone"></span>
                            </div>
                            <div class="form-group">
                                <label for="guardianRel">Relationship</label>
                                <input type="text" id="guardianRel" placeholder="e.g. Uncle, Maternal Uncle">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ══ SECTION 5: PHOTO ══ -->
                <div class="form-section" id="section-photo">
                    <div class="form-section-title"><i class="fas fa-camera"></i> Student Photo</div>
                    <div class="photo-upload-area">
                        <div class="photo-preview" id="photoPreview">
                            <i class="fas fa-user-circle"></i>
                            <span>No photo uploaded</span>
                        </div>
                        <div class="photo-instructions">
                            <p><strong>Passport-size photo</strong> (optional)</p>
                            <ul>
                                <li>Recommended: 300×400px</li>
                                <li>Formats: JPG, PNG</li>
                                <li>Max size: 2MB</li>
                            </ul>
                            <label class="photo-upload-btn" for="photoInput">
                                <i class="fas fa-upload"></i> Choose Photo
                            </label>
                            <input type="file" id="photoInput" accept="image/jpeg,image/png" style="display:none;">
                        </div>
                    </div>
                </div>

                <!-- ── Form Actions ── -->
                <div class="form-actions-bar">
                    <button type="button" class="btn-cancel-form" id="cancelForm">Cancel</button>
                    <button type="submit" class="btn-save-form" id="saveStudentBtn">
                        <i class="fas fa-save"></i> Save Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ════════════════════ DELETE CONFIRM ════════════════════ -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box modal-sm">
        <div class="modal-header">
            <h2><i class="fas fa-trash"></i> Delete Student</h2>
            <button class="modal-close" id="closeDeleteModal"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="delete-confirm">
                <div class="del-icon"><i class="fas fa-exclamation-triangle"></i></div>
                <p>Are you sure you want to delete <strong id="deleteStudentName">this student</strong>?
                   This action <strong>cannot be undone</strong>.</p>
                <div class="form-actions">
                    <button class="btn-cancel" id="cancelDelete">Cancel</button>
                    <button class="btn-danger" id="confirmDelete"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ════════════════════ TOAST ════════════════════ -->
<div class="toast" id="toast">
    <i class="fas fa-check-circle"></i>
    <span id="toastMsg">Saved!</span>
</div>

<script src="js/portal.js"></script>
<script src="js/students.js"></script>
</body>
</html>
