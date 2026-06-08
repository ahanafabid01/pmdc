<?php
/**
 * contact-data.php
 * Data layer for PMDC Contact Messages
 */
require_once __DIR__ . '/config.php';

/* ── DB connection ──────────────────────────────────────────────────── */
function pmdc_contact_db() {
    static $pdo = null;
    if ($pdo) return $pdo;
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        return null;
    }
    return $pdo;
}

/* ── Ensure table exists ────────────────────────────────────────────── */
function pmdc_contact_init() {
    $db = pmdc_contact_db();
    if (!$db) return false;
    $db->exec("CREATE TABLE IF NOT EXISTS contact_messages (
        id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name        VARCHAR(255) NOT NULL,
        email       VARCHAR(255) NOT NULL,
        phone       VARCHAR(100) DEFAULT '',
        subject     VARCHAR(255) NOT NULL,
        message     TEXT NOT NULL,
        is_read     TINYINT(1) DEFAULT 0,
        created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    return true;
}

/* ── Public CRUD ─────────────────────────────────────────────────────── */
function pmdc_contact_insert($data) {
    pmdc_contact_init();
    $db = pmdc_contact_db();
    if (!$db) return false;

    $stmt = $db->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([
        $data['name'],
        $data['email'],
        $data['phone'] ?? '',
        $data['subject'],
        $data['message']
    ]);
}

function pmdc_contact_get_all() {
    pmdc_contact_init();
    $db = pmdc_contact_db();
    if (!$db) return [];

    $stmt = $db->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
    return $stmt->fetchAll();
}

function pmdc_contact_mark_read($id) {
    $db = pmdc_contact_db();
    if (!$db) return false;

    $stmt = $db->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?");
    return $stmt->execute([$id]);
}

function pmdc_contact_delete($id) {
    $db = pmdc_contact_db();
    if (!$db) return false;

    $stmt = $db->prepare("DELETE FROM contact_messages WHERE id = ?");
    return $stmt->execute([$id]);
}
?>
