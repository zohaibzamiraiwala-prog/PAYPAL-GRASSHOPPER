<?php
// File: lessons.php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}
$user_id = $_SESSION['user_id'];

// Get lessons with progress
$sql = "SELECT l.*, 
        (SELECT COUNT(*) FROM challenges c WHERE c.lesson_id = l.id) AS total_challenges,
        (SELECT COUNT(*) FROM progress p JOIN challenges c ON p.challenge_id = c.id WHERE p.user_id = $user_id AND p.completed = 1 AND c.lesson_id = l.id) AS completed_challenges
        FROM lessons l";
$result = $conn->query($sql);

// Get badges
$sql_badges = "SELECT b.name, b.description FROM user_badges ub JOIN badges b ON ub.badge_id = b.id WHERE ub.user_id = $user_id";
$badges_result = $conn->query($sql_badges);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lessons - Coding Adventure</title>
    <style>
        body { font-family: 'Arial', sans-serif; margin: 0; padding: 0; background: linear-gradient(135deg, #1e3c72, #2a5298); color: #fff; }
        header { text-align: center; padding: 20px; background: rgba(0,0,0,0.5); }
        .lessons { display: flex; flex-wrap: wrap; justify-content: center; padding: 20px; }
        .lesson { background: rgba(255,255,255,0.1); border-radius: 10px; margin: 10px; padding: 20px; width: 300px; text-align: center; transition: transform 0.3s; }
        .lesson:hover { transform: scale(1.05); }
        .progress { background: #4CAF50; height: 10px; border-radius: 5px; margin-top: 10px; }
        .badges { padding: 20px; text-align: center; }
        .badge { display: inline-block; background: gold; color: black; padding: 10px; border-radius: 50%; margin: 5px; animation: spin 2s infinite; }
        a { color: #fff; text-decoration: none; }
        .logout { position: absolute; top: 10px; right: 10px; background: #f44336; padding: 10px; border-radius: 5px; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        @media (max-width: 768px) { .lesson { width: 90%; } }
    </style>
</head>
<body>
    <header>
        <h1>Your Lessons</h1>
        <a href="logout.php" class="logout">Logout</a>
    </header>
    <section class="lessons">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="lesson">
                <h2><a href="lesson.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></h2>
                <p><?php echo $row['description']; ?></p>
                <div>Progress: <?php echo $row['completed_challenges'] . '/' . $row['total_challenges']; ?></div>
                <div class="progress" style="width: <?php echo ($row['total_challenges'] > 0 ? ($row['completed_challenges'] / $row['total_challenges'] * 100) : 0); ?>%;"></div>
            </div>
        <?php endwhile; ?>
    </section>
    <section class="badges">
        <h2>Your Badges</h2>
        <?php while ($badge = $badges_result->fetch_assoc()): ?>
            <div class="badge"><?php echo $badge['name']; ?></div>
        <?php endwhile; ?>
    </section>
</body>
