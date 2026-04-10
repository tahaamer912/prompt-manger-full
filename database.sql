-- Table structures for the prompt management app

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Note: To seed the database with sample data, run database/seed.php via CLI or Browser.

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS prompts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category_id INT,
    user_id INT NOT NULL,
    is_public BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert default categories (user_id NULL for global defaults)
INSERT IGNORE INTO categories (name, user_id) VALUES 
('Marketing', NULL),
('Programming', NULL),
('Content Writing', NULL),
('Productivity', NULL),
('Creative Writing', NULL),
('Academic', NULL),
('Data Analysis', NULL),
('SEO', NULL),
('Social Media', NULL),
('Email Marketing', NULL),
('Business Strategy', NULL),
('Self-Improvement', NULL),
('Design', NULL),
('Copywriting', NULL),
('Roleplay', NULL),
('Finance', NULL),
('Health & Fitness', NULL),
('Travel', NULL),
('Legal', NULL),
('Other', NULL);

-- Optional: Create a demo user for testing (Password: password123)
-- INSERT IGNORE INTO users (username, email, password) VALUES ('demo_user', 'demo@example.com', '$2y$10$8S.p9YmNq0O6S5S6f6S6v.S6f6S6v.S6f6S6v.S6f6S6v.S6f6S6v');
