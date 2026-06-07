<?php
function replaceContent($file, $search, $replace) {
    $content = file_get_contents($file);
    if (strpos($content, $search) !== false) {
        $newContent = str_replace($search, $replace, $content);
        file_put_contents($file, $newContent);
        echo "Fixed path in: $file\n";
    }
}

$dir = __DIR__ . '/pages/portal/admin';
replaceContent("$dir/results.php", 'href="../teacher/css/attendance.css?v=2"', 'href="<?= BASE_URL ?>/pages/portal/teacher/css/attendance.css?v=2"');
replaceContent("$dir/teacher.php", 'href="../../../pages/teachers.php"', 'href="<?= BASE_URL ?>/teachers"');
replaceContent("$dir/registration-hsc.php", 'href="../../../pages/register-hsc.php"', 'href="<?= BASE_URL ?>/register-hsc"');
replaceContent("$dir/registration-degree.php", 'href="../../../pages/register-degree.php"', 'href="<?= BASE_URL ?>/register-degree"');
replaceContent("$dir/gallery.php", 'href="../../../pages/gallery.php"', 'href="<?= BASE_URL ?>/gallery"');
replaceContent("$dir/academic-calendar.php", 'href="../../../pages/academic-calendar.php"', 'href="<?= BASE_URL ?>/academic-calendar"');

echo "Remaining paths fixed.\n";
