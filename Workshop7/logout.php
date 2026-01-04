<?php
session_start();
session_destroy(); // Destroy session [cite: 32, 33]
header("Location: login.php");
?>