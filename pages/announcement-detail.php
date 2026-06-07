<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/announcements-data.php';

$page = 'announcements';
$base_path = '../';
$announcementId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$announcementSlug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
$announcements = pmdc_get_published_announcements();

$announcement = null;
$currentIndex = null;
foreach ($announcements as $idx => $item) {
    if ($announcementId > 0 && (int)$item['id'] === $announcementId) {
        $announcement = $item;
        $currentIndex = $idx;
        break;
    } elseif ($announcementSlug !== '' && $item['slug'] === $announcementSlug) {
        $announcement = $item;
        $currentIndex = $idx;
        break;
    }
}

function pmdc_meta_excerpt($text, $limit = 150) {
    $clean = trim(preg_replace('/\s+/', ' ', $text));
    if (strlen($clean) <= $limit) return $clean;
    return rtrim(substr($clean, 0, $limit - 1)) . '...';
}

function pmdc_render_announcement_body($text) {
    $parts = preg_split("/\r\n\r\n|\n\n|\r\r/", trim($text));
    $html = '';
    foreach ($parts as $part) {
        $p = nl2br(htmlspecialchars(trim($part), ENT_QUOTES, 'UTF-8'));
        if ($p !== '') $html .= '<p>' . $p . '</p>';
    }
    return $html;
}

$page_css = 'announcement-detail.css';
$page_js = 'announcement-detail.js';

if ($announcement) {
    $page_title = $announcement['title'] . ' | Announcements | Phulpur Mohila Degree College';
    $page_meta_description = pmdc_meta_excerpt($announcement['body'], 150);
    $currentUrl = BASE_URL . '/announcement/' . ($announcement['slug'] ? $announcement['slug'] : $announcement['id']);
    $page_meta_tags = "\n"
        . '<meta property="og:title" content="' . htmlspecialchars($announcement['title'], ENT_QUOTES, 'UTF-8') . '">' . "\n"
        . '<meta property="og:description" content="' . htmlspecialchars($page_meta_description, ENT_QUOTES, 'UTF-8') . '">' . "\n"
        . '<meta property="og:type" content="article">' . "\n"
        . '<meta property="og:url" content="' . htmlspecialchars($currentUrl, ENT_QUOTES, 'UTF-8') . '">' . "\n";
} else {
    $page_title = 'Announcement Not Found | Phulpur Mohila Degree College';
    $page_meta_description = 'This announcement may have been removed or does not exist.';
}

include '../includes/header.php';
?>

<?php if (!$announcement): ?>
    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-kicker reveal">Announcements</div>
            <h1 class="reveal">Announcement Not Found</h1>
            <p class="reveal">This announcement may have been removed or does not exist.</p>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="ann-not-found reveal">
                <i class="fas fa-file-circle-xmark"></i>
                <h2>Announcement Not Found</h2>
                <p>This announcement may have been removed or does not exist.</p>
                <a href="<?= BASE_URL ?>/announcement" class="btn btn-primary">Back to Announcements</a>
            </div>
        </div>
    </section>

