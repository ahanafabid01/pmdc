<?php
// Detect localhost or live automatically
if ($_SERVER['HTTP_HOST'] === 'localhost' ||
    strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ||
    strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false) {

    // Localhost — change /pmdc to your actual folder name
    define('BASE_URL', 'http://localhost/pmdc');
} else {
    // Live domain — just replace with real domain when ready
    define('BASE_URL', 'https://' . $_SERVER['HTTP_HOST']);
}
?>
