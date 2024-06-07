<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MemoirVerse Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <div class="welcome-section">
            <h1>Welcome to MemoirVerse!</h1>
            <p>Enter your personal details to use all of site features.</p>
        </div>
        <div class="login-section">
            <h2>Sign in</h2>
            <form id="login-form">
                <input type="email" id="email" placeholder="Email" required>
                <input type="password" id="password" placeholder="Password" required>
                <button type="submit" class="btn login-btn">Sign in</button>
            </form>

            <p>Don't have an account? Create one! <a href="#"> Registration Now!</a></p>
        </div>
    </div>
    <script src="login.js"></script>
</body>
</html>
