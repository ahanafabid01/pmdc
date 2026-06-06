<?php
/**
 * api/attendance.php
 * Handles saving, fetching and editing attendance records in the DB.
 */
header('Content-Type: application/json');
require_once '../../../includes/session_check.php';
require_once '../../../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    echo json_encode(['ok' => false, 'msg' => 'Unauthorized']);
    exit;
}

$userId = (int) $_SESSION['user_id'];
$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );

    /* ── SAVE / UPDATE ─────────────────────────────────────── */
    if ($action === 'save') {
        $body = json_decode(file_get_contents('php://input'), true);
        $programId = $body['program_id'] ?? '';
        $group     = $body['group']      ?? '';
        $year      = $body['year']       ?? '';
        $section   = $body['section']    ?? '';
        $period    = (int)($body['period'] ?? 1);
        $date      = $body['date']       ?? date('Y-m-d');
        $statuses  = $body['statuses']   ?? []; // [{student_id, status}]

        if (!$programId || !$group || !$year || !$section || !$period || !$date) {
            echo json_encode(['ok' => false, 'msg' => 'Missing required fields']);
            exit;
        }

        // Upsert the record
        $stmt = $pdo->prepare("
            INSERT INTO attendance_records 
                (teacher_user_id, program_id, academic_group, year, section, period, att_date)
            VALUES (?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE updated_at = NOW()
        ");
        $stmt->execute([$userId, $programId, $group, $year, $section, $period, $date]);
        
        // Get the record id
        $recordId = $pdo->lastInsertId();
        if (!$recordId) {
            $r = $pdo->prepare("SELECT id FROM attendance_records WHERE teacher_user_id=? AND program_id=? AND year=? AND section=? AND period=? AND att_date=?");
            $r->execute([$userId, $programId, $year, $section, $period, $date]);
            $row = $r->fetch();
            $recordId = $row['id'] ?? null;
        }

        if (!$recordId) {
            echo json_encode(['ok' => false, 'msg' => 'Could not resolve record id']);
            exit;
        }

        // Delete old statuses then re-insert
        $pdo->prepare("DELETE FROM attendance_statuses WHERE record_id = ?")->execute([$recordId]);
        $ins = $pdo->prepare("INSERT INTO attendance_statuses (record_id, student_id, status) VALUES (?, ?, ?)");
        foreach ($statuses as $s) {
            $ins->execute([$recordId, $s['student_id'], $s['status'] === 'absent' ? 'absent' : 'present']);
        }

        echo json_encode(['ok' => true, 'record_id' => $recordId]);
        exit;
    }

    /* ── FETCH RECORDS (for history/report) ───────────────── */
    if ($action === 'list') {
        $date    = $_GET['date']    ?? date('Y-m-d');
        $year    = $_GET['year']    ?? '';
        $group   = $_GET['group']   ?? '';
        $section = $_GET['section'] ?? '';

        $params = [$userId];
        $where  = ['ar.teacher_user_id = ?'];

        if ($date)    { $where[] = 'ar.att_date = ?';         $params[] = $date; }
        if ($year)    { $where[] = 'ar.year = ?';             $params[] = $year; }
        if ($group)   { $where[] = 'ar.academic_group = ?';   $params[] = $group; }
        if ($section) { $where[] = 'ar.section = ?';          $params[] = $section; }

        $sql = "SELECT ar.*, u.name as teacher_name
                FROM attendance_records ar
                JOIN users u ON ar.teacher_user_id = u.id
                WHERE " . implode(' AND ', $where) . "
                ORDER BY ar.period ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $records = $stmt->fetchAll();

        // Attach statuses
        foreach ($records as &$rec) {
            $s = $pdo->prepare("SELECT student_id, status FROM attendance_statuses WHERE record_id = ?");
            $s->execute([$rec['id']]);
            $rec['statuses'] = $s->fetchAll();
        }

        echo json_encode(['ok' => true, 'records' => $records]);
        exit;
    }

    /* ── FETCH REPORT ─────────────────────────────────────── */
    if ($action === 'report') {
        $year    = $_GET['year']    ?? '';
        $group   = $_GET['group']   ?? '';
        $section = $_GET['section'] ?? '';
        $from    = $_GET['from']    ?? date('Y-m-01');
        $to      = $_GET['to']      ?? date('Y-m-d');

        // Get all records in range for this teacher/class
        $stmt = $pdo->prepare("
            SELECT ar.id, ar.period, ar.att_date
            FROM attendance_records ar
            WHERE ar.teacher_user_id = ? AND ar.year = ? AND ar.academic_group = ?
              AND ar.section = ? AND ar.att_date BETWEEN ? AND ?
            ORDER BY ar.att_date, ar.period
        ");
        $stmt->execute([$userId, $year, $group, $section, $from, $to]);
        $records = $stmt->fetchAll();

        $totalClasses = count($records);

        if (!$totalClasses) {
            echo json_encode(['ok' => true, 'rows' => [], 'total_classes' => 0]);
            exit;
        }

        // Get all students in this class
        $stuStmt = $pdo->prepare("
            SELECT id, name, roll FROM students WHERE LOWER(academic_group) = LOWER(?) AND year = ? AND UPPER(section) = UPPER(?) ORDER BY roll
        ");
        $stuStmt->execute([$group, $year, $section]);
        $students = $stuStmt->fetchAll();

        // Aggregate attendance per student
        $recordIds = array_column($records, 'id');
        $placeholders = implode(',', array_fill(0, count($recordIds), '?'));
        $statStmt = $pdo->prepare("
            SELECT student_id, status FROM attendance_statuses WHERE record_id IN ($placeholders)
        ");
        $statStmt->execute($recordIds);
        $allStatuses = $statStmt->fetchAll();

        $presentMap = [];
        foreach ($allStatuses as $st) {
            if (!isset($presentMap[$st['student_id']])) $presentMap[$st['student_id']] = 0;
            if ($st['status'] === 'present') $presentMap[$st['student_id']]++;
        }

        $rows = [];
        foreach ($students as $s) {
            $present = $presentMap[$s['id']] ?? 0;
            $absent  = $totalClasses - $present;
            $pct     = $totalClasses > 0 ? round(($present / $totalClasses) * 100, 2) : 0;
            $rows[]  = [
                'student_id'    => $s['id'],
                'name'          => $s['name'],
                'roll'          => $s['roll'],
                'total_classes' => $totalClasses,
                'present'       => $present,
                'absent'        => $absent,
                'percent'       => $pct,
            ];
        }

        echo json_encode(['ok' => true, 'rows' => $rows, 'total_classes' => $totalClasses]);
        exit;
    }

    echo json_encode(['ok' => false, 'msg' => 'Unknown action']);

} catch (PDOException $e) {
    echo json_encode(['ok' => false, 'msg' => 'DB error: ' . $e->getMessage()]);
}
?>
