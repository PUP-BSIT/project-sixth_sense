<?php
require 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = sanitize_input($_POST["email"]);
        $password = sanitize_input($_POST["password"]);

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user["password"])) {
                echo "<script>alert('Login successful');</script>";
                header("Location: main-page.php");
                exit();
            } else {
                echo "<script>alert('Invalid password');</script>";
            }
        } else {
            echo "<script>alert('No user found with this email');</script>";
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MemoirVerse Login</title>
    <link rel="stylesheet" href="./login.css">
</head>
<body>
    <div class="container">
        <div class="welcome-section">
            <h1>Welcome to MemoirVerse!</h1>
            <p>Enter your personal details to use all of site features.</p>
        </div>
        <div class="login-section">
            <h2>Sign in</h2>
            <form id="login_form" 
            action="login.php" 
            method="post">
            <input type="email" 
            id="email" 
            name="email" 
             placeholder="Email" 
            required>
            <input type="password" 
           id="password" 
           name="password" 
           placeholder="Password" 
           required>
            <button type="submit" 
            class="btn login-btn">Sign in</button>
            </form>

            <p>Don't have an account? Create one! 
                <a href="signup.php"> Register Here</a></p>
        </div>
    </div>
    <script src="login.js"></script>
</body>
</html>
