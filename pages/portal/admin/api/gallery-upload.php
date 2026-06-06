<?php
/**
 * api/gallery-upload.php
 * Handles photo upload, edit, and delete for the admin gallery.
 */
header('Content-Type: application/json');

require_once dirname(__DIR__, 4) . '/includes/gallery-data.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

/* ── LIST ───────────────────────────────────────────────────── */
if ($action === 'list') {
    $photos = pmdc_gallery_get_all();
    // Reformat for frontend
    $formatted = array_map(function($p) {
        return [
            'id'            => (string)$p['id'],
            'title'         => $p['title'],
            'filename'      => $p['filename'],
            'year'          => (string)$p['year'],
            'date_uploaded' => $p['date_uploaded'],
            'is_external'   => !empty($p['is_external'])
        ];
    }, $photos);
    echo json_encode(['ok' => true, 'photos' => $formatted]);
    exit;
}

/* ── DELETE ─────────────────────────────────────────────────── */
if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if (!$id) { echo json_encode(['ok' => false, 'msg' => 'Invalid ID']); exit; }
    $ok = pmdc_gallery_delete($id);
    echo json_encode(['ok' => $ok]);
    exit;
}

/* ── EDIT ───────────────────────────────────────────────────── */
if ($action === 'edit') {
    $id    = (int)($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $year  = (int)($_POST['year'] ?? date('Y'));
    $date  = $_POST['date'] ?? date('Y-m-d');
    if (!$id) { echo json_encode(['ok' => false, 'msg' => 'Invalid ID']); exit; }
    $ok = pmdc_gallery_update($id, $title, $year, $date);
    echo json_encode(['ok' => $ok]);
    exit;
}

/* ── BULK DELETE ────────────────────────────────────────────── */
if ($action === 'bulk_delete') {
    $ids = json_decode($_POST['ids'] ?? '[]', true);
    $ok  = true;
    foreach ((array)$ids as $id) {
        if (!pmdc_gallery_delete((int)$id)) $ok = false;
    }
    echo json_encode(['ok' => $ok]);
    exit;
}

/* ── UPLOAD ─────────────────────────────────────────────────── */
if ($action === 'upload') {
    $year  = (int)($_POST['year'] ?? date('Y'));
    $date  = $_POST['date'] ?? date('Y-m-d');
    $title = trim($_POST['title'] ?? '');

    $uploadDir = dirname(__DIR__, 4) . '/uploads/gallery/' . $year . '/';
    $thumbDir  = dirname(__DIR__, 4) . '/uploads/gallery/thumbs/' . $year . '/';

    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    if (!is_dir($thumbDir))  mkdir($thumbDir,  0755, true);

    $results = [];
    $files   = $_FILES['photos'] ?? null;

    if (!$files) {
        echo json_encode(['ok' => false, 'msg' => 'No files received']);
        exit;
    }

    // Normalise $_FILES structure for single or multiple
    $fileList = [];
    if (is_array($files['name'])) {
        for ($i = 0; $i < count($files['name']); $i++) {
            $fileList[] = [
                'name'     => $files['name'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error'    => $files['error'][$i],
                'size'     => $files['size'][$i],
                'type'     => $files['type'][$i],
            ];
        }
    } else {
        $fileList[] = $files;
    }

    $allowed = ['image/jpeg', 'image/png', 'image/webp'];
    $maxSize = 5 * 1024 * 1024; // 5 MB

    foreach ($fileList as $file) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $results[] = ['ok' => false, 'msg' => 'Upload error: ' . $file['error']];
            continue;
        }
        if ($file['size'] > $maxSize) {
            $results[] = ['ok' => false, 'msg' => $file['name'] . ' exceeds 5MB limit'];
            continue;
        }
        $mime = mime_content_type($file['tmp_name']);
        if (!in_array($mime, $allowed)) {
            $results[] = ['ok' => false, 'msg' => $file['name'] . ' has invalid type'];
            continue;
        }

        $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $basename = uniqid('pmdc_', true) . '.' . $ext;
        $destFull = $uploadDir . $basename;
        $destThumb = $thumbDir . $basename;

        if (!move_uploaded_file($file['tmp_name'], $destFull)) {
            $results[] = ['ok' => false, 'msg' => 'Failed to save ' . $file['name']];
            continue;
        }

        // Resize full → max 1200px
        pmdc_resize_image($destFull, $destFull, 1200, 1200);
        // Generate thumbnail → 400px square crop
        pmdc_make_thumb($destFull, $destThumb, 400);

        $relPath = $year . '/' . $basename;
        $t = $title ?: pathinfo($file['name'], PATHINFO_FILENAME);
        $ok = pmdc_gallery_insert($t, $relPath, $year, $date);
        $results[] = ['ok' => $ok, 'file' => $basename];
    }

    echo json_encode(['ok' => true, 'results' => $results]);
    exit;
}

echo json_encode(['ok' => false, 'msg' => 'Unknown action']);

/* ── Image helpers ──────────────────────────────────────────── */
function pmdc_resize_image($src, $dst, $maxW, $maxH) {
    if (!function_exists('imagecreatefromjpeg')) return;
    [$w, $h, $type] = getimagesize($src);
    if (!$w || !$h) return;

    $scale = min($maxW / $w, $maxH / $h, 1);
    $nW = (int)($w * $scale);
    $nH = (int)($h * $scale);

    $orig  = pmdc_load_image($src, $type);
    if (!$orig) return;
    $canvas = imagecreatetruecolor($nW, $nH);
    imagecopyresampled($canvas, $orig, 0, 0, 0, 0, $nW, $nH, $w, $h);
    pmdc_save_image($canvas, $dst, $type);
    imagedestroy($orig);
    imagedestroy($canvas);
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
