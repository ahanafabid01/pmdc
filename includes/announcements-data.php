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

function pmdc_generate_slug($title) {
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9\s\-]/', '', $slug);
    $slug = preg_replace('/[\s\-]+/', '-', $slug);
    return trim($slug, '-');
}

function pmdc_announcements_init() {
    $db = pmdc_announcements_db();
    if (!$db) return false;

    $check = $db->query("SHOW TABLES LIKE 'pmdc_announcements'");
    if ($check && $check->rowCount() > 0) {
        $check_col = $db->query("SHOW COLUMNS FROM pmdc_announcements LIKE 'slug'");
        if ($check_col && $check_col->rowCount() == 0) {
            $db->exec("ALTER TABLE pmdc_announcements ADD COLUMN slug VARCHAR(255) UNIQUE AFTER title");
            $rows = $db->query("SELECT id, title FROM pmdc_announcements")->fetchAll();
            $upd = $db->prepare("UPDATE pmdc_announcements SET slug = ? WHERE id = ?");
            foreach ($rows as $r) {
                $upd->execute([pmdc_generate_slug($r['title']), $r['id']]);
            }
        }
        return true;
    }

    $sql = "CREATE TABLE pmdc_announcements (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) UNIQUE,
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

function pmdc_find_published_announcement_by_slug($slug) {
    pmdc_announcements_init();
    $db = pmdc_announcements_db();
    if (!$db) return null;

    $stmt = $db->prepare("SELECT * FROM pmdc_announcements WHERE slug = ? AND published = 1 LIMIT 1");
    $stmt->execute([$slug]);
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

    $stmt = $db->prepare("INSERT INTO pmdc_announcements (title, slug, category, category_label, badge_label, badge_class, date, author, published, body, attachment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $published = $data['published'] ? 1 : 0;
    
    $attachment = null;
    if (isset($data['attachment']) && is_array($data['attachment'])) {
        $attachment = json_encode($data['attachment']);
    }

    $slug = pmdc_generate_slug($data['title']);

    return $stmt->execute([
        $data['title'], $slug, $data['category'], $data['category_label'], $data['badge_label'], $data['badge_class'], 
        $data['date'], $data['author'], $published, $data['body'], $attachment
    ]);
}

function pmdc_announcement_update($id, $data) {
    pmdc_announcements_init();
    $db = pmdc_announcements_db();
    if (!$db) return false;

    $stmt = $db->prepare("UPDATE pmdc_announcements SET title=?, slug=?, category=?, category_label=?, badge_label=?, badge_class=?, date=?, author=?, published=?, body=?, attachment=? WHERE id=?");
    $published = $data['published'] ? 1 : 0;

    $attachment = null;
    if (isset($data['attachment']) && is_array($data['attachment'])) {
        $attachment = json_encode($data['attachment']);
    }

    $slug = pmdc_generate_slug($data['title']);

    return $stmt->execute([
        $data['title'], $slug, $data['category'], $data['category_label'], $data['badge_label'], $data['badge_class'], 
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
