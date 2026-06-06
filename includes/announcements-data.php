<?php
/**
 * Shared announcement data for public listing, detail pages, and admin portal.
 */

// Include DB config
require_once __DIR__ . '/db-config.php';

function pmdc_announcements_init() {
    $conn = pmdc_db_connect();
    if (!$conn) return false;

    $check = $conn->query("SHOW TABLES LIKE 'pmdc_announcements'");
    if ($check && $check->num_rows > 0) {
        $conn->close();
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

    if ($conn->query($sql)) {
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

        $stmt = $conn->prepare("INSERT INTO pmdc_announcements (title, category, category_label, badge_label, badge_class, date, author, published, body, attachment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($items as $item) {
            $stmt->bind_param("ssssssssss", $item['title'], $item['category'], $item['category_label'], $item['badge_label'], $item['badge_class'], $item['date'], $item['author'], $item['published'], $item['body'], $item['attachment']);
            $stmt->execute();
        }
        $stmt->close();
    }
    $conn->close();
    return true;
}

function pmdc_get_announcements() {
    pmdc_announcements_init();
    $conn = pmdc_db_connect();
    if (!$conn) return [];

    $res = $conn->query("SELECT * FROM pmdc_announcements ORDER BY date DESC, created_at DESC");
    $items = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            if ($row['attachment']) {
                $row['attachment'] = json_decode($row['attachment'], true);
            } else {
                $row['attachment'] = null;
            }
            $items[] = $row;
        }
    }
    $conn->close();
    return $items;
}

function pmdc_get_published_announcements() {
    pmdc_announcements_init();
    $conn = pmdc_db_connect();
    if (!$conn) return [];

    $res = $conn->query("SELECT * FROM pmdc_announcements WHERE published = 1 ORDER BY date DESC, created_at DESC");
    $items = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            if ($row['attachment']) {
                $row['attachment'] = json_decode($row['attachment'], true);
            } else {
                $row['attachment'] = null;
            }
            $items[] = $row;
        }
    }
    $conn->close();
    return $items;
}

function pmdc_find_published_announcement_by_id($id) {
    pmdc_announcements_init();
    $conn = pmdc_db_connect();
    if (!$conn) return null;

    $id = (int)$id;
    $res = $conn->query("SELECT * FROM pmdc_announcements WHERE id = $id AND published = 1 LIMIT 1");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        if ($row['attachment']) {
            $row['attachment'] = json_decode($row['attachment'], true);
        } else {
            $row['attachment'] = null;
        }
        $conn->close();
        return $row;
    }
    $conn->close();
    return null;
}

// Admin API helper functions
function pmdc_announcement_insert($data) {
    pmdc_announcements_init();
    $conn = pmdc_db_connect();
    if (!$conn) return false;

    $stmt = $conn->prepare("INSERT INTO pmdc_announcements (title, category, category_label, badge_label, badge_class, date, author, published, body, attachment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $published = $data['published'] ? 1 : 0;
    
    $attachment = null;
    if (isset($data['attachment']) && is_array($data['attachment'])) {
        $attachment = json_encode($data['attachment']);
    }

    $stmt->bind_param("ssssssssss", $data['title'], $data['category'], $data['category_label'], $data['badge_label'], $data['badge_class'], $data['date'], $data['author'], $published, $data['body'], $attachment);
    $res = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $res;
}

function pmdc_announcement_update($id, $data) {
    pmdc_announcements_init();
    $conn = pmdc_db_connect();
    if (!$conn) return false;

    $stmt = $conn->prepare("UPDATE pmdc_announcements SET title=?, category=?, category_label=?, badge_label=?, badge_class=?, date=?, author=?, published=?, body=?, attachment=? WHERE id=?");
    $published = $data['published'] ? 1 : 0;
    $id = (int)$id;

    $attachment = null;
    if (isset($data['attachment']) && is_array($data['attachment'])) {
        $attachment = json_encode($data['attachment']);
    }

    $stmt->bind_param("ssssssssssi", $data['title'], $data['category'], $data['category_label'], $data['badge_label'], $data['badge_class'], $data['date'], $data['author'], $published, $data['body'], $attachment, $id);
    $res = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $res;
}

function pmdc_announcement_delete($id) {
    pmdc_announcements_init();
    $conn = pmdc_db_connect();
    if (!$conn) return false;

    $id = (int)$id;
    $res = $conn->query("DELETE FROM pmdc_announcements WHERE id = $id");
    $conn->close();
    return $res;
}
