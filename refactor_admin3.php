<?php
$dir = __DIR__ . '/pages/portal/admin';
$files = glob($dir . '/*.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    if (strpos($content, 'src="js/') !== false) {
        $content = str_replace('src="js/', 'src="<?= BASE_URL ?>/pages/portal/admin/js/', $content);
        file_put_contents($file, $content);
        echo "Updated JS links in " . basename($file) . "\n";
    }
}
echo "Done.\n";
