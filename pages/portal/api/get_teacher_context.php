<?php
header('Content-Type: application/json');
require_once '../../../includes/session_check.php';
require_once '../../../includes/config.php';

if ($_SESSION['role'] !== 'teacher') {
    echo json_encode(['ok' => false, 'msg' => 'Unauthorized']);
    exit;
}

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("
        SELECT c.id as class_id, c.name as class_name, s.id as subject_id, s.name as subject_name 
        FROM teacher_assignments a
        JOIN classes c ON a.class_id = c.id
        JOIN subjects s ON a.subject_id = s.id
        WHERE a.user_id = ?
    ");
    $stmt->execute([$userId]);
    $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Group by class to build the class list
    $classes = [];
    foreach ($assignments as $a) {
        $classes[$a['class_id']] = ['id' => $a['class_id'], 'name' => $a['class_name']];
    }
    
    echo json_encode([
        'ok' => true,
        'teacher_name' => $_SESSION['name'],
        'assignments' => $assignments,
        'classes' => array_values($classes)
    ]);
} catch (PDOException $e) {
    echo json_encode(['ok' => false, 'msg' => 'Database error']);
}
?>
