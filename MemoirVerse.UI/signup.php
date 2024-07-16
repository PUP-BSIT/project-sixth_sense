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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="./style/signup.css">
</head>
<body>
    <div class="signup-container">
        <div class="header">
            <h1>Create an Account</h1>
            <p>Sign up to get started</p>
        </div>
        <div class="form">
            <input type="email" placeholder="Email" class="input-field">
            <input type="text" placeholder="First Name" class="input-field">
            <input type="text" placeholder="Last Name" class="input-field">
            <input type="age" placeholder="Age" class="input-field">
            <input type="gender" placeholder="Gender" class="input-field">
            <input type="password" placeholder="Password" class="input-field">
            <label for="dob" class="dob-label">Date of Birth:</label>
            <input type="date" placeholder="Date of Birth" class="input-field">
            <button class="signup-button">Sign Up</button>
        </div>
        <div class="footer">
            <p>Already have an account? <a href="index.html">Sign In Here</a></p>
        </div>
    </div>
</body>
</html>