-- Add role column to users table if it doesn't exist
ALTER TABLE users ADD COLUMN IF NOT EXISTS role VARCHAR(20) DEFAULT 'employee' AFTER password;

-- Add image column to users table if it doesn't exist
ALTER TABLE users ADD COLUMN IF NOT EXISTS image VARCHAR(255) NULL AFTER role;

-- Delete all existing users
TRUNCATE TABLE users;

-- Create admin user
INSERT INTO users (name, email, password, role, created_at, updated_at)
VALUES ('admin', 'admin@gmail.com', '$2y$12$W/oZ0dHDYrMEGNqvxbCSpug3faJeVm3uYIpWZz01IhbVDF17DxLei', 'admin', NOW(), NOW());
