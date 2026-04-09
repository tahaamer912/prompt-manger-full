<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "prompt_app";

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
    sendResponse(false, "Database connection failed. Please ensure the 'prompt_app' database exists and credentials in includes/db.php are correct.");
}

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
