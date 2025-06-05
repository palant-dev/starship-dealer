<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Directory Separator
define('DS', DIRECTORY_SEPARATOR);

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'PABSBDEC');

// URL Root
define('URLROOT', 'http://localhost:9000');

// Site Name
define('SITENAME', 'Starship Dealer');

// App Root
define('APPROOT', dirname(dirname(__FILE__)));

// Template paths
define('TEMPLATE_FRONT', APPROOT . DS . 'views' . DS . 'templates' . DS . 'front');
define('TEMPLATE_BACK', APPROOT . DS . 'views' . DS . 'templates' . DS . 'back');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1); 