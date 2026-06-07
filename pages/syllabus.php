<?php
$page       = 'syllabus';
$page_group = 'academic';
$page_title = 'Syllabus | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'May 31, 2025';

$years    = ['1st Year', '2nd Year'];
$groups   = ['Science', 'Humanities', 'Business Studies', 'All Groups'];
$examTypes= ['All Exams', 'Half-Yearly', 'Year-Change', 'Pre-Test', 'Test Exam'];

$selYear  = $_GET['year']  ?? '2nd Year';
$selGroup = $_GET['group'] ?? 'All Groups';
$selExam  = $_GET['exam']  ?? 'All Exams';

$allSyllabus = [
    ['subject'=>'Bangla', 'year'=>'1st Year', 'group'=>'All', 'exam'=>'Half-Yearly', 'note'=>'বিজ্ঞানের প্রতি মেঘনাদ, সোনার তরী, বিদ্রোহী, প্রতিদান, সুচেতনা; অপরিচিতা, বিলাসী, গৃহ, আহ্বান, আমার পথ'],
    ['subject'=>'Bangla', 'year'=>'1st Year', 'group'=>'All', 'exam'=>'Year-Change', 'note'=>'তাহারেই পড়ে মনে, পদ্মা, আঠারো বছর বয়স, ফেব্রুয়ারি ১৯৬৯, আমি কিংবদন্তির কথা বলছি, নূরলদীনের কথা মনে পড়ে যায়, ছবি; বাঙালার নয়া লেখকদের প্রতি নিবেদন, মানব কল্যাণ, মাসি-পিসি, বায়ান্নার দিনগুলো, রেইনকোট, মহাজাগতিক কিউরেটর, নেকলেস'],
    ['subject'=>'Bangla', 'year'=>'2nd Year', 'group'=>'All', 'exam'=>'Pre-Test', 'note'=>'বাংলা উচ্চারণের নিয়ম ও উচ্চারণ লেখা, বানানের নিয়ম, শব্দ গঠন, শব্দ শ্রেণি, পারিভাষিক শব্দ/অনুবাদ, দিনলিপি, ভাষণ, প্রবন্ধরচনা: ৫টি'],
    ['subject'=>'Bangla', 'year'=>'2nd Year', 'group'=>'All', 'exam'=>'Test Exam', 'note'=>'বাক্য প্রণয়ণ, শুদ্ধ প্রয়োগ, প্রতিবেদন, সমাস প্রত্যয়, অভিজ্ঞতা বর্ণনা, বৈদ্যুতিন চিঠি, খুদে বার্তা, পত্র লিখন, আবেদনপত্র, সারাংশ, ভাবসম্প্রসারণ, সংলাপ, খুদে গল্প, প্রবন্ধ: ৫টি'],

    ['subject'=>'English', 'year'=>'1st Year', 'group'=>'All', 'exam'=>'Half-Yearly', 'note'=>'Unit 1 to Unit 7, Grammar Part, Paragraph, Completing Story'],
    ['subject'=>'English', 'year'=>'1st Year', 'group'=>'All', 'exam'=>'Year-Change', 'note'=>'Unit 8 to Unit 13, Grammar, Re-arrange, Email, With Clue, Without Clue'],
    ['subject'=>'English', 'year'=>'2nd Year', 'group'=>'All', 'exam'=>'Pre-Test', 'note'=>'Grammar according to syllabus, Paragraph, Application'],
    ['subject'=>'English', 'year'=>'2nd Year', 'group'=>'All', 'exam'=>'Test Exam', 'note'=>'Grammar, Composition, Letter/Application, Paragraph'],

    ['subject'=>'ICT', 'year'=>'1st Year', 'group'=>'All', 'exam'=>'Half-Yearly', 'note'=>'অধ্যায় ০১: বিশ্বগ্রাম ও বাংলাদেশের প্রেক্ষিত; অধ্যায় ০২: কমিউনিকেশন সিস্টেম ও নেটওয়াকিং'],
    ['subject'=>'ICT', 'year'=>'1st Year', 'group'=>'All', 'exam'=>'Year-Change', 'note'=>'অধ্যায় ০১–০৪: বিশ্বগ্রাম, কমিউনিকেশন, সংখ্যা পদ্ধতি ও ডিজিটাল ডিভাইস, ওয়েব সাইট ডিজাইন ও HTML পরিচিতি'],
    ['subject'=>'ICT', 'year'=>'2nd Year', 'group'=>'All', 'exam'=>'Pre-Test', 'note'=>'অধ্যায় ০১–০৫: previous topics + প্রোগ্রামিং ভাষা'],
    ['subject'=>'ICT', 'year'=>'2nd Year', 'group'=>'All', 'exam'=>'Test Exam', 'note'=>'অধ্যায় ০১–০৬: previous topics + ডাটাবেজ ম্যানেজমেন্ট সিস্টেম'],

    ['subject'=>'Higher Mathematics', 'year'=>'1st Year', 'group'=>'Science', 'exam'=>'Half-Yearly', 'note'=>'অধ্যায় ০১ (ম্যাট্রিক্স ও নির্ণায়ক), ০২ (ভেক্টর), ০৬ (ত্রিকোণমিতিক অনুপাত), ০৯ (অন্তরীকরণ)'],
    ['subject'=>'Higher Mathematics', 'year'=>'1st Year', 'group'=>'Science', 'exam'=>'Year-Change', 'note'=>'অধ্যায় ০৩, ০৪, ০৫, ০৭, ০৮, ০১, ০৯, ১০'],
    ['subject'=>'Higher Mathematics', 'year'=>'2nd Year', 'group'=>'Science', 'exam'=>'Pre-Test', 'note'=>'অধ্যায় ০৩, ০৪, ০৬, ০৮'],
    ['subject'=>'Higher Mathematics', 'year'=>'2nd Year', 'group'=>'Science', 'exam'=>'Test Exam', 'note'=>'অধ্যায় ০১, ০২, ০৫, ০৭, ০৯, ১০, ০৬, ০৮'],

    ['subject'=>'Physics', 'year'=>'1st Year', 'group'=>'Science', 'exam'=>'Half-Yearly', 'note'=>'অধ্যায় ০১–০৫'],
    ['subject'=>'Physics', 'year'=>'1st Year', 'group'=>'Science', 'exam'=>'Year-Change', 'note'=>'অধ্যায় ০৬–১০'],
    ['subject'=>'Physics', 'year'=>'2nd Year', 'group'=>'Science', 'exam'=>'Pre-Test', 'note'=>'অধ্যায় ০১–০৫: তাপ গতিবিদ্যা, স্থির ও চল তড়িৎ, তড়িৎ প্রবাহের চৌম্বক ক্রিয়া'],
    ['subject'=>'Physics', 'year'=>'2nd Year', 'group'=>'Science', 'exam'=>'Test Exam', 'note'=>'অধ্যায় ০৬–১১: জ্যামিতিক আলোক বিজ্ঞান, ভৌত আলোক বিজ্ঞান, আধুনিক পদার্থ বিজ্ঞান, পরমাণু মডেল, সেমিকন্ডাক্টর, জ্যোতি বিজ্ঞান'],

    ['subject'=>'Chemistry', 'year'=>'1st Year', 'group'=>'Science', 'exam'=>'Half-Yearly', 'note'=>'অধ্যায় ০১ (ল্যাবরেটরির নিরাপদ ব্যবহার), ০২ (গুণগত রসায়ন)'],
    ['subject'=>'Chemistry', 'year'=>'1st Year', 'group'=>'Science', 'exam'=>'Year-Change', 'note'=>'অধ্যায় ০৩, ০৪, ০৫'],
    ['subject'=>'Chemistry', 'year'=>'2nd Year', 'group'=>'Science', 'exam'=>'Pre-Test', 'note'=>'অধ্যায় ০১ (পরিবেশ রসায়ন), ০২ (জৈব রসায়ন)'],
    ['subject'=>'Chemistry', 'year'=>'2nd Year', 'group'=>'Science', 'exam'=>'Test Exam', 'note'=>'অধ্যায় ০৩ (পরিমাণগত রসায়ন), ০৪ (তড়িৎ রসায়ন), ০৫ (অর্থনৈতিক রসায়ন)'],

    ['subject'=>'Biology', 'year'=>'1st Year', 'group'=>'Science', 'exam'=>'Half-Yearly', 'note'=>'1st Paper: অধ্যায় ০১–০২ | 2nd Paper: অধ্যায় ০১–০২'],
    ['subject'=>'Biology', 'year'=>'1st Year', 'group'=>'Science', 'exam'=>'Year-Change', 'note'=>'1st Paper: অধ্যায় ০৩, ০৪, ০৫, ০৯ | 2nd Paper: অধ্যায় ০৩, ০৪, ০৫, ১১'],
    ['subject'=>'Biology', 'year'=>'2nd Year', 'group'=>'Science', 'exam'=>'Pre-Test', 'note'=>'1st Paper: অধ্যায় ০৬, ০৭, ০৮, ১১ | 2nd Paper: অধ্যায় ০৬, ০৭, ০৮, ০৯'],
    ['subject'=>'Biology', 'year'=>'2nd Year', 'group'=>'Science', 'exam'=>'Test Exam', 'note'=>'1st Paper: অধ্যায় ১০, ১২, ০১, ০৯, ১১ | 2nd Paper: অধ্যায় ১০, ১২, ০৪, ০৫, ১১'],

    ['subject'=>'History', 'year'=>'1st Year', 'group'=>'Humanities', 'exam'=>'Half-Yearly', 'note'=>'অধ্যায় ০১–০৩: ভারত বর্ষে ইউরোপীয়দের আগমন, কোম্পানি আমল, ব্রিটিশ আমল'],
    ['subject'=>'History', 'year'=>'1st Year', 'group'=>'Humanities', 'exam'=>'Year-Change', 'note'=>'অধ্যায় ০৪–০৮: পাকিস্তানি আমল, ভাষা আন্দোলন, স্বাধীনতা ঘোষণা ও মুক্তিযুদ্ধ'],
    ['subject'=>'History', 'year'=>'2nd Year', 'group'=>'Humanities', 'exam'=>'Pre-Test', 'note'=>'অধ্যায় ০১–০৫: শিল্প বিপ্লব, ফরাসী বিপ্লব, প্রথম বিশ্বযুদ্ধ, বলশেভিক বিপ্লব, হিটলার'],
    ['subject'=>'History', 'year'=>'2nd Year', 'group'=>'Humanities', 'exam'=>'Test Exam', 'note'=>'অধ্যায় ০৬–০৯: জাতিসংঘ, স্নায়ুযুদ্ধ, বর্ণবাদ বিরোধী আন্দোলন'],

    ['subject'=>'Economics', 'year'=>'1st Year', 'group'=>'Humanities', 'exam'=>'Half-Yearly', 'note'=>'অধ্যায় ০১–০৫'],
    ['subject'=>'Economics', 'year'=>'1st Year', 'group'=>'Humanities', 'exam'=>'Year-Change', 'note'=>'অধ্যায় ০৬–১০: মূলধন, সংগঠন, খাজনা, সামগ্রিক আয়, মুদ্রা ও ব্যাংক'],
    ['subject'=>'Economics', 'year'=>'2nd Year', 'group'=>'Humanities', 'exam'=>'Pre-Test', 'note'=>'অধ্যায় ০১–০৫: বাংলাদেশের অর্থনীতি, কৃষি, শিল্প, জনসংখ্যা, খাদ্য নিরাপত্তা'],
    ['subject'=>'Economics', 'year'=>'2nd Year', 'group'=>'Humanities', 'exam'=>'Test Exam', 'note'=>'অধ্যায় ০৬–১০: অর্থায়ন, মুদ্রাস্ফিতি, আন্তর্জাতিক বাণিজ্য, সরকারি অর্থব্যবস্থা, উন্নয়ন পরিকল্পনা'],

    ['subject'=>'Civics & Good Governance', 'year'=>'1st Year', 'group'=>'Humanities', 'exam'=>'Half-Yearly', 'note'=>'অধ্যায় ০১–০৫'],
    ['subject'=>'Civics & Good Governance', 'year'=>'1st Year', 'group'=>'Humanities', 'exam'=>'Year-Change', 'note'=>'সম্পূর্ণ বই (১ম–১০ম অধ্যায়)'],
    ['subject'=>'Civics & Good Governance', 'year'=>'2nd Year', 'group'=>'Humanities', 'exam'=>'Pre-Test', 'note'=>'১ম–৫ম অধ্যায়'],
    ['subject'=>'Civics & Good Governance', 'year'=>'2nd Year', 'group'=>'Humanities', 'exam'=>'Test Exam', 'note'=>'সম্পূর্ণ বই (১ম–১০ম অধ্যায়)'],

    ['subject'=>'Logic', 'year'=>'1st Year', 'group'=>'Humanities', 'exam'=>'Half-Yearly', 'note'=>'অধ্যায় ০১–০৫ (1st Paper)'],
    ['subject'=>'Logic', 'year'=>'1st Year', 'group'=>'Humanities', 'exam'=>'Year-Change', 'note'=>'সম্পূর্ণ বই (১ম–৮ম অধ্যায়)'],
    ['subject'=>'Logic', 'year'=>'2nd Year', 'group'=>'Humanities', 'exam'=>'Pre-Test', 'note'=>'অধ্যায় ০১–০৫: যৌক্তিক সংজ্ঞা, যৌক্তিক বিভাগ, আরোহের প্রকারভেদ, প্রকল্প, কার্য-কারণ'],
    ['subject'=>'Logic', 'year'=>'2nd Year', 'group'=>'Humanities', 'exam'=>'Test Exam', 'note'=>'সম্পূর্ণ বই (১ম–৮ম অধ্যায়)'],

    ['subject'=>'Geography', 'year'=>'1st Year', 'group'=>'Humanities', 'exam'=>'Half-Yearly', 'note'=>'অধ্যায় ০১–০৪'],
    ['subject'=>'Geography', 'year'=>'1st Year', 'group'=>'Humanities', 'exam'=>'Year-Change', 'note'=>'অধ্যায় ০৫–১০'],
    ['subject'=>'Geography', 'year'=>'2nd Year', 'group'=>'Humanities', 'exam'=>'Pre-Test', 'note'=>'অধ্যায় ০১–০৫: মানব ভূগোল, জনসংখ্যা, কৃষি, খনিজ ও শক্তি সম্পদ'],
    ['subject'=>'Geography', 'year'=>'2nd Year', 'group'=>'Humanities', 'exam'=>'Test Exam', 'note'=>'অধ্যায় ০৬–১০: শিল্প, পরিবহন, বাণিজ্য, দূষণ, মানচিত্র'],

    ['subject'=>'Social Work', 'year'=>'1st Year', 'group'=>'Humanities', 'exam'=>'Half-Yearly', 'note'=>'অধ্যায় ০১–০৩'],
    ['subject'=>'Social Work', 'year'=>'1st Year', 'group'=>'Humanities', 'exam'=>'Year-Change', 'note'=>'সবটুকু'],
    ['subject'=>'Social Work', 'year'=>'2nd Year', 'group'=>'Humanities', 'exam'=>'Pre-Test', 'note'=>'অধ্যায় ০১–০৪ (2nd Paper)'],
    ['subject'=>'Social Work', 'year'=>'2nd Year', 'group'=>'Humanities', 'exam'=>'Test Exam', 'note'=>'সবটুকু'],

    ['subject'=>'Islamic Studies', 'year'=>'1st Year', 'group'=>'Humanities', 'exam'=>'Half-Yearly', 'note'=>'অধ্যায় ০১–০২'],
    ['subject'=>'Islamic Studies', 'year'=>'1st Year', 'group'=>'Humanities', 'exam'=>'Year-Change', 'note'=>'অধ্যায় ০১–০৭: ইসলামী পরিবার, সমাজ জীবন'],
    ['subject'=>'Islamic Studies', 'year'=>'2nd Year', 'group'=>'Humanities', 'exam'=>'Pre-Test', 'note'=>'আল-হাদীস'],
    ['subject'=>'Islamic Studies', 'year'=>'2nd Year', 'group'=>'Humanities', 'exam'=>'Test Exam', 'note'=>'অধ্যায় ০৩–০৭: আল ইজমা, আল-কিয়াস, ফিকহ শাস্ত্র, মৌলিক ইবাদত, তাসাউফ'],

    ['subject'=>'Business Organization & Management', 'year'=>'1st Year', 'group'=>'Business Studies', 'exam'=>'Half-Yearly', 'note'=>'অধ্যায় ০১–০৪'],
    ['subject'=>'Business Organization & Management', 'year'=>'1st Year', 'group'=>'Business Studies', 'exam'=>'Year-Change', 'note'=>'অধ্যায় ০১–০৮: যৌথ মূলধনী, সমবায়, রাষ্ট্রীয় ব্যবসায়, আইনগত দিক'],
    ['subject'=>'Business Organization & Management', 'year'=>'2nd Year', 'group'=>'Business Studies', 'exam'=>'Pre-Test', 'note'=>'অধ্যায় ০১–০৪: ব্যবস্থাপনার ধারণা, নীতি, পরিকল্পনা, সংগঠিত করণ'],
    ['subject'=>'Business Organization & Management', 'year'=>'2nd Year', 'group'=>'Business Studies', 'exam'=>'Test Exam', 'note'=>'অধ্যায় ০২–১০: কর্মীসংস্থান, নেতৃত্ব, প্রেষণা, সমন্বয়, নিয়ন্ত্রণ'],

    ['subject'=>'Accounting', 'year'=>'1st Year', 'group'=>'Business Studies', 'exam'=>'Half-Yearly', 'note'=>'অধ্যায় ০১–০৪'],
    ['subject'=>'Accounting', 'year'=>'1st Year', 'group'=>'Business Studies', 'exam'=>'Year-Change', 'note'=>'অধ্যায় ০১–০৯'],
    ['subject'=>'Accounting', 'year'=>'2nd Year', 'group'=>'Business Studies', 'exam'=>'Pre-Test', 'note'=>'অধ্যায় ০২, ০৪, ০৫, ০৬'],
    ['subject'=>'Accounting', 'year'=>'2nd Year', 'group'=>'Business Studies', 'exam'=>'Test Exam', 'note'=>'অধ্যায় ০২, ০৪, ০৫, ০৬, ০৭, ০৮, ০১'],

    ['subject'=>'Marketing / Production Management', 'year'=>'1st Year', 'group'=>'Business Studies', 'exam'=>'Half-Yearly', 'note'=>'অধ্যায় ০১–০৫'],
    ['subject'=>'Marketing / Production Management', 'year'=>'1st Year', 'group'=>'Business Studies', 'exam'=>'Year-Change', 'note'=>'অধ্যায় ০৬–১০ + পূর্বের যে কোন ৩টি'],
    ['subject'=>'Marketing / Production Management', 'year'=>'2nd Year', 'group'=>'Business Studies', 'exam'=>'Pre-Test', 'note'=>'অধ্যায় ০১, ০২, ০৫, ০৮, ০৯'],
    ['subject'=>'Marketing / Production Management', 'year'=>'2nd Year', 'group'=>'Business Studies', 'exam'=>'Test Exam', 'note'=>'পূর্ণ সিলেবাস'],
];

