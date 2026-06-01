<?php
$page       = 'degree-program';
$page_group = 'academic';
$page_title = 'Degree Program | Phulpur Mohila Degree College';
$page_css   = 'academic.css';
$base_path  = '../';

// Data from pmdc.md §10A and §10F
$programs = [
    [
        'key'         => 'ba',
        'name'        => 'BA',
        'full'        => 'Bachelor of Arts',
        'bengali'     => 'কলা বিভাগ',
        'accent'      => '#7c3aed',
        'icon'        => 'fas fa-book',
        'session_note'=> 'Offered since the 2003–2004 academic session',
        'compulsory'  => [
            'Bangla (বাংলা)',
            'History of Bangladesh\'s Liberation (বাংলাদেশের অভ্যুদয়ের ইতিহাস)',
            'English',
        ],
        'optional'    => [
            'History (ইতিহাস)',
            'Philosophy (দর্শন)',
            'Political Science (রাষ্ট্রবিজ্ঞান)',
            'Islamic Studies (ইসলাম শিক্ষা)',
        ],
        'optional_note'=> 'Choose optional subjects as per curriculum',
        'conductor'   => 'National University of Bangladesh',
    ],
    [
        'key'         => 'bss',
        'name'        => 'BSS',
        'full'        => 'Bachelor of Social Science',
        'bengali'     => 'সমাজবিজ্ঞান বিভাগ',
        'accent'      => '#2563eb',
        'icon'        => 'fas fa-users',
        'session_note'=> 'Offered since the 2003–2004 academic session',
        'compulsory'  => [
            'Bangla (বাংলা)',
            'History of Bangladesh\'s Liberation (বাংলাদেশের অভ্যুদয়ের ইতিহাস)',
            'English',
        ],
        'optional'    => [
            'History (ইতিহাস)',
            'Philosophy (দর্শন)',
            'Political Science (রাষ্ট্রবিজ্ঞান)',
            'Islamic Studies (ইসলাম শিক্ষা)',
            'Economics (অর্থনীতি)',
            'Social Welfare (সমাজকল্যাণ)',
        ],
        'optional_note'=> 'Choose optional subjects as per curriculum',
        'conductor'   => 'National University of Bangladesh',
    ],
    [
        'key'         => 'bsc',
        'name'        => 'BSc',
        'full'        => 'Bachelor of Science',
        'bengali'     => 'বিজ্ঞান বিভাগ',
        'accent'      => '#059669',
        'icon'        => 'fas fa-flask',
        'session_note'=> 'Offered since the 2003–2004 academic session',
        'compulsory'  => [
            'Bangla (বাংলা)',
            'History of Bangladesh\'s Liberation (বাংলাদেশের অভ্যুদয়ের ইতিহাস)',
            'English',
        ],
        'optional'    => [
            'Botany (উদ্ভিদ বিজ্ঞান)',
            'Zoology (প্রাণি বিজ্ঞান)',
            'Chemistry (রসায়ন)',
        ],
        'optional_note'=> 'Choose optional subjects as per curriculum',
        'conductor'   => 'National University of Bangladesh',
    ],
    [
        'key'         => 'bmt',
        'name'        => 'BMT',
        'full'        => 'Business Management & Technology',
        'bengali'     => 'ব্যবসায় ব্যবস্থাপনা এবং টেকনোলজি',
        'accent'      => '#d97706',
        'icon'        => 'fas fa-briefcase',
        'session_note'=> 'Offered since the 2004–2005 academic session',
        'compulsory'  => [
            'Bangla (বাংলা)',
            'English',
            'Business Mathematics & Statistics (ব্যবসায়িক গণিত ও পরিসংখ্যান)',
            'Marketing (মার্কেটিং)',
            'Business Organization (ব্যবসায় সংগঠন)',
            'Accounting (হিসাব বিজ্ঞান)',
            'Economics (অর্থনীতি)',
            'Computer Office Application (কম্পিউটার অফিস অ্যাপ্লিকেশন)',
            'Digital Technology & Business-1 (ডিজিটাল টেকনোলজি এন্ড বিজনেস-১)',
        ],
        'optional'    => [],
        'optional_note'=> 'All subjects are compulsory in this program',
        'conductor'   => 'National University of Bangladesh',
    ],
];

