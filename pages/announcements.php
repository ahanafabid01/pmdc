<?php
$page       = 'announcements';
$page_title = 'Announcements | Phulpur Mohila Degree College';
$page_css   = 'announcements.css';
$base_path  = '../';
include '../includes/header.php';
?>

    <!-- ══════════════════ PAGE HEADER ══════════════════ -->
    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-kicker reveal">PMDC Updates</div>
            <h1 class="reveal">Announcements &amp; Notices</h1>
            <p class="reveal">Stay updated with the latest news, exam schedules, and important notices from Phulpur Mohila Degree College.</p>
        </div>
    </section>

    <!-- ══════════════════ FILTER + LIST ══════════════════ -->
    <section class="section-padding">
        <div class="container">
            <div class="ann-layout">

                <!-- Main Content -->
                <div class="ann-main">

                    <!-- Filter Tabs -->
                    <div class="filter-bar reveal">
                        <button class="filter-btn active" data-category="all">
                            <i class="fas fa-list"></i> All
                        </button>
                        <button class="filter-btn" data-category="academic">
                            <i class="fas fa-graduation-cap"></i> Academic
                        </button>
                        <button class="filter-btn" data-category="admission">
                            <i class="fas fa-user-plus"></i> Admission
                        </button>
                        <button class="filter-btn" data-category="event">
                            <i class="fas fa-calendar-alt"></i> Events
                        </button>
                        <button class="filter-btn" data-category="notice">
                            <i class="fas fa-bell"></i> Notices
                        </button>
                    </div>

                    <!-- Announcement List -->
                    <div class="ann-list" id="annList">

                        <div class="ann-item reveal" data-category="admission">
                            <div class="ann-date">
                                <span class="ad-day">08</span>
                                <span class="ad-mon">Feb</span>
                            </div>
                            <div class="ann-body">
                                <div class="ann-tags">
                                    <span class="ann-tag tag-admission">Admission</span>
                                    <span class="ann-badge badge-urgent">Urgent</span>
                                </div>
                                <h3>Admission Open for Session 2026–27</h3>
                                <p>Applications are now being accepted for HSC 1st Year (একাদশ শ্রেণি) across Science, Commerce, and Humanities groups. Eligible SSC/Dakhil pass students may apply before the deadline.</p>
                                <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>

                        <div class="ann-item reveal" data-category="academic">
                            <div class="ann-date">
                                <span class="ad-day">06</span>
                                <span class="ad-mon">Feb</span>
                            </div>
                            <div class="ann-body">
                                <div class="ann-tags">
                                    <span class="ann-tag tag-academic">Academic</span>
                                    <span class="ann-badge badge-new">New</span>
                                </div>
                                <h3>HSC Test Examination 2026 — Schedule Released</h3>
                                <p>The pre-board test examination (টেস্ট পরীক্ষা) timetable for HSC 2nd Year (দ্বাদশ শ্রেণি) students has been published. Students must collect their admit cards from the college office.</p>
                                <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>

                        <div class="ann-item reveal" data-category="event">
                            <div class="ann-date">
                                <span class="ad-day">05</span>
                                <span class="ad-mon">Feb</span>
                            </div>
                            <div class="ann-body">
                                <div class="ann-tags">
                                    <span class="ann-tag tag-event">Event</span>
                                </div>
                                <h3>সাংস্কৃতিক অনুষ্ঠান — Annual Cultural Programme 2026</h3>
                                <p>The annual cultural programme showcasing student talent in music, dance, drama, and the arts will take place in the college auditorium. All students are encouraged to participate.</p>
                                <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>

                        <div class="ann-item reveal" data-category="notice">
                            <div class="ann-date">
                                <span class="ad-day">03</span>
                                <span class="ad-mon">Feb</span>
                            </div>
                            <div class="ann-body">
                                <div class="ann-tags">
                                    <span class="ann-tag tag-notice">Notice</span>
                                    <span class="ann-badge badge-important">Important</span>
                                </div>
                                <h3>অভিভাবক সমাবেশ — Parents' Meeting Notice</h3>
                                <p>All parents of HSC 1st &amp; 2nd Year students are invited to attend the parents' meeting on campus. Please bring the student ID card. Attendance is strongly encouraged.</p>
                                <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>

                        <div class="ann-item reveal" data-category="admission">
                            <div class="ann-date">
                                <span class="ad-day">25</span>
                                <span class="ad-mon">Jan</span>
                            </div>
                            <div class="ann-body">
                                <div class="ann-tags">
                                    <span class="ann-tag tag-admission">Admission</span>
                                </div>
                                <h3>Scholarship Applications 2026 — Now Open</h3>
                                <p>Merit-based and need-based scholarships are available for eligible students. Application deadline: 28th February 2026. Submit applications through the college office.</p>
                                <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>

                        <div class="ann-item reveal" data-category="event">
                            <div class="ann-date">
                                <span class="ad-day">22</span>
                                <span class="ad-mon">Jan</span>
                            </div>
                            <div class="ann-body">
                                <div class="ann-tags">
                                    <span class="ann-tag tag-event">Event</span>
                                </div>
                                <h3>Guest Lecture — Women Empowerment &amp; Leadership</h3>
                                <p>A special guest lecture on women's empowerment and educational leadership will be held at the college premises. All HSC students are welcome to attend. Entry is free.</p>
                                <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>

                        <div class="ann-item reveal" data-category="academic">
                            <div class="ann-date">
                                <span class="ad-day">18</span>
                                <span class="ad-mon">Jan</span>
                            </div>
                            <div class="ann-body">
                                <div class="ann-tags">
                                    <span class="ann-tag tag-academic">Academic</span>
                                </div>
                                <h3>HSC Board Exam Results 2025 — 92% Pass Rate</h3>
                                <p>Phulpur Mohila Degree College achieved an outstanding 92% pass rate in the HSC Annual Examination 2025, with 48 students receiving GPA 5.00 (A+). Full results available on the Results page.</p>
                                <a href="results.php" class="read-more">View Results <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>

                        <div class="ann-item reveal" data-category="notice">
                            <div class="ann-date">
                                <span class="ad-day">10</span>
                                <span class="ad-mon">Jan</span>
                            </div>
                            <div class="ann-body">
                                <div class="ann-tags">
                                    <span class="ann-tag tag-notice">Notice</span>
                                </div>
                                <h3>College Closed — National Holiday</h3>
                                <p>The college will remain closed on the upcoming national holiday. Regular classes will resume the following working day. Students are advised to plan accordingly.</p>
                                <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>

                    </div><!-- /.ann-list -->

                    <div class="no-results" id="noResults" style="display:none;">
                        <i class="fas fa-search"></i>
                        <p>No announcements in this category.</p>
                    </div>

                </div><!-- /.ann-main -->

                <!-- Sidebar -->
                <aside class="ann-sidebar">

                    <div class="sidebar-card reveal">
                        <h4 class="sc-title"><i class="fas fa-link"></i> Quick Access</h4>
                        <div class="quick-links">
                            <a href="results.php" class="ql-item">
                                <i class="fas fa-trophy"></i>
                                <div>
                                    <strong>Exam Results</strong>
                                    <span>View HSC board results</span>
                                </div>
                                <i class="fas fa-chevron-right ql-arrow"></i>
                            </a>
                            <a href="academics.php" class="ql-item">
                                <i class="fas fa-graduation-cap"></i>
                                <div>
                                    <strong>Academics</strong>
                                    <span>Groups &amp; subjects</span>
                                </div>
                                <i class="fas fa-chevron-right ql-arrow"></i>
                            </a>
                            <a href="contact.php" class="ql-item">
                                <i class="fas fa-envelope"></i>
                                <div>
                                    <strong>Contact Office</strong>
                                    <span>Get in touch</span>
                                </div>
                                <i class="fas fa-chevron-right ql-arrow"></i>
                            </a>
                            <a href="../pages/portal/portal-login.php" class="ql-item">
                                <i class="fas fa-lock"></i>
                                <div>
                                    <strong>Staff Portal</strong>
                                    <span>Teacher / Admin login</span>
                                </div>
                                <i class="fas fa-chevron-right ql-arrow"></i>
                            </a>
                        </div>
                    </div>

                    <div class="sidebar-card reveal">
                        <h4 class="sc-title"><i class="fas fa-calendar-alt"></i> Upcoming Events</h4>
                        <div class="upcoming-list">
                            <div class="up-item">
                                <div class="up-dot dot-blue"></div>
                                <div>
                                    <div class="up-title">অভিভাবক সমাবেশ (Parents' Meeting)</div>
                                    <div class="up-date">10:00 AM – 1:00 PM</div>
                                </div>
                            </div>
                            <div class="up-item">
                                <div class="up-dot dot-gold"></div>
                                <div>
                                    <div class="up-title">Annual Cultural Programme</div>
                                    <div class="up-date">4:00 PM onwards</div>
                                </div>
                            </div>
                            <div class="up-item">
                                <div class="up-dot dot-red"></div>
                                <div>
                                    <div class="up-title">HSC বার্ষিক পরীক্ষা (Board Exam)</div>
                                    <div class="up-date">Nov 15 – Dec 15</div>
                                </div>
                            </div>
                            <div class="up-item">
                                <div class="up-dot dot-green"></div>
                                <div>
                                    <div class="up-title">Class XI Admission Last Date</div>
                                    <div class="up-date">28 Feb 2026</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </aside>

            </div>
        </div>
    </section>

    <script>
    // Category filter
    const btns    = document.querySelectorAll('.filter-btn');
    const items   = document.querySelectorAll('.ann-item');
    const noRes   = document.getElementById('noResults');

    btns.forEach(btn => {
        btn.addEventListener('click', () => {
            btns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const cat = btn.dataset.category;
            let visible = 0;
            items.forEach(item => {
                const show = cat === 'all' || item.dataset.category === cat;
                item.style.display = show ? '' : 'none';
                if (show) visible++;
            });
            noRes.style.display = visible === 0 ? 'flex' : 'none';
        });
    });
    </script>

<?php include '../includes/footer.php'; ?>