// Determine visible exam columns based on year selection
$examCols = ($selYear === '1st Year')  ? ['Half-Yearly', 'Year-Change']
          : (($selYear === '2nd Year') ? ['Pre-Test', 'Test Exam']
          : ['Half-Yearly', 'Year-Change', 'Pre-Test', 'Test Exam']);

// Build subject × exam matrix (no exam filter — exams are columns)
$matrixFiltered = array_filter($allSyllabus, function($s) use ($selYear, $selGroup) {
    $yearMatch  = $selYear  === 'All Years' || $s['year'] === $selYear;
    $groupMatch = $selGroup === 'All Groups' || $s['group'] === 'All' || $s['group'] === $selGroup;
    return $yearMatch && $groupMatch;
});
$matrix = [];
foreach ($matrixFiltered as $s) {
    $matrix[$s['subject']][$s['exam']] = $s['note'];
}

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">
            <div class="ph-kicker reveal">
                <span class="show-en">Academic Info</span>
                <span class="show-bn">একাডেমিক তথ্য</span>
            </div>
            <h1 class="reveal">
                <span class="show-en">Syllabus</span>
                <span class="show-bn">পাঠ্যক্রম</span>
            </h1>
            <p class="reveal">Subject-wise syllabus coverage for each examination type</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <div class="ai-top-row">
                <span class="ai-session-label"><i class="fas fa-book-open"></i> Session: 2024-2025 - As per NCTB &amp; Dhaka Board</span>
                <span class="ai-last-updated">Last Updated: <?php echo $last_updated; ?></span>
            </div>

            <!-- Filters: Year + Group only (Exam type shown as columns) -->
            <form method="GET" class="ai-filter-bar" style="margin-bottom:24px;">
                <label>Year</label>
                <select name="year" class="ai-filter-select" onchange="this.form.submit()">
                    <option value="All Years" <?php echo $selYear==='All Years'?'selected':''; ?>>All Years</option>
                    <?php foreach($years as $y): ?>
                    <option value="<?php echo $y; ?>" <?php echo $selYear===$y?'selected':''; ?>><?php echo $y; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="ai-filter-sep"></div>
                <label>Group</label>
                <select name="group" class="ai-filter-select" onchange="this.form.submit()">
                    <?php foreach($groups as $g): ?>
                    <option value="<?php echo $g; ?>" <?php echo $selGroup===$g?'selected':''; ?>><?php echo $g; ?></option>
                    <?php endforeach; ?>
                </select>
            </form>

            <?php if (!empty($matrix)): ?>
            <div class="syl-table-wrap reveal">
                <table class="syl-table">
                    <thead>
                        <tr>
                            <th class="syl-th-subject">Subject</th>
                            <?php
                            $colClasses = ['Half-Yearly'=>'half','Year-Change'=>'yearchange','Pre-Test'=>'pretest','Test Exam'=>'testexam'];
                            $colIcons   = ['Half-Yearly'=>'fa-clock','Year-Change'=>'fa-sync-alt','Pre-Test'=>'fa-pen-nib','Test Exam'=>'fa-graduation-cap'];
                            foreach($examCols as $col):
                                $cls = $colClasses[$col] ?? 'other';
                            ?>
                            <th class="syl-th-exam syl-col-<?php echo $cls; ?>">
                                <i class="fas <?php echo $colIcons[$col] ?? 'fa-file-alt'; ?>"></i>
                                <?php echo htmlspecialchars($col); ?>
                            </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($matrix as $subject => $exams): ?>
                        <tr class="syl-row">
                            <td class="syl-td-subject">
                                <div class="syl-subject-name"><?php echo htmlspecialchars($subject); ?></div>
                            </td>
                            <?php foreach($examCols as $col): ?>
                            <td class="syl-td-content<?php echo isset($exams[$col]) ? '' : ' syl-empty'; ?>">
                                <?php if (isset($exams[$col])): ?>
                                    <div class="syl-content-text"><?php echo htmlspecialchars($exams[$col]); ?></div>
                                <?php else: ?>
                                    <span class="syl-na">-</span>
                                <?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="ai-not-published">
                <i class="fas fa-book-open"></i>
                <h3>No Syllabus Found</h3>
                <p>No syllabus matches your filter. Try selecting a different Year or Group.</p>
            </div>
            <?php endif; ?>

        </div>
    </div>

