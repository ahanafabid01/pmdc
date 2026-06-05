<?php
/**
 * staff-data.php
 * Data layer for PMDC Teachers & Staff
 */
require_once dirname(__DIR__, 4) . '/includes/config.php';

/* ── DB connection ──────────────────────────────────────────────────── */
function pmdc_staff_db() {
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
function pmdc_staff_init() {
    $db = pmdc_staff_db();
    if (!$db) return false;
    $db->exec("CREATE TABLE IF NOT EXISTS staff (
        id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name          VARCHAR(255)  NOT NULL,
        designation   VARCHAR(255)  NOT NULL,
        category      ENUM('teacher', 'admin', 'support') NOT NULL DEFAULT 'teacher',
        is_principal  TINYINT(1)    NOT NULL DEFAULT 0,
        subject       VARCHAR(255)  DEFAULT '—',
        qualification VARCHAR(255)  DEFAULT 'N/A',
        email         VARCHAR(255)  DEFAULT 'N/A',
        phone         VARCHAR(100)  DEFAULT 'N/A',
        photo         VARCHAR(255)  NULL,
        created_at    TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
        updated_at    TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    return true;
}

/* ── Sample data insertion (optional helper) ────────────────────────── */
function pmdc_staff_seed() {
    $db = pmdc_staff_db();
    if (!$db) return false;
    
    // Check if empty
    $count = $db->query("SELECT COUNT(*) FROM staff")->fetchColumn();
    if ($count > 0) return true; // Already seeded

    $samples = [
        ['Rowshan Ara Begum', 'Principal', 'teacher', 1, 'Administration', 'N/A', 'N/A', '01712-227983'],
        ['Md. Hafizur Rahman', 'Assistant Professor', 'teacher', 0, 'Bangla', 'N/A', 'N/A', '01725-659229'],
        ['Md. Khorshedul Rahman', 'Assistant Professor', 'teacher', 0, 'Physics', 'N/A', 'N/A', '01716-490999'],
        ['Md. Ali Akbar', 'Assistant Professor', 'teacher', 0, 'History', 'N/A', 'N/A', '01721-930034'],
        ['Jobeda Khanam', 'Accounts Assistant', 'admin', 0, 'Accounts', 'N/A', 'N/A', '01918-820956'],
        ['Md. Shafiqul Islam', 'Computer Operator', 'admin', 0, 'Computer Ops', 'N/A', 'N/A', '01988-986561'],
        ['Md. Abdul Hai', 'Peon', 'support', 0, '—', 'N/A', 'N/A', '01981-508632'],
        ['Rokeya Khatun', 'Cleaner', 'support', 0, '—', 'N/A', 'N/A', '01988-589853']
    ];

    $stmt = $db->prepare("INSERT INTO staff (name, designation, category, is_principal, subject, qualification, email, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($samples as $s) {
        $stmt->execute($s);
    }
    return true;
}

/* ── Public CRUD ─────────────────────────────────────────────────────── */
function pmdc_staff_get_all() {
    pmdc_staff_init();
    $db = pmdc_staff_db();
    if (!$db) return [];
    
    // Automatically seed if empty for demo purposes
    pmdc_staff_seed();

    $stmt = $db->query("SELECT * FROM staff ORDER BY is_principal DESC, category ASC, id ASC");
    return $stmt->fetchAll();
}

function pmdc_staff_insert($data) {
    $db = pmdc_staff_db();
    if (!$db) return false;

    if (!empty($data['is_principal'])) {
        $db->exec("UPDATE staff SET is_principal = 0");
    }

    $stmt = $db->prepare("INSERT INTO staff (name, designation, category, is_principal, subject, qualification, email, phone, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([
        $data['name'],
        $data['designation'],
        $data['category'],
        !empty($data['is_principal']) ? 1 : 0,
        $data['subject'] ?: '—',
        $data['qualification'] ?: 'N/A',
        $data['email'] ?: 'N/A',
        $data['phone'] ?: 'N/A',
        $data['photo'] ?: null
    ]);
}

function pmdc_staff_update($id, $data) {
    $db = pmdc_staff_db();
    if (!$db) return false;

    if (!empty($data['is_principal'])) {
        $db->exec("UPDATE staff SET is_principal = 0 WHERE id != " . (int)$id);
    }

    // If no new photo is provided and we don't want to clear it, $data['photo'] is null.
    // If we want to clear it, $data['photo'] is ''.
    // If we want to set a new one, $data['photo'] is the path.
    if (array_key_exists('photo', $data) && $data['photo'] !== null) {
        $photoVal = $data['photo'] === '' ? null : $data['photo'];
        
        // Fetch old photo to delete it from disk if changed/removed
        $stmt = $db->prepare("SELECT photo FROM staff WHERE id=?");
        $stmt->execute([$id]);
        $oldPhoto = $stmt->fetchColumn();
        
        if ($oldPhoto && $oldPhoto !== $photoVal) {
            $filePath = dirname(__DIR__, 4) . '/' . $oldPhoto;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        $stmt = $db->prepare("UPDATE staff SET name=?, designation=?, category=?, is_principal=?, subject=?, qualification=?, email=?, phone=?, photo=? WHERE id=?");
        return $stmt->execute([
            $data['name'],
            $data['designation'],
            $data['category'],
            !empty($data['is_principal']) ? 1 : 0,
            $data['subject'] ?: '—',
            $data['qualification'] ?: 'N/A',
            $data['email'] ?: 'N/A',
            $data['phone'] ?: 'N/A',
            $photoVal,
            $id
        ]);
    } else {
        $stmt = $db->prepare("UPDATE staff SET name=?, designation=?, category=?, is_principal=?, subject=?, qualification=?, email=?, phone=? WHERE id=?");
        return $stmt->execute([
            $data['name'],
            $data['designation'],
            $data['category'],
            !empty($data['is_principal']) ? 1 : 0,
            $data['subject'] ?: '—',
            $data['qualification'] ?: 'N/A',
            $data['email'] ?: 'N/A',
            $data['phone'] ?: 'N/A',
            $id
        ]);
    }
}

function pmdc_staff_delete($id) {
    $db = pmdc_staff_db();
    if (!$db) return false;
    
    // Get photo filename to delete it from disk
    $stmt = $db->prepare("SELECT photo FROM staff WHERE id=?");
    $stmt->execute([$id]);
    $photo = $stmt->fetchColumn();

    if ($photo) {
        $filePath = dirname(__DIR__, 4) . '/' . $photo;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    $stmt = $db->prepare("DELETE FROM staff WHERE id=?");
    return $stmt->execute([$id]);
}
