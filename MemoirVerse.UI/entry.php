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

    <main>
        <section class="diary-section">
            <h2>What's on your mind?</h2>
            <form id="entry_form" class="diary-entry" 
                enctype="multipart/form-data">
                <div class="textarea-container">
                    <textarea id="entry_input" name="entry"
                      placeholder="Start Writing Your Thoughts"></textarea>
                    <button type="submit" id="submitCombinedButton"
                     class="submit-button">Submit</button>
                    <div class="embedded-controls">
                        <label for="entry_image"
                         class="custom-file-label">Upload a picture</label>
                        <input type="file" id="entry_image" name="entry_image"
                         class="custom-file-input"
                            accept="image/*">
                        <span id="entry_image_name" 
                        class="entry-image-name"></span>

                        <select name="mood" 
                            id="entry_mood" class="mood-dropdown">
                            <option value="">Choose Mood</option>
                            <option value="Happy">Happy</option>
                            <option value="Sad">Sad</option>
                            <option value="Excited">Excited</option>
                            <option value="Angry">Angry</option>
                            <option value="Nervous">Nervous</option>
                            <option value="Content">Content</option>
                        </select>
                    </div>
                </div>
            </form>
        </section>

        <section class="entries-section">
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

    <div id="editModal" class="edit-modal">
        <div class="edit-modal-content">
            <span class="edit-close">&times;</span>
            <h2>Edit Entry</h2>
            <textarea id="editEntryInput"></textarea>
            <button id="saveEditButton">Save</button>
        </div>
    </div>

    <div id="deleteModal" class="edit-modal">
        <div class="edit-modal-content">
            <span class="edit-close" id="deleteClose">&times;</span>
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this entry?</p>
            <button id="confirmDeleteButton">Delete</button>
            <button id="cancelDeleteButton">Cancel</button>
        </div>
    </div>


    <script src="./entry_script.js"></script>
</body>

</html>