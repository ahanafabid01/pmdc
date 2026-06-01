<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Phulpur Mohila Degree College | Excellence in Education'; ?></title>
    <meta name="description" content="<?php echo isset($page_meta_description) ? htmlspecialchars($page_meta_description, ENT_QUOTES, 'UTF-8') : 'Phulpur Mohila Degree College is a women\'s degree college in Phulpur, Mymensingh, established in 1994, offering HSC and degree programmes for women students.'; ?>">
    <?php if(isset($page_meta_tags)) echo $page_meta_tags; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo isset($base_path) ? $base_path : ''; ?>styles/main.css">
    <?php if(isset($page_css)): ?>
    <link rel="stylesheet" href="<?php echo isset($base_path) ? $base_path : ''; ?>styles/<?php echo $page_css; ?>">
    <?php endif; ?>
</head>
<body>

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
                <a href="#">Library</a>
                <a href="#">Alumni</a>
                <a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/portal/portal-login.php" class="portal-link">
                    <i class="fas fa-lock"></i> Portal
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="<?php echo isset($base_path) ? $base_path : ''; ?>index.php" class="logo">
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
                <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>index.php"              class="nav-link <?php echo isset($page) && $page == 'home' ? 'active' : ''; ?>">Home</a></li>
                <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/about.php"        class="nav-link <?php echo isset($page) && $page == 'about' ? 'active' : ''; ?>">About</a></li>

                <!-- Academic Info Dropdown -->
                <?php $is_academic = isset($page_group) && $page_group === 'academic'; ?>
                <li class="nav-has-dropdown">
                    <a href="javascript:void(0)" class="nav-link nav-dropdown-toggle <?php echo $is_academic ? 'active' : ''; ?>">
                        Academic Info <i class="fas fa-chevron-down nav-dropdown-arrow"></i>
                    </a>
                    <ul class="nav-dropdown-menu">
                        <div class="nav-dropdown-inner">
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/hsc-program.php"        class="dropdown-item <?php echo isset($page) && $page == 'hsc-program'    ? 'active' : ''; ?>"><i class="fas fa-scroll"></i> HSC Program</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/degree-program.php"     class="dropdown-item <?php echo isset($page) && $page == 'degree-program' ? 'active' : ''; ?>"><i class="fas fa-user-graduate"></i> Degree Program</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/holiday-list.php"           class="dropdown-item <?php echo isset($page) && $page == 'holiday-list' ? 'active' : ''; ?>"><i class="fas fa-umbrella-beach"></i> Holiday List</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/academic-calendar.php"      class="dropdown-item <?php echo isset($page) && $page == 'academic-calendar' ? 'active' : ''; ?>"><i class="fas fa-calendar-alt"></i> Academic Calendar</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/class-routine.php"          class="dropdown-item <?php echo isset($page) && $page == 'class-routine' ? 'active' : ''; ?>"><i class="fas fa-chalkboard"></i> Class Routine</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/exam-routine.php"           class="dropdown-item <?php echo isset($page) && $page == 'exam-routine' ? 'active' : ''; ?>"><i class="fas fa-pen-alt"></i> Exam Routine</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/syllabus.php"               class="dropdown-item <?php echo isset($page) && $page == 'syllabus' ? 'active' : ''; ?>"><i class="fas fa-book-open"></i> Syllabus</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/uniform.php"                class="dropdown-item <?php echo isset($page) && $page == 'uniform' ? 'active' : ''; ?>"><i class="fas fa-tshirt"></i> Uniform</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/rules-regulation.php"      class="dropdown-item <?php echo isset($page) && $page == 'rules-regulation' ? 'active' : ''; ?>"><i class="fas fa-gavel"></i> Rules &amp; Regulation</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/student-instruction.php"   class="dropdown-item <?php echo isset($page) && $page == 'student-instruction' ? 'active' : ''; ?>"><i class="fas fa-info-circle"></i> Student Instruction</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/admit-card.php"            class="dropdown-item <?php echo isset($page) && $page == 'admit-card' ? 'active' : ''; ?>"><i class="fas fa-id-card"></i> Admit Card</a></li>
                        <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/hsc-form-fillup.php"       class="dropdown-item <?php echo isset($page) && $page == 'hsc-form-fillup' ? 'active' : ''; ?>"><i class="fas fa-file-alt"></i> HSC Form Fillup</a></li>
                        </div>
                    </ul>
                </li>

                <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/announcements.php" class="nav-link <?php echo isset($page) && $page == 'announcements' ? 'active' : ''; ?>">Announcements</a></li>
                <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/teachers.php"      class="nav-link <?php echo isset($page) && $page == 'teachers' ? 'active' : ''; ?>">Teachers &amp; Staff</a></li>
                <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/results.php"      class="nav-link <?php echo isset($page) && $page == 'results' ? 'active' : ''; ?>">Results</a></li>
                <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/contact.php"      class="nav-link <?php echo isset($page) && $page == 'contact' ? 'active' : ''; ?>">Contact</a></li>
                <li><a href="#" onclick="openModal('Apply Now')" class="nav-link nav-apply">Apply Now</a></li>
                <!-- Mobile-only panel footer -->
                <li class="nav-panel-footer">
                    <div class="npf-inner">
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
                        <a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/portal/portal-login.php" class="npf-portal-btn">
                            <i class="fas fa-lock"></i> Staff Portal
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Mobile nav backdrop -->
    <div class="nav-backdrop" id="navBackdrop"></div>
