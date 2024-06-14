<?php
require 'db_conn.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["entry"]) && !empty($_POST["entry"])) {
        $entry = mysqli_real_escape_string($conn, $_POST["entry"]);
        $userId = $_SESSION['user_id'];
        $sql = "INSERT INTO diary_entries (user_id, entry)
         VALUES ('$userId', '$entry')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Diary entry saved successfully');</script>";
        } else {
            echo "<script>alert('Error: Could not save diary entry.');
            </script>";
        }
    }
    $conn->close();
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
                <input type="text" class="search-bar" 
                 placeholder="Sorting"/>
            </div>
            <div class="content">
                <div class="writing-box">
                    <form action="main-page.php" method="post">
                        <textarea name="entry" class="writing-input" 
                        placeholder="Start Writing Your Thoughts" 
                        required></textarea>
                        <button type="submit" class="save-entry-button">
                         Save Entry</button>
                    </form>
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
                        <button type="submit" class="home-btn">
                         Home Page</button>
                    </a>
                </div>
                <form action="login.php" method="post">
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
