-- 1. Create Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100),
    role ENUM('Student', 'Staff'),
    class_name VARCHAR(50),
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Create Tanks Table (With AUTO_INCREMENT)
CREATE TABLE tanks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    location VARCHAR(100),
    water_level INT,
    status VARCHAR(20),
    last_cleaned DATE,
    next_cleaning DATE,
    cleaning_method VARCHAR(50),
    autocleaning BOOLEAN
);

-- 3. Create Admins Table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255)
);

-- 4. Initial Tank Data
INSERT INTO tanks (name, location, water_level, status, last_cleaned, next_cleaning, cleaning_method, autocleaning) VALUES 
('Main Block Tank', 'Ground Floor', 85, 'Active', '2026-04-10', '2026-04-14', 'Filtration', 1),
('Library Tank', '1st Floor', 60, 'Cleaning', '2026-04-08', '2026-04-11', 'Manual Scrubbing', 0),
('Hostel Tank A', 'Boys Hostel', 45, 'Active', '2026-04-08', '2026-04-14', 'Chlorination', 1),
('Lab Tank', 'Block D', 20, 'Disable', '2026-04-08', '2026-04-14', 'Manual Scrubbing', 0),
('Auditorium Tank', 'Main Hall', 65, 'Active', '2026-04-08', '2026-04-14', 'Filtration', 1),
('Gym Tank', 'Sports Area', 55, 'Disable', '2026-04-08', '2026-04-14', 'Manual Scrubbing', 1);