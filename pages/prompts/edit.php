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
  <title>Edit Prompt - Prompt App</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body onload="initEditPage()">

<div class="dashboard-layout">
  <div class="sidebar-container"></div>

  <div class="main-wrapper">
    <header class="dashboard-header">
      <div class="header-title">
        <h1>Edit Prompt</h1>
      </div>
      <div>
        <a href="prompts.php" class="btn btn-secondary">Cancel</a>
      </div>
    </header>
    
    <main class="content-area">
      <div class="content-container">
        <div class="form-card center-card">
          <form id="editPromptForm">
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" id="title" class="form-control" required>
            </div>
            
            <div class="form-group">
              <label for="category">Category</label>
              <select id="category" class="form-control"></select>
            </div>

            <div class="form-group">
              <label for="text">Prompt Content</label>
              <textarea id="text" class="form-control" required style="min-height: 200px;"></textarea>
            </div>
            
            <div class="form-group">
              <label class="checkbox-label" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" id="public" style="width: 18px; height: 18px;">
                <span>Make this prompt public</span>
              </label>
            </div>
            
            <div class="mt-3">
              <button type="submit" class="btn btn-primary" style="width: 100%;">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>
</div>

<script src="../../js/api.js"></script>
<script src="../../js/utils.js"></script>
<script src="../../js/components.js"></script>
<script src="edit.js"></script>
</body>
</html>
