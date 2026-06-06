<?php
/**
 * api/registration-settings.php
 * Handles fetching and saving settings for HSC and Degree registrations.
 */
header('Content-Type: application/json');
require_once dirname(__DIR__, 4) . '/includes/registration-data.php';

// Handle GET: Fetch settings
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(reg_settings_get());
    exit;
}

// Handle POST: Save settings
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    $currentSettings = reg_settings_get();
    
    // Update either hsc or degree based on what was sent
    if (isset($input['hsc'])) {
        $currentSettings['hsc'] = array_merge($currentSettings['hsc'], $input['hsc']);
    }
    if (isset($input['degree'])) {
        $currentSettings['degree'] = array_merge($currentSettings['degree'], $input['degree']);
    }

    $success = reg_settings_save($currentSettings);
    echo json_encode(['success' => $success]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Method not allowed']);
