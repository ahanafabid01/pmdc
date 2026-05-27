<?php
$page       = 'results';
$page_title = 'Examination Results | Phulpur Mohila Degree College';
$page_css   = 'results.css';
$base_path  = '../';
include '../includes/header.php';
?>

    <!-- ══════════════════ PAGE HEADER ══════════════════ -->
    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-kicker reveal">PMDC</div>
            <h1 class="reveal">HSC Examination Results</h1>
            <p class="reveal">Check and download published HSC results — Annual &amp; Test Examinations for Class XI &amp; XII.</p>
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
                                <h2>Find Your Result</h2>
                                <p>Enter your details to look up your result</p>
                            </div>
                        </div>

                        <form class="lookup-form" id="resultSearchForm">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="studentId"><i class="fas fa-id-card"></i> Roll Number</label>
                                    <input type="text" id="studentId" name="studentId"
                                           placeholder="e.g. PMDC-XII-2025-001" required>
                                </div>
                                <div class="form-group">
                                    <label for="studentName"><i class="fas fa-user"></i> Full Name</label>
                                    <input type="text" id="studentName" name="studentName"
                                           placeholder="As per college records" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="examType"><i class="fas fa-file-alt"></i> Exam Type</label>
                                    <select id="examType" name="examType" required>
                                        <option value="">Select exam…</option>
                                        <optgroup label="HSC 1st Year — একাদশ শ্রেণি">
                                            <option value="halfyearly_xi">Half-Yearly (অর্ধ-বার্ষিক)</option>
                                            <option value="yearchange_xi">Year-Change (বার্ষান্তর)</option>
                                        </optgroup>
                                        <optgroup label="HSC 2nd Year — দ্বাদশ শ্রেণি">
                                            <option value="pretest_xii">Pre-Test (প্রি-টেস্ট)</option>
                                            <option value="test_xii">Test Exam (টেস্ট পরীক্ষা)</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="examYear"><i class="fas fa-calendar-alt"></i> Session Year</label>
                                    <select id="examYear" name="examYear" required>
                                        <option value="">Select year…</option>
                                        <option value="2025">2024 – 2025</option>
                                        <option value="2024">2023 – 2024</option>
                                        <option value="2023">2022 – 2023</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="studentGroup"><i class="fas fa-layer-group"></i> Academic Group</label>
                                    <select id="studentGroup" name="studentGroup" required>
                                        <option value="">Select group…</option>
                                        <option value="science">বিজ্ঞান (Science)</option>
                                        <option value="commerce">ব্যবসায় শিক্ষা (Commerce)</option>
                                        <option value="humanities">মানবিক (Humanities)</option>
                                    </select>
                                </div>
                            </div>

                            <div id="searchError" class="search-error" style="display:none;">
                                <i class="fas fa-exclamation-circle"></i>
                                <span id="searchErrorMsg">Please fill in all fields.</span>
                            </div>

                            <button type="submit" class="btn btn-primary btn-search" id="searchBtn">
                                <i class="fas fa-search"></i>
                                <span class="btn-text">Search Result</span>
                                <span class="btn-spin" style="display:none;"><i class="fas fa-spinner fa-spin"></i> Searching…</span>
                            </button>
                        </form>

                        <div class="lookup-note">
                            <i class="fas fa-info-circle"></i>
                            Roll number and name must match college registration records exactly.
                        </div>
                    </div>

                    <!-- Published Results -->
                    <div class="published-section reveal">
                        <div class="pub-head">
                            <h3>Published Results</h3>
                            <div class="pub-filters">
                                <button class="pf-btn active" data-filter="all">All</button>
                                <button class="pf-btn" data-filter="science"><i class="fas fa-flask"></i> Science</button>
                                <button class="pf-btn" data-filter="commerce"><i class="fas fa-briefcase"></i> Commerce</button>
                                <button class="pf-btn" data-filter="humanities"><i class="fas fa-book"></i> Humanities</button>
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
                        <div class="ss-head">HSC Board Results 2025</div>
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
                        <a href="announcements.php" class="sl-item">
                            <i class="fas fa-bell"></i> Announcements
                            <i class="fas fa-chevron-right sl-arr"></i>
                        </a>
                        <a href="academics.php" class="sl-item">
                            <i class="fas fa-graduation-cap"></i> Academics
                            <i class="fas fa-chevron-right sl-arr"></i>
                        </a>
                        <a href="contact.php" class="sl-item">
                            <i class="fas fa-envelope"></i> Contact Office
                            <i class="fas fa-chevron-right sl-arr"></i>
                        </a>
                    </div>

                </aside>

            </div><!-- /.results-layout -->
        </div>
    </section>

    <script>
    // ── Lookup form ────────────────────────────────────────
    document.getElementById('resultSearchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn    = document.getElementById('searchBtn');
        const err    = document.getElementById('searchError');
        const errMsg = document.getElementById('searchErrorMsg');
        err.style.display = 'none';

        btn.querySelector('.btn-text').style.display = 'none';
        btn.querySelector('.btn-spin').style.display = 'inline-flex';
        btn.disabled = true;

        setTimeout(() => {
            btn.querySelector('.btn-text').style.display = '';
            btn.querySelector('.btn-spin').style.display = 'none';
            btn.disabled = false;
            err.style.display = 'flex';
            errMsg.textContent = 'No result found. Please check your roll number and name, or contact the Examination Cell.';
        }, 1600);
    });

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
