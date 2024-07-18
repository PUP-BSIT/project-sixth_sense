<?php
require 'db_conn.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function sanitize_input($data)
{
    return htmlspecialchars($data);
}

$message = "";
$redirect = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = sanitize_input($_POST["email"]);
        $password = sanitize_input($_POST["password"]);

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user["password"])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['first_name'] = $user['firstName'];
                $message = "Login successful";
                $redirect = "home_page.php";
            } else {
                $message = "Invalid password";
            }
        } else {
            $message = "No user found with this email";
        }

        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./style/login.css">
</head>

<body>
    <div class="login-container">
        <div class="header">
            <h1>Welcome to MemoirVerse!</h1>
            <p>Sign in to continue</p>
        </div>
        <div class="form">
            <form action="login.php" method="post">
                <input type="text" name="email"
                       placeholder="Email" 
                       class="input-field" required>
                <input type="password" name="password" 
                       placeholder="Password"
                       class="input-field" required>
                <button type="submit" class="login-button">Sign In</button>
            </form>
        </div>
        <div class="footer">
            <p>Don't have an account? Create one!
                 <a href="signup.php">Register Here</a></p>
        </div>
    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-icon">&#10003;</div>
            <p id="modal-message"></p>
        </div>
    </div>

    <script>
        function showModal(message, redirect = null) {
            document.getElementById('modal-message').innerText = message;
            const modal = document.getElementById('modal');
            modal.style.display = 'block';

            document.querySelector('.close').onclick = function () {
                modal.style.display = 'none';
                if (redirect) {
                    window.location.href = redirect;
                }
            };

            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                    if (redirect) {
                        window.location.href = redirect;
                    }
                }
            };
        }

        <?php if (!empty($message)): ?>
            showModal('<?php echo $message; ?>', '<?php echo $redirect; ?>');
        <?php endif; ?>
    </script>
</body>

</html>