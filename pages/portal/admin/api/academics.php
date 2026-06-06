<?php
/**
 * api/academics.php
 * Handles academics CRUD requests from the admin portal
 */
header('Content-Type: application/json');
require_once dirname(__DIR__, 4) . '/includes/academics-data.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action === 'list') {
    $all = pmdc_academics_get_all();
    $hsc = array_values(array_filter($all, fn($p) => $p['type'] === 'hsc'));
    $deg = array_values(array_filter($all, fn($p) => $p['type'] === 'degree'));
    
    echo json_encode(['ok' => true, 'hsc' => $hsc, 'degree' => $deg]);
    exit;
}

if ($action === 'save') {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    
    if (!$data || !isset($data['id']) || !isset($data['type'])) {
        echo json_encode(['ok' => false, 'error' => 'Invalid data']);
        exit;
    }
    
    $success = pmdc_academics_save($data);
    echo json_encode(['ok' => $success]);
    exit;
}

if ($action === 'delete') {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    
    if (!$data || !isset($data['id']) || !isset($data['type'])) {
        echo json_encode(['ok' => false, 'error' => 'Missing id or type']);
        exit;
    }
    
    $success = pmdc_academics_delete($data['id'], $data['type']);
    echo json_encode(['ok' => $success]);
    exit;
}

echo json_encode(['ok' => false, 'error' => 'Invalid action']);
?>
