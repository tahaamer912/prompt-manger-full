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
  <title>Categories - Prompt App</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body onload="initCategoriesPage()">

<div class="dashboard-layout">
  <div class="sidebar-container"></div>

  <div class="main-wrapper">
    <header class="dashboard-header">
      <div class="header-title">
        <h1>Manage Categories</h1>
      </div>
    </header>
    
    <main class="content-area">
      <div class="content-container">
        <div class="form-card center-card mb-3">
          <h3 class="mb-2">Add New Category</h3>
          <form id="addCategoryForm" style="display: flex; gap: 12px;">
            <input type="text" id="newCategory" class="form-control" placeholder="Category name" required style="flex: 1;">
            <button type="submit" class="btn btn-primary">Add</button>
          </form>
        </div>

        <div class="card">
          <h3 class="mb-2">Your Categories</h3>
          <p style="color: var(--text-secondary); margin-bottom: 1rem; font-size: 0.9rem;">Default categories cannot be deleted.</p>
          <ul id="categoryList" style="list-style: none; display: flex; flex-direction: column; gap: 12px; padding: 0;">
            <!-- Categories will be dynamically loaded here -->
          </ul>
        </div>
      </div>
    </main>
  </div>
</div>

<script src="../../js/api.js"></script>
<script src="../../js/utils.js"></script>
<script src="../../js/components.js"></script>
<script src="categories.js"></script>
</body>
</html>
