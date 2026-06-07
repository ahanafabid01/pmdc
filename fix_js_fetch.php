<?php
function ensureBaseUrlVar($dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            
            // Check if it has an HTML document (look for </body> or <script)
            if (strpos($content, '<script') !== false && strpos($content, 'window.BASE_URL') === false) {
                // Insert before the first script tag that loads a local js file
                $content = preg_replace('/(<script\s+src=[\'"]<\?= BASE_URL \?>\/pages\/portal\/)/', '<script>window.BASE_URL = "<?= BASE_URL ?>";</script>' . "\n" . '    $1', $content, 1);
                file_put_contents($file->getPathname(), $content);
            }
        }
    }
}
ensureBaseUrlVar(__DIR__ . '/pages/portal');
echo "Injected window.BASE_URL into portal pages.\n";

function fixFetchPaths($dir, $portalType) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'js') {
            $content = file_get_contents($file->getPathname());
            $changed = false;
            
            // For relative const API = 'api/...';
            if (preg_match('/const\s+(API|API_URL|API_SETTINGS)\s*=\s*([\'"`])(api[^\'"`]*)([\'"`]);/', $content)) {
                $content = preg_replace('/const\s+(API|API_URL|API_SETTINGS)\s*=\s*([\'"`])(api[^\'"`]*)([\'"`]);/', 'const $1 = window.BASE_URL + "/pages/portal/' . $portalType . '/$3";', $content);
                $changed = true;
            }
            // For relative const API_URL = 'api-students.php';
            if (preg_match('/const\s+(API_URL)\s*=\s*([\'"`])(api-students\.php)([\'"`]);/', $content)) {
                $content = preg_replace('/const\s+(API_URL)\s*=\s*([\'"`])(api-students\.php)([\'"`]);/', 'const $1 = window.BASE_URL + "/pages/portal/' . $portalType . '/$3";', $content);
                $changed = true;
            }
            
            // For inline fetch('api/...
            if (preg_match('/fetch\(\s*([\'"`])(api[^\'"`]*)([\'"`])/', $content)) {
                $content = preg_replace('/fetch\(\s*([\'"`])(api[^\'"`]*)([\'"`])/', 'fetch(window.BASE_URL + "/pages/portal/' . $portalType . '/$2"', $content);
                $changed = true;
            }
            
            // For inline fetch('../api/...
            if (preg_match('/fetch\(\s*([\'"`])\.\.\/api([^\'"`]*)([\'"`])/', $content)) {
                $content = preg_replace('/fetch\(\s*([\'"`])\.\.\/api([^\'"`]*)([\'"`])/', 'fetch(window.BASE_URL + "/pages/portal/api$2"', $content);
                $changed = true;
            }
            
            if ($changed) {
                file_put_contents($file->getPathname(), $content);
                echo "Fixed JS fetches in: " . basename($file->getPathname()) . "\n";
            }
        }
    }
}
fixFetchPaths(__DIR__ . '/pages/portal/admin/js', 'admin');
fixFetchPaths(__DIR__ . '/pages/portal/teacher/js', 'teacher');
echo "Done.\n";
