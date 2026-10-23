
<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// $host = '127.0.0.1';
$host = 'localhost';
$user = 'root';
$password = 'Qp0+i9koko.wal';
$database = 'samay';
$port = 3306;

try {
    $conn = new mysqli($host, $user, $password, $database, $port);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    http_response_code(500);
    exit('Database connection failed. Check your MySQL settings.');
}
