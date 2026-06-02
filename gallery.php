<?php
$page       = 'gallery';
$page_title = 'Gallery | Phulpur Mohila Degree College';
$page_css   = 'gallery.css';
$base_path  = './';
require_once 'includes/gallery-data.php';
$grouped     = pmdc_gallery_grouped();
$years       = pmdc_gallery_years();
$all         = pmdc_gallery_get_all();
$totalPhotos = count($all);
$totalYears  = count($years);
$latestYear  = $years ? max($years) : date('Y');
include 'includes/header.php';
?>

<!-- ══════════════════ PAGE HERO — same style as all other pages ══════════════════ -->
<section class="page-hero">
    <div class="container ph-content">
        <div class="ph-kicker reveal" data-i18n="gallery.kicker">আমাদের গ্যালারি</div>
        <h1 class="reveal" data-i18n="gallery.h1">গ্যালারি</h1>
        <p class="reveal" data-i18n="gallery.desc">ইভেন্ট, ক্যাম্পাস জীবন ও অনুষ্ঠানের ছবিসমূহ</p>
        <div class="gallery-hero-stats reveal">
            <div class="ghs-badge">
                <i class="fas fa-images"></i>
                <span class="ghs-val"><?php echo $totalPhotos; ?></span>
                <span class="ghs-lbl" data-i18n="gallery.stat.photos">মোট ছবি</span>
            </div>
            <div class="ghs-badge">
                <i class="fas fa-layer-group"></i>
                <span class="ghs-val"><?php echo $totalYears; ?></span>
                <span class="ghs-lbl" data-i18n="gallery.stat.years">বছর</span>
            </div>
            <div class="ghs-badge">
                <i class="fas fa-calendar-check"></i>
                <span class="ghs-val"><?php echo $latestYear; ?></span>
                <span class="ghs-lbl" data-i18n="gallery.stat.latest">সর্বশেষ</span>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════ YEAR FILTER BAR ══════════════════ -->
<div class="gallery-filter-wrap" id="galleryFilterBar">
    <div class="container">
        <div class="gallery-filter-scroll">
            <button class="filter-btn active" data-year="all" data-i18n="gallery.filter.all">সব</button>
            <?php foreach ($years as $y): ?>
            <button class="filter-btn" data-year="<?php echo $y; ?>"><?php echo $y; ?></button>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- ══════════════════ GALLERY CONTENT ══════════════════ -->
<section class="gallery-body">
    <div class="container">

        <?php if (empty($grouped)): ?>
        <div class="gallery-empty">
            <div class="ge-icon-wrap"><i class="far fa-image"></i></div>
            <h3 data-i18n="gallery.empty.title">এখনো কোনো ছবি নেই।</h3>
            <p data-i18n="gallery.empty.sub">শীঘ্রই আপডেট করা হবে।</p>
        </div>

        <?php else: ?>
        <?php foreach ($grouped as $year => $photos): ?>

        <div class="gallery-year-section" data-year-section="<?php echo $year; ?>">
            <div class="gys-header reveal">
                <div class="gys-title">
                    <span class="gys-year-num"><?php echo $year; ?></span>
                </div>
                <span class="gys-count">
                    <i class="fas fa-images"></i>
                    <?php echo count($photos); ?> <span data-i18n="gallery.photos">ছবি</span>
                </span>
            </div>

            <div class="gallery-grid" id="grid-<?php echo $year; ?>" data-year="<?php echo $year; ?>">
                <?php foreach ($photos as $idx => $photo):
                    $isExternal = !empty($photo['is_external']);
                    $src   = $isExternal ? $photo['filename'] : 'uploads/gallery/' . $photo['filename'];
                    $thumb = $isExternal ? $photo['filename'] : 'uploads/gallery/thumbs/' . $photo['filename'];
                    $title = htmlspecialchars($photo['title'] ?: 'Photo', ENT_QUOTES, 'UTF-8');
                    $date  = date('d M Y', strtotime($photo['date_uploaded']));
                    $extra = $idx >= 24 ? 'style="display:none;" data-extra="1"' : '';
                ?>
                <div class="gallery-thumb"
                     <?php echo $extra; ?>
                     data-src="<?php echo htmlspecialchars($src, ENT_QUOTES); ?>"
                     data-title="<?php echo $title; ?>"
                     data-date="<?php echo $date; ?>"
                     data-year="<?php echo $year; ?>"
                     data-idx="<?php echo $idx; ?>"
                     role="button" tabindex="0"
                     aria-label="View: <?php echo $title; ?>">
                    <img src="<?php echo htmlspecialchars($thumb, ENT_QUOTES); ?>"
                         alt="<?php echo $title; ?>"
                         loading="lazy">
                    <div class="gthumb-overlay">
                        <div class="gthumb-zoom"><i class="fas fa-expand-alt"></i></div>
                    </div>
                    <div class="gthumb-label"><?php echo $title; ?></div>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if (count($photos) > 24): ?>
            <div class="gallery-loadmore" id="loadmore-<?php echo $year; ?>">
                <button class="glm-btn" onclick="galleryLoadMore(<?php echo $year; ?>)">
                    <i class="fas fa-plus-circle"></i>
                    <span data-i18n="gallery.loadmore">আরও ছবি দেখুন</span>
                </button>
            </div>
            <?php endif; ?>
        </div>

        <?php endforeach; ?>
        <?php endif; ?>

    </div>
</section>

<!-- ══════════════════ LIGHTBOX ══════════════════ -->
<div class="gallery-lightbox" id="galleryLightbox"
     role="dialog" aria-modal="true" aria-label="Photo viewer">
    <div class="glb-overlay" id="glbOverlay"></div>
    <div class="glb-panel">
        <div class="glb-topbar">
            <span class="glb-counter" id="glbCounter">1 / 1</span>
            <button class="glb-close" id="glbClose" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <div class="glb-stage">
            <button class="glb-arrow glb-prev" id="glbPrev" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
            <div class="glb-img-wrap" id="glbImgWrap">
                <img src="" alt="" id="glbImg" class="glb-photo">
                <div class="glb-spinner" id="glbSpinner"><div class="glb-spinner-ring"></div></div>
            </div>
            <button class="glb-arrow glb-next" id="glbNext" aria-label="Next"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="glb-caption">
            <div class="glb-title" id="glbTitle"></div>
            <div class="glb-date"  id="glbDate"></div>
        </div>
        <div class="glb-dots" id="glbDots"></div>
    </div>
</div>

<script src="javascript/gallery.js"></script>
<?php include 'includes/footer.php'; ?>
