<?php
/**
 * api/registration-submit.php
 * Handles form submissions for public HSC and Degree Registration.
 */
header('Content-Type: application/json');
require_once dirname(__DIR__) . '/includes/registration-data.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$type = $_POST['type'] ?? 'hsc';

// Check if registration is open
$status = reg_get_status($type);
if ($status['state'] !== 'open') {
    echo json_encode(['success' => false, 'message' => 'Registration is currently closed.']);
    exit;
}

// Prepare data
$session = $status['session'];
$refNum = reg_generate_ref($type, $session);

$personalData = json_decode($_POST['personal_data'] ?? '{}', true);
$academicData = json_decode($_POST['academic_data'] ?? '{}', true);

$data = [
    'ref_number' => $refNum,
    'session' => $session,
    'program_type' => $type,
    'personal_data' => $personalData,
    'academic_data' => $academicData,
    'payment_method' => $_POST['payment_method'] ?? '',
    'transaction_id' => $_POST['transaction_id'] ?? '',
    'amount_paid' => (float)($_POST['amount_paid'] ?? 0),
    'payment_date' => $_POST['payment_date'] ?? date('Y-m-d'),
];

// Handle file uploads (simplified, just moving them to uploads/registrations)
$uploadDir = REG_UPLOAD_BASE . $session . '/' . $type . '/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

$paths = ['photo' => null, 'certificate' => null, 'birth_cert' => null];
foreach (['photo', 'certificate', 'birth_cert'] as $fileKey) {
    if (!empty($_FILES[$fileKey]['name'])) {
        $tmpName = $_FILES[$fileKey]['tmp_name'];
        $ext = strtolower(pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION));
        // Use ref_number in filename for uniqueness
        $fileName = $refNum . '_' . $fileKey . '.' . $ext;
        $destPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($tmpName, $destPath)) {
            // Store relative path
            $paths[$fileKey] = 'uploads/registrations/' . $session . '/' . $type . '/' . $fileName;
        }
    }
}

$data['photo_path'] = $paths['photo'];
$data['certificate_path'] = $paths['certificate'];
$data['birth_cert_path'] = $paths['birth_cert'];

// Save to DB
$result = reg_insert($data);

if ($result['ok']) {
    echo json_encode(['success' => true, 'ref_number' => $refNum]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to insert data into the database.']);
}
