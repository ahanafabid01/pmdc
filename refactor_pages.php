<?php
$dir = __DIR__ . '/pages';
$files = glob($dir . '/*.php');

$replacements = [
    'href="about.php"' => 'href="<?= BASE_URL ?>/about"',
    'href="announcements.php"' => 'href="<?= BASE_URL ?>/announcement"',
    'href="teachers.php"' => 'href="<?= BASE_URL ?>/teachers"',
    'href="gallery.php"' => 'href="<?= BASE_URL ?>/gallery"',
    'href="holiday-list.php"' => 'href="<?= BASE_URL ?>/academic/holiday-list"',
    'href="academic-calendar.php"' => 'href="<?= BASE_URL ?>/academic/calendar"',
    'href="class-routine.php"' => 'href="<?= BASE_URL ?>/academic/class-routine"',
    'href="exam-routine.php"' => 'href="<?= BASE_URL ?>/academic/exam-routine"',
    'href="syllabus.php"' => 'href="<?= BASE_URL ?>/academic/syllabus"',
    'href="uniform.php"' => 'href="<?= BASE_URL ?>/academic/uniform"',
    'href="rules-regulation.php"' => 'href="<?= BASE_URL ?>/academic/rules"',
    'href="student-instruction.php"' => 'href="<?= BASE_URL ?>/academic/student-instruction"',
    'href="admit-card.php"' => 'href="<?= BASE_URL ?>/academic/admit-card"',
    'href="hsc-form-fillup.php"' => 'href="<?= BASE_URL ?>/academic/hsc-form"',
    'href="degree-form-fillup.php"' => 'href="<?= BASE_URL ?>/academic/degree-form"',
    'href="register-hsc.php"' => 'href="<?= BASE_URL ?>/apply/hsc"',
    'href="register-degree.php"' => 'href="<?= BASE_URL ?>/apply/degree"',
    'href="hsc-program.php"' => 'href="<?= BASE_URL ?>/hsc-program"',
    'href="degree-program.php"' => 'href="<?= BASE_URL ?>/degree-program"',
    'href="contact.php"' => 'href="<?= BASE_URL ?>/contact"',
    'href="../index.php"' => 'href="<?= BASE_URL ?>/"',
];

foreach ($files as $file) {
    if (basename($file) === 'announcement-detail.php' || basename($file) === 'announcements.php') {
        // We already handled announcements custom links using multi_replace_file_content earlier, but we can do a pass to catch any missed basic links.
    }
    
    $content = file_get_contents($file);
    $changed = false;

    foreach ($replacements as $old => $new) {
        if (strpos($content, $old) !== false) {
            $content = str_replace($old, $new, $content);
            $changed = true;
        }
    }

    if ($changed) {
        file_put_contents($file, $content);
        echo "Updated links in " . basename($file) . "\n";
    }
}
echo "Public pages refactored.\n";