include '../includes/header.php';
?>

    <section class="page-hero">
        <div class="container ph-content">

            <div class="ph-kicker reveal">Academic Info</div>
            <h1 class="reveal">Degree Program</h1>
            <p class="reveal">BA, BSS, BSc &amp; BMT — programs, subjects, and structure</p>
        </div>
    </section>

    <div class="ai-page">
        <div class="container">

            <!-- Program Overview Strip -->
            <div class="prog-overview-strip reveal">
                <div class="prog-overview-item">
                    <i class="fas fa-graduation-cap"></i>
                    <div>
                        <div class="poi-label">Program Type</div>
                        <div class="poi-val">Degree (BA / BSS / BSc / BMT)</div>
                    </div>
                </div>
                <div class="prog-overview-sep"></div>
                <div class="prog-overview-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <div class="poi-label">Duration</div>
                        <div class="poi-val">3 Years (1st, 2nd &amp; 3rd Year)</div>
                    </div>
                </div>
                <div class="prog-overview-sep"></div>
                <div class="prog-overview-item">
                    <i class="fas fa-university"></i>
                    <div>
                        <div class="poi-label">Conducted By</div>
                        <div class="poi-val">National University of Bangladesh</div>
                    </div>
                </div>
                <div class="prog-overview-sep"></div>
                <div class="prog-overview-item">
                    <i class="fas fa-calendar-check"></i>
                    <div>
                        <div class="poi-label">BA / BSS / BSc From</div>
                        <div class="poi-val">2003–2004 Session</div>
                    </div>
                </div>
                <div class="prog-overview-sep"></div>
                <div class="prog-overview-item">
                    <i class="fas fa-calendar-check"></i>
                    <div>
                        <div class="poi-label">BMT From</div>
                        <div class="poi-val">2004–2005 Session</div>
                    </div>
                </div>
            </div>

            <!-- Tab nav for programs -->
            <div class="dp-tab-nav reveal">
                <?php foreach ($programs as $p): ?>
                <button class="dp-tab-btn" data-target="dp-<?php echo $p['key']; ?>"
                        style="--tab-accent:<?php echo $p['accent']; ?>;">
                    <i class="<?php echo $p['icon']; ?>"></i>
                    <span><?php echo $p['name']; ?></span>
                    <small><?php echo $p['full']; ?></small>
                </button>
                <?php endforeach; ?>
            </div>

            <!-- Program Cards -->
            <?php foreach ($programs as $idx => $p): ?>
            <div class="dp-program-block reveal <?php echo $idx===0?'dp-active':''; ?>" id="dp-<?php echo $p['key']; ?>">
                <div class="prog-group-card" style="--prog-accent:<?php echo $p['accent']; ?>;--prog-bg:<?php echo $p['accent']; ?>15;">
                    <div class="pgc-header">
                        <div class="pgc-icon-wrap" style="background:<?php echo $p['accent']; ?>20;color:<?php echo $p['accent']; ?>;">
                            <i class="<?php echo $p['icon']; ?>"></i>
                        </div>
                        <div>
                            <div class="pgc-name"><?php echo htmlspecialchars($p['name']); ?> — <?php echo htmlspecialchars($p['full']); ?></div>
                            <div class="pgc-bengali"><?php echo htmlspecialchars($p['bengali']); ?></div>
                        </div>
                        <span class="pgc-badge" style="background:<?php echo $p['accent']; ?>15;color:<?php echo $p['accent']; ?>;">
                            <i class="fas fa-calendar-alt" style="font-size:.65rem;"></i> <?php echo htmlspecialchars($p['session_note']); ?>
                        </span>
                    </div>

                    <div class="pgc-subjects" style="grid-template-columns:<?php echo empty($p['optional'])?'1fr':'1fr 1fr'; ?>;">
                        <div class="pgc-col">
                            <div class="pgc-col-head" style="color:<?php echo $p['accent']; ?>;">
                                <i class="fas fa-check-circle"></i> Compulsory Subjects
                            </div>
                            <ul class="pgc-subject-list">
                                <?php foreach ($p['compulsory'] as $sub): ?>
                                <li class="pgc-subject-item pgc-compulsory"><?php echo htmlspecialchars($sub); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php if (!empty($p['optional'])): ?>
                        <div class="pgc-col">
                            <div class="pgc-col-head" style="color:<?php echo $p['accent']; ?>;">
                                <i class="fas fa-list"></i> Optional Subjects
                                <span class="pgc-note-tag"><?php echo htmlspecialchars($p['optional_note']); ?></span>
                            </div>
                            <ul class="pgc-subject-list">
                                <?php foreach ($p['optional'] as $sub): ?>
                                <li class="pgc-subject-item pgc-optional"><?php echo htmlspecialchars($sub); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php else: ?>
                        <div style="display:none;"></div>
                        <?php endif; ?>
                    </div>

                    <div style="margin-top:18px;padding:12px 16px;background:var(--surface);border-radius:10px;display:flex;align-items:center;gap:10px;font-family:'Inter',sans-serif;font-size:.8rem;color:var(--muted);">
                        <i class="fas fa-university" style="color:<?php echo $p['accent']; ?>;flex-shrink:0;"></i>
                        Final public examinations are conducted by the <strong style="color:var(--navy);margin:0 3px;"><?php echo htmlspecialchars($p['conductor']); ?></strong>. Internal exams are held each year.
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Internal Exam note -->
            <div class="ai-info-card reveal" style="margin-top:8px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                    <i class="fas fa-list-ol" style="color:var(--blue);font-size:1rem;"></i>
                    <strong style="font-size:.95rem;color:var(--navy);font-family:'Inter',sans-serif;">Degree Exam Structure</strong>
                </div>
                <div class="ai-info-grid">
                    <div class="ai-info-item">
                        <span class="ai-info-label">Program Length</span>
                        <span class="ai-info-value">3 Years — 1st Year, 2nd Year, 3rd Year</span>
                    </div>
                    <div class="ai-info-item">
                        <span class="ai-info-label">Final Exam Authority</span>
                        <span class="ai-info-value">National University of Bangladesh</span>
                    </div>
                    <div class="ai-info-item">
                        <span class="ai-info-label">Internal Exams</span>
                        <span class="ai-info-value">Held each academic year by the college</span>
                    </div>
                    <div class="ai-info-item">
                        <span class="ai-info-label">Admit Card</span>
                        <span class="ai-info-value">Must be collected 10 days before exam — late collection cancels seat</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

