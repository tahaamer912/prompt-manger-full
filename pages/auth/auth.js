// Register logic
document.getElementById("registerForm")?.addEventListener("submit", async (e) => {
  e.preventDefault();

  const username = document.getElementById("username").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value;

  const response = await API.auth.register(username, email, password);
  
  if (response.success) {
    showToast("Account created successfully!");
    setTimeout(() => {
      window.location.href = "login.php";
    }, 1000);
  } else {
    showToast(response.message || "Registration failed.", "error");
  }
});

// Login logic
document.getElementById("loginForm")?.addEventListener("submit", async (e) => {
  e.preventDefault();

  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value;

  const response = await API.auth.login(email, password);

  if (response.success) {
    showToast("Login successful!");
    setTimeout(() => {
        window.location.href = "../prompts/prompts.php";
    }, 500);
  } else {
    showToast(response.message || "Invalid credentials.", "error");
  }
});

