<?php
$errors = [];
$success = "";
$name = "";
$email = "";

// When form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get form values
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm = $_POST["confirm_password"] ?? "";

    // Simple validation
    if ($name === "") {
        $errors['name'] = "Name is required.";
    }
    if ($email === "") {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }
    if ($password === "") {
        $errors['password'] = "Password is required.";
    }
    if ($confirm === "") {
        $errors['confirm'] = "Please confirm your password.";
    }
    if ($password !== "" && $confirm !== "" && $password !== $confirm) {
        $errors['confirm'] = "Passwords do not match.";
    }

    // If no errors → Save data
    if (empty($errors)) {

        $file = "users.json";

        // Create file if not exists
        if (!file_exists($file)) {
            file_put_contents($file, "[]");
        }

        // Read existing users
        $users = json_decode(file_get_contents($file), true);

        // Check duplicate email
        foreach ($users as $u) {
            if ($u["email"] === $email) {
                $errors["email"] = "Email already registered.";
                break;
            }
        }

        if (empty($errors)) {
            // Hash password
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // Create new user
            $newUser = [
                "name" => $name,
                "email" => $email,
                "password" => $hashed
            ];

            // Add user to array
            $users[] = $newUser;

            // Save back to JSON
            file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));

            $success = "Registration successful!";
            $name = "";
            $email = "";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<style>
body{font-family:Arial;padding:20px;max-width:500px;margin:auto}
.error{color:red;font-size:14px}
.success{color:green;font-size:16px;margin-bottom:10px}
input{width:100%;padding:8px;margin:5px 0}
button{padding:10px 15px;background:#007bff;border:none;color:#fff;cursor:pointer}
</style>
</head>
<body>

<h2>User Registration</h2>

<?php if ($success): ?>
    <div class="success"><?= $success ?></div>
<?php endif; ?>

<form method="post">

<label>Name</label>
<input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
<div class="error"><?= $errors['name'] ?? "" ?></div>

<label>Email</label>
<input type="email" name="email" value="<?= htmlspecialchars($email) ?>">
<div class="error"><?= $errors['email'] ?? "" ?></div>

<label>Password</label>
<input type="password" name="password">
<div class="error"><?= $errors['password'] ?? "" ?></div>

<label>Confirm Password</label>
<input type="password" name="confirm_password">
<div class="error"><?= $errors['confirm'] ?? "" ?></div>

<button type="submit">Register</button>
</form>

</body>
</html>
 