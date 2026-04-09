<?php
require_once "../includes/db.php";

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) sendResponse(false, "Authentication required.");

// 1. Total and Public Prompt Counts for this user
$stmt = $conn->prepare("SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN is_public = 1 THEN 1 ELSE 0 END) as public_count
    FROM prompts WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$counts = $stmt->get_result()->fetch_assoc();

// 2. Category Distribution for this user
$stmt = $conn->prepare("SELECT 
    COALESCE(c.name, 'Uncategorized') as category_name,
    COUNT(p.id) as count
    FROM prompts p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.user_id = ?
    GROUP BY p.category_id, c.name
    ORDER BY count DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$category_result = $stmt->get_result();
$categories = [];
while ($row = $category_result->fetch_assoc()) {
    $categories[] = $row;
}

// 3. User Statistics (e.g., date joined)
$stmt = $conn->prepare("SELECT created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_info = $stmt->get_result()->fetch_assoc();

sendResponse(true, "Analytics fetched successfully", [
    'counts' => [
        'total' => (int)$counts['total'],
        'public' => (int)$counts['public_count'],
        'private' => (int)($counts['total'] - $counts['public_count'])
    ],
    'categories' => $categories,
    'user' => [
        'joined_at' => $user_info['created_at']
    ]
]);
?>
