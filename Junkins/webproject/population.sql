-- Create database
CREATE DATABASE IF NOT EXISTS word_population_db;
USE word_population_db;

-- Users table for authentication
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Word population data table
CREATE TABLE IF NOT EXISTS word_population (
    id INT AUTO_INCREMENT PRIMARY KEY,
    word VARCHAR(100) NOT NULL,
    population_count BIGINT NOT NULL,
    language VARCHAR(50),
    region VARCHAR(50),
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample user
INSERT INTO users (username, email, password) VALUES 
('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); -- password: password

-- Insert sample word population data
INSERT INTO word_population (word, population_count, language, region) VALUES 
('hello', 1500000000, 'English', 'Global'),
('hola', 580000000, 'Spanish', 'Global'),
('bonjour', 280000000, 'French', 'Global'),
('hallo', 130000000, 'German', 'Global'),
('ciao', 85000000, 'Italian', 'Global'),
('namaste', 600000000, 'Hindi', 'South Asia'),
('konnichiwa', 125000000, 'Japanese', 'Japan'),
('nihao', 1100000000, 'Chinese', 'Global'),
('salaam', 400000000, 'Arabic', 'Middle East'),
('privet', 258000000, 'Russian', 'Eastern Europe');

-- Create indexes for better performance
CREATE INDEX idx_word ON word_population(word);
CREATE INDEX idx_language ON word_population(language);