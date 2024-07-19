<?php 
require 'db_conn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Letters from Stranger</title>
    <link rel="stylesheet" href="./letters.css">
</head>
<body>
    <header>
        <div class="header-left">
            <img src="./assets/logo.png" alt="Logo" class="logo">
        </div>

        <nav>
            <ul class="menu">
                <li><a href="./home_page.php">Home</a></li>
                <li><a href="./entry.php">Diary</a></li>
                <li><a href="./to_do_list.html">To do list</a></li>
                <li><a href="./chart.php">Chart</a></li>
                <li><a href="./letters.php">Letters from strangers</a></li>
            </ul>
            <div class="logout-logo">
                <a href="login.php" class="logout-button">Log Out</a>
            </div>
        </nav>
    </header>

    <div class="main-content">
        <div class="image-container left">
            <img src="./assets/heart.svg" alt="Heart Image">
        </div>

        <div class="container">
            <h1>Letters from Strangers</h1>
            <form id="letterForm">
                <input type="text" id="title" name="title" 
                  placeholder="Title" required>

                <textarea id="content" name="content" 
                  placeholder="Your letter" required>
                </textarea>

                <button type="submit">Submit</button>
            </form>
            <div id="message"></div>
        </div>

        <div class="image-container right">
            <img src="./assets/two-people.svg" alt="Two People Image">
        </div>
    </div>

    <div id="letters" class="letters-container">
        <div class="letter">
            <div class="closed-envelope" style="display: block;">
                <h2 class="title">Title of the Letter</h2>
                <div class="click-message">Click to open a message</div>
            </div>
            
            <div class="open-letter" style="display: none;">
                <h2>Title of the Letter</h2>
                <p>Content of the letter goes here...</p>
                <div class="timestamp">2024-07-17 21:52:12</div>
            </div>
        </div>
    </div>
    
    <script src="./letters.js"></script>
</body>
</html>