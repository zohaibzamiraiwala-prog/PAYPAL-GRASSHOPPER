<?php
// File: update_progress.php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    exit('not_logged_in');
}
$user_id = $_SESSION['user_id'];
$challenge_id = $_POST['challenge_id'];

$sql_check = "SELECT * FROM progress WHERE user_id = $user_id AND challenge_id = $challenge_id";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    $sql = "UPDATE progress SET completed = 1, attempts = attempts + 1 WHERE user_id = $user_id AND challenge_id = $challenge_id";
} else {
    $sql = "INSERT INTO progress (user_id, challenge_id, completed, attempts) VALUES ($user_id, $challenge_id, 1, 1)";
}
$conn->query($sql);

// Check if lesson completed and award badge
$sql_lesson = "SELECT lesson_id FROM challenges WHERE id = $challenge_id";
$lesson_id = $conn->query($sql_lesson)->fetch_assoc()['lesson_id'];

$sql_total = "SELECT COUNT(*) AS total FROM challenges WHERE lesson_id = $lesson_id";
$total = $conn->query($sql_total)->fetch_assoc()['total'];

$sql_completed = "SELECT COUNT(*) AS completed FROM progress p JOIN challenges c ON p.challenge_id = c.id WHERE p.user_id = $user_id AND p.completed = 1 AND c.lesson_id = $lesson_id";
$completed_count = $conn->query($sql_completed)->fetch_assoc()['completed'];

if ($completed_count == $total) {
    // Award badge based on lesson
    $badge_id = $lesson_id; // Assuming badge id matches lesson level or id for simplicity
    $sql_badge = "INSERT IGNORE INTO user_badges (user_id, badge_id) VALUES ($user_id, $badge_id)";
    $conn->query($sql_badge);
}

echo 'updated';
$conn->close();
?>