<style>
.syl-table-wrap {
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid var(--border);
    box-shadow: 0 2px 16px rgba(15,39,68,.07);
    overflow-x: auto;
}
.syl-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Inter', sans-serif;
    font-size: .82rem;
    min-width: 600px;
}
.syl-table thead tr { background: var(--navy); }
.syl-th-subject {
    text-align: left;
    padding: 15px 20px;
    font-size: .7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .09em;
    color: rgba(255,255,255,.7);
    width: 190px;
    min-width: 150px;
    position: sticky;
    left: 0;
    background: var(--navy);
    z-index: 3;
    border-right: 1px solid rgba(255,255,255,.12);
}
.syl-th-exam {
    text-align: left;
    padding: 15px 18px;
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: #fff;
    min-width: 200px;
    border-left: 1px solid rgba(255,255,255,.08);
}
.syl-th-exam i { margin-right: 6px; opacity: .8; }
.syl-col-half       { background: #1d4ed8; }
.syl-col-yearchange { background: #6d28d9; }
.syl-col-pretest    { background: #b45309; }
.syl-col-testexam   { background: #047857; }
.syl-row:nth-child(even) td { background: #f8fafc; }
.syl-row:nth-child(odd)  td { background: #fff; }
.syl-row:hover td            { background: #eff6ff !important; }
.syl-td-subject {
    padding: 14px 20px;
    vertical-align: top;
    position: sticky;
    left: 0;
    border-right: 2px solid var(--border);
    z-index: 1;
}
.syl-row:nth-child(even) .syl-td-subject { background: #f8fafc; }
.syl-row:nth-child(odd)  .syl-td-subject { background: #fff; }
.syl-row:hover .syl-td-subject            { background: #eff6ff !important; }
.syl-subject-name {
    font-weight: 700;
    color: var(--navy);
    font-size: .84rem;
    line-height: 1.4;
}
.syl-td-content {
    padding: 13px 18px;
    vertical-align: top;
    border-left: 1px solid #f0f4f8;
    border-bottom: 1px solid var(--border);
}
.syl-content-text {
    color: #374151;
    line-height: 1.65;
    font-size: .77rem;
}
.syl-empty .syl-na { color: #d1d5db; font-size: 1rem; }
.syl-row td { border-bottom: 1px solid var(--border); }
.syl-row:last-child td { border-bottom: none; }
@media (max-width: 768px) {
    .syl-th-subject, .syl-td-subject { min-width: 120px; width: 120px; padding: 10px 12px; }
    .syl-th-exam, .syl-td-content    { min-width: 170px; padding: 10px 12px; }
    .syl-subject-name { font-size: .78rem; }
    .syl-content-text { font-size: .72rem; }
}
</style>

<?php include '../includes/footer.php'; ?>
