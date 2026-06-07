<?php
$dir = __DIR__ . '/pages/portal/admin';
$files = glob($dir . '/*.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    $changed = false;
    
    // Replace href="css/...
    if (preg_match('/href="css\//', $content)) {
        $content = preg_replace('/href="css\//', 'href="<?= BASE_URL ?>/pages/portal/admin/css/', $content);
        $changed = true;
    }
    
    // Replace src="js/...
    if (preg_match('/src="js\//', $content)) {
        $content = preg_replace('/src="js\//', 'src="<?= BASE_URL ?>/pages/portal/admin/js/', $content);
        $changed = true;
    }

    if ($changed) {
        file_put_contents($file, $content);
        echo "Refactored paths in " . basename($file) . "\n";
    }
}
echo "Done.\n";
