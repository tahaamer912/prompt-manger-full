// ===== DATA MANAGEMENT =====
// NOTE: We now fetch categories and prompts from the backend API via API.js.
// Categories and prompts should ideally be fetched when needed rather than on load here.

async function getCategories() {
  const response = await API.categories.list();
  if (response.success) {
    return response.data;
  }
  return [];
}

async function getPrompts() {
  const response = await API.prompts.list();
  if (response.success) {
    return response.data;
  }
  return [];
}

// These are now handled by API calls in their respective page JS files
function savePrompts(prompts) {}
function saveCategories(categories) {}

// ===== THEME =====
function initTheme() {
  const theme = localStorage.getItem("theme") || "dark";
  document.documentElement.setAttribute("data-theme", theme);
  updateThemeIcon(theme);
}

function toggleTheme() {
  const current = document.documentElement.getAttribute("data-theme") || "dark";
  const next = current === "dark" ? "light" : "dark";
  document.documentElement.setAttribute("data-theme", next);
  localStorage.setItem("theme", next);
  updateThemeIcon(next);
  
  window.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme: next } }));
}

function updateThemeIcon(theme) {
  const btn = document.getElementById("themeToggleBtn");
  if (btn) {
    btn.innerHTML = theme === "dark" ? "☀️ Light" : "🌙 Dark";
  }
}

// ===== AUTH =====
// checkAuth is now used differently; the server handles session checks via PHP.
// But this is still useful for frontend-only state checks if needed.
async function checkAuth() {
  const status = await API.auth.status();
  if (!status.success && !window.location.pathname.includes('auth/')) {
    window.location.href = '/prompt-manger-full/pages/auth/login.php';
  }
  return status.success;
}

async function logout() {
  await API.auth.logout();
  const loginPath = window.location.pathname.includes('/pages/') ? '../auth/login.php' : 'pages/auth/login.php';
  window.location.href = loginPath;
}

// Helper for escaping HTML
function escapeHtml(unsafe) {
  if (!unsafe) return "";
  return unsafe
    .toString()
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;")
    .replace(/\n/g, "\\n");
}

// ===== TOAST NOTIFICATIONS =====
function showToast(message, type = 'success') {
  let container = document.querySelector('.toast-container');
  if (!container) {
    container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  toast.className = `toast ${type}`;
  
  let icon = '';
  if (type === 'success') icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>';
  if (type === 'error') icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>';

  toast.innerHTML = `
    ${icon}
    <span>${message}</span>
  `;

  container.appendChild(toast);

  setTimeout(() => {
    toast.classList.add('fade-out');
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}

// Initialize on load
initTheme();

