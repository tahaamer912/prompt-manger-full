<?php include "../../includes/db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Prompt App</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="auth-layout">

<div class="auth-container">
  <div class="auth-info">
    <h2>Start Your Journey</h2>
    <p>Join thousands of users organizing their AI workflow with professional prompts.</p>
  </div>
  <div class="auth-card">
    <h1 class="auth-title">Create Account</h1>
    <p class="auth-subtitle">Join the professional prompt community</p>
    
    <form id="registerForm">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" class="form-control" placeholder="johndoe" required>
      </div>
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" class="form-control" placeholder="name@example.com" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" class="form-control" placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn btn-primary">Create Account</button>
    </form>
    
    <div class="auth-footer">
      Already have an account? <a href="login.php">Login</a>
    </div>
  </div>
</div>

<script src="../../js/api.js"></script>
<script src="../../js/utils.js"></script>
<script src="auth.js"></script>
</body>
</html>
