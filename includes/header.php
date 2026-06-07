<?php
require_once dirname(__DIR__) . '/config.php';
/* ── Central Bangla page-title map ───────────────────────────
   Pages may override $page_title_bn individually.
   If not set, this map provides the Bangla title automatically.
────────────────────────────────────────────────────────────── */
if (!isset($page_title_bn)) {
    $bn_titles = [
        'home'               => 'ফুলপুর মহিলা ডিগ্রি কলেজ | উৎকর্ষে শিক্ষা',
        'about'              => 'প্রতিষ্ঠান পরিচিতি | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'academics'          => 'একাডেমিক তথ্য | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'hsc-program'        => 'এইচএসসি প্রোগ্রাম | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'degree-program'     => 'ডিগ্রি প্রোগ্রাম | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'announcements'      => 'বিজ্ঞপ্তি | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'gallery'            => 'গ্যালারি | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'teachers'           => 'শিক্ষক ও কর্মচারী | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'results'            => 'ফলাফল | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'contact'            => 'যোগাযোগ | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'holiday-list'       => 'ছুটির তালিকা | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'academic-calendar'  => 'একাডেমিক ক্যালেন্ডার | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'class-routine'      => 'ক্লাস রুটিন | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'exam-routine'       => 'পরীক্ষার রুটিন | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'syllabus'           => 'পাঠ্যক্রম | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'uniform'            => 'পোশাক বিধি | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'rules-regulation'   => 'নিয়ম ও বিধিমালা | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'student-instruction'=> 'শিক্ষার্থী নির্দেশিকা | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'admit-card'         => 'প্রবেশপত্র | ফুলপুর মহিলা ডিগ্রি কলেজ',
        'hsc-form-fillup'    => 'এইচএসসি ফর্ম পূরণ | ফুলপুর মহিলা ডিগ্রি কলেজ',
    ];
    $page_title_bn = $bn_titles[$page ?? 'home'] ?? 'ফুলপুর মহিলা ডিগ্রি কলেজ';
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Phulpur Mohila Degree College | Excellence in Education'; ?></title>
    <meta name="title-en" content="<?php echo htmlspecialchars(isset($page_title) ? $page_title : 'Phulpur Mohila Degree College | Excellence in Education', ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="title-bn" content="<?php echo htmlspecialchars(isset($page_title_bn) ? $page_title_bn : 'ফুলপুর মহিলা ডিগ্রি কলেজ', ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="description" content="<?php echo isset($page_meta_description) ? htmlspecialchars($page_meta_description, ENT_QUOTES, 'UTF-8') : 'Phulpur Mohila Degree College is a women\'s degree college in Phulpur, Mymensingh, established in 1994, offering HSC and degree programmes for women students.'; ?>">
    <?php if(isset($page_meta_tags)) echo $page_meta_tags; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/main.css?v=<?= time() ?>">
    <?php if(isset($page_css)): ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/<?php echo $page_css; ?>?v=<?= time() ?>">
    <?php endif; ?>
    <!-- i18n: load early so translations apply before paint -->
    <script src="<?= BASE_URL ?>/javascript/i18n.js?v=<?= time() ?>"></script>
</head>
<body data-page="<?php echo isset($page) ? htmlspecialchars($page, ENT_QUOTES, 'UTF-8') : 'home'; ?>">

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-left">
                <span><i class="fas fa-phone-alt"></i> 01712-227983</span>
                <span class="top-bar-sep">|</span>
                <span><i class="fas fa-envelope"></i> pmdc@edu.bd</span>
                <span class="top-bar-sep">|</span>
                <span><i class="fas fa-map-marker-alt"></i> Phulpur, Mymensingh</span>
            </div>
            <div class="top-links">
                <a href="#" data-i18n="topbar.library">পাঠাগার</a>
                <a href="#" data-i18n="topbar.alumni">প্রাক্তন শিক্ষার্থী</a>
                <a href="<?= BASE_URL ?>/admin/login" class="portal-link">
                    <i class="fas fa-lock"></i> <span data-i18n="topbar.portal">পোর্টাল</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="<?= BASE_URL ?>/" class="logo">
                <div class="logo-icon-wrap"><i class="fas fa-school"></i></div>
                <div class="logo-text-wrap">
                    <span class="logo-abbr">PMDC</span>
                    <span class="logo-sub">Phulpur Mohila Degree College</span>
                </div>
            </a>
            <button class="hamburger" id="hamburger" aria-label="Toggle navigation" aria-expanded="false">
                <span class="hb-bar"></span>
                <span class="hb-bar"></span>
                <span class="hb-bar"></span>
            </button>
            <ul class="nav-menu" id="nav-menu" role="navigation">
                <li><a href="<?= BASE_URL ?>/"              class="nav-link <?php echo isset($page) && $page == 'home' ? 'active' : ''; ?>" data-i18n="nav.home">হোম</a></li>
                <li><a href="<?= BASE_URL ?>/about"        class="nav-link <?php echo isset($page) && $page == 'about' ? 'active' : ''; ?>" data-i18n="nav.about">প্রতিষ্ঠান পরিচিতি</a></li>

                <!-- Academic Info Dropdown -->
                <?php $is_academic = isset($page_group) && $page_group === 'academic'; ?>
                <li class="nav-has-dropdown">
                    <a href="javascript:void(0)" class="nav-link nav-dropdown-toggle <?php echo $is_academic ? 'active' : ''; ?>">
                        <span data-i18n="nav.academic">একাডেমিক তথ্য</span> <i class="fas fa-chevron-down nav-dropdown-arrow"></i>
                    </a>
                    <ul class="nav-dropdown-menu">
                        <div class="nav-dropdown-inner">
                        <li><a href="<?= BASE_URL ?>/hsc-program"        class="dropdown-item <?php echo isset($page) && $page == 'hsc-program'    ? 'active' : ''; ?>"><i class="fas fa-scroll"></i> <span data-i18n="nav.hsc">এইচএসসি প্রোগ্রাম</span></a></li>
                        <li><a href="<?= BASE_URL ?>/degree-program"     class="dropdown-item <?php echo isset($page) && $page == 'degree-program' ? 'active' : ''; ?>"><i class="fas fa-user-graduate"></i> <span data-i18n="nav.degree">ডিগ্রি প্রোগ্রাম</span></a></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="<?= BASE_URL ?>/academic/holiday-list"           class="dropdown-item <?php echo isset($page) && $page == 'holiday-list' ? 'active' : ''; ?>"><i class="fas fa-umbrella-beach"></i> <span data-i18n="nav.holiday">ছুটির তালিকা</span></a></li>
                        <li><a href="<?= BASE_URL ?>/academic/calendar"      class="dropdown-item <?php echo isset($page) && $page == 'academic-calendar' ? 'active' : ''; ?>"><i class="fas fa-calendar-alt"></i> <span data-i18n="nav.calendar">একাডেমিক ক্যালেন্ডার</span></a></li>
                        <li><a href="<?= BASE_URL ?>/academic/class-routine"          class="dropdown-item <?php echo isset($page) && $page == 'class-routine' ? 'active' : ''; ?>"><i class="fas fa-chalkboard"></i> <span data-i18n="nav.class-routine">ক্লাস রুটিন</span></a></li>
                        <li><a href="<?= BASE_URL ?>/academic/exam-routine"           class="dropdown-item <?php echo isset($page) && $page == 'exam-routine' ? 'active' : ''; ?>"><i class="fas fa-pen-alt"></i> <span data-i18n="nav.exam-routine">পরীক্ষার রুটিন</span></a></li>
                        <li><a href="<?= BASE_URL ?>/academic/syllabus"               class="dropdown-item <?php echo isset($page) && $page == 'syllabus' ? 'active' : ''; ?>"><i class="fas fa-book-open"></i> <span data-i18n="nav.syllabus">পাঠ্যক্রম</span></a></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="<?= BASE_URL ?>/academic/uniform"                class="dropdown-item <?php echo isset($page) && $page == 'uniform' ? 'active' : ''; ?>"><i class="fas fa-tshirt"></i> <span data-i18n="nav.uniform">পোশাক বিধি</span></a></li>
                        <li><a href="<?= BASE_URL ?>/academic/rules"      class="dropdown-item <?php echo isset($page) && $page == 'rules-regulation' ? 'active' : ''; ?>"><i class="fas fa-gavel"></i> <span data-i18n="nav.rules">নিয়ম ও বিধিমালা</span></a></li>
                        <li><a href="<?= BASE_URL ?>/academic/student-instruction"   class="dropdown-item <?php echo isset($page) && $page == 'student-instruction' ? 'active' : ''; ?>"><i class="fas fa-info-circle"></i> <span data-i18n="nav.instruction">শিক্ষার্থী নির্দেশিকা</span></a></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="<?= BASE_URL ?>/academic/admit-card"            class="dropdown-item <?php echo isset($page) && $page == 'admit-card' ? 'active' : ''; ?>"><i class="fas fa-id-card"></i> <span data-i18n="nav.admit">প্রবেশপত্র</span></a></li>
                        <li><a href="<?= BASE_URL ?>/academic/hsc-form"       class="dropdown-item <?php echo isset($page) && $page == 'hsc-form-fillup' ? 'active' : ''; ?>"><i class="fas fa-file-alt"></i> <span data-i18n="nav.form-fillup">এইচএসসি ফর্ম পূরণ</span></a></li>
                        <li><a href="<?= BASE_URL ?>/academic/degree-form"    class="dropdown-item <?php echo isset($page) && $page == 'degree-form-fillup' ? 'active' : ''; ?>"><i class="fas fa-university"></i> <span data-i18n="nav.degree_form_fillup">ডিগ্রি ফর্ম পূরণ</span></a></li>
                        </div>
                    </ul>
                </li>

                <li><a href="<?= BASE_URL ?>/announcement" class="nav-link <?php echo isset($page) && $page == 'announcements' ? 'active' : ''; ?>" data-i18n="nav.announcements">বিজ্ঞপ্তি</a></li>
                <li><a href="<?= BASE_URL ?>/gallery"        class="nav-link <?php echo isset($page) && $page == 'gallery' ? 'active' : ''; ?>" data-i18n="nav.gallery">গ্যালারি</a></li>
                <li><a href="<?= BASE_URL ?>/teachers"      class="nav-link <?php echo isset($page) && $page == 'teachers' ? 'active' : ''; ?>" data-i18n="nav.teachers">শিক্ষক ও কর্মচারী</a></li>
                <li><a href="<?= BASE_URL ?>/results"      class="nav-link <?php echo isset($page) && $page == 'results' ? 'active' : ''; ?>" data-i18n="nav.results">ফলাফল</a></li>
                <li><a href="<?= BASE_URL ?>/contact"      class="nav-link <?php echo isset($page) && $page == 'contact' ? 'active' : ''; ?>" data-i18n="nav.contact">যোগাযোগ</a></li>
                <li class="nav-has-dropdown">
                    <a href="javascript:void(0)" class="nav-link nav-apply nav-dropdown-toggle">
                        <span data-i18n="nav.apply">ভর্তি হন</span> <i class="fas fa-chevron-down nav-dropdown-arrow"></i>
                    </a>
                    <ul class="nav-dropdown-menu">
                        <div class="nav-dropdown-inner">
                            <li><a href="<?= BASE_URL ?>/apply/hsc" class="dropdown-item"><i class="fas fa-file-alt"></i> <span>HSC Admission</span></a></li>
                            <li><a href="<?= BASE_URL ?>/apply/degree" class="dropdown-item"><i class="fas fa-university"></i> <span>Degree Admission</span></a></li>
                        </div>
                    </ul>
                </li>

                <!-- ── Mobile-only info panel — sits directly below Apply ── -->
                <li class="nav-panel-footer">
                    <div class="npf-inner">
                        <!-- Contact info -->
                        <div class="npf-contact">
                            <a href="tel:01712227983" class="npf-item">
                                <i class="fas fa-phone-alt"></i>
                                <span>01712-227983</span>
                            </a>
                            <a href="mailto:pmdc@edu.bd" class="npf-item">
                                <i class="fas fa-envelope"></i>
                                <span>pmdc@edu.bd</span>
                            </a>
                        </div>
                        <!-- Staff Portal -->
                        <a href="<?= BASE_URL ?>/admin/login" class="npf-portal-btn">
                            <i class="fas fa-lock"></i> <span data-i18n="footer.staffportal">স্টাফ পোর্টাল</span>
                        </a>
                        <!-- Language Toggle -->
                        <div class="npf-lang-row">
                            <span class="nlr-label" data-i18n="nav.language">ভাষা</span>
                            <div class="nlr-toggle">
                                <button class="lang-btn lang-active" id="mobileLangBn" aria-label="বাংলা">বাংলা</button>
                                <button class="lang-btn" id="mobileLangEn" aria-label="English">EN</button>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Mobile nav backdrop -->
    <div class="nav-backdrop" id="navBackdrop"></div>
