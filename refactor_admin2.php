<?php
$dir = __DIR__ . '/pages/portal/admin';
$files = glob($dir . '/*.php');

$replacements = [
    'href="css/styles.css"' => 'href="<?= BASE_URL ?>/pages/portal/admin/css/styles.css"',
    'src="js/main.js"' => 'src="<?= BASE_URL ?>/pages/portal/admin/js/main.js"', // Just in case there are JS files too
];

foreach ($files as $file) {
    $content = file_get_contents($file);
    $changed = false;

    foreach ($replacements as $old => $new) {
        if (strpos($content, $old) !== false) {
            $content = str_replace($old, $new, $content);
            $changed = true;
        }
    }

    if ($changed) {
        file_put_contents($file, $content);
        echo "Updated CSS/JS links in " . basename($file) . "\n";
    }
}
echo "Admin CSS/JS links refactored.\n";
