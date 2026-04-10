<?php
// Environment Detection
$is_local = ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1' || $_SERVER['SERVER_NAME'] == 'localhost');

if ($is_local) {
    // Local Settings (XAMPP)
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "prompt_app";
} else {
    // Production Settings (InfinityFree)
    $host = "sql210.byetcluster.com";
    $username = "if0_41624198";
    $password = "YOUR_DB_PASSWORD"; 
    $dbname = "if0_41624198_prompt_app";
}

mysqli_report(MYSQLI_REPORT_OFF);
$conn = @new mysqli($host, $username, $password, $dbname);

// Helper function for JSON responses
function sendResponse($success, $message, $data = null) {
    if (!headers_sent()) {
        header('Content-Type: application/json');
    }
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

if ($conn->connect_error) {
    sendResponse(false, "Database connection failed. Check your credentials in includes/db.php");
}

$conn->set_charset("utf8mb4");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
