<?php 
require_once "../../includes/db.php"; 
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Prompts - Prompt App</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body onload="initPromptsPage()">

<div class="dashboard-layout">
  <!-- Sidebar Container -->
  <div class="sidebar-container"></div>

  <!-- Main Content -->
  <div class="main-wrapper">
    <header class="dashboard-header">
      <div class="header-title">
        <h1>My Prompts</h1>
      </div>
      <div>
        <a href="create.php" class="btn btn-primary">New Prompt</a>
      </div>
    </header>
    
    <main class="content-area">
      <div class="content-container">
        <div class="search-wrapper" style="display: flex; justify-content: center; gap: 12px; align-items: center; width: 100%; flex-wrap: wrap;">
          <input type="text" id="search" class="search-input" placeholder="Search prompts..." oninput="renderPrompts()" style="flex: 1; min-width: 250px; max-width: 500px;">
          <select id="categoryFilter" class="form-control" onchange="renderPrompts()" style="width: auto; min-width: 160px; padding: 10px 16px;">
            <option value="">All Categories</option>
          </select>
        </div>
        
        <div id="prompts" class="grid-container">
          <!-- Prompts will be dynamically loaded here -->
        </div>

        <div id="pagination" class="pagination"></div>
      </div>
    </main>
  </div>
</div>

<script src="../../js/api.js"></script>
<script src="../../js/utils.js"></script>
<script src="../../js/components.js"></script>
<script src="prompts.js"></script>
</body>
</html>
