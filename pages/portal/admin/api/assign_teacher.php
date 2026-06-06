<?php
header('Content-Type: application/json');
require_once '../../../../includes/session_check.php';
require_once '../../../../includes/config.php';

// Ensure the caller is an admin
if ($_SESSION['role'] !== 'admin') {
    echo json_encode(['ok' => false, 'msg' => 'Unauthorized']);
    exit;
}

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $action = $_GET['action'] ?? '';

    if ($action === 'meta') {
        $programs = $pdo->query("SELECT id, name, full_name, type, compulsory_subjects, optional_subjects, fourth_subjects FROM academics_programs")->fetchAll(PDO::FETCH_ASSOC);
        
        $all_subjects = [];
        foreach ($programs as $p) {
            $compulsory = json_decode($p['compulsory_subjects'] ?? '[]', true) ?: [];
            $optional = json_decode($p['optional_subjects'] ?? '[]', true) ?: [];
            $fourth = json_decode($p['fourth_subjects'] ?? '[]', true) ?: [];
            $all_subjects = array_merge($all_subjects, $compulsory, $optional, $fourth);
        }
        $unique_subjects = array_values(array_unique($all_subjects));
        sort($unique_subjects);
        
        // Map subjects to {id: subject_name, name: subject_name} for the frontend
        $subjects_list = [];
        foreach ($unique_subjects as $s) {
            $subjects_list[] = ['id' => $s, 'name' => $s];
        }
        
        // Map programs to {id: id, name: full_name} for the frontend
        $classes_list = [];
        foreach ($programs as $p) {
            $classes_list[] = ['id' => $p['id'], 'name' => $p['full_name']];
        }
        
        echo json_encode(['ok' => true, 'classes' => $classes_list, 'subjects' => $subjects_list]);
        exit;
    }

    if ($action === 'list_all') {
        $stmt = $pdo->prepare("
            SELECT a.id, u.name as staff_name, u.username as staff_id, p.full_name as class_name, a.subject_name as subject_name 
            FROM teacher_assignments a
            JOIN users u ON a.user_id = u.id
            JOIN academics_programs p ON a.program_id = p.id
            ORDER BY u.name, p.full_name
        ");
        $stmt->execute();
        $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['ok' => true, 'assignments' => $assignments]);
        exit;
    }

    if ($action === 'list') {
        $staffId = $_GET['staff_id'] ?? '';
        
        // Find corresponding user
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$staffId]); // Using staffId as username for teachers
        $userId = $stmt->fetchColumn();
        
        if (!$userId) {
            echo json_encode(['ok' => true, 'assignments' => []]);
            exit;
        }

        $stmt = $pdo->prepare("
            SELECT a.id, p.full_name as class_name, a.subject_name as subject_name 
            FROM teacher_assignments a
            JOIN academics_programs p ON a.program_id = p.id
            WHERE a.user_id = ?
        ");
        $stmt->execute([$userId]);
        $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['ok' => true, 'assignments' => $assignments]);
        exit;
    }

    if ($action === 'add') {
        $data = json_decode(file_get_contents('php://input'), true);
        $staffId = $data['staff_id'] ?? '';
        $staffName = $data['staff_name'] ?? '';
        $classId = $data['class_id'] ?? '';
        $subjectId = $data['subject_id'] ?? ''; // This is actually the subject_name string now
        
        if (!$staffId || !$classId || !$subjectId) {
            echo json_encode(['ok' => false, 'msg' => 'Missing fields']);
            exit;
        }
        
        // Create user if doesn't exist
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$staffId]);
        $userId = $stmt->fetchColumn();
        
        $loginCreated = false;
        if (!$userId) {
            $pass = password_hash('password123', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, role, name) VALUES (?, ?, 'teacher', ?)");
            $stmt->execute([$staffId, $pass, $staffName]);
            $userId = $pdo->lastInsertId();
            $loginCreated = true;
        }
        
        // Insert assignment
        try {
            $stmt = $pdo->prepare("INSERT INTO teacher_assignments (user_id, program_id, subject_name) VALUES (?, ?, ?)");
            $stmt->execute([$userId, $classId, $subjectId]);
            echo json_encode(['ok' => true, 'msg' => 'Assignment added!', 'loginCreated' => $loginCreated]);
        } catch(PDOException $e) {
            echo json_encode(['ok' => false, 'msg' => 'Assignment already exists']);
        }
        exit;
    }
    
    if ($action === 'delete') {
        $id = $_GET['id'] ?? '';
        $stmt = $pdo->prepare("DELETE FROM teacher_assignments WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['ok' => true]);
        exit;
    }

} catch (PDOException $e) {
    echo json_encode(['ok' => false, 'msg' => 'Database error: ' . $e->getMessage()]);
}
