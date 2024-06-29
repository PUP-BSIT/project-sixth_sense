<?php
// request_reset.php

if (!file_exists('db_conn.php')) {
    die("Database connection file is missing.");
}

include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $secretCode = $_POST['secretCode'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Check if email and secret code match
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND secret_code = ?");
    $stmt->bind_param("ss", $email, $secretCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Update password
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $new_password, $email);
        $stmt->execute();

        echo "Your password has been reset successfully.";
    } else {
        echo "Invalid email or secret code.";
    }
}
?>

<!-- request_reset.html -->
<form action="request_reset.php" method="post">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <label for="secretCode">Secret Code:</label>
    <input type="text" name="secretCode" id="secretCode" required>
    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" id="new_password" required>
    <button type="submit">Reset Password</button>
</form>
