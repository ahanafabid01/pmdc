<?php
$dir = __DIR__ . '/pages/portal';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        
        // Find any require_once targeting 'includes/config.php' and replace it with config.php
        $newContent = preg_replace("/(require_once\s+['\"])(.*?)includes\/config\.php(['\"])/", "$1$2config.php$3", $content);
        
        if ($newContent !== $content) {
            file_put_contents($file->getPathname(), $newContent);
            echo "Fixed config path in: " . $file->getFilename() . "\n";
        }
    }
}
echo "Done fixing config requires.\n";
