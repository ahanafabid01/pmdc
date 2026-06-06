<?php
/**
 * api/staff.php
 * Handles staff CRUD operations with file uploads.
 */
header('Content-Type: application/json');

require_once dirname(__DIR__, 4) . '/includes/staff-data.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

/* ── Image helpers ──────────────────────────────────────────── */
function pmdc_load_image($path, $type) {
    switch ($type) {
        case IMAGETYPE_JPEG: return imagecreatefromjpeg($path);
        case IMAGETYPE_PNG:  $img = imagecreatefrompng($path); imagealphablending($img, true); return $img;
        case IMAGETYPE_WEBP: return imagecreatefromwebp($path);
    }
    return null;
}

function pmdc_save_image($img, $path, $type) {
    switch ($type) {
        case IMAGETYPE_JPEG: imagejpeg($img, $path, 85); break;
        case IMAGETYPE_PNG:  imagepng($img, $path, 7);  break;
        case IMAGETYPE_WEBP: imagewebp($img, $path, 85); break;
    }
}

function pmdc_make_thumb($src, $dst, $size) {
    if (!function_exists('imagecreatefromjpeg')) return;
    [$w, $h, $type] = getimagesize($src);
    if (!$w || !$h) return;

    // Square crop from centre
    $min   = min($w, $h);
    $cropX = (int)(($w - $min) / 2);
    $cropY = (int)(($h - $min) / 2);

    $orig  = pmdc_load_image($src, $type);
    if (!$orig) return;
    $canvas = imagecreatetruecolor($size, $size);
    imagecopyresampled($canvas, $orig, 0, 0, $cropX, $cropY, $size, $size, $min, $min);
    pmdc_save_image($canvas, $dst, $type);
    imagedestroy($orig);
    imagedestroy($canvas);
}

/* ── GET LIST ────────────────────────────────────────────────── */
if ($action === 'list') {
    $staff = pmdc_staff_get_all();
    // Normalise column names to camelCase for existing JS compatibility
    $formatted = array_map(function($s) {
        $photoUrl = null;
        if ($s['photo']) {
            $photoUrl = $s['photo']; // e.g. uploads/staff/filename.jpg
        }
        return [
            'id'            => (string)$s['id'], // String ID for JS compatibility
            'name'          => $s['name'],
            'designation'   => $s['designation'],
            'category'      => $s['category'],
            'isPrincipal'   => (bool)$s['is_principal'],
            'subject'       => $s['subject'],
            'qualification' => $s['qualification'],
            'email'         => $s['email'],
            'phone'         => $s['phone'],
            'photo'         => $photoUrl
        ];
    }, $staff);
    
    echo json_encode(['ok' => true, 'staff' => $formatted]);
    exit;
}

/* ── SAVE (Create/Update) ────────────────────────────────────── */
if ($action === 'save') {
    $id = $_POST['id'] ?? '';
    $data = [
        'name'          => trim($_POST['name'] ?? ''),
        'designation'   => trim($_POST['designation'] ?? ''),
        'category'      => $_POST['category'] ?? 'teacher',
        'is_principal'  => filter_var($_POST['isPrincipal'] ?? false, FILTER_VALIDATE_BOOLEAN),
        'subject'       => trim($_POST['subject'] ?? ''),
        'qualification' => trim($_POST['qualification'] ?? ''),
        'email'         => trim($_POST['email'] ?? ''),
        'phone'         => trim($_POST['phone'] ?? '')
    ];

    if (empty($data['name'])) {
        echo json_encode(['ok' => false, 'msg' => 'Name is required']);
        exit;
    }

    // Handle photo upload
    $photoPath = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['photo'];
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $mime = mime_content_type($file['tmp_name']);
        
        if (in_array($mime, $allowed) && $file['size'] <= 5 * 1024 * 1024) {
            $uploadDir = dirname(__DIR__, 4) . '/uploads/staff/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $basename = uniqid('staff_', true) . '.' . $ext;
            $destFull = $uploadDir . $basename;
            
            if (move_uploaded_file($file['tmp_name'], $destFull)) {
                // Crop and resize to 400x400 to save space and ensure square avatars
                pmdc_make_thumb($destFull, $destFull, 400);
                $photoPath = 'uploads/staff/' . $basename;
            }
        } else {
            echo json_encode(['ok' => false, 'msg' => 'Invalid image format or size exceeds 5MB']);
            exit;
        }
    }

    $removePhoto = filter_var($_POST['removePhoto'] ?? false, FILTER_VALIDATE_BOOLEAN);

    if ($photoPath) {
        $data['photo'] = $photoPath;
    } elseif ($removePhoto) {
        $data['photo'] = ''; // Empty string indicates clear
    } else {
        $data['photo'] = null; // null indicates no change
    }

    // JS generates UUID-like strings 's-1234...' when not saved. 
    // If $id starts with 's-' or is empty, it's a new record in our MySQL logic.
    if (empty($id) || strpos($id, 's-') === 0) {
        $ok = pmdc_staff_insert($data);
    } else {
        $ok = pmdc_staff_update((int)$id, $data);
    }

    echo json_encode(['ok' => $ok]);
    exit;
}

/* ── DELETE ──────────────────────────────────────────────────── */
if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if (!$id) {
        echo json_encode(['ok' => false, 'msg' => 'Invalid ID']);
        exit;
    }
    
    $ok = pmdc_staff_delete($id);
    echo json_encode(['ok' => $ok]);
    exit;
}

echo json_encode(['ok' => false, 'msg' => 'Unknown action']);
