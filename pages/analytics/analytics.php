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
  <title>Analytics - Prompt App</title>
  <link rel="stylesheet" href="../../css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body onload="initAnalyticsPage()">

<div class="dashboard-layout">
  <div class="sidebar-container"></div>

  <div class="main-wrapper">
    <header class="dashboard-header">
      <div class="header-title">
        <h1>Analytics Overview</h1>
        <p style="font-size: 0.9rem;">Welcome back, <span style="color: var(--accent); font-weight: 600;"><?php echo htmlspecialchars($_SESSION['username']); ?></span>! Here's your performance summary.</p>
      </div>
    </header>
    
    <main class="content-area">
      <div class="content-container">
        <div class="stats-grid mb-3">
          <div class="card stat-card">
            <span class="stat-label">Total Prompts</span>
            <div id="statTotal" class="stat-value">0</div>
          </div>
          <div class="card stat-card">
            <span class="stat-label">Public Library</span>
            <div id="statPublic" class="stat-value">0</div>
          </div>
          <div class="card stat-card">
            <span class="stat-label">Private Storage</span>
            <div id="statPrivate" class="stat-value">0</div>
          </div>
          <div class="card stat-card">
            <span class="stat-label">Top Category</span>
            <div id="statTopCategory" class="stat-value" style="font-size: 1.5rem; margin: 24px 0;">-</div>
          </div>
        </div>

        <div class="analytics-grid">
          <div class="card chart-container-card">
            <h3 class="mb-3" style="font-size: 1.1rem;">Visibility Distribution</h3>
            <canvas id="publicPrivateChart"></canvas>
          </div>
          <div class="card chart-container-card">
            <h3 class="mb-3" style="font-size: 1.1rem;">Category Distribution</h3>
            <div style="height: 300px; position: relative;">
               <canvas id="categoryChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<script src="../../js/api.js"></script>
<script src="../../js/utils.js"></script>
<script src="../../js/components.js"></script>
<script src="analytics.js"></script>
</body>
</html>
