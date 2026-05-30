<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Phulpur Mohila Degree College | Excellence in Education'; ?></title>
    <meta name="description" content="<?php echo isset($page_meta_description) ? htmlspecialchars($page_meta_description, ENT_QUOTES, 'UTF-8') : 'Phulpur Mohila Degree College - A leading women\'s degree college in Phulpur, Mymensingh offering HSC programs in Science, Commerce and Humanities under the Bangladesh Education Board.'; ?>">
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
                <span><i class="fas fa-phone-alt"></i> +880-1700-000000</span>
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
            <button class="hamburger" id="hamburger" aria-label="Open menu" aria-expanded="false">
                <i class="fas fa-bars" id="hamburgerIcon"></i>
            </button>
            <ul class="nav-menu" id="nav-menu" role="navigation">
                <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>index.php"              class="nav-link <?php echo isset($page) && $page == 'home' ? 'active' : ''; ?>">Home</a></li>
                <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/about.php"        class="nav-link <?php echo isset($page) && $page == 'about' ? 'active' : ''; ?>">About</a></li>
                <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/academics.php"    class="nav-link <?php echo isset($page) && $page == 'academics' ? 'active' : ''; ?>">Academics</a></li>
                <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/announcements.php" class="nav-link <?php echo isset($page) && $page == 'announcements' ? 'active' : ''; ?>">Announcements</a></li>
                <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/teachers.php"      class="nav-link <?php echo isset($page) && $page == 'teachers' ? 'active' : ''; ?>">Teachers &amp; Staff</a></li>
                <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/results.php"      class="nav-link <?php echo isset($page) && $page == 'results' ? 'active' : ''; ?>">Results</a></li>
                <li><a href="<?php echo isset($base_path) ? $base_path : ''; ?>pages/contact.php"      class="nav-link <?php echo isset($page) && $page == 'contact' ? 'active' : ''; ?>">Contact</a></li>
                <li><a href="#" onclick="openModal('Apply Now')" class="nav-link nav-apply">Apply Now</a></li>
            </ul>
        </div>
    </nav>
