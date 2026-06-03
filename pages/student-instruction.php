<?php
$page       = 'student-instruction';
$page_group = 'academic';
$page_title = 'Student Instruction | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';
$last_updated = 'May 31, 2026';

$instructions = [
    'Students must wear the prescribed uniform to college regularly. College uniform: white shalwar, white kamiz, navy blue orna, navy blue belt, white socks, white canvas shoes, white apron, and white scarf.',
    'Attendance at internal or national assemblies is compulsory for all students, teachers, and staff.',
    'Showing respect to the national flag is compulsory for everyone. When the national anthem begins, everyone must stand at attention wherever they are.',
    'Keeping classrooms clean and well-arranged is the duty and responsibility of every student. Under no circumstances should shoes be worn on benches or the benches be made dirty.',
    'Torn paper, tiffin waste, etc. must not be thrown anywhere. They must be disposed of in the bins placed in classrooms or corridors.',
    'While in college dress or uniform, no improper or disorderly behavior outside the college is permitted. If anyone does so, the authority may take disciplinary action.',
    'Every student must obtain an identity card and wear it around their neck.',
    'Every 3 months, fees and other dues must be paid at the college office and a receipt collected.',
    'If absent for 1 day without permission, the student must submit an application the following day with the guardian\'s signature and comments to the class teacher. Otherwise, they will lose their right to enter the classroom.',
    'Results of the Half-Yearly, Year-Change, Pre-Test, and Test exams can be collected from the college. A student failing any subject in the Year-Change exam will not be promoted to Class XII, and a student failing even 1 subject in the Test Exam will not be permitted to fill the HSC form under any circumstances.',
];

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">

            <div class="ph-kicker reveal">Academic Info</div>
            <h1 class="reveal">Student Instruction</h1>
            <p class="reveal">Important instructions for all students of Phulpur Mohila Degree College</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <div class="ai-top-row">
                <span class="ai-session-label"><i class="fas fa-info-circle"></i> Please read all instructions carefully</span>
                <div class="ai-meta-row">
                    <span class="ai-last-updated">Last Updated: <?php echo $last_updated; ?></span>
                </div>
            </div>

            <div class="ai-content-section reveal" style="margin-bottom:32px;">
                <h2><i class="fas fa-info-circle"></i> Student Instructions</h2>
                <div class="ai-rule-list">
                    <?php foreach ($instructions as $index => $instruction): ?>
                    <div class="ai-rule-item">
                        <div class="ai-rule-num"><?php echo $index + 1; ?></div>
                        <div class="ai-rule-body">
                            <div class="ai-rule-desc" style="color:var(--text);"><?php echo htmlspecialchars($instruction); ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>
