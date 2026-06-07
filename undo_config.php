<?php
$dir = __DIR__ . '/pages/portal';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        
        // This is tricky. Some were require_once '../../../config.php'
        // Some were require_once '../../../../config.php'
        // I need to change them back to includes/config.php
        $newContent = preg_replace("/(require_once\s+['\"]|require_once\s+__DIR__\s*\.\s*['\"]\/)(.*?)config\.php(['\"])/", "$1$2includes/config.php$3", $content);
        
        if ($newContent !== $content) {
            file_put_contents($file->getPathname(), $newContent);
            echo "Restored config path in: " . $file->getFilename() . "\n";
        }
    }
}
echo "Done restoring config requires.\n";
