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
        compulsory_codes TEXT,
        optional_subjects TEXT,
        optional_note VARCHAR(255) DEFAULT '',
        fourth_subjects TEXT,
        fourth_note VARCHAR(255) DEFAULT '',
        subject_codes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    // Add columns if upgrading from older schema
    try { $db->exec("ALTER TABLE academics_programs ADD COLUMN IF NOT EXISTS subject_codes TEXT DEFAULT NULL"); } catch(Exception $e){}
    try { $db->exec("ALTER TABLE academics_programs ADD COLUMN IF NOT EXISTS compulsory_codes TEXT DEFAULT NULL"); } catch(Exception $e){}

    // Seed data if empty
    $stmt = $db->query("SELECT COUNT(*) FROM academics_programs");
    if ($stmt->fetchColumn() == 0) {
        pmdc_academics_seed($db);
    }
    return true;
}

function pmdc_academics_seed($db) {
    $sciCodes = json_encode(['Bangla'=>['1st'=>101,'2nd'=>102],'English'=>['1st'=>107,'2nd'=>108],'ICT'=>['only'=>275],'Physics'=>['1st'=>174,'2nd'=>175],'Chemistry'=>['1st'=>176,'2nd'=>177],'Biology'=>['1st'=>178,'2nd'=>179],'Higher Mathematics'=>['1st'=>265,'2nd'=>266]]);
    $bisCodes = json_encode(['Bangla'=>['1st'=>101,'2nd'=>102],'English'=>['1st'=>107,'2nd'=>108],'ICT'=>['only'=>275],'Accounting'=>['1st'=>253,'2nd'=>254],'Business Policy & Practice'=>['1st'=>286,'2nd'=>287],'Marketing'=>['1st'=>277,'2nd'=>278],'Economics'=>['1st'=>109,'2nd'=>110],'Geography'=>['1st'=>125,'2nd'=>126]]);
    $humCodes = json_encode(['Bangla'=>['1st'=>101,'2nd'=>102],'English'=>['1st'=>107,'2nd'=>108],'ICT'=>['only'=>275],'Civics & Good Governance'=>['1st'=>269,'2nd'=>270],'Economics'=>['1st'=>109,'2nd'=>110],'Logic'=>['1st'=>121,'2nd'=>122],'Social Work'=>['1st'=>271,'2nd'=>272],'History'=>['1st'=>304,'2nd'=>305],'Geography'=>['1st'=>125,'2nd'=>126],'Civics'=>['1st'=>269,'2nd'=>270],'Islamic Studies'=>['1st'=>267,'2nd'=>268]]);
    $compCodes = json_encode(['Bangla'=>['1st'=>101,'2nd'=>102],'English'=>['1st'=>107,'2nd'=>108],'ICT'=>['only'=>275]]);

    // Seed HSC Data
    $hscData = [
        [
            'id' => 'hsc-science', 'type' => 'hsc', 'name' => 'Science', 'bengali_name' => 'বিজ্ঞান শাখা',
            'icon' => 'fas fa-flask', 'accent_color' => '#2563eb',
            'compulsory_subjects' => json_encode(['Bangla (বাংলা)', 'English', 'ICT (তথ্য ও যোগাযোগ প্রযুক্তি)'], JSON_UNESCAPED_UNICODE),
            'compulsory_codes' => $compCodes,
            'optional_subjects' => json_encode(['Physics (পদার্থ বিজ্ঞান)', 'Chemistry (রসায়ন)', 'Biology (জীব বিজ্ঞান)', 'Higher Mathematics (উচ্চতর গণিত)'], JSON_UNESCAPED_UNICODE),
            'optional_note' => 'Choose any 3',
            'fourth_subjects' => json_encode(['Higher Mathematics (উচ্চতর গণিত)', 'Biology (জীব বিজ্ঞান)'], JSON_UNESCAPED_UNICODE),
            'fourth_note' => 'Choose any 1 (optional)',
            'subject_codes' => $sciCodes,
            'full_name' => '', 'conductor' => ''
        ],
        [
            'id' => 'hsc-humanities', 'type' => 'hsc', 'name' => 'Humanities', 'bengali_name' => 'মানবিক শাখা',
            'icon' => 'fas fa-landmark', 'accent_color' => '#7c3aed',
            'compulsory_subjects' => json_encode(['Bangla (বাংলা)', 'English', 'ICT (তথ্য ও যোগাযোগ প্রযুক্তি)'], JSON_UNESCAPED_UNICODE),
            'compulsory_codes' => $compCodes,
            'optional_subjects' => json_encode(['Civics & Good Governance (পৌরনীতি ও সুশাসন)', 'Economics (অর্থনীতি)', 'Logic (যুক্তিবিদ্যা)', 'Social Work (সমাজকর্ম)', 'History (ইতিহাস)', 'Geography (ভূগোল)'], JSON_UNESCAPED_UNICODE),
            'optional_note' => 'Choose any 3',
            'fourth_subjects' => json_encode(['Civics (পৌরনীতি)', 'Economics (অর্থনীতি)', 'Logic (যুক্তিবিদ্যা)', 'Social Work (সমাজকর্ম)', 'History (ইতিহাস)', 'Islamic Studies (ইসলাম শিক্ষা)'], JSON_UNESCAPED_UNICODE),
            'fourth_note' => 'Choose any 1 (optional)',
            'subject_codes' => $humCodes,
            'full_name' => '', 'conductor' => ''
        ],
        [
            'id' => 'hsc-business', 'type' => 'hsc', 'name' => 'Business Studies', 'bengali_name' => 'ব্যবসায় শিক্ষা শাখা',
            'icon' => 'fas fa-chart-line', 'accent_color' => '#059669',
            'compulsory_subjects' => json_encode(['Bangla (বাংলা)', 'English', 'ICT (তথ্য ও যোগাযোগ প্রযুক্তি)'], JSON_UNESCAPED_UNICODE),
            'compulsory_codes' => $compCodes,
            'optional_subjects' => json_encode(['Accounting (হিসাব বিজ্ঞান)', 'Business Policy & Practice (ব্যবসায়নীতি ও প্রয়োগ)', 'Marketing (মার্কেটিং)'], JSON_UNESCAPED_UNICODE),
            'optional_note' => 'Choose any 3',
            'fourth_subjects' => json_encode(['Economics (অর্থনীতি)', 'Geography (ভূগোল)'], JSON_UNESCAPED_UNICODE),
            'fourth_note' => 'Choose any 1 (optional)',
            'subject_codes' => $bisCodes,
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
        (id, type, name, bengali_name, full_name, icon, accent_color, conductor, compulsory_subjects, compulsory_codes, optional_subjects, optional_note, fourth_subjects, fourth_note, subject_codes) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($allData as $d) {
        $stmt->execute([
            $d['id'], $d['type'], $d['name'], $d['bengali_name'], $d['full_name'], $d['icon'], $d['accent_color'], $d['conductor'],
            $d['compulsory_subjects'], $d['compulsory_codes'] ?? null, $d['optional_subjects'], $d['optional_note'], $d['fourth_subjects'], $d['fourth_note'],
            $d['subject_codes'] ?? null
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
            'id'              => $row['id'],
            'type'            => $row['type'],
            'name'            => $row['name'],
            'bengali'         => $row['bengali_name'],
            'icon'            => $row['icon'],
            'accent'          => $row['accent_color'],
            'compulsory'      => json_decode($row['compulsory_subjects'], true) ?: [],
            'compulsory_codes'=> json_decode($row['compulsory_codes'] ?? '{}', true) ?: [],
            'optional'        => json_decode($row['optional_subjects'], true) ?: [],
            'optional_note'   => $row['optional_note'],
            'subject_codes'   => json_decode($row['subject_codes'] ?? '{}', true) ?: [],
        ];
        
        if ($row['type'] === 'hsc') {
            $f['fourth']      = json_decode($row['fourth_subjects'], true) ?: [];
            $f['fourth_note'] = $row['fourth_note'];
        } else {
            $f['full']        = $row['full_name'];
            $f['conductor']   = $row['conductor'];
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
        (id, type, name, bengali_name, full_name, icon, accent_color, conductor, compulsory_subjects, compulsory_codes, optional_subjects, optional_note, fourth_subjects, fourth_note, subject_codes) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
        name=VALUES(name), bengali_name=VALUES(bengali_name), full_name=VALUES(full_name), icon=VALUES(icon), 
        accent_color=VALUES(accent_color), conductor=VALUES(conductor), compulsory_subjects=VALUES(compulsory_subjects),
        compulsory_codes=VALUES(compulsory_codes), optional_subjects=VALUES(optional_subjects),
        optional_note=VALUES(optional_note), fourth_subjects=VALUES(fourth_subjects), fourth_note=VALUES(fourth_note),
        subject_codes=VALUES(subject_codes)");

    return $stmt->execute([
        $data['id'],
        $data['type'],
        $data['name'],
        $data['bengali'],
        $data['full'] ?? '',
        $data['icon'] ?? 'fas fa-book',
        $data['accent'] ?? '#2563eb',
        $data['conductor'] ?? '',
        json_encode($data['compulsory'] ?? [], JSON_UNESCAPED_UNICODE),
        json_encode($data['compulsory_codes'] ?? [], JSON_UNESCAPED_UNICODE),
        json_encode($data['optional'] ?? [], JSON_UNESCAPED_UNICODE),
        $data['optional_note'] ?? '',
        json_encode($data['fourth'] ?? [], JSON_UNESCAPED_UNICODE),
        $data['fourth_note'] ?? '',
        json_encode($data['subject_codes'] ?? [], JSON_UNESCAPED_UNICODE),
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
