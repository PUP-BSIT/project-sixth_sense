<?php
require 'db_conn.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function sanitize_input($data) {
    return htmlspecialchars($data);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = sanitize_input($_POST["email"]);
        $password = sanitize_input($_POST["password"]);

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user["password"])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['first_name'] = $user['firstName'];
                echo "<script>alert('Login successful'); window.location.href = 'home_page.php';</script>";
                exit();
            } else {
                echo "<script>alert('Invalid password');</script>";
            }
        } else {
            echo "<script>alert('No user found with this email');</script>";
        }

        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./style/login.css">
</head>
<body>
    <div class="login-container">
        <div class="header">
            <h1>Welcome to MemoirVerse!</h1>
            <p>Sign in to continue</p>
        </div>
        <div class="form">
            <form action="login.php" method="post">
                <input type="text" name="email" placeholder="Email" class="input-field" required>
                <input type="password" name="password" placeholder="Password" class="input-field" required>
                <button type="submit" class="login-button">Sign In</button>
            </form>
        </div>
        <div class="footer">
            <p>Don't have an account? Create one! <a href="signup.php">Register Here</a></p>
        </div>
    </div>
</body>
</html>
