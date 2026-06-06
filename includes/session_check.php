<?php
session_start();

// Determine which portal is being accessed based on the URL path
$currentPath = $_SERVER['REQUEST_URI'];
$requiredRole = null;

if (strpos($currentPath, '/admin/') !== false) {
    $requiredRole = 'admin';
} elseif (strpos($currentPath, '/teacher/') !== false) {
    $requiredRole = 'teacher';
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    // Not logged in
    header("Location: /pmdc/pages/portal/portal-login.php");
    exit;
}

if ($requiredRole && $_SESSION['role'] !== $requiredRole) {
    // Logged in but wrong role
    header("Location: /pmdc/pages/portal/portal-login.php");
    exit;
}
?>
