<?php require_once "includes/db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prompt App - Manage Your Prompts</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="landing-nav">
  <h2>PromptApp</h2>
  <div class="hero-btns">
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="pages/prompts/prompts.php" class="btn btn-primary">Dashboard</a>
        <a href="#" onclick="logout()" class="btn btn-secondary">Logout</a>
    <?php else: ?>
        <a href="pages/auth/login.php" class="btn btn-secondary">Login</a>
        <a href="pages/auth/register.php" class="btn btn-primary">Get Started</a>
    <?php endif; ?>
  </div>
</nav>

<section class="landing-hero">
  <h1>Your Ultimate Prompt Management Workspace</h1>
  <p>Save, organize, and discover the best AI prompts to supercharge your workflow.</p>
  <div class="hero-btns">
    <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="pages/auth/register.php" class="btn btn-primary" style="padding: 16px 32px; font-size: 16px;">Start for Free</a>
    <?php else: ?>
        <a href="pages/prompts/prompts.php" class="btn btn-primary" style="padding: 16px 32px; font-size: 16px;">Go to Dashboard</a>
    <?php endif; ?>
    <a href="pages/public/public.php" class="btn btn-secondary" style="padding: 16px 32px; font-size: 16px;">Explore Public Prompts</a>
  </div>
</section>

<script src="js/api.js"></script>
<script src="js/utils.js"></script>
</body>
</html>
