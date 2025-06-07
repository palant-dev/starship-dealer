<?php
// Load environment variables if .env file exists
$envFile = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . '.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments and empty lines
        if (strpos($line, '#') === 0 || empty(trim($line))) continue;
        
        // Parse the line safely
        $parts = explode('=', $line, 2);
        if (count($parts) !== 2) continue;
        
        $name = trim($parts[0]);
        $value = trim($parts[1], " \t\n\r\0\x0B\"'");
        
        if (!empty($name)) {
            $_ENV[$name] = $value;
            putenv(sprintf('%s=%s', $name, $value));
        }
    }
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Directory Separator
define('DS', DIRECTORY_SEPARATOR);

// Environment
define('APP_ENV', getenv('APP_ENV') ?: 'development');

// Database configuration
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'PABSBDEC');

// URL Configuration
$port = getenv('APP_PORT') ?: '9000';
$url = getenv('APP_URL') ?: 'http://localhost';
define('URLROOT', $port === '80' ? $url : "{$url}:{$port}");

// Site Name
define('SITENAME', getenv('SITE_NAME') ?: 'Starship Dealer');

// App Root
define('APPROOT', dirname(dirname(__FILE__)));

// Template paths
define('TEMPLATE_FRONT', APPROOT . DS . 'views' . DS . 'templates' . DS . 'front');
define('TEMPLATE_BACK', APPROOT . DS . 'views' . DS . 'templates' . DS . 'back');

// Error reporting
if (APP_ENV === 'development' || getenv('DEBUG') === 'true') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}