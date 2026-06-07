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
            <div class="ph-kicker reveal" data-i18n="ann.kicker">পিএমডিসি আপডেট</div>
            <h1 class="reveal" data-i18n="ann.h1">বিজ্ঞপ্তি ও নোটিশ</h1>
            <p class="reveal" data-i18n="ann.desc">ফুলপুর মহিলা ডিগ্রি কলেজের সর্বশেষ সংবাদ, পরীক্ষার সময়সূচি এবং গুরুত্বপূর্ণ নোটিশ সম্পর্কে আপডেট থাকুন।</p>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="ann-layout">

                <div class="ann-main">
                    <div class="filter-bar reveal">
                        <button class="filter-btn active" data-category="all">
                            <i class="fas fa-list"></i> <span data-i18n="ann.filter.all">সব</span>
                        </button>
                        <button class="filter-btn" data-category="academic">
                            <i class="fas fa-graduation-cap"></i> <span data-i18n="ann.filter.academic">একাডেমিক</span>
                        </button>
                        <button class="filter-btn" data-category="admission">
                            <i class="fas fa-user-plus"></i> <span data-i18n="ann.filter.admission">ভর্তি</span>
                        </button>
                        <button class="filter-btn" data-category="event">
                            <i class="fas fa-calendar-alt"></i> <span data-i18n="ann.filter.events">অনুষ্ঠান</span>
                        </button>
                        <button class="filter-btn" data-category="notice">
                            <i class="fas fa-bell"></i> <span data-i18n="ann.filter.notices">নোটিশ</span>
                        </button>
                    </div>

                    <div class="ann-list" id="annList">
                        <?php foreach ($announcements as $item): ?>
                            <?php
                            $ts = strtotime($item['date']);
                            $detailUrl = 'announcement-detail.php?id=' . urlencode((string)$item['id']);
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
                                        <span data-i18n="home.news.readmore">আরও পড়ুন</span> &rarr;
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="no-results" id="noResults" style="display:none;">
                        <i class="fas fa-search"></i>
                        <p data-i18n="ann.noResults">এই বিভাগে কোনো বিজ্ঞপ্তি নেই।</p>
                    </div>
                </div>

                <aside class="ann-sidebar">
                    <div class="sidebar-card reveal">
                        <h4 class="sc-title"><i class="fas fa-link"></i> <span data-i18n="ann.sidebar.quickaccess">দ্রুত অ্যাক্সেস</span></h4>
                        <div class="quick-links">
                            <a href="results.php" class="ql-item">
                                <i class="fas fa-trophy"></i>
                                <div>
                                    <strong data-i18n="ann.sidebar.examresults">পরীক্ষার ফলাফল</strong>
                                    <span data-i18n="ann.sidebar.hscresults">এইচএসসি বোর্ড ফলাফল দেখুন</span>
                                </div>
                                <i class="fas fa-chevron-right ql-arrow"></i>
                            </a>
                            <a href="academics.php" class="ql-item">
                                <i class="fas fa-graduation-cap"></i>
                                <div>
                                    <strong data-i18n="ann.sidebar.academics">একাডেমিক</strong>
                                    <span data-i18n="ann.sidebar.groups">বিভাগ ও বিষয়</span>
                                </div>
                                <i class="fas fa-chevron-right ql-arrow"></i>
                            </a>
                            <a href="contact.php" class="ql-item">
                                <i class="fas fa-envelope"></i>
                                <div>
                                    <strong data-i18n="ann.sidebar.contact">অফিসে যোগাযোগ</strong>
                                    <span data-i18n="ann.sidebar.touch">যোগাযোগ করুন</span>
                                </div>
                                <i class="fas fa-chevron-right ql-arrow"></i>
                            </a>
                            <a href="../pages/portal/portal-login.php" class="ql-item">
                                <i class="fas fa-lock"></i>
                                <div>
                                    <strong data-i18n="ann.sidebar.portal">স্টাফ পোর্টাল</strong>
                                    <span data-i18n="ann.sidebar.login">শিক্ষক / প্রশাসন লগইন</span>
                                </div>
                                <i class="fas fa-chevron-right ql-arrow"></i>
                            </a>
                        </div>
                    </div>

                    <div class="sidebar-card reveal">
                        <h4 class="sc-title"><i class="fas fa-calendar-alt"></i> <span data-i18n="ann.sidebar.events">আসন্ন অনুষ্ঠান</span></h4>
                        <div class="upcoming-list">
                            <?php
                            $event_count = 0;
                            $dot_colors = ['dot-blue', 'dot-gold', 'dot-red', 'dot-green'];
                            foreach ($announcements as $item):
                                if ($item['category'] !== 'event') continue;
                                if ($event_count >= 4) break;
                                $ts = strtotime($item['date']);
                                $detailUrl = 'announcement-detail.php?id=' . urlencode((string)$item['id']);
                                $dot_class = $dot_colors[$event_count % 4];
                                $event_count++;
                            ?>
                            <a href="<?php echo htmlspecialchars($detailUrl, ENT_QUOTES, 'UTF-8'); ?>" class="up-item" style="text-decoration: none; display: flex;">
                                <div class="up-dot <?php echo $dot_class; ?>"></div>
                                <div>
                                    <div class="up-title" style="color: var(--navy);"><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    <div class="up-date"><?php echo date('F d, Y', $ts); ?></div>
                                </div>
                            </a>
                            <?php endforeach; ?>
                            <?php if ($event_count === 0): ?>
                            <p style="padding: 10px; color: var(--muted); font-size: 0.85rem;">No upcoming events.</p>
                            <?php endif; ?>
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

