<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$dest = 'announcements/view.php';
if ($id > 0) {
    $dest .= '?id=' . urlencode((string)$id);
}
header('Location: ' . $dest, true, 302);
exit;
