<?php
$page       = 'academic-calendar';
$page_group = 'academic';
$page_title = 'Academic Calendar | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';

require_once '../includes/academic-calendar-data.php';
acal_init();

$calendars = acal_list();
$sessions = [];
foreach ($calendars as $cal) {
    $sessions[] = $cal['year'] . '–' . ($cal['year'] + 1);
}
if (empty($sessions)) {
    $sessions = [date('Y') . '–' . (date('Y') + 1)]; // fallback if empty
}

$currentSession = $_GET['session'] ?? $sessions[0];
$currentYear = (int) explode('–', $currentSession)[0];

$currentCalendar = null;
foreach ($calendars as $cal) {
    if ((int)$cal['year'] === $currentYear) {
        $currentCalendar = $cal;
        break;
    }
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
                <span class="show-en">Academic Calendar</span>
                <span class="show-bn">একাডেমিক ক্যালেন্ডার</span>
            </h1>
            <p class="reveal">Key academic dates, examinations, and events for each session</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <div class="ai-top-row">
                <form method="GET" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                    <span class="ai-session-label"><i class="fas fa-layer-group"></i> Session:</span>
                    <select name="session" class="ai-filter-select" onchange="this.form.submit()" style="min-width:140px;">
                        <?php foreach($sessions as $s): ?>
                        <option value="<?php echo htmlspecialchars($s); ?>" <?php echo $currentSession===$s?'selected':''; ?>><?php echo htmlspecialchars($s); ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
                <div class="ai-meta-row">
                    <?php if ($currentCalendar): ?>
                        <span class="ai-last-updated">Last Updated: <?php echo date('F j, Y', strtotime($currentCalendar['updated_at'])); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="ai-timeline" style="margin-top: 40px; text-align: center;">
                <?php if ($currentCalendar): ?>
                    <?php 
                    $fileUrl = $base_path . 'uploads/academic-calendar/' . htmlspecialchars($currentCalendar['filename']); 
                    ?>
                    
                    <?php if ($currentCalendar['file_type'] === 'pdf'): ?>
                        <div class="calendar-pdf-container" style="margin: 0 auto; max-width: 900px;">
                            <iframe src="<?php echo $fileUrl; ?>" width="100%" height="800px" style="border: 1px solid var(--border); border-radius: 8px;">
                                This browser does not support PDFs. Please download the PDF to view it: <a href="<?php echo $fileUrl; ?>">Download PDF</a>
                            </iframe>
                            <div style="margin-top: 20px;">
                                <a href="<?php echo $fileUrl; ?>" target="_blank" class="btn btn-primary"><i class="fas fa-download"></i> Download PDF</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="calendar-image-container" style="margin: 0 auto; max-width: 900px; border: 1px solid var(--border); border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                            <img src="<?php echo $fileUrl; ?>" alt="Academic Calendar <?php echo htmlspecialchars($currentSession); ?>" style="width: 100%; height: auto; display: block;">
                        </div>
                        <div style="margin-top: 20px;">
                            <a href="<?php echo $fileUrl; ?>" target="_blank" class="btn btn-primary"><i class="fas fa-download"></i> Download Image</a>
                        </div>
                    <?php endif; ?>
                    
                <?php else: ?>
                    <div class="no-results" style="padding: 60px 20px; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1;">
                        <i class="fas fa-calendar-times" style="font-size: 3rem; color: #94a3b8; margin-bottom: 15px; display: block;"></i>
                        <h3 style="color: #475569; font-size: 1.25rem; margin-bottom: 10px;">Calendar Not Published Yet</h3>
                        <p style="color: #64748b; margin: 0;">The academic calendar for the <?php echo htmlspecialchars($currentSession); ?> session has not been uploaded yet. Please check back later.</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

<?php include '../includes/footer.php'; ?>
