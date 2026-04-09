async function injectSidebar() {
  const sidebarContainer = document.querySelector('.sidebar-container');
  if (!sidebarContainer) return;

  const currentPath = window.location.pathname;
  const urlParams = new URLSearchParams(window.location.search);
  const isPublicView = urlParams.get('view') === 'public' || currentPath.includes('public.php');
  
  // Calculate relative paths
  const isAtRoot = !currentPath.includes('/pages/');
  const pathPrefix = isAtRoot ? 'pages/' : '../';

  let menuItems = [
    { id: 'prompts', name: 'My Prompts', icon: 'M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z', link: 'prompts/prompts.php' },
    { id: 'public', name: 'Public Library', icon: 'M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5.752c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V3.58z', link: 'public/public.php' },
    { id: 'categories', name: 'Categories', icon: 'M1.5 0A1.5 1.5 0 0 0 0 1.5v2A1.5 1.5 0 0 0 1.5 5h8A1.5 1.5 0 0 0 11 3.5v-2A1.5 1.5 0 0 0 9.5 0h-8zM1 1.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2zM1.5 7A1.5 1.5 0 0 0 0 8.5v2A1.5 1.5 0 0 0 1.5 12h8A1.5 1.5 0 0 0 11 10.5v-2A1.5 1.5 0 0 0 9.5 7h-8zM1 8.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2z', link: 'categories/categories.php' },
    { id: 'analytics', name: 'Analytics', icon: 'M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5v12h-2V2h2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z', link: 'analytics/analytics.php' },
    { id: 'settings', name: 'Settings', icon: 'M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z', link: 'settings/settings.php' },
  ];

  const authStatus = await API.auth.status();
  const isLoggedIn = authStatus.success;

  if (isPublicView && !isLoggedIn) {
    menuItems = menuItems.filter(item => item.id === 'public');
  }

  const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

  const sidebarHtml = `
    <aside class="sidebar ${isCollapsed ? 'collapsed' : ''}">
      <div class="sidebar-header">
        <h2 class="sidebar-logo" onclick="window.location.href='${isAtRoot ? 'index.php' : '../../index.php'}'" style="cursor:pointer">Prompt<span>App</span></h2>
        <button class="toggle-sidebar" onclick="toggleSidebar()">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
          </svg>
        </button>
      </div>
      <nav class="sidebar-nav">
        ${menuItems.map(item => {
          const fullLink = isAtRoot ? 'pages/' + item.link : '../' + item.link;
          const isActive = currentPath.includes(item.link.split('/')[0]);
          return `
            <a href="${fullLink}" class="${isActive ? 'active' : ''}" title="${item.name}">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="${item.icon}"/>
              </svg>
              <span class="nav-text">${item.name}</span>
            </a>
          `;
        }).join('')}
      </nav>
      <div class="sidebar-footer">
        <button onclick="toggleTheme()" class="btn-sidebar-action" id="themeToggleBtn" title="Toggle Theme">🌙</button>
        ${isLoggedIn 
          ? `<button onclick="logout()" class="btn-sidebar-action logout" title="Logout">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
              </svg>
              <span class="nav-text">Logout</span>
            </button>`
          : `<button onclick="window.location.href='${isAtRoot ? 'pages/' : '../'}auth/login.php'" class="btn-sidebar-action login" title="Login">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
              </svg>
              <span class="nav-text">Login</span>
            </button>`
        }
      </div>
    </aside>
  `;

  sidebarContainer.innerHTML = sidebarHtml;
  
  if (!document.querySelector('.sidebar-overlay')) {
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    overlay.onclick = toggleMobileMenu;
    document.body.appendChild(overlay);
  }

  const header = document.querySelector('.dashboard-header');
  if (header && !header.querySelector('.mobile-nav-toggle')) {
    const toggle = document.createElement('button');
    toggle.className = 'mobile-nav-toggle';
    toggle.innerHTML = `
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
      </svg>
    `;
    toggle.onclick = toggleMobileMenu;
    header.prepend(toggle);
  }

  updateThemeIcon(document.documentElement.getAttribute("data-theme") || "dark");
}

function toggleSidebar() {
  const sidebar = document.querySelector('.sidebar');
  const isCollapsed = sidebar.classList.toggle('collapsed');
  localStorage.setItem('sidebarCollapsed', isCollapsed);
}

function toggleMobileMenu() {
  const sidebar = document.querySelector('.sidebar');
  const overlay = document.querySelector('.sidebar-overlay');
  sidebar.classList.toggle('mobile-active');
  overlay.classList.toggle('active');
}

document.addEventListener('DOMContentLoaded', injectSidebar);

