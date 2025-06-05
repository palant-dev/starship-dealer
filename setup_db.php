<?php
$host = 'localhost';
$user = 'root';
$pass = '';

try {
    // make a connection to MySQL database (fingers crossed)
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // get the SQL commands from the file and run them (hope they work)
    $sql = file_get_contents('database_setup.sql');
    $pdo->exec($sql);
    
    echo "Database setup completed successfully!\n";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
