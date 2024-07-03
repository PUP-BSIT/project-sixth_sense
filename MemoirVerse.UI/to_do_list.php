<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do Lists</title>
    <link rel="stylesheet" href="./style/to_do_list.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="profile">
                <img src="profile.jpg" alt="Profile Picture">
                <span>Memories</span>
            </div>
            <nav>
                <ul>
                    <li><a href="main_page.php">Home</a></li>
                    <li><a href="#">Mood Tracker</a></li>
                    <li><a href="#">To Do List</a></li>
                </ul>
            </nav>
        </aside>
        <main class="content">
            <header>
                <h1>To Do Lists</h1><br>
                <div class="sorting-dropdown">
                    <select id="sort-select">
                        <option value="">Sort by</option>
                        <option value="newest">Newest</option>
                        <option value="oldest">Oldest</option>
                    </select>
                </div>
            </header>
            <div class="thoughts">
                <div class="textarea-wrapper">
                    <img src="icon.png" alt="Writing Icon" class="writing-icon">
                    <input type="text" id="todo-input" placeholder="Add a new task...">
                    <button id="add-task-btn">Add Task</button>
                </div>
                <div class="task-section">
                    <div class="task assigned" id="assigned-tasks">
                        <h2>Assigned</h2>
                        <ul id="assigned-list"></ul>
                    </div>
                    <div class="task done" id="done-tasks">
                        <h2>Done</h2>
                        <ul id="done-list"></ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="./script/to_do_list.js"></script>
</body>
</html>