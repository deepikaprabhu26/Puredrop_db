CREATE DATABASE puredrop_db;
USE puredrop_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100),
    role ENUM('Student', 'Staff'),
    class_name VARCHAR(50),
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tanks (
    id INT PRIMARY KEY,
    name VARCHAR(50),
    location VARCHAR(100),
    water_level INT,
    status VARCHAR(20),
    last_cleaned DATE,
    next_cleaning DATE,
    cleaning_method VARCHAR(50),
    autocleaning BOOLEAN
);

CREATE TABLE chatbot_queries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    question TEXT,
    response TEXT,
    status ENUM('Answered', 'Rejected'),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255)
);

-- Initial Tank Data
INSERT INTO tanks VALUES 
(1, 'Main Block Tank', 'Ground Floor', 85, 'Active', '2024-01-10', '2024-01-14', 'Filtration', 1),
(2, 'Library Tank', '1st Floor', 60, 'Cleaning', '2024-01-08', '2024-01-11', 'Manual', 0),
(3, 'Hostel Tank A', 'Boys Hostel', 45, 'Active', '2024-01-08', '2024-01-14', 'Chlorination', 1);