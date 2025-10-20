<?php
// File: challenge.php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}
$user_id = $_SESSION['user_id'];
$challenge_id = $_GET['id'];

$sql = "SELECT * FROM challenges WHERE id = $challenge_id";
$challenge = $conn->query($sql)->fetch_assoc();

$sql_progress = "SELECT * FROM progress WHERE user_id = $user_id AND challenge_id = $challenge_id";
$progress = $conn->query($sql_progress)->fetch_assoc();
$completed = $progress ? $progress['completed'] : false;
$attempts = $progress ? $progress['attempts'] : 0;

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $challenge['title']; ?> - Coding Adventure</title>
    <style>
        body { font-family: 'Arial', sans-serif; margin: 0; padding: 0; background: linear-gradient(135deg, #1e3c72, #2a5298); color: #fff; }
        header { text-align: center; padding: 20px; background: rgba(0,0,0,0.5); }
        .editor { display: flex; flex-direction: column; align-items: center; padding: 20px; }
        textarea { width: 80%; height: 200px; background: #fff; color: #000; padding: 10px; border-radius: 5px; font-family: monospace; }
        button { background: #4CAF50; color: white; padding: 10px 20px; margin: 10px; border: none; border-radius: 5px; cursor: pointer; transition: background 0.3s; }
        button:hover { background: #45a049; }
        #output { background: rgba(255,255,255,0.1); width: 80%; padding: 20px; border-radius: 10px; margin-top: 20px; }
        #hint, #solution { display: none; background: rgba(0,0,0,0.5); padding: 10px; border-radius: 5px; margin: 10px; }
        .back { display: block; text-align: center; margin: 20px; background: #2196F3; padding: 10px; border-radius: 5px; width: 200px; margin: 20px auto; color: #fff; text-decoration: none; }
        @media (max-width: 768px) { textarea, #output { width: 90%; } }
    </style>
</head>
<body>
    <header>
        <h1><?php echo $challenge['title']; ?></h1>
        <p><?php echo $challenge['description']; ?></p>
    </header>
    <section class="editor">
        <textarea id="code"><?php echo $challenge['code_template']; ?></textarea>
        <button onclick="runCode()">Run Code</button>
        <button onclick="showHint()">Show Hint</button>
        <button onclick="showSolution()">Show Solution</button>
        <div id="hint"><?php echo $challenge['hint']; ?></div>
        <div id="solution"><?php echo htmlspecialchars($challenge['solution']); ?></div>
        <div id="output"></div>
    </section>
    <a href="lesson.php?id=<?php echo $challenge['lesson_id']; ?>" class="back">Back to Lesson</a>
    <script>
        function runCode() {
            const code = document.getElementById('code').value;
            const output = document.getElementById('output');
            output.innerHTML = '';
            try {
                eval(code);
                const testResult = eval('<?php echo $challenge['test_code']; ?>');
                if (testResult) {
                    output.innerHTML = 'Success! Challenge completed.';
                    output.style.color = 'green';
                    updateProgress();
                } else {
                    output.innerHTML = 'Test failed. Try again.';
                    output.style.color = 'red';
                }
            } catch (e) {
                output.innerHTML = 'Error: ' + e.message;
                output.style.color = 'red';
            }
        }

        function updateProgress() {
            fetch('update_progress.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'challenge_id=<?php echo $challenge_id; ?>'
            }).then(response => response.text())
              .then(data => {
                  if (data === 'updated') {
                      // Optional: redirect or refresh
                  }
              });
        }

        function showHint() {
            document.getElementById('hint').style.display = 'block';
        }

        function showSolution() {
            document.getElementById('solution').style.display = 'block';
        }
    </script>
</body>
</html>
