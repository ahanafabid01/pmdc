<?php
function processDirectory($dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    
    $replacements = [
        'src="../javascript/' => 'src="<?= BASE_URL ?>/javascript/',
        'src="../uploads/' => 'src="<?= BASE_URL ?>/uploads/',
        'src="../images/' => 'src="<?= BASE_URL ?>/images/',
        'href="../styles/' => 'href="<?= BASE_URL ?>/styles/',
        'href="../uploads/' => 'href="<?= BASE_URL ?>/uploads/',
        // Catch variations
        "src='../javascript/" => "src='<?= BASE_URL ?>/javascript/",
        "src='../uploads/" => "src='<?= BASE_URL ?>/uploads/",
        "href='../styles/" => "href='<?= BASE_URL ?>/styles/",
        "href='../uploads/" => "href='<?= BASE_URL ?>/uploads/",
    ];

    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            $changed = false;

            foreach ($replacements as $old => $new) {
                if (strpos($content, $old) !== false) {
                    $content = str_replace($old, $new, $content);
                    $changed = true;
                }
            }

            if ($changed) {
                file_put_contents($file->getPathname(), $content);
                echo "Fixed asset paths in " . $file->getPathname() . "\n";
            }
        }
    }
}

processDirectory(__DIR__ . '/pages');
echo "All static asset paths refactored.\n";
