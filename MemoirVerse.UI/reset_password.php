<?php

$conn = new mysqli('hostname', 'username', 'password', 'database');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $newPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $tokenHash = hash('sha256', $token);

    $stmt = $conn->prepare("SELECT id, reset_token_expires_at FROM users WHERE reset_token_hash = ?");
    $stmt->bind_param("s", $tokenHash);
    $stmt->execute();
    $stmt->bind_result($userId, $tokenExpiration);
    $stmt->fetch();

    if ($userId && new DateTime($tokenExpiration) > new DateTime()) {
        $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = ?");
        $stmt->bind_param("si", $newPassword, $userId);
        $stmt->execute();

        echo "Your password has been reset successfully.";
    } else {
        echo "Invalid or expired token.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="reset_password.php" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
        <input type="password" name="password" placeholder="Enter your new password" required>
        <button type="submit">Reset Password</button>
    </form>

</body>

</html>