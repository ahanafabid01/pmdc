<?php
function fixBrokenQuotes($dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'js') {
            $content = file_get_contents($file->getPathname());
            $changed = false;
            
            // Look for window.BASE_URL + "/pages/portal... "
            if (preg_match_all('/window\.BASE_URL \+ "(\/pages\/portal\/[^"]+)"/', $content, $matches)) {
                foreach ($matches[0] as $i => $fullMatch) {
                    $innerPath = $matches[1][$i];
                    $replacement = "window.BASE_URL + `" . $innerPath . "`";
                    $content = str_replace($fullMatch, $replacement, $content);
                    $changed = true;
                }
            }
            
            if ($changed) {
                file_put_contents($file->getPathname(), $content);
                echo "Fixed quotes in: " . basename($file->getPathname()) . "\n";
            }
        }
    }
}
fixBrokenQuotes(__DIR__ . '/pages/portal/admin/js');
fixBrokenQuotes(__DIR__ . '/pages/portal/teacher/js');
echo "Done fixing quotes.\n";
