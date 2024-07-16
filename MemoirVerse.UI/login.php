<?php
require 'db_conn.php';
require 'functions.php';
session_start();

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
            }
            } else {
                echo "<script>alert('Invalid password');</script>";
            }
        } else {
            echo "<script>alert('No user found with this email');</script>";
        }

        $stmt->close();
        $conn->close();
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
            <input type="text" placeholder="Username" class="input-field">
            <input type="password" placeholder="Password" class="input-field">
            <button class="login-button">Sign In</button>
        </div>
        <div class="footer">
            <p>Don't have an account? Create one! <a href="#">Register Here</a></p>
        </div>
    </div>
</body>
</html>
