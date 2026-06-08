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
                            <!-- Row 1 -->
                            <div class="form-row" style="grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));">
                                <div class="form-group">
                                    <label for="classSelect">Class</label>
                                    <select id="classSelect" name="classSelect" required>
                                        <option value="">Select Class</option>
                                        <option value="XI">Class XI</option>
                                        <option value="XII">Class XII</option>
                                        <option value="Degree">Degree (Pass)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sessionSelect">Session</label>
                                    <select id="sessionSelect" name="sessionSelect" required>
                                        <option value="">Select Session</option>
                                        <option value="2024-2025">2024-2025</option>
                                        <option value="2025-2026">2025-2026</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="groupSelect">Group</label>
                                    <select id="groupSelect" name="groupSelect" required>
                                        <option value="">Select Group</option>
                                        <option value="Science">Science</option>
                                        <option value="Commerce">Commerce</option>
                                        <option value="Humanities">Humanities</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="yearSelect">Year</label>
                                    <select id="yearSelect" name="yearSelect" required>
                                        <option value="">Select Class Year</option>
                                        <option value="1st Year">1st Year</option>
                                        <option value="2nd Year">2nd Year</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Row 2 -->
                            <div class="form-row" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); align-items: flex-end;">
                                <div class="form-group">
                                    <label for="examSelect">Exam</label>
                                    <select id="examSelect" name="examSelect" required>
                                        <option value="">Select Exam</option>
                                        <option value="Half Yearly">Half Yearly</option>
                                        <option value="Annual">Annual</option>
                                        <option value="Pre-Test">Pre-Test</option>
                                        <option value="Test">Test</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="rollInput">Class Roll</label>
                                    <input type="text" id="rollInput" name="rollInput" required>
                                </div>
                                <div class="form-actions-inline">
                                    <button type="submit" class="btn btn-primary btn-search" id="searchBtn" style="margin-top:0;">
                                        <i class="fas fa-search"></i>
                                        <span class="btn-text">Search</span>
                                    </button>
                                    <button type="button" class="btn btn-dl" id="downloadPdfBtn">
                                        <i class="fas fa-download"></i> Download
                                    </button>
                                </div>
                            </div>

                            <div id="searchError" class="search-error" style="display:none; margin-top: 10px;">
                                <i class="fas fa-exclamation-circle"></i>
                                <span id="searchErrorMsg">Please fill in all fields.</span>
                            </div>
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
                            <!-- Dynamic results will be populated here -->
                            <div style="padding: 30px; text-align: center; color: var(--muted); font-family: 'Inter', sans-serif;">
                                <i class="fas fa-info-circle" style="font-size: 1.5rem; margin-bottom: 10px; color: #cbd5e1;"></i>
                                <p>No published results available at this time.</p>
                            </div>
                        </div><!-- /.result-list -->
                    </div>

                </div><!-- /.results-main -->

                <!-- ════ RIGHT: Sidebar ════ -->
                <aside class="results-sidebar">





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
