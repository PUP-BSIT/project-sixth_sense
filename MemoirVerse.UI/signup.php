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

    $stmt = $conn->prepare("INSERT INTO users (email, firstName, lastName, password, dob) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $firstName, $lastName, $password, $dob);

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
            <h1>Create an Account</h1>
            <p>Sign up to get started</p>
        </div>

        <div class="form">
            <form method="POST" onsubmit="return validateForm()">
                <input type="email" id="email" name="email" 
                  placeholder="Email" class="input-field" required>

                <input type="text" id="first-name" name="firstName" 
                  placeholder="First Name" class="input-field" required>

                <input type="text" id="last-name" name="lastName" 
                  placeholder="Last Name" class="input-field" required>

                <input type="number" id="age" name="age" 
                  placeholder="Age" class="input-field" required>

                <input type="text" id="gender" name="gender" 
                  placeholder="Gender" class="input-field" required>

                <input type="password" id="password" name="password" 
                  placeholder="Password" class="input-field" 
                  autocomplete="new-password" required>

                <input type="password" id="confirm-password" 
                  placeholder="Confirm Password" class="input-field" 
                  autocomplete="new-password" required>

                <label for="dob" class="dob-label">Date of Birth:</label>
                <input type="date" id="dob" name="dob" 
                  class="input-field" required>
                  
                <button type="submit" class="signup-button">Sign Up</button>
            </form>
        </div>
        <div id="error-message"></div>
        <div class="footer">
            <p>Already have an account? <a href="login.php">Log In Here</a></p>
        </div>
    </div>
    <script src="./script/signup_validation.js"></script>
</body>
</html>
