<?php
header('Content-Type: application/json');
require_once dirname(__DIR__, 4) . '/includes/announcements-data.php';

$action = $_GET['action'] ?? '';

if ($action === 'list') {
    $raw = pmdc_get_announcements();
    $mapped = array_map(function($a) {
        return [
            'id' => (string)$a['id'],
            'title' => $a['title'],
            'message' => $a['body'], // Map body to message for JS
            'date' => $a['date'],
            'status' => $a['published'] ? 'published' : 'draft',
            'attachment' => $a['attachment'],
            'createdAt' => explode(' ', $a['created_at'])[0],
            'category' => $a['category'] ?? 'notice',
            'category_label' => $a['category_label'] ?? 'Notice',
            'badge_label' => $a['badge_label'] ?? '',
            'badge_class' => $a['badge_class'] ?? ''
        ];
    }, $raw);
    
    echo json_encode(['ok' => true, 'announcements' => $mapped]);
    exit;
}

// All actions below require JSON payload
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['ok' => false, 'error' => 'Invalid JSON']);
    exit;
}

if ($action === 'save') {
    $id = $data['id'] ?? null;
    
    $mappedData = [
        'title' => $data['title'] ?? '',
        'body' => $data['message'] ?? '',
        'date' => $data['date'] ?? date('Y-m-d'),
        'published' => ($data['status'] === 'published'),
        'author' => 'Administration',
        'category' => $data['category'] ?? 'notice',
        'category_label' => $data['category_label'] ?? 'Notice',
        'badge_label' => $data['badge_label'] ?? '',
        'badge_class' => $data['badge_class'] ?? '',
        'attachment' => $data['attachment'] ?? null
    ];
    
    if (empty($mappedData['title']) || empty($mappedData['body'])) {
        echo json_encode(['ok' => false, 'error' => 'Missing required fields']);
        exit;
    }

    if ($id && is_numeric($id)) {
        $res = pmdc_announcement_update($id, $mappedData);
    } else {
        $res = pmdc_announcement_insert($mappedData);
    }
    
    echo json_encode(['ok' => $res]);
    exit;
}

if ($action === 'delete') {
    $id = $data['id'] ?? null;
    if ($id) {
        $res = pmdc_announcement_delete($id);
        echo json_encode(['ok' => $res]);
    } else {
        echo json_encode(['ok' => false, 'error' => 'Missing ID']);
    }
    exit;
}

if ($action === 'toggle') {
    $id = $data['id'] ?? null;
    $status = $data['status'] ?? 'draft'; // The new status
    if ($id) {
        // Fetch current to update
        $existing = pmdc_find_published_announcement_by_id($id);
        // Wait, pmdc_find_published_announcement_by_id only gets published ones.
        // We need a helper to get ANY announcement by ID.
        // I will just use a direct query here since it's simple enough.
        $conn = pmdc_db_connect();
        if ($conn) {
            $id = (int)$id;
            $pub = ($status === 'published') ? 1 : 0;
            $conn->query("UPDATE pmdc_announcements SET published = $pub WHERE id = $id");
            $conn->close();
            echo json_encode(['ok' => true]);
        } else {
            echo json_encode(['ok' => false, 'error' => 'DB error']);
        }
    } else {
        echo json_encode(['ok' => false, 'error' => 'Missing ID']);
    }
    exit;
}

echo json_encode(['ok' => false, 'error' => 'Invalid action']);
