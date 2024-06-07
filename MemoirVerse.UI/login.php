<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MemoirVerse Login</title>
    <link rel="stylesheet" href="./index.css"/>
  </head>
  <body>
    <div class="container">
      <div class="signin-section">
        <h2>Login</h2>
        <form action="login_process.php" method="post">
          <input type="text" name="username" placeholder="Username" required/>
          <input
            type="password"
            name="password"
            placeholder="Password"
            required/>
          <button type="submit" class="signin-btn github">Login</button>
        </form>
        <p class="login-link">
             Don't have an account?
          <a href="signup.php">Sign Up</a>
        </p>
      </div>
    </div>
  </body>
</html>
