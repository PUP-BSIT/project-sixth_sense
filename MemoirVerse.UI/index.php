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

        <button class="signin-btn github">
          <svg class="github-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 
          18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665
          -.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 
          2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896
          -.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12" fill="#ffffff"/>
      </svg>GitHub</button>

        <button class="signin-btn google">
          <svg class="google-icon" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
              <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 4.63C12.43 13.72 17.74 9.5 24 9.5z"/>
              <path fill="#4285F4" d="M46.98 24.55c0-1.57-.14-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
              <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-4.63c-1.59 3.05-2.51 6.57-2.51 10.22 0 3.65.92 7.17 2.51 10.22l7.98-4.63z"/>
              <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 4.63c4.04 7.84 12.67 13.79 22.45 13.79z"/>
              <path fill="none" d="M0 0h48v48H0z"/>
          </svg>
          Google
      </button>

        <button class="signin-btn facebook">Facebook</button>

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