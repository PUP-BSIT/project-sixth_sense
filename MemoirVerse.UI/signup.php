<?php

if (!file_exists('db_conn.php')) {
    die("Database connection file is missing.");
}

include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $dob = $_POST['dob'];
    $secretCode = $_POST['secretCode'];

    $stmt = $conn->prepare("INSERT INTO users (email, firstName, lastName, password, dob, secret_code) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $email, $firstName, $lastName, $password, $dob, $secretCode);

    if ($stmt->execute()) {
        echo "<script>alert('Signup successful.'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Signup failed: " . $stmt->error . "'); window.location.href = 'signup.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="./style/signup.css">
</head>
<body>
    <div class="signup-container">
        <div class="header">
            <h1>Sign Up</h1>
            <p>Create your account</p>
        </div>
        <form class="form" action="signup_process.php" method="post">
            <input type="text" name="username" class="input-field" placeholder="Username" required>
            <input type="email" name="email" class="input-field" placeholder="Email" required>
            <input type="password" name="password" class="input-field" placeholder="Password" required>
            <button type="submit" class="signup-button">Sign Up</button>
        </form>
    </div>
</body>
</html>