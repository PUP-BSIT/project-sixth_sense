<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MemoirVerse Sign Up</title>
    <link rel="stylesheet" href="./index.css" />
  </head>
  <body>
    <div class="container">
      <div class="signin-section">
        <h2>Sign Up</h2>
        <form action="signup_process.php" method="post">
          <input type="text" name="username" placeholder="Username" required/>
          <input
            type="password"
            name="password"
            placeholder="Password"
            required/>
          <button type="submit" class="signin-btn">Sign Up</button>
        </form>
        <p class="login-link">
          Already have an account?
          <a href="index.php">Log in</a>
        </p>
      </div>
    </div>
  </body>
</html>