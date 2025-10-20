<?php
// File: lesson.php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}
$user_id = $_SESSION['user_id'];
$lesson_id = $_GET['id'];

$sql = "SELECT * FROM lessons WHERE id = $lesson_id";
$lesson = $conn->query($sql)->fetch_assoc();

$sql_challenges = "SELECT c.*, p.completed FROM challenges c LEFT JOIN progress p ON c.id = p.challenge_id AND p.user_id = $user_id WHERE c.lesson_id = $lesson_id ORDER BY order_num";
$challenges = $conn->query($sql_challenges);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lesson['title']; ?> - Coding Adventure</title>
    <style>
        body { font-family: 'Arial', sans-serif; margin: 0; padding: 0; background: linear-gradient(135deg, #1e3c72, #2a5298); color: #fff; }
        header { text-align: center; padding: 20px; background: rgba(0,0,0,0.5); }
        .challenges { display: flex; flex-direction: column; align-items: center; padding: 20px; }
        .challenge { background: rgba(255,255,255,0.1); border-radius: 10px; margin: 10px; padding: 20px; width: 80%; max-width: 600px; text-align: center; transition: box-shadow 0.3s; }
        .challenge:hover { box-shadow: 0 0 20px rgba(255,255,255,0.5); }
        .completed { background: #4CAF50; }
        a { color: #fff; text-decoration: none; font-size: 1.2em; }
        .back { display: block; text-align: center; margin: 20px; background: #2196F3; padding: 10px; border-radius: 5px; width: 200px; margin: 20px auto; }
        @media (max-width: 768px) { .challenge { width: 90%; } }
    </style>
</head>
<body>
    <header>
        <h1><?php echo $lesson['title']; ?></h1>
    </header>
    <section class="challenges">
        <?php while ($challenge = $challenges->fetch_assoc()): ?>
            <div class="challenge <?php echo $challenge['completed'] ? 'completed' : ''; ?>">
                <a href="challenge.php?id=<?php echo $challenge['id']; ?>"><?php echo $challenge['title']; ?> <?php echo $challenge['completed'] ? '(Completed)' : ''; ?></a>
            </div>
        <?php endwhile; ?>
    </section>
    <a href="lessons.php" class="back">Back to Lessons</a>
</body>
</html>
