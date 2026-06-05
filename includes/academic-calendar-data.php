<?php
/**
 * includes/academic-calendar-data.php
 * Data layer for Academic Calendar (one file per year).
 * Uses JSON file storage as fallback if DB is unavailable.
 */

define('ACAL_UPLOAD_DIR', dirname(__DIR__) . '/uploads/academic-calendar/');
define('ACAL_JSON',       dirname(__DIR__) . '/uploads/academic-calendar/index.json');

/* ── Ensure upload directory exists ─────────────────────── */
function acal_init() {
    if (!is_dir(ACAL_UPLOAD_DIR)) mkdir(ACAL_UPLOAD_DIR, 0755, true);
    if (!file_exists(ACAL_JSON)) file_put_contents(ACAL_JSON, json_encode([]));

    // Also try DB
    $db = acal_db();
    if ($db) {
        $db->exec("CREATE TABLE IF NOT EXISTS academic_calendars (
            id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            year         SMALLINT UNSIGNED NOT NULL UNIQUE,
            filename     VARCHAR(255) NOT NULL,
            file_type    ENUM('image','pdf') NOT NULL DEFAULT 'image',
            uploaded_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }
}

/* ── DB connection ────────────────────────────────────────── */
function acal_db() {
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

/* ── Read all entries ─────────────────────────────────────── */
function acal_list() {
    $db = acal_db();
    if ($db) {
        try {
            $rows = $db->query("SELECT * FROM academic_calendars ORDER BY year DESC")->fetchAll();
            return $rows;
        } catch (Exception $e) {}
    }
    // JSON fallback
    $data = json_decode(file_get_contents(ACAL_JSON), true) ?: [];
    usort($data, fn($a,$b) => $b['year'] <=> $a['year']);
    return $data;
}

/* ── Insert or replace entry for a year ──────────────────── */
function acal_upsert(int $year, string $filename, string $fileType): bool {
    $db = acal_db();
    if ($db) {
        try {
            $stmt = $db->prepare("INSERT INTO academic_calendars (year, filename, file_type)
                VALUES (:year, :fn, :ft)
                ON DUPLICATE KEY UPDATE filename=:fn, file_type=:ft, updated_at=NOW()");
            return $stmt->execute([':year'=>$year, ':fn'=>$filename, ':ft'=>$fileType]);
        } catch (Exception $e) {}
    }
    // JSON fallback
    $data = json_decode(file_get_contents(ACAL_JSON), true) ?: [];
    $data = array_filter($data, fn($r) => (int)$r['year'] !== $year);
    $data[] = [
        'year'        => $year,
        'filename'    => $filename,
        'file_type'   => $fileType,
        'uploaded_at' => date('Y-m-d H:i:s'),
        'updated_at'  => date('Y-m-d H:i:s'),
    ];
    return (bool)file_put_contents(ACAL_JSON, json_encode(array_values($data)));
}

/* ── Delete entry for a year ──────────────────────────────── */
function acal_delete(int $year): bool {
    $db = acal_db();
    if ($db) {
        try {
            $stmt = $db->prepare("DELETE FROM academic_calendars WHERE year = :year");
            return $stmt->execute([':year' => $year]);
        } catch (Exception $e) {}
    }
    // JSON fallback
    $data = json_decode(file_get_contents(ACAL_JSON), true) ?: [];
    $data = array_values(array_filter($data, fn($r) => (int)$r['year'] !== $year));
    return (bool)file_put_contents(ACAL_JSON, json_encode($data));
}
