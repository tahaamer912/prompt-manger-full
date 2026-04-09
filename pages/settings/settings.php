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
  <title>Settings - Prompt App</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body onload="initSettingsPage()">

<div class="dashboard-layout">
  <div class="sidebar-container"></div>

  <div class="main-wrapper">
    <header class="dashboard-header">
      <div class="header-title">
        <h1>Account Settings</h1>
      </div>
    </header>
    
    <main class="content-area">
      <div class="content-container">
        <div class="form-card center-card">
          <form id="settingsForm">
            <h3 class="mb-2">Profile Information</h3>
            <div class="form-group">
              <label for="profileUsername">Username</label>
              <input type="text" id="profileUsername" class="form-control" placeholder="Enter username">
              <small style="color: var(--text-secondary); margin-top: 4px; display: block;">Display name for your profile.</small>
            </div>
            
            <div class="form-group">
              <label for="profileEmail">Email Address</label>
              <input type="email" id="profileEmail" class="form-control" placeholder="Enter email">
              <small style="color: var(--text-secondary); margin-top: 4px; display: block;">Primary contact email.</small>
            </div>

            <div class="mt-3">
              <button type="submit" class="btn btn-primary" style="width: 100%;">Save Profile</button>
            </div>

            <hr style="border: 0; border-top: 1px solid var(--border); margin: 32px 0;">
            
            <h3 class="mb-2">Preferences</h3>
            <div class="form-group">
                <button type="button" onclick="toggleTheme()" class="btn btn-secondary">Toggle Theme</button>
            </div>
            
            <div class="mt-3">
              <button type="button" onclick="logout()" class="btn btn-danger" style="width: 100%;">Logout</button>
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
<script src="settings.js"></script>
</body>
</html>
