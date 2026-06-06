<?php
/**
 * Shared announcement data for public listing, detail pages, and admin portal.
 */

if (!defined('DB_NAME')) {
    require_once __DIR__ . '/config.php';
}

function pmdc_announcements_db() {
    static $pdo = null;
    if ($pdo) return $pdo;
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        return null;
    }
    return $pdo;
}

function pmdc_announcements_init() {
    $db = pmdc_announcements_db();
    if (!$db) return false;

    $check = $db->query("SHOW TABLES LIKE 'pmdc_announcements'");
    if ($check && $check->rowCount() > 0) {
        return true;
    }

    $sql = "CREATE TABLE pmdc_announcements (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        category VARCHAR(50) DEFAULT 'notice',
        category_label VARCHAR(50) DEFAULT 'Notice',
        badge_label VARCHAR(50) DEFAULT '',
        badge_class VARCHAR(50) DEFAULT '',
        date DATE NOT NULL,
        author VARCHAR(100) DEFAULT 'Administration',
        published TINYINT(1) DEFAULT 1,
        body TEXT NOT NULL,
        attachment LONGTEXT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    if ($db->exec($sql) !== false) {
        // Seed initial data
        $items = [
            [
                'title' => 'Admission Open for Session 2026-27',
                'category' => 'admission',
                'category_label' => 'Admission',
                'badge_label' => 'Urgent',
                'badge_class' => 'badge-urgent',
                'date' => '2026-02-08',
                'author' => 'Admission Office',
                'published' => 1,
                'body' => "Applications are now open for HSC 1st Year admission in Science, Business, and Humanities groups for the 2026-27 academic session.\n\nEligible SSC or equivalent pass students are encouraged to complete the application process before the deadline. Required documents include academic transcripts, birth certificate, and recent photographs.\n\nFor details about eligibility, admission fee, and submission instructions, please contact the college office during working hours.",
                'attachment' => null,
            ],
            [
                'title' => 'HSC Test Examination 2026 Schedule Released',
                'category' => 'academic',
                'category_label' => 'Academic',
                'badge_label' => 'New',
                'badge_class' => 'badge-new',
                'date' => '2026-02-06',
                'author' => 'Exam Committee',
                'published' => 1,
                'body' => "The official test examination routine for HSC 2nd Year students has been published.\n\nStudents must collect admit cards from the academic office at least two days before the first exam date. Attendance in all scheduled exams is mandatory.\n\nAny student with unresolved fee dues should complete payment before collecting exam documents.",
                'attachment' => json_encode([
                    'type' => 'pdf',
                    'name' => 'HSC-Test-Exam-Schedule-2026.pdf',
                    'size' => '432 KB',
                    'url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                ]),
            ],
            [
                'title' => 'Annual Cultural Programme 2026',
                'category' => 'event',
                'category_label' => 'Event',
                'badge_label' => '',
                'badge_class' => '',
                'date' => '2026-02-05',
                'author' => 'Cultural Committee',
                'published' => 1,
                'body' => "The annual cultural programme will be held at the college auditorium with performances from students across all departments.\n\nThe event includes music, drama, recitation, and group dance. Rehearsal slots are available from Sunday to Thursday after class hours.\n\nStudents interested in participating should register with the student affairs desk by February 12, 2026.",
                'attachment' => json_encode([
                    'type' => 'image',
                    'name' => 'annual-cultural-programme-2026.jpg',
                    'size' => '1.8 MB',
                    'url' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=1600&q=80',
                ]),
            ],
            [
                'title' => "Parents' Meeting Notice",
                'category' => 'notice',
                'category_label' => 'Notice',
                'badge_label' => 'Important',
                'badge_class' => 'badge-important',
                'date' => '2026-02-03',
                'author' => 'Principal Office',
                'published' => 1,
                'body' => "A parents' meeting will be held on campus for guardians of HSC 1st and 2nd Year students.\n\nDiscussion topics include attendance, academic progress, exam preparation, and institutional policies. Parents are requested to attend with the student ID card.\n\nThe meeting will begin at 10:00 AM and conclude by 1:00 PM in the main seminar hall.",
                'attachment' => null,
            ],
            [
                'title' => 'Draft Announcement Example',
                'category' => 'notice',
                'category_label' => 'Notice',
                'badge_label' => '',
                'badge_class' => '',
                'date' => '2026-01-09',
                'author' => 'Administration',
                'published' => 0,
                'body' => "This unpublished record is intentionally excluded from public pages.",
                'attachment' => null,
            ],
        ];

        $stmt = $db->prepare("INSERT INTO pmdc_announcements (title, category, category_label, badge_label, badge_class, date, author, published, body, attachment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($items as $item) {
            $stmt->execute([$item['title'], $item['category'], $item['category_label'], $item['badge_label'], $item['badge_class'], $item['date'], $item['author'], $item['published'], $item['body'], $item['attachment']]);
        }
    }
    return true;
}

function pmdc_get_announcements() {
    pmdc_announcements_init();
    $db = pmdc_announcements_db();
    if (!$db) return [];

    $stmt = $db->query("SELECT * FROM pmdc_announcements ORDER BY date DESC, created_at DESC");
    $rows = $stmt->fetchAll();
    
    foreach ($rows as &$row) {
        if ($row['attachment']) {
            $row['attachment'] = json_decode($row['attachment'], true);
        } else {
            $row['attachment'] = null;
        }
    }
    return $rows;
}

function pmdc_get_published_announcements() {
    pmdc_announcements_init();
    $db = pmdc_announcements_db();
    if (!$db) return [];

    $stmt = $db->query("SELECT * FROM pmdc_announcements WHERE published = 1 ORDER BY date DESC, created_at DESC");
    $rows = $stmt->fetchAll();
    
    foreach ($rows as &$row) {
        if ($row['attachment']) {
            $row['attachment'] = json_decode($row['attachment'], true);
        } else {
            $row['attachment'] = null;
        }
    }
    return $rows;
}

function pmdc_find_published_announcement_by_id($id) {
    pmdc_announcements_init();
    $db = pmdc_announcements_db();
    if (!$db) return null;

    $stmt = $db->prepare("SELECT * FROM pmdc_announcements WHERE id = ? AND published = 1 LIMIT 1");
    $stmt->execute([(int)$id]);
    $row = $stmt->fetch();
    
    if ($row) {
        if ($row['attachment']) {
            $row['attachment'] = json_decode($row['attachment'], true);
        } else {
            $row['attachment'] = null;
        }
        return $row;
    }
    return null;
}

// Admin API helper functions
function pmdc_announcement_insert($data) {
    pmdc_announcements_init();
    $db = pmdc_announcements_db();
    if (!$db) return false;

    $stmt = $db->prepare("INSERT INTO pmdc_announcements (title, category, category_label, badge_label, badge_class, date, author, published, body, attachment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $published = $data['published'] ? 1 : 0;
    
    $attachment = null;
    if (isset($data['attachment']) && is_array($data['attachment'])) {
        $attachment = json_encode($data['attachment']);
    }

    return $stmt->execute([
        $data['title'], $data['category'], $data['category_label'], $data['badge_label'], $data['badge_class'], 
        $data['date'], $data['author'], $published, $data['body'], $attachment
    ]);
}

function pmdc_announcement_update($id, $data) {
    pmdc_announcements_init();
    $db = pmdc_announcements_db();
    if (!$db) return false;

    $stmt = $db->prepare("UPDATE pmdc_announcements SET title=?, category=?, category_label=?, badge_label=?, badge_class=?, date=?, author=?, published=?, body=?, attachment=? WHERE id=?");
    $published = $data['published'] ? 1 : 0;

    $attachment = null;
    if (isset($data['attachment']) && is_array($data['attachment'])) {
        $attachment = json_encode($data['attachment']);
    }

    return $stmt->execute([
        $data['title'], $data['category'], $data['category_label'], $data['badge_label'], $data['badge_class'], 
        $data['date'], $data['author'], $published, $data['body'], $attachment, (int)$id
    ]);
}

function pmdc_announcement_delete($id) {
    pmdc_announcements_init();
    $db = pmdc_announcements_db();
    if (!$db) return false;

    $stmt = $db->prepare("DELETE FROM pmdc_announcements WHERE id = ?");
    return $stmt->execute([(int)$id]);
}
