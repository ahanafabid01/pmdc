<?php
$files = [
    __DIR__ . '/pages/portal/teacher/index.php',
    __DIR__ . '/pages/portal/teacher/attendance.php',
    __DIR__ . '/pages/portal/teacher/grades.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        $content = str_replace('href="attendance.php"', 'href="<?= BASE_URL ?>/teacher/attendance"', $content);
        $content = str_replace('href="grades.php"', 'href="<?= BASE_URL ?>/teacher/grades"', $content);
        
        file_put_contents($file, $content);
        echo "Fixed links in: " . basename($file) . "\n";
    }
}
