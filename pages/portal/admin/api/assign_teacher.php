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
        // Return classes and subjects
        $classes = $pdo->query("SELECT * FROM classes")->fetchAll(PDO::FETCH_ASSOC);
        $subjects = $pdo->query("SELECT * FROM subjects")->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['ok' => true, 'classes' => $classes, 'subjects' => $subjects]);
        exit;
    }

    if ($action === 'list_all') {
        $stmt = $pdo->prepare("
            SELECT a.id, u.name as staff_name, u.username as staff_id, c.name as class_name, s.name as subject_name 
            FROM teacher_assignments a
            JOIN users u ON a.user_id = u.id
            JOIN classes c ON a.class_id = c.id
            JOIN subjects s ON a.subject_id = s.id
            ORDER BY u.name, c.name
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
            SELECT a.id, c.name as class_name, s.name as subject_name 
            FROM teacher_assignments a
            JOIN classes c ON a.class_id = c.id
            JOIN subjects s ON a.subject_id = s.id
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
        $subjectId = $data['subject_id'] ?? '';
        
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
            $stmt = $pdo->prepare("INSERT INTO teacher_assignments (user_id, class_id, subject_id) VALUES (?, ?, ?)");
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
    echo json_encode(['ok' => false, 'msg' => 'Database error']);
}
