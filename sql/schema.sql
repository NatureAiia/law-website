-- Africa University School of Law website
-- Run this first, then seed.sql

CREATE DATABASE IF NOT EXISTS au_law_school CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE au_law_school;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE news_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    category ENUM('news', 'event') NOT NULL DEFAULT 'news',
    summary VARCHAR(300) NOT NULL,
    body TEXT NOT NULL,
    entry_date DATE NOT NULL,
    image_path VARCHAR(255) NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_news_events_category (category),
    INDEX idx_news_events_entry_date (entry_date)
) ENGINE=InnoDB;

CREATE TABLE faculty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    title VARCHAR(100) NOT NULL,
    department ENUM('Private Law', 'Procedural Law', 'Public Law', 'Administration') NOT NULL,
    bio TEXT NULL,
    email VARCHAR(150) NULL,
    photo_path VARCHAR(255) NULL,
    is_dean TINYINT(1) NOT NULL DEFAULT 0,
    display_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_faculty_department (department)
) ENGINE=InnoDB;

CREATE TABLE legal_help_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    contact_info VARCHAR(150) NOT NULL,
    issue_category ENUM('Family Law', 'Housing & Land', 'Human Rights', 'Health & HIV/AIDS Related', 'Consumer/Small Claims', 'Other') NOT NULL,
    description TEXT NOT NULL,
    submitted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
