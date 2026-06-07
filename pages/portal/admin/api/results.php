<?php
header('Content-Type: application/json');
require_once '../../../../includes/session_check.php';
require_once '../../../../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['ok' => false, 'msg' => 'Unauthorized']);
    exit;
}

$action = $_GET['action'] ?? '';

try {
    if ($action === 'overview') {
        // Get all active exams
        $stmt = $pdo->query("SELECT id, name, year FROM exams WHERE status = 'active' ORDER BY id DESC");
        $exams = $stmt->fetchAll();

        // Get all programs
        $stmt = $pdo->query("SELECT id, name, type FROM academics_programs ORDER BY type, name");
        $programs = $stmt->fetchAll();

        echo json_encode(['ok' => true, 'exams' => $exams, 'programs' => $programs]);
    } 
    elseif ($action === 'progress') {
        $exam_id = (int)($_GET['exam_id'] ?? 0);
        $program_id = $_GET['program_id'] ?? '';

        if (!$exam_id || !$program_id) {
            echo json_encode(['ok' => false, 'msg' => 'Missing exam or program.']);
            exit;
        }

        // 1. Get all assigned subjects for this program
        $stmt = $pdo->prepare("
            SELECT DISTINCT ta.subject_name, u.name as teacher_name
            FROM teacher_assignments ta
            JOIN users u ON ta.user_id = u.id
            WHERE ta.program_id = ?
            ORDER BY ta.subject_name
        ");
        $stmt->execute([$program_id]);
        $assignments = $stmt->fetchAll();

        // 2. For each subject, check if there are published marks in exam_marks
        $progress = [];
        $total = count($assignments);
        $published = 0;

        foreach ($assignments as $a) {
            $stmt = $pdo->prepare("
                SELECT is_published 
                FROM exam_marks 
                WHERE exam_id = ? AND program_id = ? AND subject_name = ? 
                LIMIT 1
            ");
            $stmt->execute([$exam_id, $program_id, $a['subject_name']]);
            $is_published = $stmt->fetchColumn();

            $status = ($is_published === false) ? 'Pending' : ($is_published == 1 ? 'Published' : 'Draft');
            if ($status === 'Published') $published++;

            $progress[] = [
                'subject' => $a['subject_name'],
                'teacher' => $a['teacher_name'],
                'status'  => $status
            ];
        }

        // 3. Check if released
        $stmt = $pdo->prepare("SELECT is_released FROM exam_releases WHERE exam_id = ? AND program_id = ?");
        $stmt->execute([$exam_id, $program_id]);
        $is_released = $stmt->fetchColumn() ? true : false;

        echo json_encode([
            'ok' => true, 
            'progress' => $progress, 
            'total' => $total, 
            'published' => $published,
            'is_released' => $is_released
        ]);
    } 
    elseif ($action === 'release') {
        $input = json_decode(file_get_contents('php://input'), true);
        $exam_id = (int)($input['exam_id'] ?? 0);
        $program_id = $input['program_id'] ?? '';
        $release = $input['release'] ?? true; // true = release, false = unrelease

        if (!$exam_id || !$program_id) {
            echo json_encode(['ok' => false, 'msg' => 'Missing parameters.']);
            exit;
        }

        if ($release) {
            $stmt = $pdo->prepare("
                INSERT INTO exam_releases (exam_id, program_id, is_released, released_at) 
                VALUES (?, ?, 1, NOW())
                ON DUPLICATE KEY UPDATE is_released = 1, released_at = NOW()
            ");
            $stmt->execute([$exam_id, $program_id]);
            $msg = 'Results successfully released to the public portal!';
        } else {
            $stmt = $pdo->prepare("
                UPDATE exam_releases SET is_released = 0 WHERE exam_id = ? AND program_id = ?
            ");
            $stmt->execute([$exam_id, $program_id]);
            $msg = 'Results revoked from public view.';
        }

        echo json_encode(['ok' => true, 'msg' => $msg]);
    } else {
        echo json_encode(['ok' => false, 'msg' => 'Unknown action']);
    }
} catch (Exception $e) {
    echo json_encode(['ok' => false, 'msg' => 'Database error: ' . $e->getMessage()]);
}
