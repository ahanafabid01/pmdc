<?php
/**
 * gallery-data.php
 * Data layer for the PMDC Gallery.
 * Falls back to sample data if DB is unavailable.
 */

/* ── DB connection ──────────────────────────────────────────────────── */
function pmdc_gallery_db() {
    static $pdo = null;
    if ($pdo) return $pdo;
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=pmdc_db;charset=utf8mb4', 'root', '', [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        return null;
    }
    return $pdo;
}

/* ── Ensure table exists ────────────────────────────────────────────── */
function pmdc_gallery_init() {
    $db = pmdc_gallery_db();
    if (!$db) return false;
    $db->exec("CREATE TABLE IF NOT EXISTS gallery_photos (
        id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title         VARCHAR(255)  DEFAULT '',
        filename      VARCHAR(255)  NOT NULL,
        year          SMALLINT UNSIGNED NOT NULL,
        date_uploaded DATE          NOT NULL,
        uploaded_by   VARCHAR(100)  DEFAULT 'admin',
        created_at    TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    return true;
}

/* ── Sample data (used when DB is absent or table empty) ────────────── */
function pmdc_gallery_sample() {
    $base = [
        ['title' => 'Annual Prize Giving Ceremony', 'year' => 2026, 'date_uploaded' => '2026-03-15'],
        ['title' => 'Science Fair 2026',             'year' => 2026, 'date_uploaded' => '2026-02-20'],
        ['title' => 'National Day Celebration',      'year' => 2026, 'date_uploaded' => '2026-03-26'],
        ['title' => 'Campus Life 2026',              'year' => 2026, 'date_uploaded' => '2026-04-10'],
        ['title' => 'HSC Farewell 2025',             'year' => 2025, 'date_uploaded' => '2025-11-30'],
        ['title' => 'Cultural Programme 2025',       'year' => 2025, 'date_uploaded' => '2025-10-15'],
        ['title' => 'Independence Day 2025',         'year' => 2025, 'date_uploaded' => '2025-03-26'],
        ['title' => 'Result Distribution 2025',      'year' => 2025, 'date_uploaded' => '2025-08-05'],
        ['title' => 'Freshers Welcome 2025',         'year' => 2025, 'date_uploaded' => '2025-01-20'],
        ['title' => 'Sports Day 2025',               'year' => 2025, 'date_uploaded' => '2025-02-14'],
        ['title' => 'Annual Function 2024',          'year' => 2024, 'date_uploaded' => '2024-12-05'],
        ['title' => 'Tree Plantation Drive',         'year' => 2024, 'date_uploaded' => '2024-06-05'],
        ['title' => 'Teacher\'s Day 2024',           'year' => 2024, 'date_uploaded' => '2024-10-05'],
        ['title' => 'Victory Day 2024',              'year' => 2024, 'date_uploaded' => '2024-12-16'],
        ['title' => 'Orientation Day 2023',          'year' => 2023, 'date_uploaded' => '2023-01-10'],
        ['title' => 'HSC Exam 2023',                 'year' => 2023, 'date_uploaded' => '2023-04-02'],
    ];

    // Assign Unsplash placeholders (school/event themed)
    $imgs = [
        'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=800&fit=crop&q=80',
        'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=800&h=800&fit=crop&q=80',
        'https://images.unsplash.com/photo-1567168544646-208fa5d408fb?w=800&h=800&fit=crop&q=80',
        'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=800&h=800&fit=crop&q=80',
        'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=800&h=800&fit=crop&q=80',
        'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800&h=800&fit=crop&q=80',
        'https://images.unsplash.com/photo-1544717305-2782549b5136?w=800&h=800&fit=crop&q=80',
        'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=800&h=800&fit=crop&q=80',
    ];

    $out = [];
    foreach ($base as $i => $row) {
        $out[] = array_merge($row, [
            'id'       => $i + 1,
            'filename' => $imgs[$i % count($imgs)],
            'is_external' => true,
        ]);
    }
    return $out;
}

/* ── Public: get all photos ─────────────────────────────────────────── */
function pmdc_gallery_get_all() {
    pmdc_gallery_init();
    $db = pmdc_gallery_db();
    if ($db) {
        $stmt = $db->query("SELECT * FROM gallery_photos ORDER BY year DESC, date_uploaded DESC");
        $rows = $stmt->fetchAll();
        if ($rows) return $rows;
    }
    return pmdc_gallery_sample();
}

/* ── Public: get distinct years ─────────────────────────────────────── */
function pmdc_gallery_years() {
    $photos = pmdc_gallery_get_all();
    $years  = array_unique(array_column($photos, 'year'));
    rsort($years);
    return $years;
}

/* ── Public: get photos grouped by year ────────────────────────────── */
function pmdc_gallery_grouped() {
    $photos = pmdc_gallery_get_all();
    $groups = [];
    foreach ($photos as $p) {
        $groups[$p['year']][] = $p;
    }
    krsort($groups);
    return $groups;
}

/* ── Admin: insert photo ────────────────────────────────────────────── */
function pmdc_gallery_insert($title, $filename, $year, $date, $by = 'admin') {
    $db = pmdc_gallery_db();
    if (!$db) return false;
    pmdc_gallery_init();
    $stmt = $db->prepare("INSERT INTO gallery_photos (title, filename, year, date_uploaded, uploaded_by) VALUES (?,?,?,?,?)");
    return $stmt->execute([$title, $filename, $year, $date, $by]);
}

/* ── Admin: delete photo ────────────────────────────────────────────── */
function pmdc_gallery_delete($id) {
    $db = pmdc_gallery_db();
    if (!$db) return false;
    $stmt = $db->prepare("SELECT filename FROM gallery_photos WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if ($row) {
        $path = __DIR__ . '/../uploads/gallery/' . $row['filename'];
        if (file_exists($path)) @unlink($path);
        $thumb = __DIR__ . '/../uploads/gallery/thumbs/' . $row['filename'];
        if (file_exists($thumb)) @unlink($thumb);
    }
    $del = $db->prepare("DELETE FROM gallery_photos WHERE id = ?");
    return $del->execute([$id]);
}

/* ── Admin: update photo ────────────────────────────────────────────── */
function pmdc_gallery_update($id, $title, $year, $date) {
    $db = pmdc_gallery_db();
    if (!$db) return false;
    $stmt = $db->prepare("UPDATE gallery_photos SET title=?, year=?, date_uploaded=? WHERE id=?");
    return $stmt->execute([$title, $year, $date, $id]);
}

/* ── Helper: get photo URL (handles both DB and sample) ─────────────── */
function pmdc_gallery_url($photo, $thumb = false, $base = '') {
    if (!empty($photo['is_external'])) return $photo['filename'];
    $file = $thumb ? 'thumbs/' . $photo['filename'] : $photo['filename'];
    return $base . 'uploads/gallery/' . $file;
}
