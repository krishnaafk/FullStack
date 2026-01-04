<?php
include "db.php";

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    mysqli_query($conn, "INSERT INTO users (name, email) VALUES ('$name', '$email')");
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    mysqli_query($conn, "UPDATE users SET name='$name', email='$email' WHERE id=$id");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
}

$edit = false;
$name = "";
$email = "";
$id = "";

if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $email = $row['email'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Simple CRUD App</h2>

    <form method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="text" name="name" placeholder="Name" value="<?php echo $name; ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>

        <?php if ($edit): ?>
            <button type="submit" name="update">Update</button>
        <?php else: ?>
            <button type="submit" name="save">Save</button>
        <?php endif; ?>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>

        <?php
        $result = mysqli_query($conn, "SELECT * FROM users");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>
                        <a href='index.php?edit={$row['id']}'>Edit</a> |
                        <a href='index.php?delete={$row['id']}'>Delete</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
