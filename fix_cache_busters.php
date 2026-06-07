<?php
function addCacheBusters($dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            $changed = false;
            
            $newContent = preg_replace('/href=(["\'])(.*?\.css)(["\'])/', 'href=$1$2?v=<?= time() ?>$3', $content);
            if ($newContent !== $content) {
                $content = $newContent;
                $changed = true;
            }
            
            $newContent = preg_replace('/src=(["\'])(.*?\.js)(["\'])/', 'src=$1$2?v=<?= time() ?>$3', $content);
            if ($newContent !== $content) {
                $content = $newContent;
                $changed = true;
            }
            
            if ($changed) {
                // Remove duplicates if already appended previously
                $content = preg_replace('/\?v=<\?= time\(\) \?>\?v=<\?= time\(\) \?>/', '?v=<?= time() ?>', $content);
                file_put_contents($file->getPathname(), $content);
                echo "Added cache busters to: " . basename($file->getPathname()) . "\n";
            }
        }
    }
}
addCacheBusters(__DIR__ . '/pages/portal');
echo "Done adding cache busters.\n";
