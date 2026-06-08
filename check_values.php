<?php
require 'includes/config.php';
$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);

$stmt = $pdo->query("SELECT * FROM academics_programs");
echo "Programs:\n";
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
