<?php
// Script to extract all data-i18n keys and verify if they exist in i18n.js
$pages_dir = __DIR__ . '/pages';
$includes_dir = __DIR__ . '/includes';
$index_php = __DIR__ . '/index.php';

$all_files = array_merge(
    glob($pages_dir . '/*.php'),
    glob($includes_dir . '/*.php'),
    [$index_php]
);

$keys_in_php = [];
foreach ($all_files as $file) {
    if (is_file($file)) {
        $content = file_get_contents($file);
        preg_match_all('/data-i18n="([^"]+)"/', $content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key) {
                $keys_in_php[$key][] = basename($file);
            }
        }
        
        preg_match_all('/data-i18n-ph="([^"]+)"/', $content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key) {
                $keys_in_php[$key][] = basename($file);
            }
        }
    }
}

$i18n_js = file_get_contents(__DIR__ . '/javascript/i18n.js');
preg_match_all("/'([^']+)'\s*:\s*\{/i", $i18n_js, $js_matches);
$keys_in_js = $js_matches[1];

$missing_in_js = [];
foreach ($keys_in_php as $key => $files) {
    if (!in_array($key, $keys_in_js)) {
        $missing_in_js[$key] = array_unique($files);
    }
}

if (empty($missing_in_js)) {
    echo "All i18n keys are present in i18n.js!\n";
} else {
    echo "Missing keys in i18n.js:\n";
    foreach ($missing_in_js as $key => $files) {
        echo "- $key (used in: " . implode(', ', $files) . ")\n";
    }
}
