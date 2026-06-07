<?php
$page       = 'results';
$page_title = 'Examination Results | Phulpur Mohila Degree College';
$page_css   = 'results.css';
$base_path  = '../';
include '../includes/header.php';
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/styles/marksheet.css">

    <!-- ══════════════════ PAGE HEADER ══════════════════ -->
    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-kicker reveal" data-i18n="results.kicker">পিএমডিসি</div>
            <h1 class="reveal" data-i18n="results.h1">এইচএসসি পরীক্ষার ফলাফল</h1>
            <p class="reveal" data-i18n="results.desc">একাদশ এবং দ্বাদশ শ্রেণির প্রকাশিত এইচএসসি ফলাফল পরীক্ষা করুন এবং ডাউনলোড করুন — ষাণ্মাসিক, বার্ষিক, প্রি-টেস্ট এবং টেস্ট পরীক্ষা।</p>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="results-layout">

                <!-- ════ LEFT: Search + Published Results ════ -->
                <div class="results-main">

                    <!-- Result Lookup Card -->
                    <div class="lookup-card reveal">
                        <div class="lc-header">
                            <div class="lc-icon"><i class="fas fa-search"></i></div>
                            <div>
                                <h2 data-i18n="results.find.h2">আপনার ফলাফল খুঁজুন</h2>
                                <p data-i18n="results.find.sub">আপনার ফলাফল খুঁজতে আপনার বিবরণ দিন</p>
                            </div>
                        </div>

                        <form class="lookup-form" id="resultSearchForm">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="examSelect"><i class="fas fa-file-alt"></i> Examination</label>
                                    <select id="examSelect" name="examSelect" required>
                                        <option value="">Loading Exams...</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="rollInput"><i class="fas fa-id-card"></i> Roll Number</label>
                                    <input type="text" id="rollInput" name="rollInput"
                                           placeholder="e.g. 1010" required>
                                </div>
                            </div>

                            <div id="searchError" class="search-error" style="display:none;">
                                <i class="fas fa-exclamation-circle"></i>
                                <span id="searchErrorMsg">Please fill in all fields.</span>
                            </div>

                            <button type="submit" class="btn btn-primary btn-search" id="searchBtn">
                                <i class="fas fa-search"></i>
                                <span class="btn-text">Search Result</span>
                            </button>
                        </form>

                        <div class="lookup-note">
                            <i class="fas fa-info-circle"></i>
                            Roll number and name must match college registration records exactly.
                        </div>
                    </div>

                    <!-- Dynamic Marksheet Rendered Here -->
                    <div class="marksheet-card" id="marksheetCard" style="display:none; margin-top:30px;">
                        <div class="marksheet-actions">
                            <button class="btn-back" id="backBtn"><i class="fas fa-arrow-left"></i> Back</button>
                            <button class="btn-download" id="downloadBtn" onclick="window.print()"><i class="fas fa-print"></i> Print / Download PDF</button>
                        </div>
                        
                        <div class="marksheet-wrapper" id="printableArea">
                            <div class="marksheet-header">
                                <div class="m-logo"><i class="fas fa-school" style="font-size:3rem; color:#2563eb;"></i></div>
                                <h1>Patuakhali Model Degree College</h1>
                                <h3>Academic Transcript</h3>
                                <p id="msExamName" style="font-weight:700; margin-top:5px; color:#1e293b;">Final Examination</p>
                            </div>

                            <div class="student-info-grid">
                                <div class="info-row"><span class="info-label">Name of Student:</span> <span class="info-value" id="msName">Abid</span></div>
                                <div class="info-row"><span class="info-label">Roll No:</span> <span class="info-value" id="msRoll">1010</span></div>
                                <div class="info-row"><span class="info-label">Registration No:</span> <span class="info-value" id="msRegNo">20261010</span></div>
                                <div class="info-row"><span class="info-label">Group / Class:</span> <span class="info-value" id="msGroup">Science</span></div>
                                <div class="info-row"><span class="info-label">Session:</span> <span class="info-value" id="msSession">2026-2027</span></div>
                            </div>

                            <table class="marks-table">
                                <thead>
                                    <tr>
                                        <th>Name of Subjects</th>
                                        <th>Full Marks</th>
                                        <th>Marks Obtained</th>
                                        <th>Letter Grade</th>
                                        <th>Grade Point</th>
                                    </tr>
                                </thead>
                                <tbody id="msTableBody">
                                    <!-- Filled by JS -->
                                </tbody>
                            </table>

                            <div class="marksheet-footer">
                                <div class="gpa-box">
                                    <div class="gpa-label">Result Status</div>
                                    <div class="gpa-value" id="msStatus">PASSED</div>
                                </div>
                                <div class="gpa-box" style="background:#eff6ff; border-color:#bfdbfe;">
                                    <div class="gpa-label">GPA</div>
                                    <div class="gpa-value" style="color:#1d4ed8;" id="msGpa">5.00</div>
                                </div>
                            </div>
                            
                            <div class="signatures">
                                <div class="sig-line">Prepared By</div>
                                <div class="sig-line">Controller of Exams</div>
                                <div class="sig-line">Principal</div>
                            </div>
                        </div>
                    </div>

                    <!-- Published Results -->
                    <div class="published-section reveal">
                        <div class="pub-head">
                            <h3 data-i18n="results.pub.h3">প্রকাশিত ফলাফল</h3>
                            <div class="pub-filters">
                                <button class="pf-btn active" data-filter="all" data-i18n="results.pub.all">সব</button>
                                <button class="pf-btn" data-filter="science"><i class="fas fa-flask"></i> <span data-i18n="results.pub.sci">বিজ্ঞান</span></button>
                                <button class="pf-btn" data-filter="commerce"><i class="fas fa-briefcase"></i> <span data-i18n="results.pub.com">বাণিজ্য</span></button>
                                <button class="pf-btn" data-filter="humanities"><i class="fas fa-book"></i> <span data-i18n="results.pub.hum">মানবিক</span></button>
                            </div>
                        </div>

                        <div class="result-list" id="resultList">

                            <div class="result-row reveal" data-category="science">
                                <div class="rr-left">
                                    <div class="rr-icon rr-sci"><i class="fas fa-file-pdf"></i></div>
                                    <div class="rr-info">
                                        <div class="rr-title">Test Exam — Science <span class="rr-class class-xii">Class XII</span> <span class="rr-badge badge-new">New</span></div>
                                        <div class="rr-meta">
                                            <span><i class="fas fa-calendar"></i> Published Jan 20, 2026</span>
                                            <span><i class="fas fa-users"></i> 186 Students</span>
                                            <span class="rr-bn">দ্বাদশ শ্রেণি — বিজ্ঞান — টেস্ট পরীক্ষা ২০২৫</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="rr-actions">
                                    <button class="rr-btn rr-view" onclick="viewResult('test_sci_xii_2025')"><i class="fas fa-eye"></i> View</button>
                                    <button class="rr-btn rr-dl"   onclick="downloadResult('test_sci_xii_2025')"><i class="fas fa-download"></i> PDF</button>
                                </div>
                            </div>

                            <div class="result-row reveal" data-category="commerce">
                                <div class="rr-left">
                                    <div class="rr-icon rr-com"><i class="fas fa-file-pdf"></i></div>
                                    <div class="rr-info">
                                        <div class="rr-title">Test Exam — Commerce <span class="rr-class class-xii">Class XII</span> <span class="rr-badge badge-new">New</span></div>
                                        <div class="rr-meta">
                                            <span><i class="fas fa-calendar"></i> Published Jan 18, 2026</span>
                                            <span><i class="fas fa-users"></i> 212 Students</span>
                                            <span class="rr-bn">দ্বাদশ শ্রেণি — ব্যবসায় শিক্ষা — টেস্ট পরীক্ষা ২০২৫</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="rr-actions">
                                    <button class="rr-btn rr-view" onclick="viewResult('test_com_xii_2025')"><i class="fas fa-eye"></i> View</button>
                                    <button class="rr-btn rr-dl"   onclick="downloadResult('test_com_xii_2025')"><i class="fas fa-download"></i> PDF</button>
                                </div>
                            </div>

                            <div class="result-row reveal" data-category="humanities">
                                <div class="rr-left">
                                    <div class="rr-icon rr-hum"><i class="fas fa-file-pdf"></i></div>
                                    <div class="rr-info">
                                        <div class="rr-title">Test Exam — Humanities <span class="rr-class class-xii">Class XII</span> <span class="rr-badge badge-new">New</span></div>
                                        <div class="rr-meta">
                                            <span><i class="fas fa-calendar"></i> Published Jan 15, 2026</span>
                                            <span><i class="fas fa-users"></i> 247 Students</span>
                                            <span class="rr-bn">দ্বাদশ শ্রেণি — মানবিক — টেস্ট পরীক্ষা ২০২৫</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="rr-actions">
                                    <button class="rr-btn rr-view" onclick="viewResult('test_hum_xii_2025')"><i class="fas fa-eye"></i> View</button>
                                    <button class="rr-btn rr-dl"   onclick="downloadResult('test_hum_xii_2025')"><i class="fas fa-download"></i> PDF</button>
                                </div>
                            </div>

                            <div class="result-row reveal" data-category="science">
                                <div class="rr-left">
                                    <div class="rr-icon rr-sci"><i class="fas fa-file-pdf"></i></div>
                                    <div class="rr-info">
                                        <div class="rr-title">Year-Change Exam — Science <span class="rr-class class-xi">Class XI</span></div>
                                        <div class="rr-meta">
                                            <span><i class="fas fa-calendar"></i> Published Dec 30, 2025</span>
                                            <span><i class="fas fa-users"></i> 174 Students</span>
                                            <span class="rr-bn">একাদশ শ্রেণি — বিজ্ঞান — বার্ষান্তর পরীক্ষা ২০২৫</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="rr-actions">
                                    <button class="rr-btn rr-view" onclick="viewResult('yearchange_sci_xi_2025')"><i class="fas fa-eye"></i> View</button>
                                    <button class="rr-btn rr-dl"   onclick="downloadResult('yearchange_sci_xi_2025')"><i class="fas fa-download"></i> PDF</button>
                                </div>
                            </div>

                            <div class="result-row reveal" data-category="commerce">
                                <div class="rr-left">
                                    <div class="rr-icon rr-com"><i class="fas fa-file-pdf"></i></div>
                                    <div class="rr-info">
                                        <div class="rr-title">Year-Change Exam — Commerce <span class="rr-class class-xi">Class XI</span></div>
                                        <div class="rr-meta">
                                            <span><i class="fas fa-calendar"></i> Published Dec 28, 2025</span>
                                            <span><i class="fas fa-users"></i> 198 Students</span>
                                            <span class="rr-bn">একাদশ শ্রেণি — ব্যবসায় শিক্ষা — বার্ষান্তর পরীক্ষা ২০২৫</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="rr-actions">
                                    <button class="rr-btn rr-view" onclick="viewResult('yearchange_com_xi_2025')"><i class="fas fa-eye"></i> View</button>
                                    <button class="rr-btn rr-dl"   onclick="downloadResult('yearchange_com_xi_2025')"><i class="fas fa-download"></i> PDF</button>
                                </div>
                            </div>

                            <div class="result-row reveal" data-category="humanities">
                                <div class="rr-left">
                                    <div class="rr-icon rr-hum"><i class="fas fa-file-pdf"></i></div>
                                    <div class="rr-info">
                                        <div class="rr-title">Year-Change Exam — Humanities <span class="rr-class class-xi">Class XI</span></div>
                                        <div class="rr-meta">
                                            <span><i class="fas fa-calendar"></i> Published Dec 25, 2025</span>
                                            <span><i class="fas fa-users"></i> 232 Students</span>
                                            <span class="rr-bn">একাদশ শ্রেণি — মানবিক — বার্ষান্তর পরীক্ষা ২০২৫</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="rr-actions">
                                    <button class="rr-btn rr-view" onclick="viewResult('yearchange_hum_xi_2025')"><i class="fas fa-eye"></i> View</button>
                                    <button class="rr-btn rr-dl"   onclick="downloadResult('yearchange_hum_xi_2025')"><i class="fas fa-download"></i> PDF</button>
                                </div>
                            </div>

                        </div><!-- /.result-list -->
                    </div>

                </div><!-- /.results-main -->

                <!-- ════ RIGHT: Sidebar ════ -->
                <aside class="results-sidebar">

                    <!-- Important Notice -->
                    <div class="sidebar-notice reveal">
                        <div class="sn-head">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Important Notice</span>
                        </div>
                        <ul class="sn-list">
                            <li>All results are provisional pending verification by the Bangladesh Education Board.</li>
                            <li>Report discrepancies to the Examination Cell within <strong>7 days</strong> of publication.</li>
                            <li>Original mark sheets (নম্বরপত্র) available after <strong>15 working days</strong>.</li>
                            <li>Re-checking (পুনর্নিরীক্ষণ) applications within <strong>10 days</strong> of result declaration.</li>
                        </ul>
                        <div class="sn-contact">
                            <div class="snc-label">Examination Cell</div>
                            <a href="tel:+880-1700-000000" class="snc-item"><i class="fas fa-phone"></i> +880-1700-000000</a>
                            <a href="mailto:exam@pmdc.edu.bd" class="snc-item"><i class="fas fa-envelope"></i> exam@pmdc.edu.bd</a>
                        </div>
                    </div>

                    <!-- Summary Stats -->
                    <div class="sidebar-stats reveal">
                        <div class="ss-head">HSC Board Results</div>
                        <div class="ss-grid">
                            <div class="ss-item">
                                <div class="ss-val">92%</div>
                                <div class="ss-lbl">Pass Rate</div>
                            </div>
                            <div class="ss-item">
                                <div class="ss-val">48</div>
                                <div class="ss-lbl">GPA 5.00</div>
                            </div>
                            <div class="ss-item">
                                <div class="ss-val">645</div>
                                <div class="ss-lbl">Appeared</div>
                            </div>
                            <div class="ss-item">
                                <div class="ss-val">593</div>
                                <div class="ss-lbl">Passed</div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="sidebar-links reveal">
                        <div class="sl-head">Related Links</div>
                        <a href="<?= BASE_URL ?>/announcement" class="sl-item">
                            <i class="fas fa-bell"></i> Announcements
                            <i class="fas fa-chevron-right sl-arr"></i>
                        </a>
                        <a href="academics.php" class="sl-item">
                            <i class="fas fa-graduation-cap"></i> Academics
                            <i class="fas fa-chevron-right sl-arr"></i>
                        </a>
                        <a href="<?= BASE_URL ?>/contact" class="sl-item">
                            <i class="fas fa-envelope"></i> Contact Office
                            <i class="fas fa-chevron-right sl-arr"></i>
                        </a>
                    </div>

                </aside>

            </div><!-- /.results-layout -->
        </div>
    </section>

    <script src="<?= BASE_URL ?>/javascript/marksheet.js?v=2"></script>
    <script>
    // ── Published results filter ───────────────────────────
    document.querySelectorAll('.pf-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.pf-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const f = this.dataset.filter;
            document.querySelectorAll('.result-row').forEach(row => {
                row.style.display = (f === 'all' || row.dataset.category === f) ? '' : 'none';
            });
        });
    });

    // ── Action stubs ────────────────────────────────────────
    function viewResult(id)     { alert('In production, this would open the PDF result for: ' + id); }
    function downloadResult(id) { alert('In production, this would download the PDF result for: ' + id); }
    </script>

<?php include '../includes/footer.php'; ?>
