<?php
$dirs = [
    'teacher' => __DIR__ . '/pages/portal/teacher',
    'admin'   => __DIR__ . '/pages/portal/admin'
];

foreach ($dirs as $portal => $dir) {
    $files = glob($dir . '/*.php');
    foreach ($files as $file) {
        $content = file_get_contents($file);
        $changed = false;
        
        // Fix CSS paths
        if (preg_match('/href=["\']css\//', $content)) {
            $content = preg_replace('/href=["\']css\//', 'href="<?= BASE_URL ?>/pages/portal/' . $portal . '/css/', $content);
            $changed = true;
        }
        
        // Fix JS paths
        if (preg_match('/src=["\']js\//', $content)) {
            $content = preg_replace('/src=["\']js\//', 'src="<?= BASE_URL ?>/pages/portal/' . $portal . '/js/', $content);
            $changed = true;
        }
        
        // Fix Logout paths
        if (preg_match('/href=["\']\.\.\/portal-login\.php["\']/', $content)) {
            $content = preg_replace('/href=["\']\.\.\/portal-login\.php["\']/', 'href="<?= BASE_URL ?>/admin/login"', $content);
            $changed = true;
        }
        
        // Fix index.php navigation links
        // Be careful not to replace something like href="index.php?something"
        // Most links to the dashboard are href="index.php"
        if (preg_match('/href=["\']index\.php["\']/', $content)) {
            $content = preg_replace('/href=["\']index\.php["\']/', 'href="<?= BASE_URL ?>/' . $portal . '"', $content);
            $changed = true;
        }

        if ($changed) {
            file_put_contents($file, $content);
            echo "Fixed relative paths in: $portal/" . basename($file) . "\n";
        }
    }
}
echo "Done fixing CSS/JS/Logout paths.\n";
