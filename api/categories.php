<?php
require_once "../includes/db.php";

$action = $_GET['action'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'list') {
        $stmt = $conn->prepare("SELECT id, name, user_id FROM categories WHERE user_id IS NULL OR user_id = ? ORDER BY name ASC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        sendResponse(true, "Categories fetched successfully", $categories);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$user_id) sendResponse(false, "Authentication required.");
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    if ($action === 'create') {
        $name = $data['name'] ?? '';
        if (empty($name)) sendResponse(false, "Category name is required.");
        
        $stmt = $conn->prepare("INSERT INTO categories (name, user_id) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $user_id);
        
        if ($stmt->execute()) {
            sendResponse(true, "Category created successfully", ["id" => $conn->insert_id]);
        } else {
            sendResponse(false, "Error creating category: " . $conn->error);
        }
        
    } elseif ($action === 'delete') {
        $id = $data['id'] ?? null;
        if (!$id) sendResponse(false, "Category ID is required.");
        
        $stmt = $conn->prepare("DELETE FROM categories WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        
        if ($stmt->execute()) {
            sendResponse(true, "Category deleted successfully");
        } else {
            sendResponse(false, "Error deleting category: " . $conn->error);
        }
    }
}
