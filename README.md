# PromptApp - Advanced AI Prompt Management Dashboard

PromptApp is a premium, full-stack web application designed for organizing and sharing AI prompts. Refactored from a client-side only app to a robust **PHP & MySQL** backend, it now supports real users, secure data persistence, and private/public libraries.

## ✨ Advanced Features

- **🔐 Secure Authentication**
  - Full PHP session-based login and registration.
  - Password hashing (Bcrypt) for user security.
- **📁 Structured Backend API**
  - Cleanly separated PHP API endpoints for Prompts, Categories, and User Auth.
  - CRUD operations fully integrated with a MySQL database.
- **🎨 Premium UI/UX**
  - Sleek Glassmorphism design with Dynamic Dark/Light mode.
  - Responsive sidebar and mobile-friendly layouts.
- **📊 Live Analytics**
  - Real-time visualization of prompt distribution and visibility using Chart.js.
- **🌍 Global Public Library**
  - Share prompts with the community or keep them private.
  - Search and filter through thousands of shared prompts.
- **🧪 Data Seeding**
  - Dedicated script to populate the database with professional sample data for testing.

## 🛠 Tech Stack

- **Frontend**: HTML5, Vanilla CSS3 (Custom Variables), Vanilla JavaScript.
- **Backend**: PHP 8 (Procedural/Prepared Statements).
- **Database**: MySQL.
- **Charts**: Chart.js via CDN.

## 🏁 Installation & Setup

To run this project, you need a local PHP environment (like **XAMPP**, **WAMP**, or **MAMP**).

### 1. Database Setup
1. Open **PHPMyAdmin** (usually `http://localhost/phpmyadmin`).
2. Create a new database named `prompt_app`.
3. Import the `database.sql` file located in the root directory.

### 2. Configure Connection
1. Ensure the database credentials in `includes/db.php` match your local setup:
   ```php
   $host = "localhost";
   $username = "root"; // Your MySQL username
   $password = "";     // Your MySQL password
   $dbname = "prompt_app";
   ```

### 3. (Optional) Seed Initial Data
To populate the app with a demo user and several professional sample prompts:
- **Via Browser**: Navigate to `http://localhost/prompt-manger-full/database/seed.php`
- **Via CLI**: Run `php database/seed.php` from the project root.

### 4. Run the Project
1. Move the `prompt-manger-full` folder to your server's root directory (e.g., `C:\xampp\htdocs\prompt-manger-full`).
2. Open your browser and navigate to `http://localhost/prompt-manger-full`.
3. Login using `demo@example.com` / `password123` or create a new account!

## 📁 Project Re-Architecture

```
prompt-manger-full/
├── api/                  # Backend PHP API endpoints
│   ├── auth.php          # Login, Register, Logout
│   ├── prompts.php       # Prompt CRUD
│   ├── analytics.php     # Stats data
│   └── categories.php    # Category Management
├── database/             # Database tools
│   └── seed.php          # Initial data seeder script
├── includes/             # Shared Backend logic
│   └── db.php            # Connection & Helper functions
├── js/                   # Frontend Logic
│   ├── api.js            # Central API Service (fetch)
│   ├── utils.js          # Shared UI Utilities
│   └── components.js     # Nav and Sidebar Injections
├── pages/                # UI Views (PHP)
│   ├── auth/             # Login/Register
│   ├── prompts/          # Dashboard & CRUD
│   ├── categories/       # Category Hub
│   ├── public/           # Public Library
│   ├── settings/         # Profile/Settings
│   └── analytics/        # Charting & Stats
├── css/                  # Styling & Themes
├── index.php             # Landing Page
└── database.sql          # DB Schema for Import
```

## 📜 Requirements
- PHP 7.4+ (PHP 8 recommended)
- MySQL / MariaDB
- Modern Browser (Chrome, Firefox, Edge)

---
*Built with ❤️ by Antigravity*
