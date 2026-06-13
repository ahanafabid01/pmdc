<?php
$page       = 'academics';
$page_title = 'Academics | Phulpur Mohila Degree College';
$page_css   = 'academics.css';
$base_path  = '../';
include '../includes/header.php';
?>

    <!-- ══════════════════ PAGE HEADER ══════════════════ -->
    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-kicker reveal">HSC &amp; Degree Programmes</div>
            <h1 class="reveal">Academic Groups &amp; Subjects</h1>
            <p class="reveal">উচ্চ মাধ্যমিক শিক্ষা (Higher Secondary Certificate) — বিজ্ঞান, ব্যবসায় শিক্ষা ও মানবিক বিভাগ</p>
        </div>
    </section>

    <!-- ══════════════════ HSC CLASS LEVELS ══════════════════ -->
    <section class="section-padding">
        <div class="container">
            <div class="section-head reveal">
                <div class="section-kicker">Programme Structure</div>
                <h2>HSC Class Levels</h2>
                <p>Phulpur Mohila Degree College offers the Higher Secondary Certificate across two class levels with a fixed exam structure for each year.</p>
            </div>
            <div class="levels-grid">
                <div class="level-card reveal">
                    <div class="level-num">XI</div>
                    <div class="level-body">
                        <h3>HSC 1st Year <span class="level-bn">একাদশ শ্রেণি</span></h3>
                        <p>Examinations: Half-Yearly Exam (ষাণ্মাসিক / অর্ধ-বার্ষিক পরীক্ষা) and Year-Change Exam (বার্ষিক পরীক্ষা).</p>
                        <a href="#groups" class="read-more">View Subjects <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="level-card reveal">
                    <div class="level-num">XII</div>
                    <div class="level-body">
                        <h3>HSC 2nd Year <span class="level-bn">দ্বাদশ শ্রেণি</span></h3>
                        <p>Examinations: Pre-Test Exam (প্রি-টেস্ট পরীক্ষা) and Test Exam (টেস্ট পরীক্ষা). Admit cards must be collected 10 days before the exam.</p>
                        <a href="#groups" class="read-more">View Subjects <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════════ DEGREE PROGRAMMES ══════════════════ -->
    <section class="section-padding section-alt">
        <div class="container">
            <div class="section-head reveal">
                <div class="section-kicker">Degree Programmes</div>
                <h2>Available Degree Paths</h2>
                <p>The college also offers degree-level study in four programmes.</p>
            </div>
            <div class="levels-grid">
                <div class="level-card reveal"><div class="level-num">BA</div><div class="level-body"><h3>Bachelor of Arts</h3><p>Degree programme</p></div></div>
                <div class="level-card reveal"><div class="level-num">BSS</div><div class="level-body"><h3>Bachelor of Social Science</h3><p>Degree programme</p></div></div>
                <div class="level-card reveal"><div class="level-num">BSc</div><div class="level-body"><h3>Bachelor of Science</h3><p>Degree programme</p></div></div>
                <div class="level-card reveal"><div class="level-num">BMT</div><div class="level-body"><h3>Business Management &amp; Technology</h3><p>Degree programme</p></div></div>
            </div>
        </div>
    </section>

    <!-- ══════════════════ COMPULSORY SUBJECTS ══════════════════ -->
    <section class="section-padding section-alt">
        <div class="container">
            <div class="section-head reveal">
                <div class="section-kicker">All Groups</div>
                <h2>Compulsory Subjects <span class="head-bn">বাধ্যতামূলক বিষয়</span></h2>
                <p>Every HSC student, regardless of their academic group, must study the following subjects.</p>
            </div>
            <div class="compulsory-grid reveal">

                <div class="comp-card">
                    <div class="comp-icon" style="background:#eff6ff;color:#2563eb;"><i class="fas fa-book-open"></i></div>
                    <div class="comp-info">
                        <div class="comp-subject">বাংলা (Bangla)</div>
                        <div class="comp-papers">
                            <span>Bangla 1st Paper <code>101</code></span>
                            <span>Bangla 2nd Paper <code>102</code></span>
                        </div>
                    </div>
                </div>

                <div class="comp-card">
                    <div class="comp-icon" style="background:#f0fdf4;color:#16a34a;"><i class="fas fa-language"></i></div>
                    <div class="comp-info">
                        <div class="comp-subject">English</div>
                        <div class="comp-papers">
                            <span>English 1st Paper <code>107</code></span>
                            <span>English 2nd Paper <code>108</code></span>
                        </div>
                    </div>
                </div>

                <div class="comp-card">
                    <div class="comp-icon" style="background:#faf5ff;color:#7c3aed;"><i class="fas fa-laptop-code"></i></div>
                    <div class="comp-info">
                        <div class="comp-subject">ICT <span style="font-weight:400;color:var(--muted);">(তথ্য ও যোগাযোগ প্রযুক্তি)</span></div>
                        <div class="comp-papers">
                            <span>Information &amp; Communication Technology <code>275</code></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ══════════════════ ACADEMIC GROUPS ══════════════════ -->
    <section class="section-padding" id="groups">
        <div class="container">
            <div class="section-head reveal">
                <div class="section-kicker">Elective Groups</div>
                <h2>Academic Groups <span class="head-bn">বিভাগসমূহ</span></h2>
                <p>Students choose one of three academic groups on admission. Each group has its own set of elective subjects.</p>
            </div>
            <div class="groups-grid">

                <!-- Science -->
                <div class="group-card reveal" style="position:relative;">
                    <div class="group-header gc-sci">
                        <span class="badge" style="position:absolute; top:24px; right:24px; background:rgba(255,255,255,0.25); color:#fff; padding:4px 10px; border-radius:6px; font-size:0.85rem; font-weight:600;">7+ Subjects</span>
                        <div class="gh-icon"><i class="fas fa-flask"></i></div>
                        <div>
                            <div class="gh-label">বিজ্ঞান বিভাগ</div>
                            <div class="gh-title">Science Group</div>
                        </div>
                    </div>
                    <div style="padding: 15px 20px 0; font-size: 0.9rem; color: #475569;">
                        <strong>Compulsory:</strong> 3 subjects<br>
                        <strong>Optional:</strong> 4 subjects <span style="font-size:0.8rem;">(choose any 3)</span><br>
                        <strong>4th Subject:</strong> 2 options <span style="font-size:0.8rem;">(choose any 1)</span>
                    </div>
                    <ul class="subject-list">
                        <li style="background:#f0fdf4;"><span class="sub-name" style="color:#059669;font-weight:600;"><i class="fas fa-lock" style="font-size:0.7rem;margin-right:4px;"></i>Bangla (বাংলা)</span><span class="sub-code" style="background:#dcfce7;color:#059669;">101 / 102</span></li>
                        <li style="background:#f0fdf4;"><span class="sub-name" style="color:#059669;font-weight:600;"><i class="fas fa-lock" style="font-size:0.7rem;margin-right:4px;"></i>English</span><span class="sub-code" style="background:#dcfce7;color:#059669;">107 / 108</span></li>
                        <li style="background:#f0fdf4;"><span class="sub-name" style="color:#059669;font-weight:600;"><i class="fas fa-lock" style="font-size:0.7rem;margin-right:4px;"></i>ICT (তথ্য ও যোগাযোগ প্রযুক্তি)</span><span class="sub-code" style="background:#dcfce7;color:#059669;">275</span></li>
                        <li style="border-top:2px dashed #e2e8f0;padding-top:6px;margin-top:2px;"><span class="sub-name" style="color:#6366f1;font-size:0.78rem;font-weight:600;">— Elective (choose any 3)</span><span class="sub-code" style="background:#eef2ff;color:#6366f1;">Optional</span></li>
                        <li><span class="sub-name">Physics <em>পদার্থ বিজ্ঞান</em></span><span class="sub-code">174 / 175</span></li>
                        <li><span class="sub-name">Chemistry <em>রসায়ন</em></span><span class="sub-code">176 / 177</span></li>
                        <li><span class="sub-name">Biology <em>জীব বিজ্ঞান</em></span><span class="sub-code">178 / 179</span></li>
                        <li><span class="sub-name">Higher Mathematics <em>উচ্চতর গণিত</em></span><span class="sub-code">265 / 266</span></li>
                        <li style="border-top:2px dashed #e2e8f0;padding-top:6px;margin-top:2px;"><span class="sub-name" style="color:#d97706;font-size:0.78rem;font-weight:600;">— 4th Subject / Bonus (choose any 1)</span><span class="sub-code" style="background:#fef3c7;color:#d97706;">Bonus</span></li>
                        <li><span class="sub-name">Higher Mathematics <em>উচ্চতর গণিত</em></span><span class="sub-code">265 / 266</span></li>
                        <li><span class="sub-name">Biology <em>জীব বিজ্ঞান</em></span><span class="sub-code">178 / 179</span></li>
                    </ul>
                    <div class="group-footer">
                        <a href="#" class="read-more">View Full Syllabus <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Commerce -->
                <div class="group-card reveal" style="position:relative;">
                    <div class="group-header gc-com">
                        <span class="badge" style="position:absolute; top:24px; right:24px; background:rgba(255,255,255,0.25); color:#fff; padding:4px 10px; border-radius:6px; font-size:0.85rem; font-weight:600;">6+ Subjects</span>
                        <div class="gh-icon"><i class="fas fa-briefcase"></i></div>
                        <div>
                            <div class="gh-label">ব্যবসায় শিক্ষা বিভাগ</div>
                            <div class="gh-title">Business Studies Group</div>
                        </div>
                    </div>
                    <div style="padding: 15px 20px 0; font-size: 0.9rem; color: #475569;">
                        <strong>Compulsory:</strong> 3 subjects<br>
                        <strong>Optional:</strong> 3 subjects <span style="font-size:0.8rem;">(choose any 3)</span><br>
                        <strong>4th Subject:</strong> 2 options <span style="font-size:0.8rem;">(choose any 1)</span>
                    </div>
                    <ul class="subject-list">
                        <li style="background:#f0fdf4;"><span class="sub-name" style="color:#059669;font-weight:600;"><i class="fas fa-lock" style="font-size:0.7rem;margin-right:4px;"></i>Bangla (বাংলা)</span><span class="sub-code" style="background:#dcfce7;color:#059669;">101 / 102</span></li>
                        <li style="background:#f0fdf4;"><span class="sub-name" style="color:#059669;font-weight:600;"><i class="fas fa-lock" style="font-size:0.7rem;margin-right:4px;"></i>English</span><span class="sub-code" style="background:#dcfce7;color:#059669;">107 / 108</span></li>
                        <li style="background:#f0fdf4;"><span class="sub-name" style="color:#059669;font-weight:600;"><i class="fas fa-lock" style="font-size:0.7rem;margin-right:4px;"></i>ICT (তথ্য ও যোগাযোগ প্রযুক্তি)</span><span class="sub-code" style="background:#dcfce7;color:#059669;">275</span></li>
                        <li style="border-top:2px dashed #e2e8f0;padding-top:6px;margin-top:2px;"><span class="sub-name" style="color:#6366f1;font-size:0.78rem;font-weight:600;">— Elective (choose any 3)</span><span class="sub-code" style="background:#eef2ff;color:#6366f1;">Optional</span></li>
                        <li><span class="sub-name">Accounting <em>হিসাব বিজ্ঞান</em></span><span class="sub-code">253 / 254</span></li>
                        <li><span class="sub-name">Business Policy &amp; Practice <em>ব্যবসায়নীতি ও প্রয়োগ</em></span><span class="sub-code">286 / 287</span></li>
                        <li><span class="sub-name">Marketing <em>মার্কেটিং</em></span><span class="sub-code">277 / 278</span></li>
                        <li style="border-top:2px dashed #e2e8f0;padding-top:6px;margin-top:2px;"><span class="sub-name" style="color:#d97706;font-size:0.78rem;font-weight:600;">— 4th Subject / Bonus (choose any 1)</span><span class="sub-code" style="background:#fef3c7;color:#d97706;">Bonus</span></li>
                        <li><span class="sub-name">Economics <em>অর্থনীতি</em></span><span class="sub-code">109 / 110</span></li>
                        <li><span class="sub-name">Geography <em>ভূগোল</em></span><span class="sub-code">125 / 126</span></li>
                    </ul>
                    <div class="group-footer">
                        <a href="#" class="read-more">View Full Syllabus <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Humanities -->
                <div class="group-card reveal" style="position:relative;">
                    <div class="group-header gc-hum">
                        <span class="badge" style="position:absolute; top:24px; right:24px; background:rgba(255,255,255,0.25); color:#fff; padding:4px 10px; border-radius:6px; font-size:0.85rem; font-weight:600;">9+ Subjects</span>
                        <div class="gh-icon"><i class="fas fa-book"></i></div>
                        <div>
                            <div class="gh-label">মানবিক বিভাগ</div>
                            <div class="gh-title">Humanities Group</div>
                        </div>
                    </div>
                    <div style="padding: 15px 20px 0; font-size: 0.9rem; color: #475569;">
                        <strong>Compulsory:</strong> 3 subjects<br>
                        <strong>Optional:</strong> 6 subjects <span style="font-size:0.8rem;">(choose any 3)</span><br>
                        <strong>4th Subject:</strong> 6 options <span style="font-size:0.8rem;">(choose any 1)</span>
                    </div>
                    <ul class="subject-list" style="max-height:320px; overflow-y:auto;">
                        <li style="background:#f0fdf4;"><span class="sub-name" style="color:#059669;font-weight:600;"><i class="fas fa-lock" style="font-size:0.7rem;margin-right:4px;"></i>Bangla (বাংলা)</span><span class="sub-code" style="background:#dcfce7;color:#059669;">101 / 102</span></li>
                        <li style="background:#f0fdf4;"><span class="sub-name" style="color:#059669;font-weight:600;"><i class="fas fa-lock" style="font-size:0.7rem;margin-right:4px;"></i>English</span><span class="sub-code" style="background:#dcfce7;color:#059669;">107 / 108</span></li>
                        <li style="background:#f0fdf4;"><span class="sub-name" style="color:#059669;font-weight:600;"><i class="fas fa-lock" style="font-size:0.7rem;margin-right:4px;"></i>ICT (তথ্য ও যোগাযোগ প্রযুক্তি)</span><span class="sub-code" style="background:#dcfce7;color:#059669;">275</span></li>
                        <li style="border-top:2px dashed #e2e8f0;padding-top:6px;margin-top:2px;"><span class="sub-name" style="color:#6366f1;font-size:0.78rem;font-weight:600;">— Elective (choose any 3)</span><span class="sub-code" style="background:#eef2ff;color:#6366f1;">Optional</span></li>
                        <li><span class="sub-name">Civics &amp; Good Governance <em>পৌরনীতি ও সুশাসন</em></span><span class="sub-code">269 / 270</span></li>
                        <li><span class="sub-name">Economics <em>অর্থনীতি</em></span><span class="sub-code">109 / 110</span></li>
                        <li><span class="sub-name">Logic <em>যুক্তিবিদ্যা</em></span><span class="sub-code">121 / 122</span></li>
                        <li><span class="sub-name">Social Work <em>সমাজকর্ম</em></span><span class="sub-code">271 / 272</span></li>
                        <li><span class="sub-name">History <em>ইতিহাস</em></span><span class="sub-code">304 / 305</span></li>
                        <li><span class="sub-name">Geography <em>ভূগোল</em></span><span class="sub-code">125 / 126</span></li>
                        <li style="border-top:2px dashed #e2e8f0;padding-top:6px;margin-top:2px;"><span class="sub-name" style="color:#d97706;font-size:0.78rem;font-weight:600;">— 4th Subject / Bonus (choose any 1)</span><span class="sub-code" style="background:#fef3c7;color:#d97706;">Bonus</span></li>
                        <li><span class="sub-name">Civics <em>পৌরনীতি</em></span><span class="sub-code">269 / 270</span></li>
                        <li><span class="sub-name">Economics <em>অর্থনীতি</em></span><span class="sub-code">109 / 110</span></li>
                        <li><span class="sub-name">Logic <em>যুক্তিবিদ্যা</em></span><span class="sub-code">121 / 122</span></li>
                        <li><span class="sub-name">Social Work <em>সমাজকর্ম</em></span><span class="sub-code">271 / 272</span></li>
                        <li><span class="sub-name">History <em>ইতিহাস</em></span><span class="sub-code">304 / 305</span></li>
                        <li><span class="sub-name">Islamic Studies <em>ইসলাম শিক্ষা</em></span><span class="sub-code">267 / 268</span></li>
                    </ul>
                    <div class="group-footer">
                        <a href="#" class="read-more">View Full Syllabus <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ══════════════════ GRADING TABLE ══════════════════ -->
    <section class="section-padding section-alt">
        <div class="container">
            <div class="section-head reveal">
                <div class="section-kicker">Evaluation System</div>
                <h2>HSC Grading Scale</h2>
                <p>Each exam has an independent GPA. There is no combined total GPA across Half-Yearly, Year-Change, Pre-Test, and Test exams.</p>
            </div>
            <div class="grade-table-wrap reveal">
                <table class="grade-table">
                    <thead>
                        <tr>
                            <th>Marks</th>
                            <th>Grade</th>
                            <th>Grade Point</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="gt-aplus"><td>80–100</td><td><span class="grade-badge gb-aplus">A+</span></td><td>5.00</td></tr>
                        <tr><td>70–79</td><td><span class="grade-badge gb-a">A</span></td><td>4.00</td></tr>
                        <tr class="gt-alt"><td>60–69</td><td><span class="grade-badge gb-am">A-</span></td><td>3.50</td></tr>
                        <tr><td>50–59</td><td><span class="grade-badge gb-b">B</span></td><td>3.00</td></tr>
                        <tr class="gt-alt"><td>40–49</td><td><span class="grade-badge gb-c">C</span></td><td>2.00</td></tr>
                        <tr><td>33–39</td><td><span class="grade-badge gb-d">D</span></td><td>1.00</td></tr>
                        <tr class="gt-alt"><td>0–32</td><td><span class="grade-badge gb-f">F</span></td><td>0.00</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- ══════════════════ RESOURCES BAND ══════════════════ -->
    <section class="resources-band">
        <div class="container">
            <div class="section-head reveal" style="margin-bottom:48px;">
                <div class="section-kicker" style="color:rgba(255,255,255,.5);">Support</div>
                <h2 style="color:#fff;">Academic Resources</h2>
                <p style="color:rgba(255,255,255,.55);">Everything you need to plan and manage your HSC and degree journey.</p>
            </div>
            <div class="resources-grid">
                <div class="resource-card reveal">
                    <div class="rc-icon"><i class="far fa-calendar-alt"></i></div>
                    <h4>Academic Calendar</h4>
                    <p>Important dates — HSC classes, exam schedule, and college holidays.</p>
                </div>
                <div class="resource-card reveal">
                    <div class="rc-icon"><i class="fas fa-book"></i></div>
                    <h4>Syllabus (পাঠ্যসূচি)</h4>
                    <p>Bangladesh Education Board approved HSC syllabi and exam outlines.</p>
                </div>
                <div class="resource-card reveal">
                    <div class="rc-icon"><i class="fas fa-file-alt"></i></div>
                    <h4>Examination Cell</h4>
                    <p>Board registration, test exam schedule, admit cards, and results portal.</p>
                </div>
                <div class="resource-card reveal">
                    <div class="rc-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <h4>Class Counselling</h4>
                    <p>Academic support and group selection guidance for newly admitted students.</p>
                </div>
            </div>
        </div>
    </section>

<?php include '../includes/footer.php'; ?>