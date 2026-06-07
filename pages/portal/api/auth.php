<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../../includes/config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get JSON POST data
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';
    $portal   = $data['portal'] ?? ''; // 'teacher' or 'admin'
    
    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Username and password are required.']);
        exit;
    }
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password_hash'])) {
        // Verify role matches portal (optional, but good for security)
        if ($user['role'] !== $portal) {
            echo json_encode(['success' => false, 'message' => 'You do not have permission to access this portal.']);
            exit;
        }
        
        // Setup session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['name'] = $user['name'];
        
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error.']);
}
?>
