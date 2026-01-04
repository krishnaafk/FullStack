<?php
session_start();
// Redirect to login if not logged in [cite: 27, 28]
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

// Read cookie for theme; default to "light" [cite: 29, 30]
$theme = $_COOKIE['theme'] ?? 'light';
?>

<html>
<head>
    <style>
        body { 
            background-color: <?php echo ($theme == 'dark') ? '#333' : '#fff'; ?>; 
            color: <?php echo ($theme == 'dark') ? '#fff' : '#000'; ?>; 
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['user_name']; ?>!</h1>
    <nav>
        <a href="preference.php">Change Theme</a> | 
        <a href="logout.php">Logout</a> </nav>
</body>
</html>