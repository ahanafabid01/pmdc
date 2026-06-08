<?php
header('Content-Type: application/json');
require_once '../../../../includes/session_check.php';
require_once '../../../../includes/contact-data.php';

// Ensure the caller is an admin
if ($_SESSION['role'] !== 'admin') {
    echo json_encode(['ok' => false, 'msg' => 'Unauthorized']);
    exit;
}

$action = $_GET['action'] ?? '';

if ($action === 'list') {
    $messages = pmdc_contact_get_all();
    echo json_encode(['ok' => true, 'messages' => $messages]);
    exit;
}

if ($action === 'mark_read') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;
    if ($id) {
        $ok = pmdc_contact_mark_read($id);
        echo json_encode(['ok' => $ok]);
    } else {
        echo json_encode(['ok' => false, 'msg' => 'Missing ID']);
    }
    exit;
}

if ($action === 'delete') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $ok = pmdc_contact_delete($id);
        echo json_encode(['ok' => $ok]);
    } else {
        echo json_encode(['ok' => false, 'msg' => 'Missing ID']);
    }
    exit;
}

echo json_encode(['ok' => false, 'msg' => 'Invalid action']);
?>
