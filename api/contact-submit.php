<?php
/**
 * api/contact-submit.php
 * Public API to receive contact form submissions.
 */
header('Content-Type: application/json');
require_once dirname(__DIR__) . '/includes/contact-data.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['ok' => false, 'msg' => 'Invalid data format']);
    exit;
}

if (empty($data['name']) || empty($data['email']) || empty($data['subject']) || empty($data['message'])) {
    echo json_encode(['ok' => false, 'msg' => 'Please fill all required fields']);
    exit;
}

$ok = pmdc_contact_insert($data);

if ($ok) {
    echo json_encode(['ok' => true, 'msg' => 'Message sent successfully']);
} else {
    echo json_encode(['ok' => false, 'msg' => 'Failed to save message. Please try again.']);
}
?>
