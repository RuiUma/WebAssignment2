CREATE DATABASE user_auth;

USE user_auth;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    birthday DATE NOT NULL,
    password VARCHAR(512) NOT NULL,
    status ENUM('inactive', 'active') DEFAULT 'inactive',
    verification_token VARCHAR(128),
    session_token VARCHAR(128),
    session_expiry DATETIME
);
