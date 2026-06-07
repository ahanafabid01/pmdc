<?php
$dir = __DIR__ . '/pages';
$academic_files = [
    'academic-calendar.php', 'admit-card.php', 'class-routine.php', 
    'exam-routine.php', 'rules-regulation.php', 'student-instruction.php', 
    'syllabus.php', 'uniform.php', 'hsc-form-fillup.php', 'degree-form-fillup.php'
];

foreach ($academic_files as $f) {
    $path = $dir . '/' . $f;
    if (!file_exists($path)) continue;
    
    $content = file_get_contents($path);
    
    // Replace Academic Info Kicker
    $kicker_en = '<div class="ph-kicker reveal">Academic Info</div>';
    $kicker_bn = '<div class="ph-kicker reveal">
                <span class="show-en">Academic Info</span>
                <span class="show-bn">একাডেমিক তথ্য</span>
            </div>';
    $content = str_replace($kicker_en, $kicker_bn, $content);
    
    // Replace Titles
    $titles = [
        'Academic Calendar' => 'একাডেমিক ক্যালেন্ডার',
        'Admit Card' => 'প্রবেশপত্র',
        'Class Routine' => 'ক্লাস রুটিন',
        'Exam Routine' => 'পরীক্ষার রুটিন',
        'Rules &amp; Regulation' => 'নিয়ম ও বিধিমালা',
        'Rules & Regulation' => 'নিয়ম ও বিধিমালা',
        'Student Instruction' => 'শিক্ষার্থী নির্দেশিকা',
        'Syllabus' => 'পাঠ্যক্রম',
        'Uniform' => 'পোশাক বিধি',
        'HSC Form Fillup' => 'এইচএসসি ফর্ম পূরণ',
        'Degree Form Fillup' => 'ডিগ্রি ফর্ম পূরণ'
    ];
    
    foreach ($titles as $en => $bn) {
        $h1_en = '<h1 class="reveal">' . $en . '</h1>';
        $h1_bn = '<h1 class="reveal">
                <span class="show-en">' . $en . '</span>
                <span class="show-bn">' . $bn . '</span>
            </h1>';
        $content = str_replace($h1_en, $h1_bn, $content);
    }
    
    file_put_contents($path, $content);
}

echo "Hero sections translated!\n";
