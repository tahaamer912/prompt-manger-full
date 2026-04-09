<?php
require_once "../includes/db.php";

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if ($action === 'register') {
        $username = $data['username'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        
        if (empty($username) || empty($email) || empty($password)) {
            sendResponse(false, "All fields are required.");
        }
        
        // Check if user already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            sendResponse(false, "User with this email already exists.");
        }
        
        // Hash password
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        // Create user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed);
        
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            sendResponse(true, "Registration successful.");
        } else {
            sendResponse(false, "Error creating user: " . $conn->error);
        }
        
    } elseif ($action === 'login') {
        $emailInput = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        
        if (empty($emailInput) || empty($password)) {
            sendResponse(false, "All fields are required.");
        }
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $emailInput);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            sendResponse(true, "Login successful.");
        } else {
            sendResponse(false, "Invalid email or password.");
        }
    } elseif ($action === 'update_profile') {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) sendResponse(false, "Authentication required.");
        
        $username = $data['username'] ?? '';
        $email = $data['email'] ?? '';
        
        if (empty($username) || empty($email)) {
            sendResponse(false, "Username and Email are required.");
        }
        
        // Check if email is taken by another user
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $email, $user_id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            sendResponse(false, "Email is already taken by another user.");
        }
        
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $username, $email, $user_id);
        
        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            sendResponse(true, "Profile updated successfully.");
        } else {
            sendResponse(false, "Error updating profile: " . $conn->error);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'logout') {
        session_destroy();
        sendResponse(true, "Logged out successfully.");
    } elseif ($action === 'status') {
        if (isset($_SESSION['user_id'])) {
            sendResponse(true, "Authenticated", [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
                'email' => $_SESSION['email'] ?? ''
            ]);
        } else {
            sendResponse(false, "Not authenticated");
        }
    }
}
