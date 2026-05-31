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
                <div class="group-card reveal">
                    <div class="group-header gc-sci">
                        <div class="gh-icon"><i class="fas fa-flask"></i></div>
                        <div>
                            <div class="gh-label">বিজ্ঞান বিভাগ</div>
                            <div class="gh-title">Science Group</div>
                        </div>
                    </div>
                    <ul class="subject-list">
                        <li><span class="sub-name">Physics 1st Paper <em>পদার্থবিজ্ঞান ১ম</em></span><span class="sub-code">174</span></li>
                        <li><span class="sub-name">Physics 2nd Paper <em>পদার্থবিজ্ঞান ২য়</em></span><span class="sub-code">175</span></li>
                        <li><span class="sub-name">Chemistry 1st Paper <em>রসায়ন ১ম</em></span><span class="sub-code">176</span></li>
                        <li><span class="sub-name">Chemistry 2nd Paper <em>রসায়ন ২য়</em></span><span class="sub-code">177</span></li>
                        <li><span class="sub-name">Biology 1st Paper <em>জীববিজ্ঞান ১ম</em></span><span class="sub-code">178</span></li>
                        <li><span class="sub-name">Biology 2nd Paper <em>জীববিজ্ঞান ২য়</em></span><span class="sub-code">179</span></li>
                        <li><span class="sub-name">Higher Math 1st Paper <em>উচ্চতর গণিত ১ম</em></span><span class="sub-code">265</span></li>
                        <li><span class="sub-name">Higher Math 2nd Paper <em>উচ্চতর গণিত ২য়</em></span><span class="sub-code">266</span></li>
                    </ul>
                    <div class="group-footer">
                        <a href="#" class="read-more">View Full Syllabus <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Commerce -->
                <div class="group-card reveal">
                    <div class="group-header gc-com">
                        <div class="gh-icon"><i class="fas fa-briefcase"></i></div>
                        <div>
                            <div class="gh-label">ব্যবসায় শিক্ষা বিভাগ</div>
                            <div class="gh-title">Commerce Group</div>
                        </div>
                    </div>
                    <ul class="subject-list">
                        <li><span class="sub-name">Accounting 1st Paper <em>হিসাববিজ্ঞান ১ম</em></span><span class="sub-code">253</span></li>
                        <li><span class="sub-name">Accounting 2nd Paper <em>হিসাববিজ্ঞান ২য়</em></span><span class="sub-code">254</span></li>
                        <li><span class="sub-name">Finance &amp; Banking 1st Paper</span><span class="sub-code">292</span></li>
                        <li><span class="sub-name">Finance &amp; Banking 2nd Paper</span><span class="sub-code">293</span></li>
                        <li><span class="sub-name">Business Organisation 1st Paper</span><span class="sub-code">277</span></li>
                        <li><span class="sub-name">Business Organisation 2nd Paper</span><span class="sub-code">278</span></li>
                        <li><span class="sub-name">Production Management 1st Paper</span><span class="sub-code">286</span></li>
                        <li><span class="sub-name">Production Management 2nd Paper</span><span class="sub-code">287</span></li>
                    </ul>
                    <div class="group-footer">
                        <a href="#" class="read-more">View Full Syllabus <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Humanities -->
                <div class="group-card reveal">
                    <div class="group-header gc-hum">
                        <div class="gh-icon"><i class="fas fa-book"></i></div>
                        <div>
                            <div class="gh-label">মানবিক বিভাগ</div>
                            <div class="gh-title">Humanities Group</div>
                        </div>
                    </div>
                    <ul class="subject-list">
                        <li><span class="sub-name">Civics &amp; Good Governance 1st Paper</span><span class="sub-code">269</span></li>
                        <li><span class="sub-name">Civics &amp; Good Governance 2nd Paper</span><span class="sub-code">270</span></li>
                        <li><span class="sub-name">Sociology 1st Paper <em>সমাজবিজ্ঞান</em></span><span class="sub-code">117</span></li>
                        <li><span class="sub-name">Sociology 2nd Paper</span><span class="sub-code">118</span></li>
                        <li><span class="sub-name">Economics 1st Paper <em>অর্থনীতি</em></span><span class="sub-code">109</span></li>
                        <li><span class="sub-name">Economics 2nd Paper</span><span class="sub-code">110</span></li>
                        <li><span class="sub-name">History 1st Paper <em>ইতিহাস</em></span><span class="sub-code">304</span></li>
                        <li><span class="sub-name">History 2nd Paper</span><span class="sub-code">305</span></li>
                        <li><span class="sub-name">Logic <em>যুক্তিবিদ্যা</em></span><span class="sub-code">121/122</span></li>
                        <li><span class="sub-name">Geography <em>ভূগোল</em></span><span class="sub-code">125/126</span></li>
                        <li><span class="sub-name">Social Work <em>সমাজকর্ম</em></span><span class="sub-code">271/272</span></li>
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