<?php
// File: create_tables.php
// Run this once to create tables and insert sample data
include 'db.php';

// Create tables
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$sql_lessons = "CREATE TABLE IF NOT EXISTS lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    level INT DEFAULT 1
)";

$sql_challenges = "CREATE TABLE IF NOT EXISTS challenges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lesson_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    code_template TEXT,
    hint TEXT,
    solution TEXT,
    test_code TEXT,
    order_num INT DEFAULT 1,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
)";

$sql_progress = "CREATE TABLE IF NOT EXISTS progress (
    user_id INT NOT NULL,
    challenge_id INT NOT NULL,
    completed BOOLEAN DEFAULT FALSE,
    attempts INT DEFAULT 0,
    last_attempt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, challenge_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (challenge_id) REFERENCES challenges(id) ON DELETE CASCADE
)";

$sql_badges = "CREATE TABLE IF NOT EXISTS badges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT
)";

$sql_user_badges = "CREATE TABLE IF NOT EXISTS user_badges (
    user_id INT NOT NULL,
    badge_id INT NOT NULL,
    awarded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, badge_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE CASCADE
)";

$conn->query($sql_users);
$conn->query($sql_lessons);
$conn->query($sql_challenges);
$conn->query($sql_progress);
$conn->query($sql_badges);
$conn->query($sql_user_badges);

// Insert sample data if not exists
$conn->query("INSERT IGNORE INTO lessons (title, description, level) VALUES ('Introduction to Coding', 'Learn the basics of JavaScript.', 1)");
$conn->query("INSERT IGNORE INTO lessons (title, description, level) VALUES ('Functions and Variables', 'Dive deeper into functions.', 2)");

$lesson1_id = $conn->query("SELECT id FROM lessons WHERE title='Introduction to Coding'")->fetch_assoc()['id'];
$lesson2_id = $conn->query("SELECT id FROM lessons WHERE title='Functions and Variables'")->fetch_assoc()['id'];

$conn->query("INSERT IGNORE INTO challenges (lesson_id, title, description, code_template, hint, solution, test_code, order_num) VALUES 
    ($lesson1_id, 'Greet the World', 'Write a function greet that returns \"Hello World\".', 'function greet() {\n  return \"\";\n}', 'Return the string \"Hello World\".', 'function greet() {\n  return \"Hello World\";\n}', 'greet() === \"Hello World\"', 1)");

$conn->query("INSERT IGNORE INTO challenges (lesson_id, title, description, code_template, hint, solution, test_code, order_num) VALUES 
    ($lesson1_id, 'Add Numbers', 'Write a function add that takes two numbers and returns their sum.', 'function add(a, b) {\n  return 0;\n}', 'Return a + b.', 'function add(a, b) {\n  return a + b;\n}', 'add(1, 2) === 3 && add(5, 5) === 10', 2)");

$conn->query("INSERT IGNORE INTO badges (name, description) VALUES ('Beginner Coder', 'Completed the first lesson.')");
$conn->query("INSERT IGNORE INTO badges (name, description) VALUES ('Function Master', 'Completed the second lesson.')");

echo "Tables created and sample data inserted.";
$conn->close();
?>
