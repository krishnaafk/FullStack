<?php

$conn = mysqli_connect('localhost','root','','library_db');
if(!$conn){ die('Connection failed'); }

include 'db.php';
$sql = "INSERT INTO books VALUES(NULL,'$_POST[title]','$_POST[author]','$_POST[category]','$_POST[quantity]')";
mysqli_query($conn,$sql);
?>

<html>
    <form action='add_book.php' method='post'>
<input type='text' name='title'>
<input type='text' name='author'>
<input type='text' name='category'>
<input type='number' name='quantity'>
<button>Add Book</button>
</form>
</html>