<?php else: ?>
    <?php
    $ts = strtotime($announcement['date']);
    $prevAnn = ($currentIndex !== null && isset($announcements[$currentIndex + 1])) ? $announcements[$currentIndex + 1] : null;
    $nextAnn = ($currentIndex !== null && $currentIndex > 0 && isset($announcements[$currentIndex - 1])) ? $announcements[$currentIndex - 1] : null;

    $recentAnnouncements = array_values(array_filter($announcements, static function($item) use ($announcement) {
        return (int)$item['id'] !== (int)$announcement['id'];
    }));
    $recentAnnouncements = array_slice($recentAnnouncements, 0, 5);

    $attachment = $announcement['attachment'] ?? null;
    $attachmentType = $attachment['type'] ?? '';
    $attachmentName = $attachment['name'] ?? '';
    $attachmentUrl = $attachment['url'] ?? '#';
    $attachmentSize = $attachment['size'] ?? '';
    ?>
    <section class="page-hero ann-detail-hero">
        <div class="container ph-content">
            <div class="ann-tags reveal">
                <span class="ann-tag tag-<?php echo htmlspecialchars($announcement['category'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars($announcement['category_label'], ENT_QUOTES, 'UTF-8'); ?>
                </span>
            </div>
            <h1 class="reveal"><?php echo htmlspecialchars($announcement['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <div class="ann-meta-row reveal">
                <span><i class="fas fa-calendar-alt"></i> <?php echo date('F j, Y', $ts); ?></span>
                <span><i class="fas fa-pen"></i> Posted by: <?php echo htmlspecialchars($announcement['author'], ENT_QUOTES, 'UTF-8'); ?></span>
                <span><i class="fas fa-school"></i> PMDC</span>
            </div>
        </div>
    </section>

    <section class="section-padding ann-detail-section">
        <div class="container">
            <div class="ann-detail-layout">
                <div class="ann-detail-main">
                    <article class="ann-detail-card detail-animate" id="annContentCard">
                        <div class="ann-message-body">
                            <?php echo pmdc_render_announcement_body($announcement['body']); ?>
                        </div>

                        <?php if ($attachment): ?>
                            <div class="attachment-section">
                                <h3>Attachment</h3>

                                <?php if ($attachmentType === 'image'): ?>
                                    <div class="attachment-image-wrap">
                                        <img src="<?php echo htmlspecialchars($attachmentUrl, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($attachmentName, ENT_QUOTES, 'UTF-8'); ?>">
                                    </div>
                                    <a href="<?php echo htmlspecialchars($attachmentUrl, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener" class="btn-attach-outline">Download Image</a>
                                <?php else: ?>
                                    <?php
                                    $isPdf = stripos($attachmentName, '.pdf') !== false || $attachmentType === 'pdf';
                                    $docIcon = $isPdf ? 'fa-file-pdf' : 'fa-file-word';
                                    $docCls = $isPdf ? 'doc-pdf' : 'doc-word';
                                    ?>
                                    <div class="attachment-doc-card">
                                        <div class="doc-icon <?php echo $docCls; ?>">
                                            <i class="fas <?php echo $docIcon; ?>"></i>
                                        </div>
                                        <div class="doc-info">
                                            <strong><?php echo htmlspecialchars($attachmentName, ENT_QUOTES, 'UTF-8'); ?></strong>
                                            <span><?php echo htmlspecialchars($attachmentSize, ENT_QUOTES, 'UTF-8'); ?></span>
                                        </div>
                                        <a href="<?php echo htmlspecialchars($attachmentUrl, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener" class="btn-doc-download">Download</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </article>

                    <?php if ($prevAnn || $nextAnn): ?>
                        <div class="ann-detail-nav detail-animate">
                            <?php if ($prevAnn): 
                                $prevUrl = BASE_URL . '/announcement/' . ($prevAnn['slug'] ? $prevAnn['slug'] : $prevAnn['id']);
                            ?>
                                <a href="<?php echo $prevUrl; ?>" class="ann-nav-link left">
                                    <span class="arr">&larr;</span> Previous Announcement
                                </a>
                            <?php endif; ?>
                            <?php if ($nextAnn): 
                                $nextUrl = BASE_URL . '/announcement/' . ($nextAnn['slug'] ? $nextAnn['slug'] : $nextAnn['id']);
                            ?>
                                <a href="<?php echo $nextUrl; ?>" class="ann-nav-link right">
                                    Next Announcement <span class="arr">&rarr;</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <aside class="ann-detail-sidebar">
                    <div class="sidebar-card reveal sidebar-stagger">
                        <h4 class="sc-title"><i class="fas fa-clock"></i> Recent Announcements</h4>
                        <div class="recent-ann-list">
                            <?php foreach ($recentAnnouncements as $recent): ?>
                                <?php 
                                    $rts = strtotime($recent['date']); 
                                    $recentUrl = BASE_URL . '/announcement/' . ($recent['slug'] ? $recent['slug'] : $recent['id']);
                                ?>
                                <a href="<?php echo $recentUrl; ?>" class="recent-ann-item">
                                    <div class="ann-date">
                                        <span class="ad-day"><?php echo date('d', $rts); ?></span>
                                        <span class="ad-mon"><?php echo date('M', $rts); ?></span>
                                    </div>
                                    <div class="recent-ann-title"><?php echo htmlspecialchars($recent['title'], ENT_QUOTES, 'UTF-8'); ?></div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <a href="<?= BASE_URL ?>/announcement" class="view-all-ann">View All Announcements <i class="fas fa-arrow-right"></i></a>
                    </div>

                    <div class="sidebar-card reveal sidebar-stagger">
                        <h4 class="sc-title"><i class="fas fa-share-alt"></i> Share This</h4>
                        <div class="share-row">
                            <button class="share-btn share-copy" id="copyLinkBtn" type="button">
                                <i class="fas fa-link"></i> Copy Link
                            </button>
                            <a class="share-btn share-facebook" id="shareFacebookBtn" target="_blank" rel="noopener" href="#">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a class="share-btn share-whatsapp" id="shareWhatsappBtn" target="_blank" rel="noopener" href="#">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                </aside>
            </div>

            <div class="ann-back-row reveal">
                <a href="<?= BASE_URL ?>/announcement" class="ann-back-link">&larr; Back to Announcements</a>
            </div>
        </div>
    </section>

    <div class="link-toast" id="linkToast">Link copied!</div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
