<?php
header('Content-Type: application/json');
require_once '../../../../includes/session_check.php';
require_once '../../../../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    echo json_encode(['ok' => false, 'msg' => 'Unauthorized']);
    exit;
}

$action = $_GET['action'] ?? '';
$teacher_id = (int)$_SESSION['user_id'];

try {
    if ($action === 'list') {
        $exam_id = (int)($_GET['exam_id'] ?? 0);
        $program_id = $_GET['program_id'] ?? '';
        $subject_name = $_GET['subject_name'] ?? '';

        if (!$exam_id || !$program_id || !$subject_name) {
            echo json_encode(['ok' => false, 'msg' => 'Missing parameters.']);
            exit;
        }

        $stmt = $pdo->prepare("
            SELECT student_id, mark, is_published
            FROM exam_marks
            WHERE exam_id = ? AND program_id = ? AND subject_name = ? AND teacher_id = ?
        ");
        $stmt->execute([$exam_id, $program_id, $subject_name, $teacher_id]);
        $records = $stmt->fetchAll();
        
        $is_published = !empty($records) ? (bool)$records[0]['is_published'] : false;

        echo json_encode(['ok' => true, 'records' => $records, 'is_published' => $is_published]);
    } 
    elseif ($action === 'save' || $action === 'publish') {
        $input = json_decode(file_get_contents('php://input'), true);
        
        $exam_id = (int)($input['exam_id'] ?? 0);
        $program_id = $input['program_id'] ?? '';
        $subject_name = $input['subject_name'] ?? '';
        $marks = $input['marks'] ?? [];
        
        if (!$exam_id || !$program_id || !$subject_name || empty($marks)) {
            echo json_encode(['ok' => false, 'msg' => 'Invalid payload.']);
            exit;
        }

        // Verify that the teacher hasn't already published
        $stmt = $pdo->prepare("SELECT is_published FROM exam_marks WHERE exam_id = ? AND program_id = ? AND subject_name = ? AND teacher_id = ? LIMIT 1");
        $stmt->execute([$exam_id, $program_id, $subject_name, $teacher_id]);
        $existing = $stmt->fetchColumn();

        if ($existing == 1) {
            echo json_encode(['ok' => false, 'msg' => 'Marks are already published and locked.']);
            exit;
        }

        $is_published = ($action === 'publish') ? 1 : 0;

        $pdo->beginTransaction();
        
        $insertStmt = $pdo->prepare("
            INSERT INTO exam_marks (exam_id, student_id, program_id, subject_name, teacher_id, mark, is_published)
            VALUES (?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE mark = VALUES(mark), is_published = VALUES(is_published)
        ");

        foreach ($marks as $m) {
            // mark can be numeric or null if empty
            $markValue = ($m['mark'] === '' || $m['mark'] === null) ? null : (float)$m['mark'];
            $insertStmt->execute([
                $exam_id,
                (int)$m['student_id'],
                $program_id,
                $subject_name,
                $teacher_id,
                $markValue,
                $is_published
            ]);
        }
        
        $pdo->commit();
        echo json_encode(['ok' => true, 'msg' => 'Successfully saved!']);
    } else {
        echo json_encode(['ok' => false, 'msg' => 'Unknown action']);
    }
} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode(['ok' => false, 'msg' => 'Database error: ' . $e->getMessage()]);
}
