<?php
require_once __DIR__ . "/../includes/db.php";

echo "Starting database seeding...\n";

// 1. Create a demo user if doesn't exist
$demo_username = "demo_user";
$demo_email = "demo@example.com";
$demo_password = password_hash("password123", PASSWORD_DEFAULT);

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $demo_email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $demo_username, $demo_email, $demo_password);
    $stmt->execute();
    $user_id = $conn->insert_id;
    echo "Demo user created (ID: $user_id).\n";
} else {
    $user_id = $user['id'];
    echo "Demo user already exists (ID: $user_id).\n";
}

// 2. Define and Ensure Categories Exist
$default_categories = [
    'Marketing', 'Programming', 'Content Writing', 'Productivity', 
    'Creative Writing', 'Academic', 'Data Analysis', 'SEO', 
    'Social Media', 'Email Marketing', 'Business Strategy', 
    'Self-Improvement', 'Design', 'Copywriting', 'Roleplay', 
    'Finance', 'Health & Fitness', 'Travel', 'Legal', 'Other'
];

foreach ($default_categories as $cat_name) {
    $stmt = $conn->prepare("INSERT IGNORE INTO categories (name, user_id) VALUES (?, NULL)");
    $stmt->bind_param("s", $cat_name);
    $stmt->execute();
}

$categories = [];
$result = $conn->query("SELECT id, name FROM categories");
while ($row = $result->fetch_assoc()) {
    $categories[$row['name']] = $row['id'];
}
echo "Categories ensured.\n";

// 3. Define sample prompts
$sample_prompts = [
    [
        'title' => 'SEO Meta Description Generator',
        'category' => 'SEO',
        'content' => "Act as an SEO expert. Write a compelling meta description for a blog post about '[TOPIC]'. The description should be under 160 characters, include the primary keyword naturally, and end with a clear call to action.",
        'is_public' => 1
    ],
    [
        'title' => 'Python Unit Test Writer',
        'category' => 'Programming',
        'content' => "Generate a set of Python unit tests using the unittest framework for the following function:\n\n[PASTE FUNCTION HERE]\n\nInclude tests for edge cases and handle potential errors gracefully.",
        'is_public' => 1
    ],
    [
        'title' => 'Product Description Optimizer',
        'category' => 'Marketing',
        'content' => "Rewrite this product description to be more persuasive and benefit-driven. Focus on the emotional connection and solve specific pain points for the target audience: [AUDIENCE].\n\nOriginal Description:\n[TEXT]",
        'is_public' => 1
    ],
    [
        'title' => 'Daily Routine Planner',
        'category' => 'Productivity',
        'content' => "Create a highly efficient daily schedule based on these tasks and priorities: [LIST]. Include breaks, focused deep-work blocks, and time for physical activity. Optimize for maximum energy levels throughout the day.",
        'is_public' => 1
    ],
    [
        'title' => 'Instagram Caption Creator',
        'category' => 'Social Media',
        'content' => "Write 5 engaging Instagram captions for a photo showing [SCENE]. Use a mix of educational, witty, and inspirational tones. Include relevant hashtags and a call to action to comment below.",
        'is_public' => 1
    ],
    [
        'title' => 'Professional Email Refiner',
        'category' => 'Email Marketing',
        'content' => "Refine this email draft to sound more professional yet approachable. Ensure the tone is appropriate for my [MANAGER/CLIENT].\n\nDraft:\n[TEXT]",
        'is_public' => 0
    ],
    [
        'title' => 'Creative Short Story Prompt',
        'category' => 'Creative Writing',
        'content' => "Write a sci-fi short story opening based on this concept: 'In a world where memories can be traded like currency, a man discovers a memory that isn't his but feels like home.'",
        'is_public' => 1
    ],
    [
        'title' => 'Academic Essay Outline',
        'category' => 'Academic',
        'content' => "Create a detailed outline for a research paper on [TOPIC]. Include an introduction with a thesis statement, three main body sections with supporting arguments, and a conclusion that summarizes the findings.",
        'is_public' => 1
    ],
    [
        'title' => 'SQL Query Generator',
        'category' => 'Programming',
        'content' => "Write a complex SQL query that joins the 'orders', 'users', and 'products' tables to find the top 5 customers by total spending in the last 30 days. Include columns for username, total_spent, and order_count.",
        'is_public' => 0
    ],
    [
        'title' => 'Self-Improvement Goal Setter',
        'category' => 'Self-Improvement',
        'content' => "Help me break down my big goal of [GOAL] into SMART (Specific, Measurable, Achievable, Relevant, Time-bound) milestones for the next 3 months. Provide a step-by-step action plan for the first two weeks.",
        'is_public' => 1
    ]
];

// 4. Insert prompts
$inserted_count = 0;
foreach ($sample_prompts as $prompt) {
    // Skip if prompt title already exists for this user (simple check)
    $check_stmt = $conn->prepare("SELECT id FROM prompts WHERE title = ? AND user_id = ?");
    $check_stmt->bind_param("si", $prompt['title'], $user_id);
    $check_stmt->execute();
    if ($check_stmt->get_result()->num_rows > 0) {
        continue;
    }

    $category_id = $categories[$prompt['category']] ?? null;
    
    $stmt = $conn->prepare("INSERT INTO prompts (title, content, category_id, user_id, is_public) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiii", $prompt['title'], $prompt['content'], $category_id, $user_id, $prompt['is_public']);
    
    if ($stmt->execute()) {
        $inserted_count++;
    }
}

echo "Seeding completed! Inserted $inserted_count new sample prompts.\n";
if (php_sapi_name() !== 'cli') {
    echo "<br><br><a href='../index.php'>Go to Dashboard</a>";
}
?>
