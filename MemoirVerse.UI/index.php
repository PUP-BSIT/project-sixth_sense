<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MemoirVerse Sign In</title>
    <link rel="stylesheet" href="./index.css" />
  </head>
  <body>
    <div class="container">
      <div class="welcome-section">
        <h1>Welcome to MemoirVerse!</h1>
        <p>Enter your personal details to use all of site features.</p>
      </div>
      <div class="signin-section">
        <h2>Sign in</h2>
        <button class="signin-btn github">GITHUB</button>
        <button class="signin-btn google">GOOGLE</button>
        <button class="signin-btn facebook">FACEBOOK</button>
        <div class="separator">or</div>
        <button
          class="create-account-btn"
          onclick="window.location.href='signup.php'">Create Account</button>
        <p class="login-link">
          Already have an account? <a href="login.php">Log in</a>
        </p>
      </div>
    </div>
  </body>
</html>
