<?php

if (!file_exists('db_conn.php')) {
    die("Database connection file is missing.");
}

include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (email, firstName, lastName, age, gender, password, dob) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("sssssss", $email, $firstName, $lastName, $age, $gender, $password, $dob);
        if ($stmt->execute()) {
            echo "<script>alert('Signup successful.'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Signup failed: " . $stmt->error . "'); window.location.href = 'signup.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Signup failed: Could not prepare statement. " . $conn->error . "'); window.location.href = 'signup.php';</script>";
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
    <script src="signup.js" defer></script>
</head>
<body>
    <div class="signup-container">
        <div class="header">
            <h1>Create an Account</h1>
            <p>Sign up to get started</p>
        </div>
        <div class="form">
            <form id="signup-form" action="signup.php" method="POST">
                <input type="email" name="email"
                  placeholder="Email" class="input-field" required>
                <input type="text" name="firstName"
                  placeholder="First Name" class="input-field" required>
                <input type="text" name="lastName" 
                  placeholder="Last Name" class="input-field" required>
                <input type="number" name="age" 
                  placeholder="Age" class="input-field" required>
                <input type="text" name="gender" 
                  placeholder="Gender" class="input-field" required>
                <input type="password" name="password" id="password" 
                  placeholder="Password" class="input-field" required>
                <input type="password" name="confirmPassword" 
                  id="confirmPassword" placeholder="Confirm Password"
                  class="input-field" required>
                <label for="dob" class="dob-label">Date of Birth:</label>
                <input type="date" name="dob" placeholder="Date of Birth"
                  class="input-field" required>
                <button type="submit" class="signup-button">Sign Up</button>
            </form>
        </div>
        <div class="footer">
            <p>Already have an account? <a href="login.php">Log In Here</a></p>
        </div>
    </div>
</body>
</html>
