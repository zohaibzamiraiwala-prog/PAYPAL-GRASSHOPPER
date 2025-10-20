<?php
// File: signup.php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($sql)) {
        echo "Signup successful! Redirecting...";
        echo "<script>window.location.href = 'login.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Coding Adventure</title>
    <style>
        body { font-family: 'Arial', sans-serif; margin: 0; padding: 0; background: linear-gradient(135deg, #1e3c72, #2a5298); color: #fff; display: flex; justify-content: center; align-items: center; height: 100vh; }
        form { background: rgba(255,255,255,0.1); padding: 40px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.2); width: 300px; }
        input { display: block; width: 100%; padding: 10px; margin: 10px 0; border: none; border-radius: 5px; }
        button { background: #4CAF50; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; width: 100%; transition: background 0.3s; }
        button:hover { background: #45a049; }
        a { color: #fff; text-decoration: none; display: block; text-align: center; margin-top: 10px; }
        @media (max-width: 768px) { form { width: 90%; } }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Sign Up</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
        <a href="login.php">Already have an account? Login</a>
    </form>
</body>
</html>
