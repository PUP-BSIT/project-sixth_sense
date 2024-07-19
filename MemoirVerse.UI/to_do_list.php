<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include 'db_conn.php';

error_log("Request method: " . $_SERVER['REQUEST_METHOD']);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['to_do_id'], $input['user_id'], $input['assigned'], $input['done'])) {
        $to_do_id = $input['to_do_id'];
        $user_id = $input['user_id'];
        $assigned = $input['assigned'];
        $done = $input['done'];

        $sql = "INSERT INTO to_do_list (to_do_id, user_id, assigned, done) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $to_do_id, $user_id, $assigned, $done);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Database error: " . $stmt->error]);
        }
    } else {
        error_log("Invalid input: " . print_r($input, true));
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request method"]);
}
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
                <li><a href="./entries.php">Diary</a></li>
                <li><a href="./to_do_list.html">To do list</a></li>
                <li><a href="./chart.html">Chart</a></li>
                 <li><a href="./letters.html">Letters from strangers</a></li>
            </ul>
            <div class="logout-logo">
                <a href="logout.php" class="logout-button">Log Out</a>
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
    <script src="./script/to_do_list.js"></script>
</body>
</html>