<style>
/* ── Degree program page specific styles ───────────────────── */
.prog-overview-strip {
    display: flex; align-items: stretch; flex-wrap: wrap;
    background: #fff; border: 1px solid var(--border);
    border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,.07);
    padding: 20px 24px; gap: 0; margin-bottom: 28px;
}
.prog-overview-item {
    display: flex; align-items: center; gap: 12px;
    padding: 6px 16px; flex: 1; min-width: 150px;
}
.prog-overview-item i { font-size: 1.1rem; color: var(--blue); flex-shrink: 0; }
.poi-label { font-size: .67rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .07em; font-family: 'Inter',sans-serif; }
.poi-val   { font-size: .8rem; font-weight: 700; color: var(--navy); font-family: 'Inter',sans-serif; margin-top: 2px; }
.prog-overview-sep { width: 1px; background: var(--border); margin: 4px 0; flex-shrink: 0; }

/* Tab nav */
.dp-tab-nav {
    display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px;
}
.dp-tab-btn {
    display: flex; flex-direction: column; align-items: center;
    gap: 2px; padding: 12px 22px; border-radius: 12px;
    border: 2px solid var(--border); background: #fff;
    cursor: pointer; transition: all .2s ease; flex: 1; min-width: 120px;
    font-family: 'Inter',sans-serif;
}
.dp-tab-btn i   { font-size: 1.2rem; color: #94a3b8; transition: color .2s; }
.dp-tab-btn span{ font-size: .95rem; font-weight: 800; color: var(--navy); }
.dp-tab-btn small{ font-size: .68rem; color: var(--muted); font-weight: 500; }
.dp-tab-btn:hover,
.dp-tab-btn.active-tab {
    border-color: var(--tab-accent);
    background: var(--tab-accent);
    box-shadow: 0 4px 14px rgba(0,0,0,.12);
}
.dp-tab-btn:hover i, .dp-tab-btn.active-tab i  { color: #fff; }
.dp-tab-btn:hover span, .dp-tab-btn.active-tab span { color: #fff; }
.dp-tab-btn:hover small, .dp-tab-btn.active-tab small{ color: rgba(255,255,255,.8); }

/* Program blocks */
.dp-program-block { display: none; }
.dp-program-block.dp-active { display: block; }

.prog-group-card {
    background: #fff; border: 1px solid var(--border);
    border-top: 4px solid var(--prog-accent);
    border-radius: 16px; padding: 24px 28px;
    box-shadow: 0 2px 12px rgba(0,0,0,.07); margin-bottom: 20px;
}
.pgc-header { display: flex; align-items: center; gap: 14px; margin-bottom: 22px; flex-wrap: wrap; }
.pgc-icon-wrap {
    width: 48px; height: 48px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; flex-shrink: 0;
}
.pgc-name    { font-size: 1.1rem; font-weight: 800; color: var(--navy); font-family: 'Inter',sans-serif; }
.pgc-bengali { font-size: .8rem; color: var(--muted); font-family: 'Inter',sans-serif; margin-top: 2px; }
.pgc-badge   { margin-left: auto; padding: 5px 14px; border-radius: 20px; font-size: .73rem; font-weight: 700; font-family: 'Inter',sans-serif; white-space: nowrap; display: flex; align-items: center; gap: 5px; }

.pgc-subjects { display: grid; gap: 20px; }
.pgc-col-head {
    font-size: .74rem; font-weight: 800; text-transform: uppercase;
    letter-spacing: .07em; display: flex; align-items: center; gap: 6px;
    margin-bottom: 10px; font-family: 'Inter',sans-serif; flex-wrap: wrap;
}
.pgc-note-tag { font-size: .68rem; font-weight: 500; color: #94a3b8; text-transform: none; letter-spacing: 0; }
.pgc-subject-list  { display: flex; flex-direction: column; gap: 5px; }
.pgc-subject-item  { font-size: .8rem; font-family: 'Inter',sans-serif; padding: 7px 12px; border-radius: 8px; font-weight: 600; line-height: 1.4; }
.pgc-compulsory { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
.pgc-optional   { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }

@media (max-width: 900px) {
    .prog-overview-strip { gap: 8px; }
    .prog-overview-item  { padding: 6px 10px; min-width: 130px; }
    .prog-overview-sep   { display: none; }
    .dp-tab-btn          { padding: 10px 14px; min-width: 100px; }
    .dp-tab-btn span     { font-size: .85rem; }
    .prog-group-card     { padding: 18px; }
}
@media (max-width: 540px) {
    .pgc-subjects { grid-template-columns: 1fr !important; }
    .dp-tab-nav   { gap: 6px; }
    .dp-tab-btn   { min-width: calc(50% - 6px); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs    = document.querySelectorAll('.dp-tab-btn');
    const blocks  = document.querySelectorAll('.dp-program-block');

    // Activate first tab
    if (tabs.length) tabs[0].classList.add('active-tab');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const target = this.dataset.target;
            tabs.forEach(t  => t.classList.remove('active-tab'));
            blocks.forEach(b => b.classList.remove('dp-active'));
            this.classList.add('active-tab');
            const block = document.getElementById(target);
            if (block) block.classList.add('dp-active');
        });
    });
});
</script>

<?php include '../includes/footer.php'; ?>
