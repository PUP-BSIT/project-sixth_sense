<?php
require 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'db_conn.php';
    $email = sanitize_input($_POST["email"]);
    $lastName = sanitize_input($_POST["lastName"]);
    $firstName = sanitize_input($_POST["firstName"]);
    $password = password_hash(sanitize_input($_POST["password"]), PASSWORD_DEFAULT);
    $dob = sanitize_input($_POST["dob"]);

    $sql = "INSERT INTO users (email, lastName, firstName, password, dob) 
    VALUES ('$email', '$lastName', '$firstName', '$password', '$dob')";

    if ($conn->query($sql) === TRUE) {
      echo "<script>alert('New record created successfully');</script>";
  } else {
      echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');
      </script>";
  }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MemoirVerse Registration</title>
  <link rel="stylesheet" href="style/signup.css"/>
</head>

<body>
  <div class="container">
    <div class="form-section">
      <form action="signup.php" method="post">
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="lastName" placeholder="Last Name" required>
    <input type="text" name="firstName" placeholder="First Name" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="date" name="dob" placeholder="Date of Birth" required>
    <button type="submit" class="submit-btn">
        <span class="submit-text">Register</span>
    </button>

    <button type="button" class="submit-btn"
     onclick="window.location.href='login.php'">
    <span class="submit-text">Back to Login</span>
    </button>
</form>
    </div>
    <div class="welcome-section">
      <h1>MemoirVerse Registration</h1>
      <p>Enter your personal details to use all of site features.</p>
    </div>
  </div>
</body>

</html>