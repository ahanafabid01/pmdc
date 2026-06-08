<?php
require 'includes/config.php';
$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
$stmt = $pdo->query('SHOW TABLES');
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
echo "Tables:\n";
print_r($tables);

foreach(['students', 'programs', 'academic_groups', 'classes'] as $tbl) {
    if(in_array($tbl, $tables)) {
        echo "\nSchema for $tbl:\n";
        $stmt = $pdo->query("DESCRIBE $tbl");
        print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}
