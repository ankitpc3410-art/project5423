CREATE DATABASE IF NOT EXISTS innovation_center;
USE innovation_center;

CREATE TABLE IF NOT EXISTS innovation_projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    project_title VARCHAR(150) NOT NULL,
    student_name VARCHAR(100) NOT NULL,
    college_name VARCHAR(150) NOT NULL,
    branch VARCHAR(50) NOT NULL,
    domain VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    description TEXT NOT NULL,
    poster VARCHAR(255) NOT NULL DEFAULT 'default.png',
    github_link VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
