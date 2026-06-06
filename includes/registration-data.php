<?php
/**
 * registration-data.php
 * Data layer for PMDC Student Registration System.
 * PDO MySQL with JSON file fallback.
 */

if (!defined('DB_NAME')) {
    require_once __DIR__ . '/config.php';
}

define('REG_UPLOAD_BASE',   __DIR__ . '/../uploads/registrations/');
define('REG_DATA_DIR',      REG_UPLOAD_BASE . 'data/');
define('REG_SETTINGS_FILE', REG_UPLOAD_BASE . 'settings.json');

/* ── Ensure directories exist ───────────────────────────── */
function reg_ensure_dirs() {
    foreach ([REG_UPLOAD_BASE, REG_DATA_DIR] as $dir) {
        if (!is_dir($dir)) mkdir($dir, 0755, true);
    }
}

/* ── DB connection ──────────────────────────────────────── */
function reg_db() {
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

/* ── Create table ───────────────────────────────────────── */
function reg_init() {
    $db = reg_db();
    if (!$db) return false;
    $db->exec("CREATE TABLE IF NOT EXISTS registrations (
        id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        ref_number       VARCHAR(30)  NOT NULL UNIQUE,
        session          VARCHAR(9)   NOT NULL,
        program_type     ENUM('hsc','degree') NOT NULL,
        personal_data    JSON         NOT NULL,
        academic_data    JSON         NOT NULL,
        payment_method   VARCHAR(20)  NOT NULL DEFAULT '',
        transaction_id   VARCHAR(60)  NOT NULL DEFAULT '',
        amount_paid      DECIMAL(8,2) NOT NULL DEFAULT 0,
        payment_date     DATE         NOT NULL,
        photo_path       VARCHAR(255) DEFAULT NULL,
        certificate_path VARCHAR(255) DEFAULT NULL,
        birth_cert_path  VARCHAR(255) DEFAULT NULL,
        status           ENUM('pending','approved','rejected') DEFAULT 'pending',
        rejection_reason TEXT         DEFAULT NULL,
        admin_note       TEXT         DEFAULT NULL,
        submitted_at     TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
        reviewed_at      TIMESTAMP    NULL,
        reviewed_by      VARCHAR(100) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    $db->exec("CREATE TABLE IF NOT EXISTS registration_settings (
        setting_key VARCHAR(50) PRIMARY KEY,
        setting_value JSON NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    return true;
}

/* ── Generate reference number ───────────────────────────── */
function reg_generate_ref(string $type, string $session): string {
    $year   = preg_match('/(\d{4})/', $session, $m) ? $m[1] : date('Y');
    $prefix = $type === 'hsc' ? 'HSC' : 'DEG';
    $base   = "PMDC-{$prefix}-{$year}-";

    $db = reg_db();
    if ($db) {
        $row = $db->query("SELECT COUNT(*) as c FROM registrations WHERE program_type = '$type'")->fetch();
        return $base . str_pad(($row['c'] ?? 0) + 1, 5, '0', STR_PAD_LEFT);
    }

    $store = reg_json_load($type);
    return $base . str_pad(count($store) + 1, 5, '0', STR_PAD_LEFT);
}

/* ── Insert application ─────────────────────────────────── */
function reg_insert(array $data): array {
    reg_ensure_dirs();
    reg_init();

    $db = reg_db();
    if ($db) {
        $stmt = $db->prepare("INSERT INTO registrations
            (ref_number, session, program_type, personal_data, academic_data,
             payment_method, transaction_id, amount_paid, payment_date,
             photo_path, certificate_path, birth_cert_path)
            VALUES (:ref,:session,:type,:personal,:academic,:pmethod,:txn,:amount,:pdate,:photo,:cert,:birth)");
        $stmt->execute([
            ':ref'     => $data['ref_number'],
            ':session' => $data['session'],
            ':type'    => $data['program_type'],
            ':personal'=> json_encode($data['personal_data'], JSON_UNESCAPED_UNICODE),
            ':academic'=> json_encode($data['academic_data'],  JSON_UNESCAPED_UNICODE),
            ':pmethod' => $data['payment_method'],
            ':txn'     => $data['transaction_id'],
            ':amount'  => $data['amount_paid'],
            ':pdate'   => $data['payment_date'],
            ':photo'   => $data['photo_path']        ?? null,
            ':cert'    => $data['certificate_path']  ?? null,
            ':birth'   => $data['birth_cert_path']   ?? null,
        ]);
        return ['ok' => true];
    }

    $store   = reg_json_load($data['program_type']);
    $data['submitted_at'] = date('Y-m-d H:i:s');
    $data['status']       = 'pending';
    $store[] = $data;
    reg_json_save($data['program_type'], $store);
    return ['ok' => true];
}

/* ── List applications ──────────────────────────────────── */
function reg_list(string $type, string $session = '', array $filters = []): array {
    reg_init();
    $db = reg_db();

    if ($db) {
        $where  = ["program_type = :type"];
        $params = [':type' => $type];
        if ($session) { $where[] = "session = :session"; $params[':session'] = $session; }
        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $where[] = "status = :status"; $params[':status'] = $filters['status'];
        }
        if (!empty($filters['search'])) {
            $q = '%' . $filters['search'] . '%';
            $where[] = "(ref_number LIKE :q1 OR JSON_EXTRACT(personal_data,'$.full_name_en') LIKE :q2 OR transaction_id LIKE :q3)";
            $params += [':q1'=>$q,':q2'=>$q,':q3'=>$q];
        }
        if (!empty($filters['payment_method']) && $filters['payment_method'] !== 'all') {
            $where[] = "payment_method = :pm"; $params[':pm'] = $filters['payment_method'];
        }
        $stmt = $db->prepare("SELECT * FROM registrations WHERE " . implode(' AND ', $where) . " ORDER BY submitted_at DESC");
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        foreach ($rows as &$row) {
            $row['personal_data'] = json_decode($row['personal_data'], true);
            $row['academic_data'] = json_decode($row['academic_data'],  true);
        }
        return $rows;
    }

    $store = reg_json_load($type);
    if ($session) $store = array_filter($store, fn($r) => ($r['session']??'') === $session);
    if (!empty($filters['status']) && $filters['status'] !== 'all') {
        $store = array_filter($store, fn($r) => ($r['status']??'') === $filters['status']);
    }
    return array_values($store);
}

/* ── Get single ─────────────────────────────────────────── */
function reg_get(string $ref): ?array {
    $db = reg_db();
    if ($db) {
        $stmt = $db->prepare("SELECT * FROM registrations WHERE ref_number = ?");
        $stmt->execute([$ref]);
        $row = $stmt->fetch();
        if (!$row) return null;
        $row['personal_data'] = json_decode($row['personal_data'], true);
        $row['academic_data'] = json_decode($row['academic_data'],  true);
        return $row;
    }
    foreach (['hsc','degree'] as $t) {
        foreach (reg_json_load($t) as $r) {
            if (($r['ref_number']??'') === $ref) return $r;
        }
    }
    return null;
}

/* ── Update status ──────────────────────────────────────── */
function reg_update_status(string $ref, string $status, string $reason = '', string $note = ''): bool {
    $db = reg_db();
    if ($db) {
        $db->prepare("UPDATE registrations SET status=?,rejection_reason=?,admin_note=?,reviewed_at=NOW(),reviewed_by='admin' WHERE ref_number=?")
            ->execute([$status,$reason,$note,$ref]);
        return true;
    }
    foreach (['hsc','degree'] as $t) {
        $store = reg_json_load($t); $changed = false;
        foreach ($store as &$r) {
            if (($r['ref_number']??'') === $ref) {
                $r['status']=$status; $r['rejection_reason']=$reason; $r['admin_note']=$note; $r['reviewed_at']=date('Y-m-d H:i:s'); $changed=true;
            }
        }
        if ($changed) { reg_json_save($t,$store); return true; }
    }
    return false;
}

/* ── Save admin note ────────────────────────────────────── */
function reg_save_note(string $ref, string $note): bool {
    $db = reg_db();
    if ($db) { $db->prepare("UPDATE registrations SET admin_note=? WHERE ref_number=?")->execute([$note,$ref]); return true; }
    foreach (['hsc','degree'] as $t) {
        $store = reg_json_load($t); $changed = false;
        foreach ($store as &$r) { if (($r['ref_number']??'') === $ref) { $r['admin_note']=$note; $changed=true; } }
        if ($changed) { reg_json_save($t,$store); return true; }
    }
    return false;
}

/* ════════════════════════════════════════════════════════════
   SETTINGS
   ════════════════════════════════════════════════════════════ */
function reg_settings_get(): array {
    reg_init();
    $db = reg_db();
    
    // Default fallback
    $defaults = [
        'status'     => 'closed',
        'session'    => '2026-2027',
        'fee'        => 200,
        'open_date'  => '',
        'close_date' => '',
        'bkash'      => '01XXXXXXXXX',
        'nagad'      => '01XXXXXXXXX',
        'rocket'     => '01XXXXXXXXX',
    ];
    $settings = ['hsc' => $defaults, 'degree' => $defaults];

    if ($db) {
        $stmt = $db->query("SELECT setting_key, setting_value FROM registration_settings");
        while ($row = $stmt->fetch()) {
            $key = $row['setting_key'];
            if (isset($settings[$key])) {
                $settings[$key] = array_merge($settings[$key], json_decode($row['setting_value'], true) ?: []);
            }
        }
        return $settings;
    }

    if (file_exists(REG_SETTINGS_FILE)) {
        $raw = json_decode(file_get_contents(REG_SETTINGS_FILE), true);
        if ($raw) return array_merge($settings, $raw);
    }
    
    return $settings;
}

function reg_settings_save(array $data): bool {
    reg_init();
    $db = reg_db();
    
    if ($db) {
        $stmt = $db->prepare("INSERT INTO registration_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
        foreach (['hsc', 'degree'] as $key) {
            if (isset($data[$key])) {
                $stmt->execute([$key, json_encode($data[$key], JSON_UNESCAPED_UNICODE)]);
            }
        }
        return true;
    }

    reg_ensure_dirs();
    return (bool) file_put_contents(REG_SETTINGS_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

/**
 * Determine actual registration state for a type.
 * Returns array with 'state' => 'not_open_yet' | 'open' | 'closed'
 *
 * Rules:
 *  1. status !== 'open'                       → closed (admin manually closed)
 *  2. open_date set and today < open_date      → not_open_yet
 *  3. close_date set and today > close_date    → closed (auto-expired)
 *  4. Otherwise                               → open
 */
function reg_get_status(string $type): array {
    $settings = reg_settings_get();
    $s        = $settings[$type] ?? [];

    $status     = $s['status']     ?? 'closed';
    $open_date  = $s['open_date']  ?? '';
    $close_date = $s['close_date'] ?? '';
    $session    = $s['session']    ?? '2026-2027';
    $fee        = $s['fee']        ?? 200;

    $today = date('Y-m-d');

    if ($status !== 'open') {
        return [
            'state'      => 'closed',
            'session'    => $session,
            'fee'        => $fee,
            'open_date'  => $open_date,
            'close_date' => $close_date,
            'settings'   => $s,
        ];
    }

    if ($open_date && $today < $open_date) {
        return [
            'state'      => 'not_open_yet',
            'session'    => $session,
            'fee'        => $fee,
            'open_date'  => $open_date,
            'close_date' => $close_date,
            'settings'   => $s,
        ];
    }

    if ($close_date && $today > $close_date) {
        return [
            'state'      => 'closed',
            'session'    => $session,
            'fee'        => $fee,
            'open_date'  => $open_date,
            'close_date' => $close_date,
            'settings'   => $s,
        ];
    }

    return [
        'state'      => 'open',
        'session'    => $session,
        'fee'        => $fee,
        'open_date'  => $open_date,
        'close_date' => $close_date,
        'settings'   => $s,
    ];
}

/* ── JSON store helpers ─────────────────────────────────── */
function reg_json_file(string $type): string { return REG_DATA_DIR . "registrations_{$type}.json"; }
function reg_json_load(string $type): array {
    $f = reg_json_file($type);
    if (!file_exists($f)) return [];
    $raw = json_decode(file_get_contents($f), true);
    return is_array($raw) ? $raw : [];
}
function reg_json_save(string $type, array $data): void {
    file_put_contents(reg_json_file($type), json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

/* ── Stats ──────────────────────────────────────────────── */
function reg_stats(string $type, string $session = ''): array {
    $rows     = reg_list($type, $session);
    $pending  = count(array_filter($rows, fn($r) => ($r['status']??'') === 'pending'));
    $approved = count(array_filter($rows, fn($r) => ($r['status']??'') === 'approved'));
    $rejected = count(array_filter($rows, fn($r) => ($r['status']??'') === 'rejected'));
    return ['total'=>count($rows),'pending'=>$pending,'approved'=>$approved,'rejected'=>$rejected];
}
