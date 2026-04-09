<?php
require_once "../includes/db.php";

$action = $_GET['action'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'list') {
        if (!$user_id) sendResponse(false, "Authentication required.");
        $stmt = $conn->prepare("SELECT p.*, c.name as category_name 
                               FROM prompts p 
                               LEFT JOIN categories c ON p.category_id = c.id 
                               WHERE p.user_id = ? 
                               ORDER BY p.updated_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $prompts = [];
        while ($row = $result->fetch_assoc()) {
            $prompts[] = $row;
        }
        sendResponse(true, "Prompts fetched successfully", $prompts);
        
    } elseif ($action === 'public') {
        $stmt = $conn->prepare("SELECT p.*, c.name as category_name, u.username 
                               FROM prompts p 
                               LEFT JOIN categories c ON p.category_id = c.id 
                               LEFT JOIN users u ON p.user_id = u.id 
                               WHERE p.is_public = 1 
                               ORDER BY p.updated_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        $prompts = [];
        while ($row = $result->fetch_assoc()) {
            $prompts[] = $row;
        }
        sendResponse(true, "Public prompts fetched successfully", $prompts);
        
    } elseif ($action === 'get') {
        $id = $_GET['id'] ?? null;
        if (!$id) sendResponse(false, "Prompt ID is required.");
        
        $stmt = $conn->prepare("SELECT p.*, c.name as category_name 
                               FROM prompts p 
                               LEFT JOIN categories c ON p.category_id = c.id 
                               WHERE p.id = ? AND (p.user_id = ? OR p.is_public = 1)");
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $prompt = $stmt->get_result()->fetch_assoc();
        
        if ($prompt) {
            sendResponse(true, "Prompt fetched successfully", $prompt);
        } else {
            sendResponse(false, "Prompt not found or access denied.");
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$user_id) sendResponse(false, "Authentication required.");
    
    $data = json_decode(file_get_contents("php://input"), true);
    $title = $data['title'] ?? '';
    $content = $data['content'] ?? '';
    $category_id = $data['category_id'] ?? null;
    $is_public = $data['is_public'] ?? 0;
    
    if ($action === 'create') {
        $stmt = $conn->prepare("INSERT INTO prompts (title, content, category_id, user_id, is_public) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiii", $title, $content, $category_id, $user_id, $is_public);
        
        if ($stmt->execute()) {
            sendResponse(true, "Prompt created successfully", ["id" => $conn->insert_id]);
        } else {
            sendResponse(false, "Error creating prompt: " . $conn->error);
        }
        
    } elseif ($action === 'update') {
        $id = $data['id'] ?? null;
        if (!$id) sendResponse(false, "Prompt ID is required.");
        
        $stmt = $conn->prepare("UPDATE prompts SET title = ?, content = ?, category_id = ?, is_public = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssiiii", $title, $content, $category_id, $is_public, $id, $user_id);
        
        if ($stmt->execute()) {
            sendResponse(true, "Prompt updated successfully");
        } else {
            sendResponse(false, "Error updating prompt: " . $conn->error);
        }
        
    } elseif ($action === 'delete') {
        $id = $data['id'] ?? null;
        if (!$id) sendResponse(false, "Prompt ID is required.");
        
        $stmt = $conn->prepare("DELETE FROM prompts WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        
        if ($stmt->execute()) {
            sendResponse(true, "Prompt deleted successfully");
        } else {
            sendResponse(false, "Error deleting prompt: " . $conn->error);
        }
    }
}
