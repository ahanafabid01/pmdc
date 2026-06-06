<?php
/**
 * api/registration-admin.php
 * Handles fetching application lists and updating application statuses and notes.
 */
header('Content-Type: application/json');
require_once dirname(__DIR__, 4) . '/includes/registration-data.php';

// Handle GET: List applications
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $type = $_GET['type'] ?? 'hsc';
    $session = $_GET['session'] ?? '';
    
    // Fetch from database
    $applications = reg_list($type, $session);
    
    echo json_encode(['applications' => $applications]);
    exit;
}

// Handle POST: Update status or admin note
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input || empty($input['ref_number'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    $refNum = $input['ref_number'];
    
    // Update admin note
    if (isset($input['admin_note']) && !isset($input['status'])) {
        $success = reg_save_note($refNum, $input['admin_note']);
        echo json_encode(['success' => $success]);
        exit;
    }
    
    // Update status
    if (isset($input['status'])) {
        $status = $input['status'];
        $reason = $input['rejection_reason'] ?? '';
        $success = reg_update_status($refNum, $status, $reason);
        echo json_encode(['success' => $success]);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'No action performed']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Method not allowed']);
