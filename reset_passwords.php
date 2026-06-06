<?php
require_once 'includes/config.php';
$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);

// Reset admin password to: admin123
$adminHash = password_hash('admin123', PASSWORD_DEFAULT);
$pdo->prepare("UPDATE users SET password_hash=? WHERE username='admin'")->execute([$adminHash]);

// Reset teacher password to: teacher123
$teacherHash = password_hash('teacher123', PASSWORD_DEFAULT);
$pdo->prepare("UPDATE users SET password_hash=? WHERE username='teacher'")->execute([$teacherHash]);

// Also update T0001, T0002 to password123
$tHash = password_hash('password123', PASSWORD_DEFAULT);
$pdo->prepare("UPDATE users SET password_hash=? WHERE username IN ('T0001','T0002','1')")->execute([$tHash]);

echo "Done!\n";
echo "Admin login: username=admin, password=admin123\n";
echo "Teacher (generic) login: username=teacher, password=teacher123\n";
echo "Teacher T0001 login: username=T0001, password=password123\n";
echo "Teacher T0002 login: username=T0002, password=password123\n";
