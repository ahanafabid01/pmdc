<?php
/**
 * includes/academics-data.php
 * Handles database interaction for Academics (HSC and Degree Programs)
 */

if (!defined('DB_NAME')) {
    require_once __DIR__ . '/config.php';
}

function pmdc_academics_db() {
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

function pmdc_academics_init() {
    $db = pmdc_academics_db();
    if (!$db) return false;

    // Create table
    $db->exec("CREATE TABLE IF NOT EXISTS academics_programs (
        id VARCHAR(50) PRIMARY KEY,
        type ENUM('hsc', 'degree') NOT NULL,
        name VARCHAR(100) NOT NULL,
        bengali_name VARCHAR(255) NOT NULL,
        full_name VARCHAR(255) DEFAULT '',
        icon VARCHAR(100) DEFAULT 'fas fa-book',
        accent_color VARCHAR(20) DEFAULT '#2563eb',
        conductor VARCHAR(255) DEFAULT 'National University of Bangladesh',
        compulsory_subjects TEXT,
        optional_subjects TEXT,
        optional_note VARCHAR(255) DEFAULT '',
        fourth_subjects TEXT,
        fourth_note VARCHAR(255) DEFAULT '',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Seed data if empty
    $stmt = $db->query("SELECT COUNT(*) FROM academics_programs");
    if ($stmt->fetchColumn() == 0) {
        pmdc_academics_seed($db);
    }
    return true;
}

function pmdc_academics_seed($db) {
    // Seed HSC Data
    $hscData = [
        [
            'id' => 'hsc-science', 'type' => 'hsc', 'name' => 'Science', 'bengali_name' => 'বিজ্ঞান শাখা',
            'icon' => 'fas fa-flask', 'accent_color' => '#2563eb',
            'compulsory_subjects' => json_encode(['Bangla (বাংলা)', 'English', 'ICT (তথ্য ও যোগাযোগ প্রযুক্তি)']),
            'optional_subjects' => json_encode(['Physics (পদার্থ বিজ্ঞান)', 'Chemistry (রসায়ন)', 'Biology (জীব বিজ্ঞান)']),
            'optional_note' => 'Choose any 3',
            'fourth_subjects' => json_encode(['Higher Mathematics (উচ্চতর গণিত)', 'Biology (জীব বিজ্ঞান)']),
            'fourth_note' => 'Choose any 1 (optional)',
            'full_name' => '', 'conductor' => ''
        ],
        [
            'id' => 'hsc-humanities', 'type' => 'hsc', 'name' => 'Humanities', 'bengali_name' => 'মানবিক শাখা',
            'icon' => 'fas fa-landmark', 'accent_color' => '#7c3aed',
            'compulsory_subjects' => json_encode(['Bangla (বাংলা)', 'English', 'ICT (তথ্য ও যোগাযোগ প্রযুক্তি)']),
            'optional_subjects' => json_encode(['Civics & Good Governance (পৌরনীতি ও সুশাসন)', 'Economics (অর্থনীতি)', 'Logic (যুক্তিবিদ্যা)', 'Social Work (সমাজকর্ম)', 'History (ইতিহাস)', 'Geography (ভূগোল)']),
            'optional_note' => 'Choose any 3',
            'fourth_subjects' => json_encode(['Civics (পৌরনীতি)', 'Economics (অর্থনীতি)', 'Logic (যুক্তিবিদ্যা)', 'Social Work (সমাজকর্ম)', 'History (ইতিহাস)', 'Islamic Studies (ইসলাম শিক্ষা)']),
            'fourth_note' => 'Choose any 1 (optional)',
            'full_name' => '', 'conductor' => ''
        ],
        [
            'id' => 'hsc-business', 'type' => 'hsc', 'name' => 'Business Studies', 'bengali_name' => 'ব্যবসায় শিক্ষা শাখা',
            'icon' => 'fas fa-chart-line', 'accent_color' => '#059669',
            'compulsory_subjects' => json_encode(['Bangla (বাংলা)', 'English', 'ICT (তথ্য ও যোগাযোগ প্রযুক্তি)']),
            'optional_subjects' => json_encode(['Accounting (হিসাব বিজ্ঞান)', 'Business Policy & Practice (ব্যবসায়নীতি ও প্রয়োগ)', 'Marketing (মার্কেটিং)']),
            'optional_note' => 'Choose any 3',
            'fourth_subjects' => json_encode(['Economics (অর্থনীতি)', 'Geography (ভূগোল)']),
            'fourth_note' => 'Choose any 1 (optional)',
            'full_name' => '', 'conductor' => ''
        ],
    ];

    // Seed Degree Data
    $degData = [
        [
            'id' => 'deg-ba', 'type' => 'degree', 'name' => 'BA', 'full_name' => 'Bachelor of Arts', 'bengali_name' => 'কলা বিভাগ',
            'icon' => 'fas fa-book', 'accent_color' => '#7c3aed', 'conductor' => 'National University of Bangladesh',
            'compulsory_subjects' => json_encode(['Bangla (বাংলা)', "History of Bangladesh's Liberation (বাংলাদেশের অভ্যুদয়ের ইতিহাস)", 'English']),
            'optional_subjects' => json_encode(['History (ইতিহাস)', 'Philosophy (দর্শন)', 'Political Science (রাষ্ট্রবিজ্ঞান)', 'Islamic Studies (ইসলাম শিক্ষা)']),
            'optional_note' => 'Choose optional subjects as per curriculum',
            'fourth_subjects' => '[]', 'fourth_note' => ''
        ],
        [
            'id' => 'deg-bss', 'type' => 'degree', 'name' => 'BSS', 'full_name' => 'Bachelor of Social Science', 'bengali_name' => 'সমাজবিজ্ঞান বিভাগ',
            'icon' => 'fas fa-users', 'accent_color' => '#2563eb', 'conductor' => 'National University of Bangladesh',
            'compulsory_subjects' => json_encode(['Bangla (বাংলা)', "History of Bangladesh's Liberation (বাংলাদেশের অভ্যুদয়ের ইতিহাস)", 'English']),
            'optional_subjects' => json_encode(['History (ইতিহাস)', 'Philosophy (দর্শন)', 'Political Science (রাষ্ট্রবিজ্ঞান)', 'Islamic Studies (ইসলাম শিক্ষা)', 'Economics (অর্থনীতি)', 'Social Welfare (সমাজকল্যাণ)']),
            'optional_note' => 'Choose optional subjects as per curriculum',
            'fourth_subjects' => '[]', 'fourth_note' => ''
        ],
        [
            'id' => 'deg-bsc', 'type' => 'degree', 'name' => 'BSc', 'full_name' => 'Bachelor of Science', 'bengali_name' => 'বিজ্ঞান বিভাগ',
            'icon' => 'fas fa-flask', 'accent_color' => '#059669', 'conductor' => 'National University of Bangladesh',
            'compulsory_subjects' => json_encode(['Bangla (বাংলা)', "History of Bangladesh's Liberation (বাংলাদেশের অভ্যুদয়ের ইতিহাস)", 'English']),
            'optional_subjects' => json_encode(['Botany (উদ্ভিদ বিজ্ঞান)', 'Zoology (প্রাণি বিজ্ঞান)', 'Chemistry (রসায়ন)']),
            'optional_note' => 'Choose optional subjects as per curriculum',
            'fourth_subjects' => '[]', 'fourth_note' => ''
        ],
        [
            'id' => 'deg-bmt', 'type' => 'degree', 'name' => 'BMT', 'full_name' => 'Business Management & Technology', 'bengali_name' => 'ব্যবসায় ব্যবস্থাপনা এবং টেকনোলজি',
            'icon' => 'fas fa-briefcase', 'accent_color' => '#d97706', 'conductor' => 'National University of Bangladesh',
            'compulsory_subjects' => json_encode(['Bangla (বাংলা)', 'English', 'Business Mathematics & Statistics (ব্যবসায়িক গণিত ও পরিসংখ্যান)', 'Marketing (মার্কেটিং)', 'Business Organization (ব্যবসায় সংগঠন)', 'Accounting (হিসাব বিজ্ঞান)', 'Economics (অর্থনীতি)', 'Computer Office Application (কম্পিউটার অফিস অ্যাপ্লিকেশন)', 'Digital Technology & Business-1 (ডিজিটাল টেকনোলজি এন্ড বিজনেস-১)']),
            'optional_subjects' => '[]',
            'optional_note' => 'All subjects are compulsory in this program',
            'fourth_subjects' => '[]', 'fourth_note' => ''
        ]
    ];

    $allData = array_merge($hscData, $degData);
    $stmt = $db->prepare("INSERT INTO academics_programs 
        (id, type, name, bengali_name, full_name, icon, accent_color, conductor, compulsory_subjects, optional_subjects, optional_note, fourth_subjects, fourth_note) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($allData as $d) {
        $stmt->execute([
            $d['id'], $d['type'], $d['name'], $d['bengali_name'], $d['full_name'], $d['icon'], $d['accent_color'], $d['conductor'],
            $d['compulsory_subjects'], $d['optional_subjects'], $d['optional_note'], $d['fourth_subjects'], $d['fourth_note']
        ]);
    }
}

function pmdc_academics_get_all($type = null) {
    pmdc_academics_init();
    $db = pmdc_academics_db();
    if (!$db) return [];

    $sql = "SELECT * FROM academics_programs";
    $params = [];
    if ($type) {
        $sql .= " WHERE type = ?";
        $params[] = $type;
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();
    
    // Decode JSON strings and re-map field names for frontend compatibility
    $formatted = [];
    foreach ($rows as $row) {
        $f = [
            'id' => $row['id'],
            'type' => $row['type'],
            'name' => $row['name'],
            'bengali' => $row['bengali_name'],
            'icon' => $row['icon'],
            'accent' => $row['accent_color'],
            'compulsory' => json_decode($row['compulsory_subjects'], true) ?: [],
            'optional' => json_decode($row['optional_subjects'], true) ?: [],
            'optional_note' => $row['optional_note']
        ];
        
        if ($row['type'] === 'hsc') {
            $f['fourth'] = json_decode($row['fourth_subjects'], true) ?: [];
            $f['fourth_note'] = $row['fourth_note'];
        } else {
            $f['full'] = $row['full_name'];
            $f['conductor'] = $row['conductor'];
        }
        $formatted[] = $f;
    }
    return $formatted;
}

function pmdc_academics_save($data) {
    pmdc_academics_init();
    $db = pmdc_academics_db();
    if (!$db) return false;

    $stmt = $db->prepare("INSERT INTO academics_programs 
        (id, type, name, bengali_name, full_name, icon, accent_color, conductor, compulsory_subjects, optional_subjects, optional_note, fourth_subjects, fourth_note) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
        name=VALUES(name), bengali_name=VALUES(bengali_name), full_name=VALUES(full_name), icon=VALUES(icon), 
        accent_color=VALUES(accent_color), conductor=VALUES(conductor), compulsory_subjects=VALUES(compulsory_subjects), 
        optional_subjects=VALUES(optional_subjects), optional_note=VALUES(optional_note), fourth_subjects=VALUES(fourth_subjects), fourth_note=VALUES(fourth_note)");

    return $stmt->execute([
        $data['id'],
        $data['type'],
        $data['name'],
        $data['bengali'],
        $data['full'] ?? '',
        $data['icon'] ?? 'fas fa-book',
        $data['accent'] ?? '#2563eb',
        $data['conductor'] ?? '',
        json_encode($data['compulsory'] ?? []),
        json_encode($data['optional'] ?? []),
        $data['optional_note'] ?? '',
        json_encode($data['fourth'] ?? []),
        $data['fourth_note'] ?? ''
    ]);
}

function pmdc_academics_delete($id, $type) {
    pmdc_academics_init();
    $db = pmdc_academics_db();
    if (!$db) return false;

    $stmt = $db->prepare("DELETE FROM academics_programs WHERE id = ? AND type = ?");
    return $stmt->execute([$id, $type]);
}
?>
