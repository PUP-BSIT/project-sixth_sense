<?php
require 'db_conn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["entry"])) {
        $entry = sanitize_input($_POST["entry"]);
        $userId = 1;
        $sql = "INSERT INTO diary_entries (user_id, entry) VALUES ('$userId', '$entry')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Diary entry saved successfully');</script>";
        } else {
            echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Interface</title>
    <link rel="stylesheet" href="./main-page.css"/>
  </head>
  <body>
    <div class="container">
      <div class="sidebar">
        <div class="profile">
          <div class="profile-pic"></div>
          <span class="profile-name">MemoirVerse Team!</span>
        </div>
        <div class="menu">
  <div class="menu-item active">Home</div>
  <div class="menu-item">Mood Tracker</div>
  <div class="menu-item">To do List</div>
  <div class="menu-item">Pinned</div>
  <div class="menu-item">
    
  </div>
</div>
      <div class="main">
        <div class="header">
          <input type="text" class="search-bar" placeholder="Search"/>
        </div>
        <div class="content">
          <div class="writing-box">
            <input
              type="text"
              class="writing-input"
              placeholder="Start Writing Your Thoughts"/>
          </div>
          <div class="color-palette">
            <div class="color color1"></div>
            <div class="color color2"></div>
            <div class="color color3"></div>
            <div class="color color4"></div>
            <div class="color color5"></div>
            <div class="color color6"></div>
          </div>
        </div>
        <div class="footer">
          <button class="more-pages-button">More Pages</button>
          <div class="button-container">
          <a href="home-page.php">
    <button type="submit" class="home-btn">Home Page</button>
         </div>

          <form action="login.php" method="post">
      <button type="submit" class="logout-btn">Logout</button>
    </form>
        </div>
      </div>
    </div>
    <div class="diary-container">
  <div class="diary">
    <h2>Write here</h2>
    <form action="save_entry.php" method="post">
      <textarea name="entry" placeholder="Your diary entry..." required></textarea>
      <button type="submit">Save Entry</button>
    </form>
  </div>
</div>
  </body>
</html>
