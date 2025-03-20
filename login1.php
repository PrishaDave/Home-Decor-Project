<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Assume your admin username and password is hardcoded
    // Ideally, these should come from a database
    $admin_username = "admin";
    $admin_password = "adminpassword"; // Change this to a hashed password in a real system

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_panel.html'); // Redirect to the admin panel
        exit;
    } else {
        echo "Invalid credentials!";
    }
}
?>

<!-- HTML for Login Page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>

<h2>Admin Login</h2>
<form method="POST" action="login.php">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>

</body>
</html>
