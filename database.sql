-- Database: rbru_agri_innovation

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    school VARCHAR(255),
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    activity_id INT NOT NULL,
    completed TINYINT(1) DEFAULT 0,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (activity_id) REFERENCES activities(id),
    UNIQUE KEY unique_registration (student_id, activity_id)
);

-- Seed initial activities
INSERT INTO activities (title) VALUES 
('Climate Data Hacking Workshop'),
('Deep Dive Lab CNN Training Workshop'),
('AI-IoT Prototyping Workshop'),
('RBRU-Praneet Tech Showcase');
