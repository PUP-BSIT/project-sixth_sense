<?php
require_once 'db_conn.php';

$errorMsg = "Sorry, Unable to Connect";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = sanitize_input($_POST["email"]);
  $lastName = sanitize_input($_POST["lastName"]);
  $firstName = sanitize_input($_POST["firstName"]);
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
  $dob = sanitize_input($_POST["dob"]);

  $checkEmailQuery = "SELECT id FROM users WHERE email = '$email'";
  $result = $conn->query($checkEmailQuery);
  if ($result->num_rows > 0) {
    $errorMsg = "Email already registered. Please use a different email.";
  } else {
    $sql = "INSERT INTO users 
              (email, last_name, first_name, password_hash, date_of_birth) 
            VALUES ('$email','$lastName','$firstName','$password','$dob')";

    if ($conn->query($sql) === TRUE) {
      header("Location: login.php?success=1");
      exit();
    } else {
      $errorMsg = "Error: " . $conn->error;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MemoirVerse Registration</title>
  <link rel="stylesheet" href="./signup.css" />
</head>

<body>
  <div class="container">
    <div class="form-section">
      <form>
        <input type="email" placeholder="Email" required>
        <input type="text" placeholder="Last Name" required>
        <input type="text" placeholder="First Name" required>
        <input type="password" placeholder="Password" required>
        <input type="date" placeholder="Date of Birth" required>
        <button type="submit" class="submit-btn">
          <span class="submit-text">Register</span>
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