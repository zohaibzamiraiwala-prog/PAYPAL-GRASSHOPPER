<?php
// File: index.php
session_start();
if (isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'lessons.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coding Adventure - Learn to Code Interactively</title>
    <style>
        body { font-family: 'Arial', sans-serif; margin: 0; padding: 0; background: linear-gradient(135deg, #1e3c72, #2a5298); color: #fff; }
        header { text-align: center; padding: 100px 20px; background: rgba(0,0,0,0.5); }
        h1 { font-size: 3em; margin: 0; animation: fadeIn 2s; }
        p { font-size: 1.5em; }
        .benefits { display: flex; flex-wrap: wrap; justify-content: center; padding: 50px 20px; }
        .benefit { background: rgba(255,255,255,0.1); border-radius: 10px; margin: 10px; padding: 20px; width: 300px; text-align: center; transition: transform 0.3s; }
        .benefit:hover { transform: scale(1.05); }
        .btn { background: #4CAF50; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-size: 1.2em; transition: background 0.3s; }
        .btn:hover { background: #45a049; }
        footer { text-align: center; padding: 20px; background: rgba(0,0,0,0.3); }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @media (max-width: 768px) { h1 { font-size: 2em; } p { font-size: 1.2em; } }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Coding Adventure</h1>
        <p>Learn coding interactively with fun challenges, just like Grasshopper!</p>
        <a href="signup.php" class="btn">Sign Up</a>
        <a href="login.php" class="btn" style="margin-left: 10px;">Login</a>
    </header>
    <section class="benefits">
        <div class="benefit">
            <h2>Beginner-Friendly</h2>
            <p>Start from scratch with easy exercises.</p>
        </div>
        <div class="benefit">
            <h2>Gamified Learning</h2>
            <p>Earn badges and track progress.</p>
        </div>
        <div class="benefit">
            <h2>Interactive Editor</h2>
            <p>Write and test code in real-time.</p>
        </div>
    </section>
    <footer>
        <p>&copy; 2025 Coding Adventure</p>
    </footer>
</body>
</html>
