<?php
 require 'db_conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" href="./style/to_do_list.css">
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
                <li><a href="./to_do_list.php">To do list</a></li>
                <li><a href="./chart.php">Chart</a></li>
                <li><a href="./letters.php">Letters from strangers</a></li>
            </ul>

            <div class="logout-logo">
                <a href="login.php" class="logout-button">Log Out</a>
            </div>
            <img src="./assets/logo.png" alt="Logo" class="logo">
        </nav>
    </header>

    <main>
        <div class="container">
            <h1>To Do List</h1>
            <div class="input-container">
                <input type="text" placeholder="What do you have planned?" id="task-input">
                <button id="add-task">Add Task</button>
            </div>

            <div class="tasks-container">
                <div class="tasks" id="tasks">
                    <h2>Assigned</h2>
                    <div class="sort">
                        <span id="sort-newest">Newest</span>
                        <span id="sort-oldest">Oldest</span>
                    </div>
                    <div id="task-list"></div>
                </div>
                
                <div class="tasks" id="completed-tasks">
                    <h2>Done</h2>
                    <div class="sort">
                        <span id="sort-newest-completed">Newest</span>
                        <span id="sort-oldest-completed">Oldest</span>
                    </div>
                    <div id="completed-task-list"></div>
                </div>
            </div>
        </div>
    </main>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit your task</h2>
            <input type="text" id="modal-task-input">
            <button id="save-task">Save</button>
        </div>
    </div>

    <script src="./script/to_do_list.js"></script>
</body>
</html>