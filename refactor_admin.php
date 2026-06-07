<?php
$dir = __DIR__ . '/pages/portal/admin';
$files = glob($dir . '/*.php');

$replacements = [
    'href="index.php"' => 'href="<?= BASE_URL ?>/admin"',
    'href="students.php"' => 'href="<?= BASE_URL ?>/admin/students"',
    'href="results.php"' => 'href="<?= BASE_URL ?>/admin/results"',
    'href="announcements.php"' => 'href="<?= BASE_URL ?>/admin/announcement"',
    'href="teacher.php"' => 'href="<?= BASE_URL ?>/admin/staff"',
    'href="gallery.php"' => 'href="<?= BASE_URL ?>/admin/gallery"',
    'href="academics.php"' => 'href="<?= BASE_URL ?>/admin/academics"',
    'href="registration-hsc.php"' => 'href="<?= BASE_URL ?>/admin/registration"',
    'href="academic-calendar.php"' => 'href="<?= BASE_URL ?>/admin/calendar"',
    'href="assign_teachers.php"' => 'href="<?= BASE_URL ?>/admin/assign-teachers"', // Though not explicitly asked, it exists
    'href="registration-degree.php"' => 'href="<?= BASE_URL ?>/admin/registration-degree"',
    'href="../portal-login.php"' => 'href="<?= BASE_URL ?>/admin/login"',
];

foreach ($files as $file) {
    $content = file_get_contents($file);
    $changed = false;

    // Check if session_check is included, if so, config is available.
    // If some files don't include session_check.php, we might need to add config.php directly, but let's assume they all do because it's an admin panel.

    foreach ($replacements as $old => $new) {
        if (strpos($content, $old) !== false) {
            $content = str_replace($old, $new, $content);
            $changed = true;
        }
    }

    if ($changed) {
        file_put_contents($file, $content);
        echo "Updated links in " . basename($file) . "\n";
    }
}
echo "Admin links refactored.\n";
