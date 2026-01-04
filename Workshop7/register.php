<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $full_name = $_POST['full_name'];
    // Implement password hashing [cite: 13, 14]
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Use Prepared statements to add student [cite: 15]
    $stmt = $pdo->prepare("INSERT INTO students (student_id, full_name, password_hash) VALUES (?, ?, ?)");
    if ($stmt->execute([$student_id, $full_name, $password])) {
        header("Location: login.php"); // Redirect after success [cite: 16]
    }
}
?>

<form method="POST">
    <input type="text" name="student_id" placeholder="Student ID" required>
    <input type="text" name="full_name" placeholder="Full Name" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>

