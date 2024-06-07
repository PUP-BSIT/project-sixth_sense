<?php
require_once 'db_conn.php';

$errorMsg = "Sorry, Unable to Connect";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize_input($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['first_name'] ."".$user['last_name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $errorMsg = "Invalid email or password";
        }
    } else {
        $errorMsg = "Invalid email or password";
    }
}

$registrationSuccess = isset($_GET['success']) && $_GET['success'] == 1;
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
            <form id="login_form">
                <input type="email" id="email" placeholder="Email" required>
                <input type="password" id="password" 
                    placeholder="Password" required>
                <button type="submit" class="btn login-btn">Sign in</button>
            </form>

            <p>Don't have an account? Create one! 
                <a href="signup.php"> Registration Now!</a></p>
        </div>
    </div>
    <script src="login.js"></script>
</body>
</html>
