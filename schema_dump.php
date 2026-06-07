<?php
require_once 'includes/config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$tables = [];
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_row()) {
    $table = $row[0];
    $tables[$table] = [];
    $cols = $conn->query("DESCRIBE `$table`");
    while ($col = $cols->fetch_assoc()) {
        $tables[$table][] = $col['Field'] . " (" . $col['Type'] . ")";
    }
}
echo json_encode($tables, JSON_PRETTY_PRINT);
$conn->close();
