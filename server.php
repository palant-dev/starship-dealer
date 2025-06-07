<?php
// Load configuration (which includes environment variables)
require_once __DIR__ . '/app/config/config.php';

// Get port from environment
$port = getenv('APP_PORT') ?: '9000';
$host = 'localhost';

echo "Starting server at http://{$host}:{$port}\n";
echo "Press Ctrl+C to stop the server\n";

// Execute the PHP built-in server with document root set to public directory
$command = sprintf('php -S %s:%s -t public', $host, $port);
passthru($command);
