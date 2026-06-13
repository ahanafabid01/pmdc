<?php
require_once __DIR__ . '/../../../includes/students-data.php';
require_once __DIR__ . '/../../../includes/config.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

// ── Special GET action: return academic programs from DB ──────────────────
if ($method === 'GET' && ($_GET['action'] ?? '') === 'programs') {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER, DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        $rows = $pdo->query("SELECT id, name, type, optional_subjects, fourth_subjects, optional_note FROM academics_programs ORDER BY type, name")->fetchAll(PDO::FETCH_ASSOC);
        $programs = [];
        foreach ($rows as $r) {
            $programs[] = [
                'id'               => $r['id'],
                'name'             => $r['name'],
                'type'             => $r['type'],
                'optionalNote'     => $r['optional_note'],
                'optionalSubjects' => json_decode($r['optional_subjects'] ?? '[]', true) ?: [],
                'fourthSubjects'   => json_decode($r['fourth_subjects']   ?? '[]', true) ?: [],
            ];
        }
        echo json_encode(['success' => true, 'programs' => $programs]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// ── Map DB row → JS camelCase ─────────────────────────────────────────────
function mapRowToJs($row) {
    return [
        'id'              => $row['id'],
        'name'            => $row['name'],
        'initials'        => $row['initials'],
        'roll'            => $row['roll'],
        'regno'           => $row['regno'],
        'year'            => $row['year'],
        'group'           => $row['academic_group'],
        'programType'     => $row['program_type']     ?? 'hsc',
        'programId'       => $row['program_id']       ?? '',
        'optionalSubject' => $row['optional_subject'] ?? '',
        'fourthSubject'   => $row['fourth_subject']   ?? '',
        'section'         => $row['section'],
        'session'         => $row['session'],
        'institution'     => $row['institution'],

        'dob'             => $row['dob'],
        'gender'          => $row['gender'],
        'religion'        => $row['religion'],
        'bloodGroup'      => $row['blood_group'],
        'nid'             => $row['nid'],
        'birthCert'       => $row['birth_cert'],

        'phone'           => $row['phone'],
        'email'           => $row['email'],
        'presentAddr'     => $row['present_addr'],
        'permanentAddr'   => $row['permanent_addr'],

        'fatherName'      => $row['father_name'],
        'fatherNid'       => $row['father_nid'],
        'fatherPhone'     => $row['father_phone'],
        'fatherOcc'       => $row['father_occ'],

        'motherName'      => $row['mother_name'],
        'motherNid'       => $row['mother_nid'],
        'motherPhone'     => $row['mother_phone'],
        'motherOcc'       => $row['mother_occ'],

        'guardianName'    => $row['guardian_name'],
        'guardianPhone'   => $row['guardian_phone'],
        'guardianRel'     => $row['guardian_rel'],

        'photoUrl'        => $row['photo_url'],
        'color'           => $row['color'],
        'addedDate'       => $row['added_date'],
    ];
}

// ── Map JS camelCase → DB columns ─────────────────────────────────────────
function mapJsToDb($js) {
    return [
        'id'               => $js['id']             ?? '',
        'name'             => $js['name']           ?? '',
        'initials'         => $js['initials']       ?? '',
        'roll'             => $js['roll']           ?? '',
        'regno'            => $js['regno']          ?? '',
        'year'             => $js['year']           ?? '',
        'academic_group'   => $js['group']          ?? '',
        'program_type'     => $js['programType']    ?? 'hsc',
        'program_id'       => $js['programId']      ?? '',
        'optional_subject' => $js['optionalSubject'] ?? '',
        'fourth_subject'   => $js['fourthSubject']  ?? '',
        'section'          => $js['section']        ?? '',
        'session'          => $js['session']        ?? '',
        'institution'      => $js['institution']    ?? '',

        'dob'              => $js['dob']            ?? null,
        'gender'           => $js['gender']         ?? '',
        'religion'         => $js['religion']       ?? '',
        'blood_group'      => $js['bloodGroup']     ?? '',
        'nid'              => $js['nid']            ?? '',
        'birth_cert'       => $js['birthCert']      ?? '',

        'phone'            => $js['phone']          ?? '',
        'email'            => $js['email']          ?? '',
        'present_addr'     => $js['presentAddr']    ?? '',
        'permanent_addr'   => $js['permanentAddr']  ?? '',

        'father_name'      => $js['fatherName']     ?? '',
        'father_nid'       => $js['fatherNid']      ?? '',
        'father_phone'     => $js['fatherPhone']    ?? '',
        'father_occ'       => $js['fatherOcc']      ?? '',

        'mother_name'      => $js['motherName']     ?? '',
        'mother_nid'       => $js['motherNid']      ?? '',
        'mother_phone'     => $js['motherPhone']    ?? '',
        'mother_occ'       => $js['motherOcc']      ?? '',

        'guardian_name'    => $js['guardianName']   ?? '',
        'guardian_phone'   => $js['guardianPhone']  ?? '',
        'guardian_rel'     => $js['guardianRel']    ?? '',

        'photo_url'        => $js['photoUrl']       ?? null,
        'color'            => $js['color']          ?? '',
        'added_date'       => $js['addedDate']      ?? null,
    ];
}

// ── CRUD ──────────────────────────────────────────────────────────────────
if ($method === 'GET') {
    $rows     = pmdc_get_all_students();
    $students = array_map('mapRowToJs', $rows);
    echo json_encode(['success' => true, 'data' => $students]);
    exit;
}

if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) { echo json_encode(['success' => false, 'error' => 'Invalid data']); exit; }
    if (pmdc_add_student(mapJsToDb($input))) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to add student to DB']);
    }
    exit;
}

if ($method === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input || empty($input['id'])) { echo json_encode(['success' => false, 'error' => 'Invalid data or missing ID']); exit; }
    if (pmdc_update_student($input['id'], mapJsToDb($input))) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update student in DB']);
    }
    exit;
}

if ($method === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input || empty($input['id'])) { echo json_encode(['success' => false, 'error' => 'Missing ID']); exit; }
    if (pmdc_delete_student($input['id'])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete student']);
    }
    exit;
}

echo json_encode(['success' => false, 'error' => 'Method not allowed']);
