<?php
// 1. Move BASE_URL logic to includes/config.php
$includes_config_path = __DIR__ . '/includes/config.php';
$includes_config = file_get_contents($includes_config_path);

$base_url_logic = "
// Detect localhost or live automatically
if (\$_SERVER['HTTP_HOST'] === 'localhost' ||
    strpos(\$_SERVER['HTTP_HOST'], 'localhost') !== false ||
    strpos(\$_SERVER['HTTP_HOST'], '127.0.0.1') !== false) {

    // Localhost
    if (!defined('BASE_URL')) define('BASE_URL', 'http://localhost/pmdc');
} else {
    // Live domain
    if (!defined('BASE_URL')) define('BASE_URL', 'https://' . \$_SERVER['HTTP_HOST']);
}
";

if (strpos($includes_config, 'BASE_URL') === false) {
    $includes_config = str_replace('<?php', '<?php' . $base_url_logic, $includes_config);
    file_put_contents($includes_config_path, $includes_config);
    echo "Added BASE_URL to includes/config.php\n";
}

// 2. Delete root config.php
$root_config_path = __DIR__ . '/config.php';
if (file_exists($root_config_path)) {
    unlink($root_config_path);
    echo "Deleted root config.php\n";
}

// 3. Update files that point to the root config.php
function replaceRootConfig($dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            
            // Replaces: dirname(__DIR__) . '/config.php'
            // with:     dirname(__DIR__) . '/includes/config.php'
            $newContent = str_replace("dirname(__DIR__) . '/config.php'", "dirname(__DIR__) . '/includes/config.php'", $content);
            
            // Replaces: __DIR__ . '/config.php'
            // with:     __DIR__ . '/includes/config.php'
            // (Only if it's not already in includes, wait, if __DIR__ is includes, we don't want includes/includes/config.php)
            // Wait, in includes/header.php, __DIR__ is includes. So dirname(__DIR__) . '/config.php' targets root config.
            // If we replace with dirname(__DIR__) . '/includes/config.php', it correctly targets includes/config.php.
            
            // In index.php: require_once __DIR__ . '/config.php';
            // should become require_once __DIR__ . '/includes/config.php';
            if (basename($file->getPathname()) === 'index.php') {
                $newContent = str_replace("__DIR__ . '/config.php'", "__DIR__ . '/includes/config.php'", $newContent);
            }
            
            // In pages/portal/portal-login.php: require_once __DIR__ . '/../../config.php';
            // should become require_once __DIR__ . '/../../includes/config.php';
            $newContent = str_replace("__DIR__ . '/../../config.php'", "__DIR__ . '/../../includes/config.php'", $newContent);
            
            // In includes/registration-data.php: require_once __DIR__ . '/config.php'; -> this was already __DIR__ in includes!
            // Wait! If __DIR__ is includes, __DIR__ . '/config.php' is ALREADY targeting includes/config.php!
            // Wait, earlier the user had require_once __DIR__ . '/config.php'; inside includes/*.php!
            // I should leave __DIR__ . '/config.php' ALONE if it is inside the includes directory!!
            
            if ($newContent !== $content) {
                file_put_contents($file->getPathname(), $newContent);
                echo "Updated path in: " . $file->getPathname() . "\n";
            }
        }
    }
}

replaceRootConfig(__DIR__);
echo "Done.\n";
