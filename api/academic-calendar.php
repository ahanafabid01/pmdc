<?php
/**
 * api/academic-calendar.php
 * Handles upload/delete/list for the Academic Calendar.
 * One image or PDF per academic year.
 */
header('Content-Type: application/json');
require_once dirname(__DIR__) . '/includes/academic-calendar-data.php';

acal_init();

$action = $_POST['action'] ?? $_GET['action'] ?? '';

/* ── LIST ───────────────────────────────────────────────── */
if ($action === 'list') {
    echo json_encode(['ok' => true, 'calendars' => acal_list()]);
    exit;
}

/* ── DELETE ─────────────────────────────────────────────── */
if ($action === 'delete') {
    $year = (int)($_POST['year'] ?? 0);
    if (!$year) { echo json_encode(['ok' => false, 'msg' => 'Invalid year']); exit; }

    // Remove physical file
    $all  = acal_list();
    $row  = array_values(array_filter($all, fn($r) => (int)$r['year'] === $year))[0] ?? null;
    if ($row && $row['filename']) {
        $path = ACAL_UPLOAD_DIR . $row['filename'];
        if (file_exists($path)) unlink($path);
    }

    $ok = acal_delete($year);
    echo json_encode(['ok' => $ok]);
    exit;
}

/* ── UPLOAD ─────────────────────────────────────────────── */
if ($action === 'upload') {
    $year = (int)($_POST['year'] ?? 0);
    if (!$year) { echo json_encode(['ok' => false, 'msg' => 'Year is required']); exit; }

    $file = $_FILES['file'] ?? null;
    if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['ok' => false, 'msg' => 'No file received or upload error']);
        exit;
    }

    $maxSize = 10 * 1024 * 1024; // 10 MB
    if ($file['size'] > $maxSize) {
        echo json_encode(['ok' => false, 'msg' => 'File exceeds 10 MB limit']);
        exit;
    }

    $mime     = mime_content_type($file['tmp_name']);
    $allowed  = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];
    if (!in_array($mime, $allowed)) {
        echo json_encode(['ok' => false, 'msg' => 'Only JPG, PNG, WEBP or PDF allowed']);
        exit;
    }

    $fileType = ($mime === 'application/pdf') ? 'pdf' : 'image';
    $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $basename = 'calendar_' . $year . '_' . time() . '.' . $ext;
    $dest     = ACAL_UPLOAD_DIR . $basename;

    // Delete old file for this year first
    $all = acal_list();
    $old = array_values(array_filter($all, fn($r) => (int)$r['year'] === $year))[0] ?? null;
    if ($old && $old['filename']) {
        $oldPath = ACAL_UPLOAD_DIR . $old['filename'];
        if (file_exists($oldPath)) unlink($oldPath);
    }

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        echo json_encode(['ok' => false, 'msg' => 'Failed to save file']);
        exit;
    }

    $ok = acal_upsert($year, $basename, $fileType);
    echo json_encode(['ok' => $ok, 'filename' => $basename, 'file_type' => $fileType]);
    exit;
}

echo json_encode(['ok' => false, 'msg' => 'Unknown action']);
