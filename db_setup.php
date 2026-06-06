<?php
require_once 'includes/config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully to " . DB_NAME . "\n";

    // 1. Users Table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            role ENUM('admin', 'teacher') NOT NULL,
            name VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "Created users table.\n";

    // 2. Classes Table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS classes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            year VARCHAR(20) NOT NULL,
            program VARCHAR(50) NOT NULL
        )
    ");
    echo "Created classes table.\n";

    // 3. Subjects Table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS subjects (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            code VARCHAR(20) NOT NULL
        )
    ");
    echo "Created subjects table.\n";

    // 4. Teacher Assignments Table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS teacher_assignments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            class_id INT NOT NULL,
            subject_id INT NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
            FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
            UNIQUE KEY unique_assignment (user_id, class_id, subject_id)
        )
    ");
    echo "Created teacher_assignments table.\n";

    // Insert mock data if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    if ($stmt->fetchColumn() == 0) {
        $adminPass = password_hash('pmdc@admin', PASSWORD_DEFAULT);
        $teacherPass = password_hash('pmdc2024', PASSWORD_DEFAULT);
        
        $pdo->exec("INSERT INTO users (username, password_hash, role, name) VALUES 
            ('admin', '$adminPass', 'admin', 'System Administrator'),
            ('teacher', '$teacherPass', 'teacher', 'Jane Doe')
        ");
        echo "Inserted mock users.\n";
    }

    $stmt = $pdo->query("SELECT COUNT(*) FROM classes");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO classes (name, year, program) VALUES 
            ('HSC 1st Year - Science', 'xi', 'science'),
            ('HSC 1st Year - Business', 'xi', 'commerce'),
            ('HSC 1st Year - Humanities', 'xi', 'humanities'),
            ('HSC 2nd Year - Science', 'xii', 'science'),
            ('HSC 2nd Year - Business', 'xii', 'commerce'),
            ('HSC 2nd Year - Humanities', 'xii', 'humanities')
        ");
        echo "Inserted mock classes.\n";
    }

    $stmt = $pdo->query("SELECT COUNT(*) FROM subjects");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO subjects (name, code) VALUES 
            ('Bangla I', '101'),
            ('Bangla II', '102'),
            ('English I', '107'),
            ('English II', '108'),
            ('Physics I', '174'),
            ('Chemistry I', '176'),
            ('Accounting I', '253'),
            ('History I', '109')
        ");
        echo "Inserted mock subjects.\n";
    }

} catch (PDOException $e) {
    die("DB Setup Failed: " . $e->getMessage());
}
?>
