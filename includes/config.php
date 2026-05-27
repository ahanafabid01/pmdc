<?php
/**
 * Lumina University Website Configuration
 * Common settings and constants
 */

// Site Information
define('SITE_NAME', 'Lumina University');
define('SITE_TAGLINE', 'Excellence in Education');
define('SITE_URL', 'https://lumina.edu');

// Contact Information
define('CONTACT_PHONE', '+1 (555) 123-4567');
define('CONTACT_EMAIL', 'info@lumina.edu');
define('CONTACT_ADMISSIONS_EMAIL', 'admissions@lumina.edu');
define('CONTACT_ADDRESS', '123 University Avenue, Boston, MA 02110, USA');

// Social Media Links
define('SOCIAL_FACEBOOK', '#');
define('SOCIAL_TWITTER', '#');
define('SOCIAL_INSTAGRAM', '#');
define('SOCIAL_LINKEDIN', '#');

// Site Settings
define('COPYRIGHT_START_YEAR', 1895);
define('ENABLE_MAINTENANCE_MODE', false);

// Date and Time
date_default_timezone_set('America/New_York');

// Error Reporting (Disable in production)
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Session Configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
