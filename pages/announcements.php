<?php
$page       = 'announcements';
$page_title = 'Announcements | Phulpur Mohila Degree College';
$page_css   = 'announcements.css';
$base_path  = '../';

require_once '../includes/announcements-data.php';
$announcements = pmdc_get_published_announcements();

function pmdc_excerpt($text, $limit = 190) {
    $clean = trim(preg_replace('/\s+/', ' ', $text));
    if (strlen($clean) <= $limit) return $clean;
    return rtrim(substr($clean, 0, $limit - 1)) . '...';
}

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-kicker reveal">PMDC Updates</div>
            <h1 class="reveal">Announcements &amp; Notices</h1>
            <p class="reveal">Stay updated with the latest news, exam schedules, and important notices from Phulpur Mohila Degree College.</p>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="ann-layout">

                <div class="ann-main">
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

                    <div class="ann-list" id="annList">
                        <?php foreach ($announcements as $item): ?>
                            <?php
                            $ts = strtotime($item['date']);
                            $detailUrl = '../announcements/view.php?id=' . urlencode((string)$item['id']);
                            ?>
                            <div class="ann-item reveal" data-category="<?php echo htmlspecialchars($item['category'], ENT_QUOTES, 'UTF-8'); ?>">
                                <div class="ann-date">
                                    <span class="ad-day"><?php echo date('d', $ts); ?></span>
                                    <span class="ad-mon"><?php echo date('M', $ts); ?></span>
                                </div>
                                <div class="ann-body">
                                    <div class="ann-tags">
                                        <span class="ann-tag tag-<?php echo htmlspecialchars($item['category'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <?php echo htmlspecialchars($item['category_label'], ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                        <?php if (!empty($item['badge_label'])): ?>
                                            <span class="ann-badge <?php echo htmlspecialchars($item['badge_class'], ENT_QUOTES, 'UTF-8'); ?>">
                                                <?php echo htmlspecialchars($item['badge_label'], ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <h3>
                                        <a class="ann-title-link" href="<?php echo htmlspecialchars($detailUrl, ENT_QUOTES, 'UTF-8'); ?>">
                                            <?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?>
                                        </a>
                                    </h3>
                                    <p><?php echo htmlspecialchars(pmdc_excerpt($item['body']), ENT_QUOTES, 'UTF-8'); ?></p>
                                    <a href="<?php echo htmlspecialchars($detailUrl, ENT_QUOTES, 'UTF-8'); ?>" class="read-more">
                                        Read More &rarr;
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="no-results" id="noResults" style="display:none;">
                        <i class="fas fa-search"></i>
                        <p>No announcements in this category.</p>
                    </div>
                </div>

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
                                    <div class="up-title">Parents' Meeting</div>
                                    <div class="up-date">10:00 AM - 1:00 PM</div>
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
                                    <div class="up-title">HSC Board Exam</div>
                                    <div class="up-date">Nov 15 - Dec 15</div>
                                </div>
                            </div>
                            <div class="up-item">
                                <div class="up-dot dot-green"></div>
                                <div>
                                    <div class="up-title">Class XI Admission Last Date</div>
                                    <div class="up-date">Feb 28, 2026</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </section>

    <script>
    const btns = document.querySelectorAll('.filter-btn');
    const items = document.querySelectorAll('.ann-item');
    const noRes = document.getElementById('noResults');

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

