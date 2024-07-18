<?php
require 'db_conn.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MemoirVerse</title>
    <link rel="stylesheet" href="./style/entry_style.css">
</head>
<body>
    <header>
        <div class="header-left">
            <div class="user-profile">
                <img src="#" alt="Profile Picture" class="profile-pic">
                <span class="user-info">Jane Doe</span>
            </div>
        </div>
         <nav>
            <ul class="menu">
                <li><a href="./entry.php">Diary</a></li>
                <li><a href="./to_do_list.php">To do list</a></li>
                <li><a href="./chart.php">Chart</a></li>
                <li><a href="./letters.php">Letters from strangers</a></li>
            </ul>
            <div class="logout-logo">
                <a href="login.php" class="logout-button">Log Out</a>
            </div>
    </header>
    <main>
        <section class="diary-section">
            <h2>What's on your mind?</h2>
            <form id="entry_form" class="diary-entry" 
            enctype="multipart/form-data">
                <textarea id="entry_input" name="entry"
                 placeholder="Start Writing Your Thoughts"></textarea>
                <div class="form-controls">
                    <button type="submit" id="submitCombinedButton" 
                    class="diary-button">Submit</button>
                </div>
                <div class="form-controls">
                    <label for="entry_image"
                        class="custom-file-label">Upload a picture</label>
                    <input type="file" id="entry_image"
                        name="entry_image" class="custom-file-input"
                        accept="image/*">
                    <select name="mood" id="entry_mood" class="mood-dropdown">
                        <option value="">Choose Mood</option>
                        <option value="Happy">Happy</option>
                        <option value="Sad">Sad</option>
                        <option value="Excited">Excited</option>
                        <option value="Angry">Angry</option>
                        <option value="Nervous">Nervous</option>
                        <option value="Content">Content</option>
                    </select>
                </div>
                <span id="entry_image_name"></span>
            </form>
            <div class="sort-buttons">
                <button id="sort_newest"
                    class="diary-button sort-button">Sort by Newest</button>
                <button id="sort_oldest" 
                    class="diary-button sort-button">Sort by Oldest</button>
            </div>
            <div id="entries_container"></div>
        </section>
    </main>
    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01">
        <div id="caption"></div>
    </div>
    <script src="./entry_script.js"></script>
</body>
</html>
