<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To do lists</title>
    <link rel="stylesheet" href="./style/to_do_list.css">
</head>
<body>
    <header>
        <div class="sorting-dropdown">
            <select>
                <option>Sorting</option>
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
            </select>
        </div>
    </header>
    <div class="container">
        <aside class="sidebar">
            <div class="profile">
                <img src="profile.jpg" alt="Profile Picture">
                <span>Jane Sn Blue</span>
            </div>
            <nav>
                <ul>
                    <a href="main_page.php">
                        <li class="menu-item">Home</li>
                    </a>
                    <li class="menu-item">Mood Tracker</li>
                    <li class="menu-item active">To do List</li>
                    <li class="menu-item">Pinned</li>
                </ul>
            </nav>
        </aside>
        <main class="content">
          <div class="thoughts">
            <div class="textarea-wrapper">
                <img src="icon.png" alt="Writing Icon" class="writing-icon">
                <input type="text" id="todo-input" placeholder="To Do lists">
            </div>
            <div class="task-section">
                <div class="task assigned" id="assigned-tasks">
                    <h2>Assigned</h2>
                </div>
                <div class="task done" id="done-tasks">
                    <h2>Done</h2>
                </div>
            </div>
          </div>
        </main>
    </div>
    <script src="./script/to_do_list.js"></script>
</body>
</html>