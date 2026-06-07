<?php
http_response_code(404);
require_once dirname(__DIR__) . '/includes/config.php';
$page = '404';
$page_title = 'Page Not Found | PMDC';
include '../includes/header.php';
?>

<section class="page-hero">
    <div class="container ph-content" style="text-align: center; padding: 100px 0;">
        <div class="ph-kicker reveal">Error 404</div>
        <h1 class="reveal" style="font-size: 5rem; margin-bottom: 20px;">404</h1>
        <p class="reveal" style="font-size: 1.5rem; margin-bottom: 40px;">The page you're looking for doesn't exist.</p>
        <div class="reveal">
            <a href="<?= BASE_URL ?>/" class="btn btn-primary" style="margin-right: 15px;">Go to Home</a>
            <a href="<?= BASE_URL ?>/announcement" class="btn btn-secondary">View Announcements</a>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
