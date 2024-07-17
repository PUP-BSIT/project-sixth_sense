<?php
session_start();
$welcomeName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : "MemoirVerse";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MemoirVerse</title>
    <link rel="stylesheet" href="./style/home_page.css">
</head>
<body>
    <header>
        <div class="header-left">
            <div class="user-profile">
                <img src="profile.jpg" alt="Profile Picture" class="profile-pic">
                <span class="user-info">Jane Doe</span>
            </div>
        </div>
        <nav>
            <ul class="menu">
                <li><a href="./entry.php">Diary</a></li>
                <li><a href="./to_do_list.html">To do list</a></li>
                <li><a href="./chart.html">Chart</a></li>
                <li><a href="./letters.html">Letters from strangers</a></li>
            </ul>
            <div class="logout-logo">
                <a href="login.php" class="logout-button">Log Out</a>
            </div>
            <img src="./pictures/logo.png" alt="Logo" class="logo">
        </nav>
    </header>
    <main>
        <h1>Welcome "name ng user"!</h1>
        <p>Explore, reflect, and document your life's adventures in the MemoirVerse!</p>
        <div class="features">
            <div class="feature-box">Keep track of your daily thoughts and experiences.</div>
            <div class="feature-box">Monitor your emotions and well-being over time.</div>
            <div class="feature-box">Track your tasks and process throughout the day.</div>
            <div class="feature-box">Gain insights into your emotional well-being by charting your moods over time.</div>
        </div>
    </main>
</body>
</html>