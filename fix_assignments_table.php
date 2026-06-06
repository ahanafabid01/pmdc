<?php
require_once 'includes/config.php';
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Drop old table
    $pdo->exec("DROP TABLE IF EXISTS teacher_assignments");
    
    // Recreate with program_id and subject_name
    $pdo->exec("
        CREATE TABLE teacher_assignments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            program_id VARCHAR(50) NOT NULL,
            subject_name VARCHAR(255) NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (program_id) REFERENCES academics_programs(id) ON DELETE CASCADE,
            UNIQUE KEY unique_assignment (user_id, program_id, subject_name)
        )
    ");
    echo "Successfully recreated teacher_assignments table.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
