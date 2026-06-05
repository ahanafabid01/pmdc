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
    
    // Include config if not already included
    if (!defined('DB_NAME')) {
        require_once dirname(__DIR__) . '/includes/config.php';
    }
    
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



/* ── Public: get all photos ─────────────────────────────────────────── */
function pmdc_gallery_get_all() {
    pmdc_gallery_init();
    $db = pmdc_gallery_db();
    if ($db) {
        $stmt = $db->query("SELECT * FROM gallery_photos ORDER BY year DESC, date_uploaded DESC");
        return $stmt->fetchAll();
    }
    return [];
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
