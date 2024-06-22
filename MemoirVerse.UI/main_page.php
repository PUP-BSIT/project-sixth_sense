<?php
require 'db_conn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You need to log in first.'); window.location.href = 'login.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["entry"]) && !empty($_POST["entry"])) {
        $entry = mysqli_real_escape_string($conn, $_POST["entry"]);
        $userId = $_SESSION['user_id'];
        $entryDate = date('Y-m-d H:i:s');
        $sql = "INSERT INTO diary_entries (user_id, entry, entry_date) VALUES ('$userId', '$entry', '$entryDate')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Diary entry saved successfully');</script>";
        } else {
            echo "<script>alert('Error: Could not save diary entry.');</script>";
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Interface</title>
    <link rel="stylesheet" href="./style/main_page.css" />
  </head>
  <body>
    <div class="container">

      <div class="sidebar">
        <div class="profile">
          <div class="profile-pic"></div>
          <span class="profile-name">Memories</span>
        </div>
        <div class="menu">
          <div class="menu-item active">Home</div>
          <div class="menu-item">Mood Tracker</div>
          <div class="menu-item">To do List</div>
          <div class="menu-item">Pinned</div>
        </div>
      </div>

      <div class="main">

        <div class="header">
          <a href="home-page.php">
            <button type="button" class="home-btn">Home Page</button>
          </a>
          <form action="login.php" method="post" class="logout-form">
            <button type="submit" class="logout-btn">Logout</button>
          </form>
        </div>

        <div class="content">

          <div class="sorting-buttons">
            <button id="sort_newest" class="sort-button">Sort by Newest</button>
            <button id="sort_oldest" class="sort-button">Sort by Oldest</button>
          </div>

          <div class="writing-box">
          <form id="entry_form" action="main-page.php" method="post" enctype="multipart/form-data">
  <textarea id="entry_input" name="entry" class="writing-input" placeholder="Start Writing Your Thoughts" required></textarea>
  <input type="file" id="entry_image" name="entry_image" accept="image/*">
  <button type="submit" class="save-entry-button">Save Entry</button>
</form>
          </div>

          <div id="entries_container"></div>
        </div>

        <div class="footer">
          <button class="more-pages-button">More Pages</button>
        </div>
        
      </div>
    </div>
    <script src="./script/main_page.js"></script>
  </body>
</html>