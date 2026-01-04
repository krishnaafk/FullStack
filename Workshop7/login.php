<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $password = $_POST['password'];

    // Check if student exists [cite: 18]
    $stmt = $pdo->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->execute([$student_id]);
    $user = $stmt->fetch();

    // Verify hashed password [cite: 19, 20, 21]
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['logged_in'] = true; // Store session variable [cite: 23]
        $_SESSION['user_name'] = $user['full_name'];
        header("Location: dashboard.php"); // Redirect to dashboard [cite: 24]
    } else {
        echo "Invalid Credentials";
    }
}
?>
<form method="POST">
    <input type="text" name="student_id" placeholder="Student ID" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

