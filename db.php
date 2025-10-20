<?php
// File: db.php
$servername = "localhost"; // Assuming localhost, change if needed
$username = "uiumzmgo1eg2q";
$password = "kuqi5gwec3tv";
$dbname = "dbjsy9nv4gbh67";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
